<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadsController;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalInformationShopController extends Controller
{
    

    public function index($id)
    {
        $shop = User::find($id)->shop->append(['img_logo','img_banner']);
        return response()->json([
            'result' => true,
            'data'=>
            [
                'shop'=>$shop,
            ]
        ]); 
    }

    public function update(Request $request)
    {
        $id_logo = 0;
        $id_top_banner = 0;
        if (!empty($request->all()['logo_url'])) {
                                    
            $id_logo = (new UploadsController)->upload_photo($request->all()['logo_url'],$request->ecom_user_id);
        }
        if (!empty($request->all()['top_banner_url'])) {
                                    
            $id_top_banner = (new UploadsController)->upload_photo($request->all()['top_banner_url'],$request->ecom_user_id);
        }
        $shop = Shop::find($request->shop_id);
        $shop->name             = $request->name;
        $shop->address          = $request->address;
        $shop->phone            = $request->phone;
        $shop->slug             = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;
        $shop->meta_title       = $request->meta_title;
        $shop->meta_description = $request->meta_description;
        $shop->logo             = $id_logo;
        $shop->top_banner = $id_top_banner;

        if ($shop->save()) {
            return response()->json([
                'result' => true,
                'data'=>
                [
                    'shop'=>$shop->append(['img_logo','img_banner']),
                ]
            ]); 
        }

        return response()->json([
            'result' => false,
        ]); 
    }
}
