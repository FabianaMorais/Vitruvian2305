<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Users\NewUser;
use App\Models\Users\User;
use App\Models\Permissions;

use Log;

class HomeController extends Controller
{

   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Displaying a different home depends on the guard type
        if (Auth::guard('new_reg')->check()) { // new users
            if ($request->user()->type == NewUser::NEW_ORGANIZATION) {
                return view('new_users.home_new_orgs');
            } else {
                return view('new_users.home_new_pros');
            }

        } else if (Auth::guard('web')->check()) { // regular users
            if ($request->user()->type == User::RESEARCHER
                || $request->user()->type == User::DOCTOR
                || $request->user()->type == User::CAREGIVER) {

                    return redirect(route('list patients'));

            } else if ($request->user()->type == User::ORGANIZATION) {
                return redirect(route('org.manage.pros'));

            } else if ($request->user()->type == User::ADMIN) {

                $dashboard_data = array(); // data to be presented on the dashboard panels
                $dashboard_data['registrations'] = count( NewUser::whereNotNull('email_verified_at')->get() ); // number of new registrations

                return view('admins.home', compact('dashboard_data'));
            }
        }

        // if something goes wrong, we show error 500
        return abort(500);
    }
}
