<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\User;
use App\Utility\ProductUtility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sort_search =null;
        $product_data = Products::orderBy('id', 'desc')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $product_data = $product_data->where('name', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $product_data = $product_data->paginate(10);
        return view('admin.products.index',compact('product_data','sort_search'));
    }

    public function create()
    {
        $category = Categories::all();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.create', compact('category', 'brands'));
    }

    public function store(Request $request)
    {
        $sellerProduct = app(SellerProductController::class);

        $product = $sellerProduct->store_product($request->except([
            '_token', 'sku',
        ]));

        if (Auth::check() && Auth::user()->user_type === 'admin') {
            $product->user_id = Auth::id();
            $product->save();
        }

        $request->merge(['product_id' => $product->id]);

        $sellerProduct->store_product_stock($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id',
        ]), $product);

        flash('Sản phẩm đã được tạo thành công')->success();

        return redirect()->route('admin.products.index');
    }

    public function approve(Request $request)
    {
        // dd($request->approved);
        $product = Products::findOrFail($request->id);
        $product->approved = (int)$request->approved;
        $product->save();
        return 1;
    }


    // public function data_ajax(Request $request){
    //     $product_data = Products::all()->sortDesc();
    //     $out =  DataTables::of($product_data)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $output = '';
    //         $data->data[$i]->added_by = User::find( $data->data[$i]->user_id)->name;
    //         $data->data[$i]->total_stock = Products::find( $data->data[$i]->id)->product_stock?->qty;
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'tags', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $sellerProduct = app(SellerProductController::class);

        $product = $sellerProduct->update_product($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type',
        ]), $product);

        if ($product->product_stock) {
            $product->product_stock->delete();
        }

        $request->merge(['product_id' => $product->id]);
        $sellerProduct->update_product_stock($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id',
        ]), $product);

        flash('Sản phẩm đã được cập nhật thành công')->success();

        return redirect()->route('admin.products.edit', ['id' => $product->id]);
    }

}
