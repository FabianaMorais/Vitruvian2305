<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ServerTools\UserFileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Log;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth:web,new_reg');
    }

    /**
     * Displays the profile page
     */
    public function index(Request $request) {

        $user_data = Auth::user()->getData();

        // Temp solution to display code to organizations
        if (Auth::user()->isOrganization()) {
            $org_code = Auth::user()->getRoleData()->code;
            return view('profile.profile_org', compact('user_data', 'org_code'));

        } else if (Auth::user()->isProfessional()) {
            return view('profile.profile_pros', compact('user_data'));

        } else if (Auth::user()->isAdmin()) {
            return view('profile.profile_admin', compact('user_data'));
        }

        abort(401);
    }


    /**
     * Updates the current user's profile
     * 
     */
    public function updateProfile(Request $request) {

        $request->validate([
            'in_profile_avt' => 'image|mimes:jpeg,png,jpg|max:6656' // 6656Kb = 6.5MB
        ]);

        // Saving avatar
        if ($request->file('in_profile_avt') !== NULL) {

            $user = $request->user();
            $filename = UserFileManager::saveAvatarImage($request->user()->name, $request->file('in_profile_avt'));
            $user->avatar = $filename; // saving avatar name on user model
            $user->save();

            session(['avatar' => $filename]); // updating ession
        }

        // Saving specific elements, depending on user type
        if (Auth::user()->isOrganization()) {
            return $this->saveOrganizationProfile($request);

        } else if (Auth::user()->isProfessional()) {
            return $this->saveProfessionalProfile($request);

        } else if (Auth::user()->isAdmin()) {
            return $this->saveAdminProfile($request);
        }

        abort(401);
    }


    /**
     * Changes the password for the current user
     */
    public function changePassword(Request $req) {

        $req->validate([
            'old_pw' => 'required|string|min:6|max:80',
            'new_pw' => 'required|string|min:8|max:80|confirmed', // NOTE: confirmation field must be new_pw_confirmation
        ]);

        // Checking old password
        if ( !Hash::check( $req->input('old_pw'), Auth::user()->password) ) {
            abort(401);
        }

        $user = Auth::user();
        $user->password = Hash::make($req->input('new_pw'));
        $user->save();

        return response()->json(200);
    }

    /**
     * Deletes a user's account and displays the delete successful view
     */
    public function deleteAccount(Request $req) {

        $user = Auth::user();
        Auth::logout(); // Logging out before deleting

        if ($req->input('cb_keep_data') == 'on') { // Checkbox ON = keep data
            $user->deleteAccount(false);

        } else { // Hard deleting
            $user->deleteAccount(true);
        }

        // Displaying success view
        return view('profile.shared_components.pg_account_deleted');
    }


    /**
     * Saves profile for organziation users
     */
    private function saveOrganizationProfile(Request $req) {

        $req->validate([
            'full_name' => 'required|string|min:5|max:80',
            'leader_name' => 'required|string|min:5|max:80',
            'fiscal_number' => 'required|string|min:5|max:80',
            'address' => 'required|string|min:5|max:160',
            'phone' => 'required|string|max:30',
        ], [
            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),

            'leader_name.required' => trans('validation.VAL_REQUIRED'),
            'leader_name.min' => trans('validation.VAL_MIN_5'),

            'fiscal_number.required' => trans('validation.VAL_REQUIRED'),

            'address.required' => trans('validation.VAL_REQUIRED'),
            'address.min' => trans('validation.VAL_MIN_5'),
        ]);

        // NOTE: Doesn't matter if it is an Organization or a New Organization, since the data structure is the same
        $org = Auth::user()->getRoleData();
        $org->full_name = $req->input('full_name');
        $org->leader_name = $req->input('leader_name');
        $org->fiscal_number = $req->input('fiscal_number');
        $org->address = $req->input('address');

        // phone must be unique but can be the same
        if ( $req->input('phone') !== NULL && $req->input('phone') != $org->phone ) {
            $req->validate([
                'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
            ], [
                'phone.required' => trans('validation.VAL_REQUIRED'),
                'phone.unique' => trans('validation.VAL_PHONE_EXISTS'),
            ]);

            $org->phone = $req->input('phone');
        }

        $org->save();

        return redirect( route('profile') );
    }

    /**
     * Saves profile for professional users
     */
    private function saveProfessionalProfile(Request $req) {

        $req->validate([
            'full_name' => 'required|string|min:5|max:80',
            'address' => 'required|string|min:5|max:160',
            'phone' => 'required|string|max:30',
        ], [
            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),

            'address.required' => trans('validation.VAL_REQUIRED'),
            'address.min' => trans('validation.VAL_MIN_5'),
        ]);

        // NOTE: Doesn't matter if it is a Professional or a New Professional, since the data structure is the same
        $pro = Auth::user()->getRoleData();
        $pro->full_name = $req->input('full_name');
        $pro->address = $req->input('address');

        // phone must be unique but can be the same
        if ( $req->input('phone') !== NULL && $req->input('phone') != $pro->phone ) {
            $req->validate([
                'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
            ], [
                'phone.required' => trans('validation.VAL_REQUIRED'),
                'phone.unique' => trans('validation.VAL_PHONE_EXISTS'),
            ]);

            $pro->phone = $req->input('phone');
        }

        $pro->save();

        return redirect( route('profile') );
    }


    /**
     * Saves profile for admin users
     */
    private function saveAdminProfile(Request $req) {

        $req->validate([
            'full_name' => 'required|string|min:5|max:80',
        ], [
            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),
        ]);

        $admin = Auth::user()->getRoleData();
        $admin->full_name = $req->input('full_name');
        $admin->save();

        return redirect( route('profile') );
    }
}
