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

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $sort_search =null;
        $customer_data = User::orderBy('id', 'desc')
            ->where('user_type','customer')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $enterprise_data = $customer_data->where('name', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $customer_data = $customer_data->paginate(10);
        return view('admin.customer.index',compact('customer_data','sort_search'));
    }

    public function detail($id)
    {
        $data_customer = User::find($id);
        $city_name = City::find($data_customer->addresses[0]->city_id)->city_name;
        $country_name = Country::find($data_customer->addresses[0]->country_id)->country_name;
        $district_name = District::find($data_customer->addresses[0]->district_id)->district_name;
        // $ward_name = $data_customer->ward;
        // $user_name = User::find($data_address->user_id)->name;
        $str = $data_customer->addresses[0]->address.', '.$district_name.', '.$city_name.', '.$country_name;
        $data_customer->full_adress = $str;
        return view('admin.customer.show',compact('data_customer'));
    }
}
