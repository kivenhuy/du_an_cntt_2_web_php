<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Category;
use App\Models\HomeSlide;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $best_selling_products = Products::where('approved',1)->get()->take(4);
        $fresh_today_products = Products::where('approved',1)->where('short_shelf_life',1)->get()->sortByDesc('created_at')->take(3);
        $new_products = Products::where('approved',1)->latest()->limit(8)->get();
        // dd($now->startOfWeek()->addWeek(2));

        // dd(Session::get('start_time_range_fruits'));
        $now = Carbon::now();
        $fresh_fruit_high_quantity = Products::where('approved',1)
        ->withCount('order_detail')
        ->orderBy('order_detail_count', 'asc')
        ->get()->append(['percent_date'])->sortBy('percent_date')->filter(function ($item) {
            return  $item->percent_date <= 60 && $item->percent_date > 0;
        })->values()->take(8);
        


        $home_slides = HomeSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('user_layout.index',
        [
            'best_selling_products'=>$best_selling_products,
            'fresh_today_products'=>$fresh_today_products,
            'new_products'=>$new_products,
            // 'fresh_sea_food_high_quantity'=>$fresh_sea_food_high_quantity,
            'fresh_fruit_high_quantity'=>$fresh_fruit_high_quantity,
            'home_slides'=>$home_slides,
        ]);
    }

    public function product(Request $request, $slug)
    {
       

        $detailedProduct  = Products::where('slug', $slug)->where('approved', 1)->first();
        $categories_data = Categories::find($detailedProduct->category_id);
        if ($detailedProduct != null && $detailedProduct->published) {
            $data_product = json_decode($detailedProduct->choice_options);
            
            $arr_attr = [];
           
            $review_status = 0;
            $reviews = $detailedProduct->reviews()->paginate(3);
            return view('user_layout.products.product_detail',
                [
                'detailedProduct' => $detailedProduct,
                // 'product_queries' => $product_queries,
                // 'total_query' => $total_query,
                'reviews' => $reviews,
                'review_status' => $review_status,
                'arr_attr' => $arr_attr,
                'categories_data'=>$categories_data,
                // 'order_sample'=>$order_sample,
                'product_traceability'=>0,
            ]);
        }
    }

    public function comming_soon()
    {
        return view('user_layout.comming_soon');
    }

    public function dashboard()
    {
        if (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'enterprise' ) 
        {
            return view('user_layout.dashboard');
        } else {
            abort(404);
        }
    }

    public function shop(Request $request,$slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $min_price_choose = $request->min_price;
        $max_price_choose = $request->max_price;
        $selected_categories = array();
        $brand_id = null;
        $rating = null;
        $conditions = ['user_id' => $shop->user->id, 'published' => 1, 'approved' => 1];

        

        $products = Products::where($conditions);

        if ($request->has('selected_categories')) {
            $selected_categories = $request->selected_categories;
            $products->whereIn('category_id', $selected_categories);
        }

        if ($min_price != null && $max_price != null) {
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if ($request->has('rating')) {
            $rating = $request->rating;
            $products->where('rating', '>=', $rating);
        }
        $products_all = Products::where($conditions)->get();
        switch ($sort_by) 
        {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
            case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
            default:
                $products->orderBy('id', 'desc');
                break;
        }
        $certificates = $shop->certificate;
        $product_factories = $shop->product_fatory;
        $img_certificates = [];
        if(isset($certificates))
        {
            $img_certificates_data = $certificates->img_certificates;
            if(!empty($img_certificates_data))
            {
                $img_certificates = explode(",",$img_certificates_data);
            }
        }
        $img_product_factories = [];
        if(isset($product_factories))
        {
            $img_product_factories_data = $product_factories->img_product_factories;
            if(!empty($img_product_factories_data))
            {
                $img_product_factories = explode(",",$img_product_factories_data);
            }
            // $img_product_factories = explode(",",$img_product_factories);
        }
        
        $products = $products->paginate(24)->appends(request()->query());
        if ($shop != null) {
            
            return view('user_layout.seller.shop', compact('img_certificates','img_product_factories','products_all','min_price_choose','max_price_choose','shop', 'products', 'selected_categories', 'min_price', 'max_price', 'brand_id', 'sort_by', 'rating'));
        }
        abort(404);
    }

    /**
     * Danh sách toàn bộ sản phẩm: view riêng, lọc theo nhiều danh mục (selected_categories[]).
     */
    public function listingAllProducts(Request $request)
    {
        return $this->index_all_products($request);
    }

    public function index_all_products(Request $request)
    {
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $min_price_req = $request->min_price;
        $max_price_req = $request->max_price;
        $min_price_choose = $request->min_price;
        $max_price_choose = $request->max_price;
        $seller_id = $request->seller_id;

        $selected_categories = array_values(array_unique(array_filter(
            array_map('intval', (array) $request->input('selected_categories', [])),
            fn ($id) => $id > 0
        )));

        $selected_brands = array_values(array_unique(array_filter(
            array_map('intval', (array) $request->input('selected_brands', [])),
            fn ($id) => $id > 0
        )));

        $conditions = ['published' => 1, 'approved' => 1];
        $products = Products::where($conditions);

        if ($selected_categories !== []) {
            $products->whereIn('category_id', $selected_categories);
        }

        if ($selected_brands !== []) {
            $products->whereIn('brand_id', $selected_brands);
        }

        if ($min_price_req != null && $max_price_req != null) {
            $products->where('unit_price', '>=', $min_price_req)->where('unit_price', '<=', $max_price_req);
        }

        switch ($sort_by) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
            case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
            default:
                $products->orderBy('id', 'desc');
                break;
        }

        $total_product = $products->count();
        $products = $products->paginate(24)->appends(request()->query());
        foreach ($products as $sub_products) {
            $sub_products->name_seller = User::find($sub_products->user_id)->name;
        }

        $min_price = Products::where('published', 1)->where('approved', 1)->min('unit_price');
        $max_price = Products::where('published', 1)->where('approved', 1)->max('unit_price');

        // Sidebar: toàn bộ danh mục + thương hiệu có sản phẩm đăng bán.
        $filter_categories = Category::query()->orderBy('name')->get();
        $filter_brands = Brand::whereHas('products', function ($q) use ($conditions) {
            $q->where($conditions);
        })->orderBy('name')->get();

        return view('user_layout.products.product_listing_all', compact(
            'total_product',
            'min_price_choose',
            'max_price_choose',
            'min_price',
            'max_price',
            'products',
            'query',
            'sort_by',
            'seller_id',
            'selected_categories',
            'selected_brands',
            'filter_categories',
            'filter_brands'
        ));
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) { 
            return $this->index_category($request, $category->id);
        }
        abort(404);
    }


    public function index_category(Request $request, $category_id = null, $brand_id = null)
    {
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $min_price_choose = $request->min_price;
        $max_price_choose = $request->max_price;
        $seller_id = $request->seller_id;
        $conditions = [ 'published' => 1, 'approved' => 1];

        $selected_brands = array_values(array_unique(array_filter(
            array_map('intval', (array) $request->input('selected_brands', [])),
            fn ($id) => $id > 0
        )));

        $category_slug = $category_id !== null
            ? Category::where('id', $category_id)->value('slug')
            : null;

        $products = Products::where($conditions);

        // Trang danh mục: luôn theo đúng category trong URL; chỉ lọc thêm theo thương hiệu.
        if ($category_id != null) {
            $products->where('category_id', $category_id);
        }

        if ($selected_brands !== []) {
            $products->whereIn('brand_id', $selected_brands);
        }

        if ($min_price != null && $max_price != null) {
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        switch ($sort_by) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
            case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
            default:
                $products->orderBy('id', 'desc');
                break;
        }

        $total_product = $products->count();
        $products =  $products->paginate(24)->appends(request()->query());
        foreach($products as $sub_products)
        {
            $sub_products->name_seller = User::find($sub_products->user_id)->name;
        }
        $min_price = Products::where('published', 1)->min('unit_price');
        $max_price = Products::where('published', 1)->max('unit_price');

        // Bộ lọc danh mục: chỉ hiển thị đúng danh mục đang xem (một chip).
        $filter_categories = $category_id !== null
            ? Category::where('id', $category_id)->orderBy('name')->get()
            : collect();

        // Thương hiệu có ít nhất một sản phẩm thuộc đúng danh mục này.
        $filter_brands = $category_id !== null
            ? Brand::whereHas('products', function ($q) use ($conditions, $category_id) {
                $q->where($conditions)->where('category_id', $category_id);
            })->orderBy('name')->get()
            : collect();

        return view('user_layout.products.product_listing', compact(
            'total_product',
            'min_price_choose',
            'max_price_choose',
            'min_price',
            'max_price',
            'products',
            'query',
            'category_id',
            'brand_id',
            'sort_by',
            'seller_id',
            'filter_categories',
            'filter_brands',
            'selected_brands',
            'category_slug'
        ));
    }

    public function profile(Request $request)
    {
        return view('user_layout.user.profile');
    }

    public function userProfileUpdate(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->photo;
        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }
}
