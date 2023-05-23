<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use App\Models\Users\NewUser;
use App\Models\NewRegistries\NewProData;
use App\Models\NewRegistries\NewOrgData;

use App\Models\Organization;
use App\Models\Professional;


use App\ServerTools\PopulateInvestorAccount;

use Log;
use Carbon\Carbon;

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
    protected $redirectTo = '/home';

    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * OVERRIDE
     * Override to query for organization names
     * 
     * Show the application registration form.
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $orgs_list = array();
        $orgs = Organization::all();

        foreach ($orgs as $o) { // building a list of all organization naes
            array_push($orgs_list, $o->full_name);
        }

        return view('auth.register', compact('orgs_list'));
    }

    /**
     * OVERRIDE
     * Get a validator for an incoming registration request.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        // selecting form submission depending on the passed type
        if (isset($data['rb_regist']) && $data['rb_regist'] == "organization") {
            return $this->validateNewOrganization($data);

        } else { // by default, we assume it was the new professionals' form
            return $this->validateNewProfessional($data);
        }
    }

    /**
     * Validates the new professional form
     */
    private function validateNewProfessional(array $data) {

        $validator = Validator::make($data, [
            'rb_regist' => 'required|in:professional',

            'rb_regist_pro_type' => 'required|in:researcher,doctor,caregiver',

            'pro_name' => ['required', 'string', 'min:5', 'max:80', 'unique:users,name', 'unique:mysql_new_users.new_users,name'],
            'pro_full_name' => ['required', 'min:5', 'max:80'],
            'pro_email' => ['required', 'string', 'email', 'max:80', 'unique:users,email', 'unique:mysql_new_users.new_users,email'],
            'pro_address' => ['required', 'min:5', 'max:160'],
            'pro_phone' => ['required', 'max:30'],
            'pro_organization' => ['nullable', 'exists:organizations,full_name'], // Must exist in organizations table or be null
            'pro_custom_organization' => ['required_without:pro_organization', 'max:160'],
            'pro_password' => ['required', 'string', 'min:8', 'max:80', 'confirmed'], // NOTE: confirmation field must be pro_password_confirmation
            'cb_pro_policy' => ['accepted'],

        ], [
            'pro_name.required' => trans('validation.VAL_REQUIRED'),
            'pro_name.min' => trans('validation.VAL_MIN_5'),
            'pro_name.unique' => trans('validation.VAL_USER_EXISTS'),

            'pro_full_name.required' => trans('validation.VAL_REQUIRED'),
            'pro_full_name.min' => trans('validation.VAL_MIN_5'),

            'pro_email.required' => trans('validation.VAL_REQUIRED'),
            'pro_email.min' => trans('validation.VAL_MIN_5'),
            'pro_email.unique' => trans('validation.VAL_EMAIL_EXISTS'),
            'pro_email.email' => trans('validation.VAL_EMAIL_TYPE'),

            'pro_address.required' => trans('validation.VAL_REQUIRED'),
            'pro_address.min' => trans('validation.VAL_MIN_5'),

            'pro_phone.required' => trans('validation.VAL_REQUIRED'),

            'pro_custom_organization.required_without' => trans('validation.VAL_REQUIRED_ORGANIZATION'),

            'pro_password.required' => trans('validation.VAL_REQUIRED'),
            'pro_password.min' => trans('validation.VAL_MIN_8'),
            'pro_password.confirmed' => trans('validation.VAL_PASSWORD_CONFIRMATION'),

            'cb_pro_policy.accepted' => trans('validation.VAL_CHECKBOX_REQUIRED'),
        ]);

        if (isset($data['rb_regist_pro_type'])) { // returning the selected professional type so the form auto selects it
            $proType = $data['rb_regist_pro_type'];
        } else {
            $proType = 'researcher';
        }

        // if the validation fails, we add information about which of the forms was being viewed
        if ($validator->fails()) {
            $validator->after(function ($validator) use ($proType) {
                $validator->errors()->add('type', "professional");
                $validator->errors()->add('pro_type', $proType);
            });
        }

        // Log::debug(print_r($validator->errors(), true));

        return $validator;
    }

    /**
     * Validates the new organization form
     */
    private function validateNewOrganization(array $data) {

        $validator = Validator::make($data, [
            'rb_regist' => 'required|in:organization',

            'org_name' => ['required', 'string', 'min:5', 'max:80', 'unique:users,name', 'unique:mysql_new_users.new_users,name'],
            'org_full_name' => ['required', 'min:5', 'max:80', 'unique:organizations,full_name', 'unique:mysql_new_users.data_new_orgs,full_name'],
            'org_email' => ['required', 'string', 'email', 'max:80', 'unique:users,email', 'unique:mysql_new_users.new_users,email'],
            'org_leader_name' => ['required', 'min:5', 'max:80'],
            'org_fiscal' => ['required', 'min:5', 'max:80'], // TODO: How is a fiscal number composed? Leave as text?
            'org_address' => ['required', 'min:5', 'max:160'],
            'org_phone' => ['required', 'max:30'],
            'org_password' => ['required', 'string', 'min:8', 'max:80', 'confirmed'], // NOTE: confirmation field must be pro_password_confirmation
            'cb_org_policy' => ['accepted'],

        ], [
            'org_name.required' => trans('validation.VAL_REQUIRED'),
            'org_name.min' => trans('validation.VAL_MIN_5'),
            'org_name.unique' => trans('validation.VAL_USER_EXISTS'),

            'org_full_name.required' => trans('validation.VAL_REQUIRED'),
            'org_full_name.min' => trans('validation.VAL_MIN_5'),
            'org_full_name.unique' => trans('validation.VAL_ORGANIZATION_EXISTS'),

            'org_email.required' => trans('validation.VAL_REQUIRED'),
            'org_email.min' => trans('validation.VAL_MIN_5'),
            'org_email.unique' => trans('validation.VAL_EMAIL_EXISTS'),
            'org_email.email' => trans('validation.VAL_EMAIL_TYPE'),

            'org_leader_name.required' => trans('validation.VAL_REQUIRED'),
            'org_leader_name.min' => trans('validation.VAL_MIN_5'),

            'org_fiscal.required' => trans('validation.VAL_REQUIRED'),
            'org_fiscal.min' => trans('validation.VAL_MIN_5'), // TODO: How is a fiscal number composed? Leave as text?

            'org_address.required' => trans('validation.VAL_REQUIRED'),
            'org_address.min' => trans('validation.VAL_MIN_5'),

            'org_phone.required' => trans('validation.VAL_REQUIRED'),

            'pro_custom_organization.required_without' => trans('validation.VAL_REQUIRED_ORGANIZATION'),

            'org_password.required' => trans('validation.VAL_REQUIRED'),
            'org_password.min' => trans('validation.VAL_MIN_8'),
            'org_password.confirmed' => trans('validation.VAL_PASSWORD_CONFIRMATION'),

            'cb_org_policy.accepted' => trans('validation.VAL_CHECKBOX_REQUIRED'),
        ]);

        // if the validation fails, we add information about which of the forms was being viewed
        if ($validator->fails()) {
            $validator->after(function ($validator) {
                $validator->errors()->add('type', "organization");
            });
        }

        // Log::debug(print_r($validator->errors(), true));

        return $validator;
    }

    /**
     * Create a new "new user" instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Users\NewUser
     */
    protected function create(array $data) {

        if (isset($data['rb_regist']) && $data['rb_regist'] == "organization") { // register new organizations

            if(env('INVESTOR_SERVER', false)){
                return $this->addTestOrganization($data);
            }

            $newUser = NewUser::create([
                'name' => $data['org_name'],
                'email' => $data['org_email'],
                'password' => Hash::make($data['org_password']),
                'type' => NewUser::NEW_ORGANIZATION,
            ]);

            NewOrgData::create([
                'fk_new_user_id' => $newUser->id,
                'full_name' => $data['org_full_name'],
                'leader_name' => $data['org_leader_name'],
                'fiscal_number' => $data['org_fiscal'],
                'address' => $data['org_address'],
                'phone' => $data['org_phone'],
            ]);

            return $newUser;

        } else { // register new professionals
            
            if(env('INVESTOR_SERVER', false)){
                return $this->addTestProfessional($data);
            }

            // Setting the chosen professional type
            switch($data['rb_regist_pro_type']) {
                case 'doctor':
                    $type = NewUser::NEW_DOCTOR;
                    break;
                case 'caregiver':
                    $type = NewUser::NEW_CAREGIVER;
                    break;
                default: // includes 'researcher'
                    $type = NewUser::NEW_RESEARCHER;
                    break;
            }

            $newUser = NewUser::create([
                'name' => $data['pro_name'],
                'email' => $data['pro_email'],
                'password' => Hash::make($data['pro_password']),
                'type' => $type,
            ]);

            $newProData = NewProData::create([
                'fk_new_user_id' => $newUser->id,
                'full_name' => $data['pro_full_name'],
                'address' => $data['pro_address'],
                'phone' => $data['pro_phone'],
            ]);

            if (isset($data['pro_organization'])) { // if the user picked an organization from the list

                // Now we fetch the chosen organization by name
                $org = Organization::where('full_name', $data['pro_organization'])->get()->first();
                if (isset($org)) { // if we find it
                    $newProData->fk_organization_id = $org->id;

                } else { // if we are unable to find it, we associate a custom name, but log the event
                    Log::debug("ERROR: Register controller was unable to find organization by name. Adding custom organization to professional entry with id " . $newProData->id);
                    $newProData->custom_organization = $data['pro_organization'];
                }
                $newProData->save();

            } else { // but if the user chose a custom organization
                $newProData->custom_organization = $data['pro_custom_organization'];
                $newProData->save();
            }

            return $newUser;
        }
    }


    /**
     * OVERRIDE
     * Override to get guard depending on user type
     * 
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // removed so we login through the login controller in the registered() function
        //$this->guard($user->name)->login($user);
       
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * OVERRIDE
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard($username) {
        $newUser = NewUser::where('name', $username)->get()->first();

        if (isset($newUser)) { // if the email refers to a new user
            return Auth::guard('new_reg'); // we return the guard for new registries

        } else { // if not, we return the guard for regular users
            return Auth::guard('web');
        }

        // If no guards are present, we return the default value
        return Auth::guard();
    }

    /**
     * OVERRIDE
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user) {

        // We log in through the login controller to avoid session object maintenance
        // on both this controller and LoginController
        $request->merge(['email' => $user->email]);

        if ($request->input()['rb_regist'] == "organization") {
            $request->merge(['password' => $request->input()['org_password']]);
        } else {
            $request->merge(['password' => $request->input()['pro_password']]);
        }

        // Logging in and presenting the user with the "resend email" option
    
        $login = new LoginController();
        $login->login($request);

    }


    private function addTestProfessional(Array $data ) : User{
        // Setting the chosen professional type
        switch($data['rb_regist_pro_type']) {
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

        $user = User::create([
            'name' => $data['pro_name'],
            'email' => $data['pro_email'],
            'password' => Hash::make($data['pro_password']),
            'type' => $type,
            'email_verified_at' => Carbon::now(),
            'avatar' => 'prof_template' . rand(1,11) . '_avt.jpg'
        ]);

        $proData = Professional::create([
            'fk_user_id' => $user->id,
            'full_name' => $data['pro_full_name'],
            'address' => $data['pro_address'],
            'phone' => $data['pro_phone'],
        ]);

        if (isset($data['pro_organization'])) { // if the user picked an organization from the list
            // Now we fetch the chosen organization by name
            $org = Organization::where('full_name', $data['pro_organization'])->get()->first();
            if (isset($org)) { // if we find it
                $proData->fk_organization_id = $org->id;
            } else { // if we are unable to find it, we associate a custom name, but log the event
                Log::debug("ERROR: Register controller was unable to find organization by name. Adding custom organization to professional entry with id " . $newProData->id);
                $proData->fk_organization_id = $data['pro_organization'];
            }
            $proData->save();

        } else { // but if the user chose a custom organization
            $proData->custom_organization = $data['pro_custom_organization'];
            $proData->save();
        }

        $patient_list = PopulateInvestorAccount::populateProfessional($user,5);
        PopulateInvestorAccount::populatePatientList($patient_list);
        PopulateInvestorAccount::addPatientsToTeam($user, $patient_list);

        return $user;
    }

    private function addTestOrganization(Array $data) : User {
        $user = User::create([
            'name' => $data['org_name'],
            'email' => $data['org_email'],
            'password' => Hash::make($data['org_password']),
            'type' => User::ORGANIZATION,
            'email_verified_at' => Carbon::now(),
            'avatar' => 'org_template_avt.jpg'
        ]);
        $org = Organization::create([
            'fk_user_id' => $user->id,
            'full_name' => $data['org_full_name'],
            'leader_name' => $data['org_leader_name'],
            'fiscal_number' => $data['org_fiscal'],
            'address' => $data['org_address'],
            'phone' => $data['org_phone'],
            'official_email' => $data['org_email']
        ]);
        $professional_list = PopulateInvestorAccount::populateOrganization($user,5);
        foreach($professional_list as $professional){
            $patient_list = PopulateInvestorAccount::populateProfessional($professional,5);
        }
        
        PopulateInvestorAccount::createTeams($professional_list,$user);

        return $user;
    }

}
