<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EnterpriseController extends Controller
{
    public function index(Request $request)
    {
        $sort_search =null;
        $enterprise_data = User::orderBy('id', 'desc')
            ->where('user_type','enterprise')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $enterprise_data = $enterprise_data->where('name', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $enterprise_data = $enterprise_data->paginate(10);
        return view('admin.enterprise.index',compact('enterprise_data','sort_search'));
    }

    public function detail($id)
    {
        $data_enterprise = User::find($id);
        $city_name = City::find($data_enterprise->city)->city_name;
        $country_name = Country::find($data_enterprise->country)->country_name;
        $district_name = District::find($data_enterprise->district)->district_name;
        $ward_name = $data_enterprise->ward;
        // $user_name = User::find($data_address->user_id)->name;
        $str = $data_enterprise->address.', '.$ward_name.', '.$district_name.', '.$city_name.', '.$country_name;
        $data_enterprise->full_adress = $str;
        return view('admin.enterprise.show',compact('data_enterprise'));
    }
}
