<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\Country;

use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.country.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $country = new Country();
        $data_country = [
            'country_name' =>$request->country_name,
            'country_code'=>$request->country_code,
        ];
        $final_data = $country->create($data_country);
        if($final_data)
        {
            flash(translate('Country has been inserted successfully'))->success();
            return view('admin.country.index');
        }
        else
        {
            flash(translate('Country has been inserted Fail'))->error();
            return view('admin.country.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }

    public function data_ajax(Request $request)
    {
        $country_data = Country::all()->sortDesc();
        $out =  DataTables::of($country_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $output = '';
            $data->data[$i]->action = (string)$output;
            }
        $out->setData($data);
        return $out;
    }
}
