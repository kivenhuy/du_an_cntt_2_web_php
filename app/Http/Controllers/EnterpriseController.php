<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EnterpriseController extends Controller
{
    public function index()
    {
        return view('admin.enterprise.index');
    }

    public function data_ajax(Request $request)
    {
        $enterprise = User::where('user_type','enterprise')->get();
        $out =  DataTables::of($enterprise)->make(true);
        $data = $out->getData();
        for($i=0; $i < count($data->data); $i++) {
            // dd($data->data[$i]->id);
            $enterprise_data = User::find( $data->data[$i]->id);
            $data->data[$i]->bussiness_name = $enterprise_data->enterprise_detail->bussiness_name;
            $data->data[$i]->organization_type = $enterprise_data->enterprise_detail->organization_type;
            $data->data[$i]->bussiness_type = implode(", ",json_decode($enterprise_data->enterprise_detail->bussiness_type));
            $output = '';
            $data->data[$i]->action = (string)$output;
        }
        $out->setData($data);
        return $out;
    }
}