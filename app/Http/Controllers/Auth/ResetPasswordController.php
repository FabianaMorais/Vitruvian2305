<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

use App\Models\Users\NewUser;

use Log;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * OVERRIDE
     * Overriding function so we can pass the email to the broker function
     * 
     * Reset the given user's password.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request) {

        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker( $request->get('email') )->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * OVERRIDE
     * Overriding function so we can pass the email to the guard function
     * 
     * Reset the given user's password.
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password) {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        // $this->guard( $user->email )->login($user);


    }

    /**
     * OVERRIDE
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response) {

        // Since our request already has inputs with email and password
        // we'll use them to simply log through the login controller
        $login = new LoginController();
        $login->login($request);

        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }


    /**
     * OVERRIDE
     * Returns the appropriate broker depending on the passed email
     * 
     * Get the broker to be used during password reset.
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker($email) {

        $newUser = NewUser::where('email', $email)->get()->first();

        if (isset($newUser)) { // if the email refers to a new user
            return Password::broker('new_users'); // we return the broker for new users

        } else { // if not, we return the broker for regular users
            return Password::broker('users');
        }
    }

    /**
     * OVERRIDE
     * Returns the appropriate guard depending on the passed email
     * 
     * Get the guard to be used during password reset.
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard($email) {
        $newUser = NewUser::where('email', $email)->get()->first();

        if (isset($newUser)) { // if the email refers to a new user
            return Auth::guard('new_reg'); // we return the guard for new registries

        } else { // if not, we return the guard for regular users
            return Auth::guard('web');
        }

    }

}
