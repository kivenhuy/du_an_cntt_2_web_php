<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.products.index');
    }


    public function approve(Request $request)
    {
        $product = Products::findOrFail($request->id);
        $product->approved = $request->approved;
        $product->save();
        return 1;
    }


    public function data_ajax(Request $request){
        $product_data = Products::all()->sortDesc();
        $out =  DataTables::of($product_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $data->data[$i]->added_by = User::find( $data->data[$i]->user_id)->name;
            $data->data[$i]->total_stock = Products::find( $data->data[$i]->id)->product_stock?->qty;
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }

}
