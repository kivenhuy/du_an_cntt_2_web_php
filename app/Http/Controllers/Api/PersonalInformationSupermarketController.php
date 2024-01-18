<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadsController;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class PersonalInformationSupermarketController extends Controller
{
    

    public function index($id)
    {
        $user_data = User::find($id)->append(['img_logo']);
        return response()->json([
            'result' => true,
            'data'=>
            [
                'user_data'=>$user_data,
                'address_data'=>$user_data->addresses,
            ]
        ]); 
    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);
        $id_logo = $user->avatar_original ;
        if (!empty($request->all()['photo']) || $request->all()['photo'] != null) {
                                    
            $id_logo = (new UploadsController)->upload_photo_supermarket($request->all()['photo'],$request->user_id);
        }
        
        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $id_logo;
        $user->save();

        return response()->json([
            'result' => true,
            'data'=>
            [
                'user_data'=>$user->append(['img_logo']),
            ]
        ]); 
    }
}
