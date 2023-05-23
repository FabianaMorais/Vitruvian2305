<?php

namespace App\Http\Controllers\PrivateAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\ServerTools\Mailer;

use App\Models\Users\User;
use App\Models\Patient;
use App\Models\Professional;

use DB;

use Log;

/**
 * Deals with all things related to Authentication for the private API
 */
class ApiAuthController extends Controller
{

    /**
     * Allows a patient user to effectively confirm his registration
     * and define a personal password
     * 
     * @param Request with username, inscription_code and password
     */
    public function firstLogin(Request $request) {
        $request->validate([
            'username' => 'required|string|min:5|max:80',
            'inscription_code' => 'required|string|min:12|max:12',
            'password' => 'required|string|min:8|max:16',
        ]);

        $user = User::where('name', $request->username)->get()->first();

        if( isset($user) && $user->isPatient() ){

            $patient = $user->getRoleData();

            // If the patient already completed his registry, he cannot do it again
            if($patient->isFullyRegistered()) {
                abort(401);
            }

            // Validating user code
            if ($patient->inscription_code != $request->inscription_code) {
                abort(406);
            }

            $user->password = Hash::make( $request->password );
            $user->email_verified_at = Carbon::now();
            $user->save();

            $patient->first_login = Carbon::now();
            $patient->save();

            $user_code = $patient->inscription_code;

            // create user's collection in mongodb
            DB::connection('mongodb')->createCollection($patient->inscription_code);

            //create token
            $token = $user->createToken('Vitruvian')->accessToken;
            return response()->json(['token' => $token, 'user_code' => $user_code], 200);

        }else{
            abort(406);
        }
    }

    /**
     * Logs in a user and returns their access token
     *
     * @param Request with inscription code and password
     */
    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string|min:5|max:80',
            'password' => 'required|string|min:6|max:16',
        ]);

        $credentials = [
            'name' => $request->username,
            'password' => $request->password,
        ];

        if( !Auth::attempt($credentials) ) {
            abort(401);
        }

        //create token
        $user = $request->user();
        $token = $user->createToken('Vitruvian')->accessToken;

        if ($user->isPatient()) {
            $user_code = $user->getRoleData()->inscription_code;
        } else {
            $user_code = "";
        }

        return response()->json(['token' => $token, 'user_code' => $user_code], 200);
    }

    /**
     * Logs the user user out of the system
     *
     * Always presents to the user a successful logout, even if with errors
     */
    public function logout(Request $request) {

        if ($request->user()->token() != null) {
            $request->user()->token()->revoke();
            return response()->json([ 'res'=>'Logout successful' ], 200);

        } else {
            return response()->json([ 'res'=>'Logout with error' ], 203);
        }
    }

    /**
     * Validated the user's session token
     */
    public function validateToken(Request $request) {
        return response()->json(['success' => 'Token is valid'], 200);
    }

    /**
     * Changes the password for an authenticated user using the mobile application
     * @param Requet with old password and new password
     */
    public function changePassword(Request $request) {
        $request->validate([
            'old_password' => 'required|string|min:6|max:16', // test users have 6 character passwords
            'new_password' => 'required|string|min:8|max:16',
        ]);

        $user = $request->user();

        if ( !Hash::check( $request->old_password, $user->password) ) {
            abort(401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => 'Password changed successfully'], 200);
    }

    /**
     * Recover a patient's password
     * @param Request with username, patient code and desired password
     */
    public function recoverPassword(Request $request) {

        $request->validate([
            'username' => 'required|string|min:5|max:80',
            'patient_code' => 'required|string|min:12|max:12',
            'password' => 'required|string|min:8|max:16',
        ]);

        $user = User::where('name', $request->username)->get()->first();

        if( isset($user) && $user->isPatient() ){

            $patient = $user->getRoleData();

            if(!$patient->isFullyRegistered()) { // patient must be fully registered
                abort(401);
            }

            if ($patient->inscription_code != $request->patient_code) { // Validating user code
                abort(406);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            $user_code = $patient->inscription_code;

            //create token
            $token = $user->createToken('Vitruvian')->accessToken;
            return response()->json(['token' => $token, 'user_code' => $user_code], 200);
        }

        abort(406);
    }

    /**
     * Resends a user's code to his email account, so he can
     * recover his password
     * 
     * This way, we guarantee that he is the correct user because his
     * email account is only accessible to him
     * 
     * @param Request with user's email
     */
    public function resendCode(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->where('type', User::PATIENT)->get()->first();

        if (isset($user)) { // If we find a valid user

            $code = $user->getRoleData()->inscription_code;

            $subject = trans('auth.EMAIL_RECOVER_USER_CODE_TTL');
            $text = trans('auth.EMAIL_RECOVER_USER_CODE_TXT_A') . $code . trans('auth.EMAIL_RECOVER_USER_CODE_TXT_B');

            Mailer::sendEmailToPatient($request->email, $subject, $text);

            return response()->json(['success' => 'Mail sent to ' . $request->email], 200);

        } else {
            abort(404);
        }
    }

}
