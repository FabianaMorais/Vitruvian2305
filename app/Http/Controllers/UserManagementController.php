<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users\NewUser;
use App\Models\Users\User;
use App\Models\Professional;
use App\Models\Organization;

use App\ServerTools\Mailer;
use Carbon\Carbon;
use Log;

/**
 * Regulates the acceptance or refusal of new users
 * 
 * TODO: Optimizations. Check TODO comments
 * 
 */
class UserManagementController extends Controller
{
    /**
     * These functions are only accessible to admins
     */
    public function __construct() {
        $this->middleware('auth:web');
        $this->middleware('access:admin');
    }

    /**
     * Displays the view to accept / refuse new users
     */
    public function showManageRegistrationsView(Request $request) {

        // Retrieving new registrations (only after email verification)
        $newUsers = NewUser::whereNotNull('email_verified_at')->get();
        $user_list = array();

        foreach($newUsers as $nu) {
            $user_list[$nu->id] = $nu->getFullName();
        }

        return view('admins.user_registrations.manage_regs', compact('user_list'));
    }


    /**
     * Returns a new registration entry
     */
    public function viewRegistrationEntry(Request $request) {

        $request->validate([
            'entry' => 'required|string|min:36|max:36', // expecting uuid
        ]);

        $newUser = NewUser::find($request->input('entry'));
        $user_info = $newUser->getData();

        // rendering the panel according to the new user's type
        if ($newUser->isType(NewUser::NEW_ORGANIZATION)) {
            $entryView = view('admins.user_registrations.entry_org', compact('user_info'))->render();
        } else {
            $entryView = view('admins.user_registrations.entry_pro', compact('user_info'))->render();
        }

        $resp = new \stdClass();
        $resp->entry_view = $entryView;
        return response()->json($resp, 200);
    }

    /**
     * Accepts a new registration and creates a new accepted User entry
     */
    public function acceptRegistration(Request $request) {

        $request->validate([
            'entry' => 'required|string|min:36|max:36', // expecting uuid
        ]);

        // TODO: Future proof: What if various admins try to accept / refuse the same new user at the same time?

        $acceptedUser = NewUser::find($request->input('entry'));
        if( $this->userWasCreated($acceptedUser) ) {

            $subject = trans('pg_manage_regs.EMAIL_ACCEPTED_SUBJECT');
            $text = trans('pg_manage_regs.EMAIL_ACCEPTED_TEXT');
            Mailer::sendEmailToPro($acceptedUser->email, $subject, $text);

            // Deleting NewUser entry
            $acceptedUser->deleteAccount();

            return response()->json("OK", 200);
        }

        // If we reach this point, it means the user was not created successfully
        Log::debug("[ERROR] NewUser with id " . $acceptedUser->id . " was NOT able to be accepted. No User entry was created.");
        return response()->json("Not created", 422);
    }

    /**
     * Refuses a new registration and deletes the NewUser entry
     */
    public function refuseRegistration(Request $request) {

        $request->validate([
            'entry' => 'required|string|min:36|max:36', // expecting uuid
        ]);

        // TODO: Future proof: What if various admins try to accept / refuse the same new user at the same time?

        $rejectedUser = NewUser::find($request->input('entry'));

        $subject = trans('pg_manage_regs.EMAIL_REJECTED_SUBJECT');
        $text = trans('pg_manage_regs.EMAIL_REJECTED_TEXT');
        Mailer::sendEmailToPro($rejectedUser->email, $subject, $text);

        $rejectedUser->deleteAccount(); // Deleting NewUser entry

        return response()->json("OK", 200);
    }

    /**
     * Creates a User from a NewUser, depending on its type
     * @param NewUser The NewUser entry to create the user from
     * @return bool true if the user was created successfully
     */
    private function userWasCreated(NewUser $nu) : bool {

        // NOTE: usernames and emails are guaranteed to be unique due to being checked upon registration

        $nuData = $nu->getData(); // retrieving data

        if ($nu->isType(NewUser::NEW_ORGANIZATION)) { // Creating an organization user

            $userData = User::create([
                'name' => $nuData->username,
                'email' => $nuData->email,
                'password' => $nu->password, // retirved directly from model
                'email_verified_at' => Carbon::now(), // becomes the date it was accepted
                'type' => User::ORGANIZATION,
                'avatar' => $nuData->avatar,
            ]);

            Organization::create([
                'fk_user_id' => $userData->id,
                'full_name' => $nuData->full_name,
                'official_email' => $nuData->email,
                'leader_name' => $nuData->leader_name,
                'fiscal_number' => $nuData->fiscal_number,
                'address' => $nuData->address,
                'phone' => $nuData->phone,
            ]);

            return true;

        } else if ($nu->isProfessional()) { // Creating a professional user

            // Mapping user types
            switch($nu->type) {
                case NewUser::NEW_DOCTOR:
                    $userType = User::DOCTOR;
                    break;
                case NewUser::NEW_CAREGIVER:
                    $userType = User::CAREGIVER;
                    break;
                default: // includes 'NEW_RESEARCHER'
                    $userType = User::RESEARCHER;
                    break;
            }

            $userData = User::create([
                'name' => $nuData->username,
                'email' => $nuData->email,
                'password' => $nu->password, // retirved directly from model
                'email_verified_at' => Carbon::now(), // becomes the date it was accepted
                'type' => $userType,
                'avatar' => $nuData->avatar,
            ]);

            $proData = Professional::create([
                'fk_user_id' => $userData->id,
                'full_name' => $nuData->full_name,
                'address' => $nuData->address,
                'phone' => $nuData->phone,
            ]);

            // if the new user has a set organization
            if (isset($nuData->organization_id)) {
                $proData->fk_organization_id = $nuData->organization_id;

            } else { // if not, we save its name
                $proData->custom_organization = $nuData->organization_name;
            }
            $proData->save();

            return true;

        } else {
            return false;
        }
    }
}
