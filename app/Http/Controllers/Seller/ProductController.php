<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\User;
use App\Utility\ProductUtility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.products.index');
    }

    public function create()
    {
        $category = Categories::all();
        return view('seller.products.create',compact('category'));
    }


    public function store(Request $request)
    {
        // Create Product
        $product = $this->store_product($request->except([
            '_token', 'sku'
        ]));
        $request->merge(['product_id' => $product->id]);

        // Create Product Stock
        $this->store_product_stock($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);
        flash(translate('Product has been inserted successfully'))->success();

        return redirect()->route('seller.products');
    }


    public function store_product(array $data)
    {
        $collection = collect($data);
        $approved = 1;
        if (auth()->user()->user_type == 'seller') {
            $user_id = auth()->user()->id;
           
                $approved = 0;
        } else {
            $user_id = User::where('user_type', 'admin')->first()->id;
        }
        $tags = array();
        if ($collection['tags'][0] != null) {
            foreach (json_decode($collection['tags'][0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $collection['tags'] = implode(',', $tags);
        $discount_start_date = null;
        $discount_end_date   = null;
        if ($collection['date_range'] != null) {
            $date_var               = explode(" to ", $collection['date_range']);
            $discount_start_date = strtotime($date_var[0]);
            $discount_end_date   = strtotime($date_var[1]);
        }
        unset($collection['date_range']);
        
        if ($collection['meta_title'] == null) {
            $collection['meta_title'] = $collection['name'];
        }
        if ($collection['meta_description'] == null) {
            $collection['meta_description'] = strip_tags($collection['description']);
        }

        if ($collection['meta_img'] == null) {
            $collection['meta_img'] = $collection['thumbnail_img'];
        }


        $shipping_cost = 0;
        if (isset($collection['shipping_type'])) {
            if ($collection['shipping_type'] == 'free') {
                $shipping_cost = 0;
            } elseif ($collection['shipping_type'] == 'flat_rate') {
                $shipping_cost = $collection['flat_shipping_cost'];
            }
        }
        unset($collection['flat_shipping_cost']);

        $slug = Str::slug($collection['name']);
        $same_slug_count = Products::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $colors = json_encode(array());
        if (
            isset($collection['colors_active']) &&
            $collection['colors_active'] &&
            $collection['colors'] &&
            count($collection['colors']) > 0
        ) {
            $colors = json_encode($collection['colors']);
        }

        unset($collection['colors_active']);

        $choice_options = array();
        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $str = '';
            $item = array();
            foreach ($collection['choice_no'] as $key => $no) {
                $str = 'choice_options_' . $no;
                $item['attribute_id'] = $no;
                $attribute_data = array();
                // foreach (json_decode($request[$str][0]) as $key => $eachValue) {
                foreach ($collection[$str] as $key => $eachValue) {
                    // array_push($data, $eachValue->value);
                    array_push($attribute_data, $eachValue);
                }
                unset($collection[$str]);

                $item['values'] = $attribute_data;
                array_push($choice_options, $item);
            }
        }

        $choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        if (isset($collection['choice_no']) && $collection['choice_no']) {
            $attributes = json_encode($collection['choice_no']);
            unset($collection['choice_no']);
        } else {
            $attributes = json_encode(array());
        }

        $published = 1;
        if(isset($collection['button']))
        {
            if ($collection['button'] == 'unpublish' || $collection['button'] == 'draft') {
                $published = 0;
            }
            unset($collection['button']);
        }

        $data = $collection->merge(compact(
            'user_id',
            'approved',
            'discount_start_date',
            'discount_end_date',
            'shipping_cost',
            'slug',
            'colors',
            'choice_options',
            'attributes',
            'published',
        ))->toArray();
        return Products::create($data);
    }

    public function store_product_stock(array $data, $product)
    {
        $collection = collect($data);

        $options = ProductUtility::get_attribute_options($collection);
        
        //Generates the combinations of customer choice options
        $combinations = $this->generate_combination($options);
        
        $variant = '';
        if (count($combinations) > 0) {
            $product->variant_product = 1;
            $product->save();
            foreach ($combinations as $key => $combination) {
                $str = ProductUtility::get_combination_string($combination, $collection);
                $product_stock = new ProductStock();
                $product_stock->product_id = $product->id;
                $product_stock->variant = $str;
                $product_stock->price = request()['price_' . str_replace('.', '_', $str)];
                $product_stock->sku = request()['sku_' . str_replace('.', '_', $str)];
                $product_stock->qty = request()['qty_' . str_replace('.', '_', $str)];
                $product_stock->image = request()['img_' . str_replace('.', '_', $str)];
                $product_stock->save();
            }
        } else {
            unset($collection['colors_active'], $collection['colors'], $collection['choice_no']);
            $qty = $collection['current_stock'];
            $price = $collection['unit_price'];
            unset($collection['current_stock']);

            $data = $collection->merge(compact('variant', 'qty', 'price'))->toArray();
            ProductStock::create($data);
        }
    }

    public function generate_combination($arrays, $i=0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            $result = array();
            foreach ($arrays[$i] as $v) {
                $result[][] = $v;
            }
            return $result;
        }
    
        // get combinations from subsequent arrays
        $tmp = $this->generate_combination($arrays, $i + 1);
    
        $result = array();
    
        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? 
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }
    
        return $result;
    }
    

    public function data_ajax(Request $request){
        $product_data = Products::all()->sortDesc();
        $out =  DataTables::of($product_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $data->data[$i]->category_name = Products::find( $data->data[$i]->id)->category->name;
            $data->data[$i]->action = (string)$output;
            }
        $out->setData($data);
        return $out;
    }

}
