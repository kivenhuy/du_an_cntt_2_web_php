<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Country;
use App\Models\EnterpriseDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    protected function guard()
    {
        return Auth::guard();
    }   

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['myLayout' => 'blank'];

        return view('user_layout.user_login');
    }

    public function showRegisterForm()
    {
        $country = Country::all();
        return view('user_layout.user_register',compact('country'));
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
            else if($user->user_type == "admin")
            {
                return redirect()->route('admin.dashboard');
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

    public function storeRegisterForm(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        elseif (User::where('phone',$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();
        $data_created = 
        [
            "_token" => $request->_token,
            "name" => $request->name,
            "country" =>0,
            "city" => 0,
            "email" => $request->email,
            "phone" => $request->phone,
            "district" =>0,
            "ward" =>0,
            "address" => "",
            "user_type" => 'customer',
            "password" => $request->password,
            "password_confirmation" => $request->password_confirmation,
            // "full_address" =>  $full_address
        ];
        $user = $this->create($data_created);
        $credential = [
            'email' => $user->email,
            'password' => $request->password
        ];
        if (auth()->attempt($credential )) {
            $user_login = Auth::user();
            if($user_login->user_type == "seller")
            {
                return redirect()->route('seller.dashboard');
            }
            else if($user_login->user_type == "admin")
            {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('homepage');
        }

        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();
        flash(translate('Registration successful.'))->success();
    }

    // Store Enterprise Role
    public function storeEnterpriseForm(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        elseif (User::where('phone',$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }
        $this->validator($request->all())->validate();
        $data_created = 
        [
            "_token" => $request->_token,
            "name" => $request->name,
            "country" =>$request->country_3,
            "city" => $request->city_3,
            "email" => $request->email,
            "phone" => $request->phone,
            "district" =>$request->district_3,
            "ward" =>$request->ward_3,
            "address" => $request->address_3,
            "user_type" => 'enterprise',
            "password" => $request->password,
            "password_confirmation" => $request->password_confirmation,
        ];
        $user = $this->create($data_created);
        if($user)
        {
            $enterprise = new EnterpriseDetails();
            $enterprise->user_id = $user->id;
            $enterprise->bussiness_name = $request->bussiness_name;
            $enterprise->organization_type = $request->organization_type;
            $enterprise->business_type = json_encode($request->bussiness_type);
            $enterprise->fax_number = $request->fax_number;
            $enterprise->tax_number = $request->tax_number;
            $enterprise->regis_number = $request->registration_number;
            $enterprise->date_of_regis = $request->dor;
            $enterprise->save();
        }
        $credential = [
            'email' => $user->email,
            'password' => $request->password
        ];
        if (auth()->attempt($credential)) {
            $user_login = Auth::user();
            $address = new Address();
            $address->user_id   = Auth::user()->id;
            $address->address       = $request->address_3;
            $address->country_id    = $request->country_3;
            $address->city_id       = $request->city_3;
            $address->district_id   = $request->district_3;
            $address->postal_code   = 70000;
            $address->phone         = $request->phone;
            $address->save();
            try
            {
                $upsteamUrl = env('SUPERMARKET_URL');
                $signupApiUrl = $upsteamUrl . '/auth/register';
                $data_cooperative = [
                    'name' => $request->name,
                    'username' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'phone_number' => $request->phone,
                    'ecom_user_id' => $user->id,
                ];
                $response = Http::post($signupApiUrl,$data_cooperative);
            }
            catch(\Exception $exception) {
                
            }
            return redirect()->route('homepage');
        }
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();
        flash(translate('Registration successful.'))->success();
    }

    protected function create(array $data)
    {
        // dd($data['name']);
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $data['email'];
        }
        else
        {
            $email = "";
        }
        $data_created = 
        [
            'name' => $data['name'],
            'email' => $email,
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'district' => $data['district'],
            'city' => $data['city'],
            'country' => $data['country'],
            'address' => $data['address'],
            'user_type' =>  $data['user_type'],
            'ward' => 0
        ];
        $user = User::create($data_created);
        return $user;
    }
}
