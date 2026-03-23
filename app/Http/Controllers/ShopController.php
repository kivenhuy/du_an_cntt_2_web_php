<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegistrationRequest;
use App\Models\Seller;
use App\Models\Shop;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Auth;
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
        $upsteamUrl = env('FARM_URL');
        $signupApiUrl = $upsteamUrl . '/auth/register';
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
                    try
                    {
                        $upsteamUrl = env('FARM_URL');
                        $signupApiUrl = $upsteamUrl . '/auth/register';
                        $data_cooperative = [
                            'name' => $user->name,
                            'username' => $user->name,
                            'ecom_user_id' => $user->id,
                            'email' => $user->email,
                            'password' => $request->password,
                            'phone_number' => $user->phone,
                        ];
                        $response = Http::withOptions([
                            'verify' => false,
                        ])->post($signupApiUrl,$data_cooperative);
                        
                    }
                    catch(\Exception $exception) {
                        
                    }
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

    public function index()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop.detail', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = Shop::find($request->shop_id);

        if ($request->has('name') && $request->has('address')) {
            if ($request->has('shipping_cost')) {
                $shop->shipping_cost = $request->shipping_cost;
            }

            $shop->name             = $request->name;
            $shop->address          = $request->address;
            $shop->phone            = $request->phone;
            $shop->slug             = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;
            $shop->meta_title       = $request->meta_title;
            $shop->meta_description = $request->meta_description;
            $shop->logo             = $request->logo;
        }

        if ($request->has('delivery_pickup_longitude') && $request->has('delivery_pickup_latitude')) {

            $shop->delivery_pickup_longitude    = $request->delivery_pickup_longitude;
            $shop->delivery_pickup_latitude     = $request->delivery_pickup_latitude;
        }  elseif (
            $request->has('top_banner') ||
            $request->has('sliders') || 
            $request->has('banner_full_width_1') || 
            $request->has('banners_half_width') || 
            $request->has('banner_full_width_2')
        ) {
            $shop->top_banner = $request->top_banner;
            $shop->slider = $request->slider;
           
        }

        if ($shop->save()) {
            flash(translate('Your Shop has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
