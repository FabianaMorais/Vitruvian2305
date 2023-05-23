<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use App\Models\Users\User;
use App\Models\Professional;
use App\ServerTools\UserFileManager;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\ServerTools\Mailer;
use App\Models\TeamUser;

use Log;

class OrganizationController extends Controller
{

    /**
     * 
     * NOTE: User is guaranteed to be an organization by the route's middleware
     * 
     * Route:
     * name('org.manage.pros')
     */
    public function indexPros()
    {
        // get all pros from the current organization
        $org = Organization::where('fk_user_id', Auth::user()->id )->get()->first();
        $org_pros = $org->getProUIList();

        return view('organizations.manage_pros.index_pros', compact('org_pros'));
    }

    /**
     * Displays the "Add new professional" view for organizations
     * name('org.manage.pros.new')
     */
    public function addProForm(Request $req)
    {
        return view('organizations.manage_pros.add_pro');
    }

    /**
     * Registers a new professional in the web app adn associates it with the current organization user
     * name('org.manage.pros.save_new')
     */
    public function saveNewPro(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:5|max:80|unique:users,name|unique:pgsql_new_users.public.new_users,name',
            'type' => 'required|in:researcher,doctor,caregiver',
            'full_name' => 'required|min:5|max:80',
            'email' => 'required|string|email|max:80|unique:users,email|unique:pgsql_new_users.public.new_users,email',
            'address' => 'required|min:5|max:160',
            'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
            'avatar_file' => 'image|mimes:jpeg,png,jpg|max:6656' // 6656Kb = 6.5MB
        ], [
            'name.required' => trans('validation.VAL_REQUIRED'),
            'name.min' => trans('validation.VAL_MIN_5'),
            'name.unique' => trans('validation.VAL_USER_EXISTS'),

            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),

            'email.required' => trans('validation.VAL_REQUIRED'),
            'email.min' => trans('validation.VAL_MIN_5'),
            'email.unique' => trans('validation.VAL_EMAIL_EXISTS'),
            'email.email' => trans('validation.VAL_EMAIL_TYPE'),

            'address.required' => trans('validation.VAL_REQUIRED'),
            'address.min' => trans('validation.VAL_MIN_5'),

