<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServerTools\Mailer;
use App\ServerTools\MongoManager;

use App\Models\Professional;
use App\Models\Patient;
use App\Models\Users\User;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\Medication;
use App\Models\PatientMedication;
use App\Models\CrisisEvent;
use App\Models\PatientCrisisEvent;
use App\Models\MinuteTimestamps;

//new sensors
use App\Models\Sensors\AdpdData;
use App\Models\Sensors\AdxlData;
use App\Models\Sensors\BcmData;
use App\Models\Sensors\EcgData;
use App\Models\Sensors\EdaData;
use App\Models\Sensors\PedometerData;
use App\Models\Sensors\PpgData;
use App\Models\Sensors\SqiData;
use App\Models\Sensors\SyncppgData;
use App\Models\Sensors\TemperatureData;

use App\Models\DownloadDataEntryBuilder;
use App\Models\PatientOwner;
use App\Models\Organization;
use App\Builders\PatientDescriptionData;

use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

use Log;

class PatientController extends Controller
{
    /**
     * Display a all Patients associated with the current user
     */
    public function index(Request $request) {

        // NOTE: Current user must be Professional, as guaranteed by the middleware

        $patient_infos = $request->user()->getRoleData()->getPatients(true);
        $meds = Medication::all();
        return view('professionals.list_patients', compact(['patient_infos','meds']));
    }

    /**
     * Show the form for creating a new Patient
     */
    public function addPatientForm() {
        return view('professionals.add_patient');
    }

