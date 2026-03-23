<?php

namespace App\Http\Controllers\Admin;
use Session;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

use App\Models\Commune;
use App\Models\Province;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function index()
    {
        return view('admin.commune.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $province = Province::all();
        return view('admin.commune.create',['province'=>$province]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $commune = new Commune();
        $data_commune = [
            'province_id' =>$request->province_id,
            'commune_code'=>$request->commune_code,
            'commune_name'=>$request->commune_name,
        ];
        $final_data = $commune->create($data_commune);
        if($final_data)
        {
            flash(translate('commune has been inserted successfully'))->success();
            return redirect()->route('commune.index');
        }
        else
        {
            flash(translate('commune has been inserted Fail'))->error();
            return redirect()->route('commune.index');
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
        $commune_data = Commune::all()->sortDesc();
        $out =  DataTables::of($commune_data)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            $data->data[$i]->action = (string)$output;
            $data->data[$i]->province_name = Commune::find($data->data[$i]->id)->province->province_name;
        }
        $out->setData($data);
        return $out;
    }
}
