<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['myLayout' => 'blank'];

        return view('user_layout.user_login');
    }

    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:5',
        ]);
        
        if ($validator->fails()) {
            //flash($validator->messages()->first())->error();
            return back()->withErrors($validator)->withInput();
        }
        
        $credential = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (auth()->attempt($credential)) {
            $user = Auth::user();
            if($user->user_type == "seller")
            {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->route('homepage');
        }

        //flash('The credentials did not match')->error();

        return redirect()->back()
            ->withErrors(['message' => 'The credentials did not match'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('user.login');
    }
}
