<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Yajra\DataTables\DataTables;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        return view('admin.province.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $country = Country::all();
        return view('admin.province.create',['country'=>$country]);
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
        $province = new Province();
        $data_province = [
            'country_id' =>$request->country_id,
            'province_code'=>$request->province_code,
            'province_name'=>$request->province_name,
        ];
        $final_data = $province->create($data_province);
        if($final_data)
        {
            flash(translate('province has been inserted successfully'))->success();
            return redirect()->route('province.index');
        }
        else
        {
            flash(translate('province has been inserted Fail'))->error();
            return redirect()->route('province.index');
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
        $province_data = Province::all()->sortDesc();
        $out =  DataTables::of($province_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            $data->data[$i]->action = (string)$output;
            $data->data[$i]->country_name = Province::find($data->data[$i]->id)->country->country_name;
        }
        $out->setData($data);
        return $out;
    }
}
