<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SellerController extends Controller
{
    public function index()
    {
        return view('admin.seller.index');
    }

    public function data_ajax(Request $request)
    {
        $shops = Shop::all();
        $out =  DataTables::of($shops)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $shop_data = Shop::find( $data->data[$i]->id);
            $data->data[$i]->phone = $shop_data->user->phone;
            $data->data[$i]->email = $shop_data->user->email;
            $data->data[$i]->num_product = $shop_data->user->products->count();
            $data->data[$i]->due_to_seller = 0;
            $output = '';
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }


    public function approve_seller(Request $request)
    {
        $shop = Shop::findOrFail($request->id);
        $shop->verification_status = 1;
        if ($shop->save()) {
            flash(translate('Seller has been approved successfully'))->success();
        }
        flash(translate('Something went wrong'))->error();
        return 1;
    }
}
