<?php

namespace App\Http\Controllers\FarmManagement;

use App\Http\Controllers\Controller;
use App\Models\Cultivation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CultivationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('farm_management.cultivation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cultivation = new Cultivation();
        $mytime = Carbon::now();
        $data = [
            'updated_at'   => $mytime,
            'created_at'   => $mytime,
            'staff_id'   => Auth::user()->id,
            'cultivation_name'    =>$request->cultivation_name,
            'harvest_Season'      =>$request->harvest_Season,
            'crop_variety'      => $request-> crop_variety,
            'sowing_Date'       => $request-> sowing_Date,
            'expected_Date_of_Harvest_after_Sowing'          => $request-> expected_Date_of_Harvest_after_Sowing,
            'est_Yield'          => $request-> est_Yield,
            'seed_Quantity_unit'           => $request-> seed_Quantity_unit,
        ];
        $cultivation->create($data);
        return redirect()->route("cultivation.index")->with('success','Farmer created successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cultivation $cultivation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cultivation $cultivation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cultivation $cultivation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cultivation $cultivation)
    {
        //
    }
}
