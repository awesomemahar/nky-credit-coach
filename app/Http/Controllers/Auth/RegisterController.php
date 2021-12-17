<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'package' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $package = SubscriptionPackage::where('id',$data['package'])->where('status',1)->first();
        if(!is_null($package) && $package->package_type == 'Starter'){
            $type = 3;
        }elseif(!is_null($package) && $package->package_type == 'Business'){
            $type = 2;
        }else{
            return null;
        }

        try{
            return User::create([
                'first_name' => $data['first_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'subscription_package_id'=>$package->id,
                'subscription_status'=>1,
                'type' => $type,
                'trial_ends_at' => now()->addDays(7),
            ]);
        }catch (\Exception $exception){
            return null;
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if(is_null($user)){
            return back()->with('error', 'Something Went Wrong');
        }
        event(new Registered($user));

        $this->guard()->login($user);

        if ($user->type == 2) {
            return redirect()->route('business.index');
        } else if ($user->type == 3) {
            return redirect()->route('client.index');
        } else {
            auth()->logout();
            return back()->with('error', 'Something Went Wrong');
        }
    }
}
