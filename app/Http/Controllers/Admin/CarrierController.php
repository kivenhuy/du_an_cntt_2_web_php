<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\CarrierRange;
use App\Models\CarrierRangePrice;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.carriers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carrier                = new Carrier;
        $carrier->name          = $request->carrier_name;
        $carrier->transit_time  = $request->transit_time;
        $carrier->logo          = $request->logo;
        $free_shipping          = isset($request->shipping_type) ? 1 : 0;
        $carrier->free_shipping = $free_shipping;
        $carrier->save();
        // if not free shipping, then add the carrier ranges and prices
        if($free_shipping == 0){
            for($i=0; $i < count($request->delimiter1); $i++){

                // Add Carrier ranges
                $carrier_range                  = new CarrierRange();
                $carrier_range->carrier_id      = $carrier->id;
                $carrier_range->billing_type    = $request->billing_type;
                $carrier_range->delimiter1      = $request->delimiter1[$i];
                $carrier_range->delimiter2      = $request->delimiter2[$i];
                $carrier_range->save();

                // Add carrier range prices
                $carrier_range_price =  new CarrierRangePrice();
                $carrier_range_price->carrier_id = $carrier->id;
                $carrier_range_price->carrier_range_id = $carrier_range->id;
                $carrier_range_price->price = $request->carrier_price;
                $carrier_range_price->save();
            }
        }
        flash(translate('New carrier has been added successfully'))->success();
        return 1;
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrier $carrier)
    {
        //
    }

    public function data_ajax(Request $request)
    {
        $carrier = Carrier::all();
        $out =  DataTables::of($carrier)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            $data->data[$i]->action = (string)$output;
            $data->data[$i]->logo = uploaded_asset($data->data[$i]->logo);
        }
        $out->setData($data);
        return $out;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrier $carrier)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $carrier = Carrier::findOrFail($request->id);
        $carrier->status = $request->status;
        if($carrier->save()){
            return 1;
        }
        return 0;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrier $carrier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrier $carrier)
    {
        //
    }
}