            'phone.required' => trans('validation.VAL_REQUIRED'),
            'phone.unique' => trans('validation.VAL_PHONE_EXISTS'),
        ]);

        if (!Auth::user()->isOrganization()) { // Making sure the current user is an organization
            abort(401); // else, he is unauthorized
        }

        // Defining selected type
        switch($req->input('type')) {
            case 'doctor':
                $type = User::DOCTOR;
                break;
            case 'caregiver':
                $type = User::CAREGIVER;
                break;
            default: // includes 'researcher'
                $type = User::RESEARCHER;
                break;
        }

        // generating random password start
        $str_result = '0123456789abcdefghijklmnopqrstuvwxyz!#$%&/=_:.,;';
        $rndPassStart = substr(str_shuffle($str_result), 0, 4);

        // creating professional and user entry
        $newUser = User::create([
            'name' => $req->input('name'),
            'email' => $req->input('email'),
            'password' => Hash::make( $rndPassStart . Auth::user()->getRoleData()->code ), // generating password by adding organization's code
            'email_verified_at' => Carbon::now(),
            'type' => $type,
        ]);

        if ($req->file('avatar_file') !== null) {
            $fileName = UserFileManager::saveAvatarImage($newUser->name, $req->file('avatar_file'));
            $newUser->avatar = $fileName; // saving avatar name on user model
            $newUser->save();
        }

        $newProData = Professional::create([
            'fk_user_id' => $newUser->id,
            'full_name' => $req->input('full_name'),
            'address' => $req->input('address'),
            'phone' => $req->input('phone'),
        ]);
        $newProData->fk_organization_id = Auth::user()->getRoleData()->id; // For the current organization
        $newProData->save();

        // Emailing the new professional
        // NOTE: We only tell the first 4 characters of the password to the user
        // he must request the organization code to his organization in order to complete complete his password.
        $subject = trans('pg_manage_pros.EMAIL_REGISTRATION_SUBJECT');
        $text = trans('pg_manage_pros.EMAIL_REGISTRATION_TEXT_A')
                . '<b>' . $req->input('name') . '</b>'
                . trans('pg_manage_pros.EMAIL_REGISTRATION_TEXT_B')
                . '<b>' .$rndPassStart . '</b>'
                . trans('pg_manage_pros.EMAIL_REGISTRATION_TEXT_C') ;

        Mailer::sendEmailToPro($req->input('email'), $subject, $text);

        return view('organizations.manage_pros.add_pro_complete');
    }


    /**
     * Displays the "Edit professional" view for organizations
     * name('org.manage.pros.edit')
     */
    public function editProForm(Request $req, $proKey)
    {
        // Testing Professional's user key as UUID
        $uuidPattern = '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/';

        if( !preg_match($uuidPattern, $proKey) || strlen($proKey) != 36 ) {
            abort(401);
        }

        $proUser = User::where( 'id', $proKey )->get()->first();

        if ( isset($proUser) && $proUser->isProfessional() ) {

            $pro_entry = $proUser->getData();

            // If the current user is not the professional's organization
            if (!Auth::user()->isOrganization() || Auth::user()->getRoleData()->id != $pro_entry->fk_organization_id) {
                abort(401); // else, he is unauthorized
            }

        } else {
            abort(404);
        }

        return view('organizations.manage_pros.edit_pro', compact('pro_entry'));
    }

    /**
     * Saves changes to an already existing professional's profile from the current organization
     * name('org.manage.pros.save_edit')
     */
    public function saveEditPro(Request $req)
    {
        /* NOTE:
        We'll have to perform multiple validation steps to preserve email and phone as unique entries.
        We'll only validate these two fields if, and only if, they were actually changed.
        This is because, if they were kept the same, we would be unable to save them due to being
        tagged as "unique", since they would already be associated with a user entry (the current
        professional's entry), and validation would be failed. */
        $req->validate([
            'pro_key' => 'required|uuid',
            'type' => 'required|in:researcher,doctor,caregiver',
            'full_name' => 'required|min:5|max:80',
            'address' => 'required|min:5|max:160',
            'avatar_file' => 'image|mimes:jpeg,png,jpg|max:6656' // 6656Kb = 6.5MB
        ], [
            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),

            'address.required' => trans('validation.VAL_REQUIRED'),
            'address.min' => trans('validation.VAL_MIN_5'),
        ]);

        $proUser = User::where( 'id', $req->input('pro_key') )->get()->first();

        // After retrieving the user, we'll perform validations on the email and phone fields
        if ( isset($proUser) && $proUser->isProfessional() ) {

            $proData = $proUser->getRoleData(); // Professional's role data

            // Making sure the current user is the professional's organization
            if (Auth::user()->isOrganization() && Auth::user()->getRoleData()->id == $proData->fk_organization_id) {

                // Updating data
                if ( $req->input('email') !== NULL && $req->input('email') != $proUser->email ) { // if the email field was changed
                    $req->validate([
                    'email' => 'required|string|email|max:80|unique:users,email|unique:pgsql_new_users.public.new_users,email',
                    ], [
                        'email.required' => trans('validation.VAL_REQUIRED'),
                        'email.min' => trans('validation.VAL_MIN_5'),
                        'email.unique' => trans('validation.VAL_EMAIL_EXISTS'),
                        'email.email' => trans('validation.VAL_EMAIL_TYPE'),
                    ]);

                    $proUser->email = $req->input('email');
                }

                if ( $req->input('phone') !== NULL && $req->input('phone') != $proData->phone ) { // if the phone field was changed
                    $req->validate([
                        'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
                    ], [
                        'phone.required' => trans('validation.VAL_REQUIRED'),
                        'phone.unique' => trans('validation.VAL_PHONE_EXISTS'),
                    ]);

                    $proData->phone = $req->input('phone');
                }

                if ($req->file('avatar_file') !== null) {
                    $fileName = UserFileManager::saveAvatarImage($proUser->name, $req->file('avatar_file'));
                    $proUser->avatar = $fileName; // saving avatar name on user model
                }

                // Defining selected type
                switch($req->input('type')) {
                    case 'doctor':
                        $type = User::DOCTOR;
                        break;
                    case 'caregiver':
                        $type = User::CAREGIVER;
                        break;
                    default: // includes 'researcher'
                        $type = User::RESEARCHER;
                        break;
                }
                $proUser->type = $type;
                $proData->address = $req->input('address');
                $proData->full_name = $req->input('full_name');

                $proData->save();
                $proUser->save();

                $pro_key = $proUser->id;

                return view('organizations.manage_pros.edit_pro_complete', compact('pro_key'));

            } else { // If not the professional's organization
                abort(401);
            }

        } else { // Professional entry not found
            abort(404);
        }
    }

    /**
     * Removes the passed professional from the current organization
     * name('org.manage.pros.delete')
     */
    public function removePro(Request $req, $proKey)
    {
        // Testing Professional's user key as UUID
        $uuidPattern = '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/';

        if( !preg_match($uuidPattern, $proKey) || strlen($proKey) != 36 ) {
            abort(401);
        }

        $proUser = User::where( 'id', $proKey )->get()->first();

        if ( isset($proUser) && $proUser->isProfessional() ) {

            $pro = $proUser->getRoleData();

            // If the current user is not the professional's organization
            if (!Auth::user()->isOrganization() || Auth::user()->getRoleData()->id != $pro->fk_organization_id) {
                abort(401); // else, he is unauthorized
            }

            // Removing
            $pro->fk_organization_id = NULL;
            $pro->save();

            // Removing from this organization's projects
            $teamParticipations = TeamUser::where('fk_user_id', $proKey)->get();
            foreach ($teamParticipations as $part) {
                // CONSIDER: Includes removing this professional from other organization's projects as well.
                $part->delete();
            }

            return view('organizations.manage_pros.delete_pro_complete');

        } else {
            abort(404);
        }
    }

}
