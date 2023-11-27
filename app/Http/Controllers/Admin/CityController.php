<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.city.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $country = Country::all();
        return view('admin.city.create',['country'=>$country]);
    }


    public function filter_by_country(Request $request)
    {
        $city = Country::find($request->id)->city;
        return $city;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $city = new City();
        $data_city = [
            'country_id' =>$request->country_id,
            'city_code'=>$request->city_code,
            'city_name'=>$request->city_name,
        ];
        $final_data = $city->create($data_city);
        if($final_data)
        {
            flash(translate('City has been inserted successfully'))->success();
            return redirect()->route('city.index');
        }
        else
        {
            flash(translate('City has been inserted Fail'))->error();
            return redirect()->route('city.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }


    public function data_ajax(Request $request)
    {
        $city_data = City::all()->sortDesc();
        $out =  DataTables::of($city_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            $data->data[$i]->action = (string)$output;
            $data->data[$i]->country_name = City::find($data->data[$i]->id)->country->country_name;
        }
        $out->setData($data);
        return $out;
    }
}
