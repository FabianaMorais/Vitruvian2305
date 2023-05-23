<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Users\User;
use App\Models\Users\NewUser;

use Log;

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
    protected $redirectTo = '/home';

    public function __construct() {
        // Users with session authenticated by the passed guards won't be able to use
        // this controller's functions
        $this->middleware('guest')->except('logout');
    }

    /**
     * OVERRIDE
     * Attempts to login the current user cycling through various guards
     */
    protected function attemptLogin(Request $request) {

        if (Auth::guard('new_reg')->attempt($this->credentials($request), $request->filled('remember'))) {
            return true;

        } else if (Auth::guard('web')->attempt($this->credentials($request), $request->filled('remember'))) {
            return true;
        }

        // If unable to be authenticated by any of the guards
        return false;
    }


    /**
     * OVERRIDE
     * Setting session variables
     * 
     * The user has been authenticated.
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user) {

        // Storing avatar in session
        session(['avatar' => $user->avatar]);



    }

    /**
     * OVERRIDE
     * User can wither input the email or the username
     *
     * Get the needed authorization credentials from the request.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request) {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'name';
        
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    /**
     * OVERRIDE
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        if (Auth::guard('new_reg')->check()) {
            return Auth::guard('new_reg');

        } else if (Auth::guard('web')->check()) {
            return Auth::guard('web');
        }

        // If no guards are present, we return the default value
        return Auth::guard();
    }
}