    /**
     * Stores a new patient entry in the database
     */
    public function saveNewPatient(Request $request) {
        $request->validate([
            'name' => 'required|string|min:5|max:80|unique:users,name|unique:pgsql_new_users.public.new_users,name',

            'email' => 'required|email|unique:users,email|unique:pgsql_new_users.public.new_users,email',
            'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
            'full_name' => 'required|string|min:5|max:80',
        ], [

            'name.required' => trans('validation.VAL_REQUIRED'),
            'name.min' => trans('validation.VAL_MIN_5'),
            'name.unique' => trans('validation.VAL_USER_EXISTS'),

            'email.required' => trans('validation.VAL_REQUIRED'),
            'email.unique' => trans('validation.VAL_EMAIL_EXISTS'),
            'email.email' => trans('validation.VAL_EMAIL_TYPE'),

            'phone.required' => trans('validation.VAL_REQUIRED'),
            'phone.unique' => trans('validation.VAL_PHONE_EXISTS'),

            'full_name.required' => trans('validation.VAL_REQUIRED'),
            'full_name.min' => trans('validation.VAL_MIN_5'),
        ]);

        // Generating random password
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'; 
        $random_password = substr(str_shuffle($str_result), 0, 12);

        // Creating user entry
        $newPatUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make( str_shuffle($random_password) ), // This password doesn't matter as it will be replaced
            'type' => User::PATIENT,
        ]);

        // Creating patient entry
        $patient = Patient::create([
            'fk_user_id' => $newPatUser->id,
            'full_name' => $request->input('full_name'),
            'phone' => $request->input('phone'),
        ]);

        // Creating professional / user relationship
        PatientOwner::create([
            'fk_patient_id' => $patient->id,
            'fk_owner_id' => $request->user()->id,
        ]);

        // If the user was created by a professional
        if ($request->user()->isProfessional()) {

            // And that professional works for an organization
            $orgId = $request->user()->getRoleData()->fk_organization_id;

            if ($orgId != null) { // Professional may not have an organization
                $org = Organization::where('id', $orgId)->get()->first();

                if (isset($org)) {
                    PatientOwner::create([ // Then this new patient belongs to the organization as well
                        'fk_patient_id' => $patient->id,
                        'fk_owner_id' => $org->user->id,
                    ]);
                }

            }
        }
        // TODO: What if organizations are able to add patients as well?

        // TODO: Send SMS with username? or maybe switch: send the SMS with the user code and the email with the username and instructions
            // TODO: Note that the user should keep the user code forever, so maybe it's best by email?

        $subject = trans('pg_patient_description.NEW_PATIENT_EMAIL_TTL');
        $text = trans('pg_patient_description.NEW_PATIENT_EMAIL_TXT_A') . $patient->inscription_code . trans('pg_patient_description.NEW_PATIENT_EMAIL_TXT_B');
        Mailer::sendEmailToPatient( $request->input('email'), $subject, $text );

        return view('professionals.add_patient_complete');
    } // TODO:

    /**
     * Updates a patient's profile
     */
    public function updatePatientProfile(Request $req) {
        $req->validate([
            // NOTE: Placeholders to enable this data if we wish. But this data should only be filled by the patient through the app
            // 'name' => 'required|string|min:5|max:80|unique:users,name|unique:pgsql_new_users.public.new_users,name',
            // 'email' => 'required|email|unique:users,email|unique:pgsql_new_users.public.new_users,email',
            // 'phone' => 'required|max:30|unique:professionals,phone|unique:organizations,phone|unique:patients,phone|unique:pgsql_new_users.public.data_new_pros,phone|unique:pgsql_new_users.public.data_new_orgs,phone',
            // 'full_name' => 'required|string|min:5|max:80',

            'user_key' => 'required|uuid',

            // Patient data changeable by professionals
            'in_gender' => 'in:m,f,unspecified',
            'in_weight' => 'nullable|numeric|min:1|max:500',

            'in_b_day' => 'nullable|required_with:in_b_month,in_b_year|numeric|min:1|max:31',
            'in_b_month' => 'nullable|required_with:in_b_day,in_b_year|numeric|min:1|max:12',
            'in_b_year' => 'nullable|required_with:in_b_month,in_b_day|numeric|min:' . (Carbon::now()->year - 100) . '|max:' . Carbon::now()->year, // max is current year

            'in_blood_type' => 'in:a_pos,a_neg,b_pos,b_neg,o_pos,o_neg,ab_pos,ab_neg,unspecified',

            'in_diagnosed' => 'nullable|string|min:5|max:1000',
            'in_other' => 'nullable|string|min:5|max:1000',

        ], [
            // No custom validation messages
        ], [
            // Custom attribute names for default returned messages
            'in_gender' => lcfirst(trans('validation.FIELD')),
            'in_weight' => lcfirst(trans('pg_patient_description.WEIGHT')),

            'in_b_day' => trans('generic.DAY'),
            'in_b_month' => trans('generic.MONTH'),
            'in_b_year' => trans('generic.YEAR'),

            'in_blood_type' => strtolower(trans('pg_patient_description.BLOOD_TYPE')),

            'in_diagnosed' => trans('validation.FIELD'),
            'in_other' => trans('validation.FIELD'),
        ]);


        $patUser = User::find($req->input('user_key'));
        if (!isset($patUser) || !$patUser->isPatient()) {
            abort(404);
        }

        $patient = $patUser->getRoleData();
        $patient->weight_kg = $req->input('in_weight');
        $patient->diagnosed = $req->input('in_diagnosed');
        $patient->other = $req->input('in_other');

        // Mapping inputs
        if ($req->input('in_b_day') != NULL
            && $req->input('in_b_month') != NULL
            && $req->input('in_b_year') != NULL) {

            // yyyy-mm-dd
            $bDate = Carbon::parse( $req->input('in_b_year') . "-" . $req->input('in_b_month') . "-" . $req->input('in_b_day') );

            $patient->date_of_birth = $bDate; // updating patient model

            $age = $bDate->age; // We'll return the calculated age to update the profile

        } else { // if the user cleared the birth date fields
            $patient->date_of_birth = NULL;
            $age = NULL; // we return NULL as the calculated age
        }

        switch ($req->input('in_gender')) {
            case "m":
                $patient->gender = Patient::GENDER_MALE;
                break;
            case "f":
                $patient->gender = Patient::GENDER_FEMALE;
                break;
            default: // includes unspecified
                $patient->gender = Patient::GENDER_UNSPECIFIED;
                break;
        }

        switch ($req->input('in_blood_type')) {
            case "a_pos":
                $patient->blood_type = Patient::BLOOD_A_POS;
                break;
            case "a_neg":
                $patient->blood_type = Patient::BLOOD_A_NEG;
                break;
            case "b_pos":
                $patient->blood_type = Patient::BLOOD_B_POS;
                break;
            case "b_neg":
                $patient->blood_type = Patient::BLOOD_B_NEG;
                break;
            case "o_pos":
                $patient->blood_type = Patient::BLOOD_O_POS;
                break;
            case "o_neg":
                $patient->blood_type = Patient::BLOOD_O_NEG;
                break;
            case "ab_pos":
                $patient->blood_type = Patient::BLOOD_AB_POS;
                break;
            case "ab_neg":
                $patient->blood_type = Patient::BLOOD_AB_NEG;
                break;
            default: // includes unspecified
                $patient->blood_type = Patient::BLOOD_UNSPECIFIED;
                break;
        }

        $patient->save();

        // Returning Json with calculated age to be updated in the UI
        $resp = new \stdClass();
        $resp->age = $age;
        return response()->json($resp, 200);
    }

    /*

        Get a patient's data and built the view to display it in client

    */
   public function get_patient_description_by_id(Request $request){
       if($request->p_id != null){

            $patient = Patient::find($request->p_id); // For patient profile tab
            if (!isset($patient)) {
                abort(405); // making sure patient exists
            }
            if (!isset($request->date_query)){
                abort(405);
            }
            $p_profile = $patient->getHealthProfile();



            $patient_info = $request->p_id;
            $patient_data = new PatientDescriptionData($request->p_id);
            //get all data 
            $patient_data->getInitialPatientDescription($request->date_query);
            $final_data = $patient_data->patient_description;
            //assign the data needed for blade templates into vars for compact
            $patient_medication = $final_data->patient_medication;
            $weekly_medication_schedule = $final_data->weekly_medication_schedule;
            $crisis_event_list = $final_data->crisis_event_list;
            $patient_professionals = $final_data->professionals;
            $patient_teams = $final_data->teams;
            $daily_medication_schedule = $final_data->daily_med_schedule;
            $final_data->entry_ui = view('professionals.patient_description_components.patient_description', compact(['patient_info','patient_medication','weekly_medication_schedule','crisis_event_list','patient_professionals','patient_teams', 'p_profile', 'daily_medication_schedule']))->render();
            return response()->json($final_data,200);
       }else{
           return abort(405);
       }
   }

   public function getPatientDataForCharts(Request $request){
        if($request->p_id != null){

            $patient = Patient::find($request->p_id); // For patient profile tab
            if (!isset($patient)) {
                abort(405); // making sure patient exists
            }

            $request->validate([
                'start_date' => 'required|date_format:d/m/Y H:i',
                'end_date' => 'required|date_format:d/m/Y H:i',
                'p_id' => 'required'
            ]);

            
            $patient_info = $request->p_id;
            $patient_data = new PatientDescriptionData($request->p_id);
            //get all data 
            
            // $patient_data->getPatientCollectedData(Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->timestamp * 1000, Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->timestamp * 1000, $request->p_id);
            $patient_data->getPatientCollectedDatav2(Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->timestamp * 1000, Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->timestamp * 1000, $request->p_id);
            $final_data = $patient_data->patient_description;
            return response()->json($final_data,200);
        }else{
            return abort(405);
        }
   }

   public function getMedicationForDay(Request $request){
       if(isset($request->p_id) && isset($request->date)){
            $patient_data = new PatientDescriptionData($request->p_id);
            $date = Carbon::createFromFormat('d/m/Y',$request->date);
            $patient_data->getPatientMedicationForDay($date);
            $daily_medication_schedule = $patient_data->patient_description->daily_med_schedule;
            $entry_ui = view('professionals.patient_description_components.updateable_med_schedule', compact(['daily_medication_schedule']))->render();
            return response()->json($entry_ui,200);
       }else{
            return abort(405);
       }
        
   }
   
   //add medication form submit
    public function new_medication_schedule(Request $request){
        $patient_medication = new PatientMedication();
        $query_results = Medication::where('name',strtolower($request->medication_name))
                                    ->where('pill_dosage',$request->medication_dosage)
                                    ->where('type',$request->medication_type)
                                    ->first();

        if($query_results!=null){
            $med_id = $query_results->id;

        }else{
            $med = new Medication();
            $med->name = strtolower($request->medication_name);
            $med->pill_dosage = $request->medication_dosage;
            $med->type = $request->medication_type;
            $med->save();

            $med_id = Medication::where('name',strtolower($request->medication_name))
                                ->where('pill_dosage',$request->medication_dosage)
                                ->where('type',$request->medication_type)
                                ->first()
                                ->id;
        }

        $patient_medication->fk_medication_id = $med_id;
        $patient_medication->fk_patient_id = $request->patient_id;
        $patient_medication->periodicity = $request->periodicity;
        $patient_medication->nr_of_pills_each_intake = $request->nr_of_pills_each_intake;
        $clean_intake_schedule = [];

        foreach($request->scheduled_intakes as $scheduled_intake) {
            array_push($clean_intake_schedule, MinuteTimestamps::where('hour',$scheduled_intake[0])->where('minute',$scheduled_intake[1])->first()->id);
        }

        $patient_medication->scheduled_intakes = $clean_intake_schedule;
        $patient_medication->start_date = Carbon::now();

        if(intval($request->treatment_duration) != -1){
            $patient_medication->end_date = Carbon::now()->add($request->treatment_duration,'days');
        }

        $patient_medication->save();
        
        $resp = new \stdClass();
        $resp->reset_form_html = view('professionals.patient_description_components.add_medication_form')->render();
        return response()->json($resp,200);
   }

   public function new_crisis_event(Request $request){
        $patient_crisis_event = new PatientCrisisEvent();
        $patient_crisis_event->fk_patient_id = $request->pat_id;
        $patient_crisis_event->fk_crisis_event_id = $request->crisis_id;
        if($request->crisis_min != null && $request->crisis_hour != null){
            $patient_crisis_event->fk_minute_timestamps_id = MinuteTimestamps::where('minute',$request->crisis_min)->where('hour',$request->crisis_hour)->first()->id;
        }
        $patient_crisis_event->crisis_date = Carbon::createFromFormat('Y-m-d', $request->crisis_date)->toDateString();
        if($request->crisis_duration != null){
            $patient_crisis_event->duration_in_seconds = $request->crisis_duration;
        }
        if($request->crisis_notes != null){
            $patient_crisis_event->notes = $request->crisis_notes;
        }
        $patient_crisis_event->save();

        $resp = new \stdClass();
        $resp->reset_form_html = view('professionals.patient_description_components.add_user_crisis_form')->render();
        return response()->json($resp,200);
   }


   //send an email with professional code to a patient to recover his password
   public function recoverPatientPassword(Request $request){
        return view('professionals.recover_password_form');
   }

   public function sendPatientPasswordRecoveryEmail(Request $request){
        $rules = [
            'patient_email' => 'required|email',
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
            'email' => trans('pg_professionals.INVALID_EMAIL')
        ];

        $request->validate($rules,$messages);
        $user_id = $request->user()->getRoleData()->id;
        $professional_code = Professional::find($user_id)->code;

        $subject = 'Vitruvian Shield Password Recovery';
        $text = '<p>To recover your password through the mobile application, use your user code along with the following professional code :</p><p>' . $professional_code . '</p>';
        Mailer::sendEmailToPatient( $request->input('patient_email'), $subject, $text);

        return redirect()->route('home')->with('status','Password recovery email sent successfully!');
    }

    /**
     * Route to download data options
     * 
     * NOTE: Current user must be Professional, as guaranteed by the middleware
     * 
     */
    public function downloadOptionsView(Request $request){
        
        $prof_teams = TeamUser::where('fk_user_id',$request->user()->id)->get();
        $teams_with_patients = array();
        foreach($prof_teams as $team_info){
            $team_data = new \stdClass();
            //get team info
            $team = Team::find($team_info->fk_team_id);
            $team_data->name = $team->name;
            //get all patients for team
            $team_patient_users = TeamUser::where('fk_team_id',$team->id)->where('role', 0)->get();
            $team_data->patient_count = count($team_patient_users);
            //foreach patient, get their avatar and name
            $team_data->patients = array();
            foreach($team_patient_users as $team_patient_user){
                $user = User::find($team_patient_user->fk_user_id);
                $patient = new \stdClass();
                $patient->name = $user->name;
                $patient->avatar = $user->avatar;
                $patient->id = Patient::where('fk_user_id',$user->id)->first()->id;
                array_push($team_data->patients, $patient);
            }
            
            array_push($teams_with_patients,$team_data);
        }
        //get direct patients
        $direct_patients = $request->user()->getRoleData()->getPatients();

        $team_data = new \stdClass();
        //get team info
        $team_data->name = "Your Patients";
        $team_data->patient_count = count($direct_patients);
        $team_data->patients = array();
        foreach($direct_patients as $direct_patient){
            $user = User::find($direct_patient->fk_user_id);
            $patient = new \stdClass();
            $patient->name = $user->name;
            $patient->avatar = $user->avatar;
            $patient->id = Patient::where('fk_user_id',$user->id)->first()->id;
            array_push($team_data->patients, $patient);
        }
        array_push($teams_with_patients,$team_data);
        //TODO: ADD DIRECT PATIENTS INTO TEAM "YOUR PATIENTS"
        return view('professionals.data_download.download_options',compact('teams_with_patients'));
    }

    public function exportPatientData(Request $request){
        $rules = [
            'start_date' => 'required|date_format:d/m/Y H:i',
            'end_date' => 'required|date_format:d/m/Y H:i',
            'patient_list' => 'required|array',
            'patient_list.*' => 'integer',
            'use_submitted_by_users' => 'required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD')
        ];

        $request->validate($rules,$messages);

        foreach($request->patient_list as $patient){
            if(!Patient::find($patient)->isOwnedBy($request->user()->id)){
                return abort(405);
            }
        }

        $result_data = array();
        // $pat_counter = 0;
        foreach($request->patient_list as $patient){
            
            $patient_code = Patient::find($patient)->inscription_code;

            
            $data_array = array();

            
            $start_timestamp = Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->timestamp * 1000;
            $end_timestamp = Carbon::createFromFormat('d/m/Y H:i',$request->end_date)->timestamp * 1000;
            //TODO: query bucket names
            $all_bucket_names = array();

            $all_bucket_names = DB::connection('mongodb')
                                    ->table($patient_code)
                                    ->select('datetime')
                                    ->where('datetime','<',$end_timestamp)
                                    ->where('datetime','>',$start_timestamp)
                                    ->orderBy('datetime')
                                    ->options(['allowDiskUse' => true])
                                    ->get();

            
            //if there are buckets
            if(count($all_bucket_names) > 0 ){
                $patient_data = new \stdClass();
                $patient_data->patient = $patient;
                //foreach bucket query its data and add it to $data_array
                $patient_data->bucket_names = $all_bucket_names;
                //select if all crisis are used or only the ones submitted by professionals
                if($request->input('use_submitted_by_users') == 1){
                    $pat_crisis = PatientCrisisEvent::where('fk_patient_id',$patient)->get();
                }else{
                    $pat_crisis = PatientCrisisEvent::where('fk_patient_id',$patient)->where('submitted_by_doctor',true)->get();
                }

                $processed_pce_list = [];
                if(count($pat_crisis) != 0){
                    foreach($pat_crisis as $pce){
                        $timeObj = MinuteTimestamps::where('id',$pce->fk_minute_timestamps_id)->first();
                        $time_str = '';
                        if(strlen($timeObj->hour) <2){
                            $time_str = $time_str . '0' . $timeObj->hour . ':';
                        }else{
                            $time_str = $time_str . $timeObj->hour . ':';
                        }
                        if(strlen($timeObj->minute) <2){
                            $time_str = $time_str . '0' . $timeObj->minute;
                        }else{
                            $time_str = $time_str . $timeObj->minute;
                        }
                        $datetime_str =  '' . $pce->crisis_date . ' ' . $time_str;
                        $result_unix_ts = Carbon::createFromFormat('Y-m-d H:i', $datetime_str)->getTimestamp();
                        $processed_pce_list_entry = new \stdClass();
                        $processed_pce_list_entry->min = $result_unix_ts * 1000;
                        $processed_pce_list_entry->max = ($result_unix_ts + $pce->duration_in_seconds) * 1000;
                        $processed_pce_list_entry->name = CrisisEvent::where('id',$pce->fk_crisis_event_id)->first()->name;
                        array_push($processed_pce_list,$processed_pce_list_entry);
                    }
                }
                $patient_data->crisis_events = $processed_pce_list;
            }
            // $pat_counter = $pat_counter + 1;
            if(count($all_bucket_names) > 0){
                array_push($result_data, $patient_data);
            }
            
        }


        return response()->json($result_data,200);
    }

    public function fetchPatientBucketList(Request $request){
        $rules = [
            'patient' => 'required|integer',
            'bucket_list' => 'required|array'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD')
        ];

        $request->validate($rules,$messages);
        if(!Patient::find($request->patient)->isOwnedBy($request->user()->id)){
            return abort(405);
        }

        $patient_code = Patient::find($request->patient)->inscription_code;
        $result_data = array();
        foreach($request->bucket_list as $bucket){
            $prev_cycle_data = $result_data;
            $result_data = array_merge($prev_cycle_data, MongoManager::findDocumentById($bucket['_id']['$oid'], $patient_code)['data']);
        }


        return response()->json($result_data,200);
    }

    



    private function generateInscriptionCode($strLength){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // Shufle the $str_result and returns substring
        // currently string with 12 characters of length
        return substr(str_shuffle($str_result), 0, $strLength);
    }

    private function addHeaderToCsv($current_csv,$sensor_id){
        if($sensor_id == 1){
            $current_csv = $current_csv . 'adpd_app,adpd_signal_data,adpd_dark_data,adpd_data_type,adpd_sequence,adpd_sample_n,';
        }else if($sensor_id == 2){
            $current_csv = $current_csv . 'adxl_x,adxl_y,adxl_z,';
        }else if($sensor_id == 3){
            $current_csv = $current_csv . 'ecg_data,ecg_ecg_info,ecg_hr,';
        }else if($sensor_id == 4){
            $current_csv = $current_csv . 'eda_real_data, eda_imaginary_data,eda_impedance_img,eda_impedance_real,eda_real_and_img,eda_impedance_magnitude,eda_impedance_phase,eda_admittance_real,eda_admittance_img,eda_admittance_phase,';
        }else if($sensor_id == 5){
            $current_csv = $current_csv . '';
        }else if($sensor_id == 6){
            $current_csv = $current_csv . 'ped_steps,ped_reserved,';
        }else if($sensor_id == 7){
            $current_csv = $current_csv . 'ppg_adpd_lib_state,ppg_confidence,ppg_hr,ppg_type,ppg_interval,';
        }else if($sensor_id == 8){
            $current_csv = $current_csv . 'syncppg_ppg_data,syncppg_adxl_timestamp,syncppg_x,syncppg_y,syncppg_z,';
        }else if($sensor_id == 9){
            $current_csv = $current_csv . 'temp_skin_temperature,temp_impedance,';
        }else if($sensor_id == 10){
            $current_csv = $current_csv . 'bcm_imaginary,bcm_real,bcm_freq_index,bcm_impedance_img,bcm_impedance_real,bcm_real_and_img,bcm_impedance_magnitude,bcm_impedance_phase,';
        }else{
            $current_csv = $current_csv . 'sqi_sqi,sqi_sqi_slot,sqi_reserved,';
        }
        
        return $current_csv;
    }
}
