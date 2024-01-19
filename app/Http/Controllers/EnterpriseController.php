<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EnterpriseController extends Controller
{
    public function index(Request $request)
    {
        $sort_search =null;
        $enterprise_data = User::orderBy('id', 'desc')
            ->where('user_type','enterprise')
            ->distinct();
       
        if ($request->has('search')) {
            $sort_search = $request->search;
            $enterprise_data = $enterprise_data->where('name', 'like', '%' . $sort_search . '%');
        }
        // dd($request_data->get()->appends(['seller_name']));
        $enterprise_data = $enterprise_data->paginate(10);
        return view('admin.enterprise.index',compact('enterprise_data','sort_search'));
    }

    // public function data_ajax(Request $request)
    // {
    //     $enterprise = User::where('user_type','enterprise')->get();
    //     $out =  DataTables::of($enterprise)->make(true);
    //     $data = $out->getData();
    //     for($i=0; $i < count($data->data); $i++) {
    //         // dd($data->data[$i]->id);
    //         $enterprise_data = User::find( $data->data[$i]->id);
    //         $data->data[$i]->bussiness_name = $enterprise_data->enterprise_detail->bussiness_name;
    //         $data->data[$i]->organization_type = $enterprise_data->enterprise_detail->organization_type;
    //         $data->data[$i]->bussiness_type = "";
    //         $output = '';
    //         $data->data[$i]->action = (string)$output;
    //     }
    //     $out->setData($data);
    //     return $out;
    // }
}
