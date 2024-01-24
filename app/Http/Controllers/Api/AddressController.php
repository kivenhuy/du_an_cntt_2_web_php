<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    

    public function index()
    {
        $country = Country::all();
        $carrier = Carrier::all();
        return response()->json([
            'result' => true,
            'data'=>
            [
                'country'=>$country,
                'carrier'=>$carrier,
            ]
        ]); 
    }

    public function filter_by_country(Request $request)
    {
        $city = Country::find($request->id)->city;
        return response()->json([
            'result' => true,
            'data'=>
            [
                'city'=>$city,
            ]
        ]); 
    }

    public function filter_by_city(Request $request)
    {
        $district = City::find($request->id)->district;
        return response()->json([
            'result' => true,
            'data'=>
            [
                'district'=>$district,
            ]
        ]); 
    }

    public function get_data_carrier($id)
    {
        $data_carrier = Carrier::find($id);
        return response()->json([
            'result' => true,
            'data'=>$data_carrier,
        ]); 
    }
}
