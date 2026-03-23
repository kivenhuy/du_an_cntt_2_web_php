<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipper = [];
        try
        {
            $upsteamUrl = env('SHIPPING_URL');
            $signupApiUrl = $upsteamUrl . '/get_all_shipper';
            $response = Http::get($signupApiUrl);
            $data_response = (json_decode($response)->data);
            $shipper = $data_response->shipper;
        }
        catch(\Exception $exception) {
            
        }
        $shipper_data = $this->paginate($shipper);
        // dd($shipper_data);
        return view('admin.shipper.index',['shipper_data'=>$shipper_data]);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,['path' => route('admin.shipper.index')], $options);
    }

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
   
    public function approve_shipper(Request $request)
    {
        $data_response = false;
        try
        {
            $upsteamUrl = env('SHIPPING_URL');
            $signupApiUrl = $upsteamUrl . '/approval_shipper';
            $response = Http::post($signupApiUrl,[
                'id'=>$request->id,
                'status'=>$request->status,
            ]);
            // dd(json_decode($response)->body());
            $data_response = (json_decode($response)->status);
            
            // $shipper = $data_response->shipper;
        }
        catch(\Exception $exception) {
            
        }
        if ($data_response) {
            flash(translate('Shipper has been approved successfully'))->success();
            return 1;
        }
        flash(translate('Something went wrong'))->error();
        return 0;
    }

    public function shipper_detail($id)
    {
        $shipper = [];
        try
        {
            $upsteamUrl = env('SHIPPING_URL');
            $signupApiUrl = $upsteamUrl . '/detail_shipper/'.$id;
            $response = Http::get($signupApiUrl, [
                'headers'=>[
                    'Accept' => 'application/json'
                ]
            ]);
            $data_response = (json_decode($response)->data);
            $shipper = $data_response->shipper;
        }
        catch(\Exception $exception) {
            
        }
        $shipper->carrier_name = Carrier::find($shipper->carrier_id)->name;
        $city_name = City::find($shipper->city)->city_name;
        $country_name = Country::find($shipper->country)->country_name;
        $district_name = District::find($shipper->district)->district_name;
        $ward_name = $shipper->ward;
        // $user_name = User::find($data_address->user_id)->name;
        $str = $shipper->address.', '.$ward_name.', '.$district_name.', '.$city_name.', '.$country_name;
        $shipper->full_adress = $str;
        // dd($shipper);
        if(isset($shipper))
        {
            return view('admin.shipper.show',['shipper_data'=>$shipper]);
        }
    }
}
