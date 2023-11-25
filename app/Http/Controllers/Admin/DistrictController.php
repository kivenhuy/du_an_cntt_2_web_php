<?php

namespace App\Http\Controllers\Admin;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.district.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $city = City::all();
        return view('admin.district.create',['city'=>$city]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $district = new District();
        $data_district = [
            'city_id'=>$request->city_id,
            'district_name'=>$request->district_name,
            'district_code'=>$request->district_code,
        ];
        $final_data = $district->create($data_district);
        if($final_data)
        {
            flash(translate('District has been inserted Successfully'))->success();
            return redirect()->route('district.index');
        }
        else
        {
            flash(translate('District has been inserted Fail'))->error();
            return redirect()->route('district.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        //
    }

    public function data_ajax(Request $request)
    {
        $district_data = District::all()->sortDesc();
        $out =  DataTables::of($district_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $data->data[$i]->city_name = District::find($data->data[$i]->id)->city->city_name;
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }
}
