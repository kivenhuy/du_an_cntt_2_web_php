<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegistrationRequest;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShopController extends Controller
{
    public function store(SellerRegistrationRequest $request)
    {            
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $email = $request->email;
        }
        else
        {
            $email = "";
        }
        $lat ="";
        $lng ="";
        $data_created = 
        [
            'name' => $request->name,
            'email' => $email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'country' => $request->country_2,
            'city' => $request->city_2,
            'ward' => $request->ward    ,
            'user_type' => $request->user_type,
            'district' => $request->district,
            'address' => $request->address,
        ];
        $user = User::create($data_created);
        if ($user) {
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $user->name;
            $shop->address = $user->address;
            $shop->slug = preg_replace('/\s+/', '-', str_replace("/"," ", $user->name));
            if($shop->save())
            {
                $seller = new Seller;
                $seller->user_id = $user->id;
                if($seller->save())
                {        
                    auth()->login($user, false);
                    flash(translate('Your Shop has been created successfully!'))->success();
                    return redirect()->route('seller.dashboard');
                }
                else
                {
                    flash(translate('Sorry! Something went wrong with Seller DB.'))->error();
                    return back();  
                }
            }
            else
            {
                flash(translate('Sorry! Something went wrong Shop DB.'))->error();
                return back();  
            }
           
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
