<?php

namespace App\Http\Controllers\FarmManagement;

use App\Http\Controllers\Controller;
use App\Models\Cultivation;
use App\Models\FarmerDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
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
        $all_farmer = FarmerDetails::all();
        return view('farm_management.cultivation.create',compact('all_farmer'));
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
            'farmer_id'   => $request->farmer_id,
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

    public function dtajax(Request $request)
    {
        $cultivationDetails = Cultivation::all()->sortDesc();
        $out =  DataTables::of($cultivationDetails)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            $output = '';
            $today = Carbon::parse($data->data[$i]->expected_Date_of_Harvest_after_Sowing);
            if($today->isToday())
            {
                $output .= ' <a href="'.url(route('cultivation.upload_to_product',['id'=>$data->data[$i]->id])).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Convert To Product" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-upload"></i></a>';
            }
            $data->data[$i]->farmer_name = Cultivation::find($data->data[$i]->id)->farmer->full_name;
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }
    
    public function upload_to_product(Request $request)
    {
        
    }
}
