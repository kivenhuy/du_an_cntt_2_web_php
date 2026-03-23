<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $address = new Address();
        if($request->has('customer_id')){
            $address->user_id   = $request->customer_id;
        }
        else{
            $address->user_id   = Auth::user()->id;
        }
        $address->address       = $request->address;
        $address->country_id    = $request->country_id;
        $address->city_id       = $request->city_id;
        $address->district_id   = $request->district_id;
        $address->postal_code   = $request->postal_code;
        $address->phone         = $request->phone;
        $address->save();

        flash(translate('Address info Stored successfully'))->success();
        return back();
    }

    public function set_default($id){
        foreach (Auth::user()->addresses as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        $address = Address::findOrFail($id);
        $address->set_default = 1;
        $address->save();

        return back();
    }
}
