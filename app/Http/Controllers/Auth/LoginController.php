<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if (Auth::user()->type == 1) {
                return redirect()->route('admin.index');
            } else if (Auth::user()->type == 2) {
                Auth::user()->syncSubscriptions();
                return redirect()->route('business.index');
            } else {
                Auth::user()->syncSubscriptions();
                return redirect()->route('client.index');
            }
        } else {
            return redirect()->back()->with('error', 'Email-Address Or Password Are Wrong.');
        }
    }
}
