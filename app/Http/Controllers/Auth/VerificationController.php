<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;

use App\ServerTools\Mailer;
use Mail;
use Config;
use Log;

use App\Models\Users\NewUser;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * OVERRIDE
     * Override to send an email to the administrator account
     * after a new user verifies its email
     * 
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {

            // checking user type
            switch($request->user()->type) {
                case NewUser::NEW_ORGANIZATION:
                    $typeTxt = "organization";
                break;
                
                case NewUser::NEW_DOCTOR:
                    $typeTxt = "medical professional";
                break;
                
                case NewUser::NEW_CAREGIVER:
                    $typeTxt = "caregiver";
                break;
                
                default:
                    $typeTxt = "researcher";
                break;
            }

            $subject = "New " . ucwords($typeTxt) . " Registration";
            $text = "A new " . $typeTxt . " under the username " . $request->user()->name . " requested to be registered in Vitruvian Shield.<br><br>The registration is waiting for your approval.<br><br>Please visit <a href='" . route('admin.registrations') . "'><u>your administrator dashboard</u></a> to do so.";
            Mailer::sendEmailToAdmin(config('vitruvian.email_admin'), $subject, $text);

            event(new Verified($request->user()));
        }

        return redirect($this->redirectPath())->with('verified', true);
    }
}
