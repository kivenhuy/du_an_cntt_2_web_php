<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Products;
use App\Models\ProductStock;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\DataTables;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $sort_search =null;
        $shop_data = Shop::orderBy('id', 'desc')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $shop_data = $shop_data->where('name', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $shop_data = $shop_data->paginate(10);
        return view('admin.seller.index',compact('shop_data','sort_search'));
    }

    public function details($id)
    {
        $data_seller = Shop::find($id);
        $city_name = City::find($data_seller->user->city)->city_name;
        $country_name = Country::find($data_seller->user->country)->country_name;
        $district_name = District::find($data_seller->user->district)->district_name;
        $ward_name = $data_seller->user->ward;
        // $user_name = User::find($data_address->user_id)->name;
        $str = $data_seller->address.', '.$ward_name.', '.$district_name.', '.$city_name.', '.$country_name;
        $data_seller->full_adress = $str;
        return view('admin.seller.show',compact('data_seller'));
    }

    // public function data_ajax(Request $request)
    // {
    //     $shops = Shop::all();
    //     $out =  DataTables::of($shops)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $shop_data = Shop::find( $data->data[$i]->id);
    //         $data->data[$i]->phone = $shop_data->user->phone;
    //         $data->data[$i]->email = $shop_data->user->email;
    //         $data->data[$i]->num_product = $shop_data->user->products->count();
    //         $data->data[$i]->due_to_seller = 0;
    //         $output = '';
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }


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
