<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\User;
use App\Utility\ProductUtility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

}
