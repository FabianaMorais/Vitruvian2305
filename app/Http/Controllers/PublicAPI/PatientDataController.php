<?php

namespace App\Http\Controllers\PublicAPI;

use Illuminate\Http\Request;
use App\Models\PatientCrisisEvent;
use App\Models\MinuteTimestamps;
use App\Models\Patient;
use App\Models\PatientMedication;
use App\Models\Medication;
use App\Models\MedTaking;

use Carbon\Carbon;
use Log;

class PatientDataController extends BaseApiDataHandler
{

    /**
     * Controller protected by PublicApiAccess middleware
     */
    public function __construct()
    {
        $this->middleware('api.public');
    }


    /**
     * Retrieves all profile info for the passed patients
     * 
     */
    public function getPatientProfiles(Request $req) {
        $pats = $this->allowPatientsOrFail($req);

        $list = array();

        // Filtering patient data to be shown
        foreach($pats as $p) {
            $entry = new \stdClass();
            $entry->code = $p->inscription_code;
            $entry->gender = Patient::getGenderString($p->gender);
            $entry->date_of_birth = (isset($p->date_of_birth))? date("Y-m-d", strtotime($p->date_of_birth)) : "unspecified";
            $entry->country = (isset($p->country))? $p->country : "unspecified";
            $entry->weight_kg = (isset($p->weight_kg))? $p->weight_kg : "unspecified";
            $entry->blood_type = Patient::getBloodTypeString($p->blood_type);
            $entry->diagnosed_diseases = (isset($p->diagnosed))? $p->diagnosed : "none";
            $entry->other_conditions = (isset($p->other))? $p->other : "none";

            array_push($list, $entry);
        }

        return response()->json(['patients' => json_encode($list)], 200);
    }


    // Crises
    /*
        adds a crisis event to a patient
        params:
        Request body parameters:
            patient - MANDATORY string
            timestamp - MANDATORY string with timestamp EX: '2018-06-15 12:34:00'
            duration - MANDATORY integer value of duration in seconds
            crisis_event - MANDATORY string value of crisis event to add
                possible values:
                    - 'other'
                    - 'ep_absence_seizure'
                    - 'ep_seizure'
                    - 'loss_balance'
                    - 'loss_consciousness'
                    - 'fall'

            notes - OPTIONAL string with notes about the crisis event 
    */
    public function addPatientCrisisEvent(Request $req){
        $req->validate([
            'patient' => 'required|string|min:5|max:80',
            'timestamp' => 'date_format:Y-m-d H:i:s|required',
            'duration'=> 'numeric|required|min:1',
            'crisis_event' => 'string|required',
            'notes' => 'string|min:3|max:300'
        ]);
        $crisis_event_id = $this->getUserCrisisId($req->input('crisis_event'));
        if($crisis_event_id == false){
            abort(422);
        }

        //check if patient exists
        $patient = Patient::where('inscription_code', $req->input('patient') )->get()->first();

        if($patient == null ){
            return response()->noContent();
        }
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }


        $carbon_date = Carbon::parse($req->input("timestamp"));
        $minute_timestamp_id = MinuteTimestamps::where('minute',$carbon_date->minute)->where('hour',$carbon_date->hour)->first();
        $new_crisis_event = PatientCrisisEvent::create([
            'fk_patient_id' => $patient->id,
            'fk_crisis_event_id' => $crisis_event_id,
            'fk_minute_timestamps_id' => $minute_timestamp_id->id,
            'crisis_date' => $carbon_date,
            'duration_in_seconds' => $req->input("duration"),
        ]);
        if($req->input("notes") != null){
            $new_crisis_event->notes = $req->input("notes");
            $new_crisis_event->save();
        }
    }


    /*
        gets a  list of crisis events for a list of patients
        params:
        Request body parameters:
            patients : MANDATORY  -> array of patient codes (string)
            start_date : OPTIONAL  -> string with date EX: '2018-06-15'
            end_date : OPTIONAL  -> string with date EX: '2018-06-15'
        returns:
            list of crisis events in a list of requested patients
            crisis event object is defined by:
                -crisis_date
                -crisis_time
                -duration_in_seconds
                -submitted_by_doctor
                -patient
                -crisis_event
    */

    public function getCrisisEventList(Request $req){
        //validate time format
        $req->validate([
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
        ]);

        $start_date = $req->input("start_date");
        $end_date = $req->input("end_date");

        $pats = $this->allowPatientsOrFail($req);

        $result_array = [];
        foreach($pats as $p) {

            $patient_crisis_events = PatientCrisisEvent::where( 'fk_patient_id' , $p->id );

            if( $start_date != NULL ){
                if( $end_date != NULL && 
                Carbon::parse($end_date) < Carbon::parse($start_date)
                ){
                    abort(422);
                }
                $patient_crisis_events->where('crisis_date','>=',Carbon::parse($start_date));
            }
            if( $end_date != NULL ){
                $patient_crisis_events->where('crisis_date','<=',Carbon::parse( $end_date) );
            }
            $patient_crisis_events = $patient_crisis_events->get();
            foreach( $patient_crisis_events as $p_c_e ){

                //add patient to crisis event
                $p_c_e->patient = $p->user->name;
                //turn crisis event id into its
                $p_c_e->crisis_event = $this->getUserCrisisName($p_c_e->fk_crisis_event_id);

                //if there are notes add them
                if($p_c_e->notes != null){
                    $p_c_e->description = $p_c_e->notes;
                }
                //get time in hh:mm format
                $minute_timestamp = MinuteTimestamps::find($p_c_e->fk_minute_timestamps_id);
                if($minute_timestamp->minute < 10){
                    $minute_timestamp->minute = '0' . $minute_timestamp->minute;
                }
                if($minute_timestamp->hour < 10){
                    $minute_timestamp->hour = '0' . $minute_timestamp->hour;
                }
                $p_c_e->crisis_time = ''.$minute_timestamp->hour . ':' . $minute_timestamp->minute;

            }
            array_push( $result_array, $patient_crisis_events );
        }
        return response()->json( [ 'data' => $result_array ], 200 );
    }




    

    // Medicação

    /*
        gets a  list of medication intakes scheduled for a day for a list of patients
        params:
        Request body parameters:
            patients : MANDATORY  -> array of patient codes (string)
            date : MANDATORY  -> string with date EX: '2018-06-15'
            
        returns:
         list of scheduled intakes in a list of requested patients
         scheduled intake is object :
            prescription_id
            start_date
            prescribed_by_professional
            patient
            medication
            intake_time
            intake_amount
            
    */
    public function getMedicationByDay(Request $req){
        //validate time format
        $req->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);
        
        $pats = $this->allowPatientsOrFail($req);
        $date = Carbon::parse($req->input("date"));

        $result_array = [];
        foreach($pats as $p) {
            $pat_med = $p->getPatientMedicationForDay($p->user, $date);
            //if patient has no  medication, getPatientMedicationForDay returns false
            if($pat_med != false){
                array_push($result_array,$pat_med);
            }
        }

        if(count($result_array) > 0){
            return response()->json( [ 'data' => $result_array ], 200 );
        }else{
            return response()->noContent();
        }
        
        
    }

    /*
        adds a medication to a patient's medication schedule
        params:
        Request body parameters:
            patient - MANDATORY string
            medication_name : MANDATORY ->string with pill name
            medication_dosage : MANDATORY ->numeric value of the pill's dosage in mg
            medication_type : MANDATORY -> string with type of medication 
            periodicity : OPTIONAL -> numeric value of periodicity of the intakes, 
                                                    IF NOT DEFINED MEDICATION WILL BE PRESCRIBED TO BE TAKEN EVERY DAY
                                                    IF DEFINED MEDICATION WILL BE PRESCRIBED TO BE TAKEN EVERY *PERIODICITY_VALUE* DAYS
            scheduled_intakes: MANDATORY -> array with the medication schedule for 1 day defined as:
                    [
                        intake_time: MANDATORY value ->string with time value in the format "hh:mm"
                        pills_per_intake: MANDATORY value -> numeric value of the number of pills to take at the defined time (ex, 2 pills at defined time)
                    ]
            start_timestamp : MANDATORY  -> string with date EX: '2018-06-15 00:00:00'
            treatment_duration : OPTIONAL  -> numeric value of the treatment's duration in days (IF NONE IS SET TREATMENT IS PRESCRIBED INDEFINITELY)
                
    */
    public function addMedication(Request $req){
        $req->validate([
            'patient' => 'required|string|min:5|max:80',
            'medication_name' => 'required|string|min:5|max:80',
            'medication_dosage'=> 'numeric|required|min:1',
            'medication_type' => 'string|required|min:3|max:80',
            'periodicity' => 'numeric|min:1',
            'scheduled_intakes' => 'required|array',
            'scheduled_intakes.*.intake_time' => 'required|date_format:H:i',
            'scheduled_intakes.*.pills_per_intake' => 'required|numeric|min:1',
            'start_timestamp' => 'date_format:Y-m-d H:i:s|required',
            'treatment_duration'=> 'numeric|min:1',
        ]);
        
        //check if med_type is in our list of valid types
        $med_type = $this->getMedicationTypeId($req->input('medication_type'));
        if($med_type== false){
            abort(422);
        }

        //check if patient exists
        $patient = Patient::where('inscription_code', $req->input('patient') )->get()->first();

        if($patient == null ){
            return response()->noContent();
        }
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }
        //clean schedule into db format
        $final_scheduled_intake_list = [];
        $final_nr_pills_per_intake_list = [];
        foreach($req->input("scheduled_intakes") as $si){
            //get minute timestamps id
            $time_list = explode(':',$si["intake_time"]);
            $minute_timestamp_id = MinuteTimestamps::where('minute',$time_list[1])->where('hour',$time_list[0])->first()->id;
            array_push($final_scheduled_intake_list,$minute_timestamp_id);
            array_push($final_nr_pills_per_intake_list,$si["pills_per_intake"]);
        }

        $medication_id = $this->getMedicationId($req->input("medication_name"),$req->input("medication_dosage"),$med_type);
        $treatment_start_date = Carbon::parse($req->input("start_timestamp"));

        //build patient medication object
        $newPatientMedication = new PatientMedication();
        $newPatientMedication->id = PatientMedication::generatePatMedCode(18);
        $newPatientMedication->fk_patient_id = $patient->id;
        $newPatientMedication->fk_medication_id = $medication_id;
        $newPatientMedication->periodicity = $req->input("periodicity");
        $newPatientMedication->start_date = $treatment_start_date;
        $newPatientMedication->scheduled_intakes = $final_scheduled_intake_list;
        $newPatientMedication->nr_of_pills_each_intake = $final_nr_pills_per_intake_list;

        //add optional values if they exist
        if($req->input("treatment_duration") != null){
            $newPatientMedication->end_date = $treatment_start_date->addDays($req->input("treatment_duration"));
        }
        if($req->input("periodicity") == null ){
            $newPatientMedication->periodicity = 1;
        }else{
            $newPatientMedication->periodicity = $req->input("periodicity");
        }

        $newPatientMedication->save();
        
    }

    //sets a treatment as ended in the moment the request is done
    //request body params:
        // prescription_id MANDATORY string value obtained when listing the medications for a user for a day with /getMedicationForDay request
    public function setTreatmentEnd(Request $req){
        $req->validate([
            'prescription_id' => 'required|string|min:18|max:18',
        ]);
        $pat_med = PatientMedication::find($req->input("prescription_id"));
        if($pat_med == null){
            return response()->noContent();
        }
        //check if patient exists
        $patient = Patient::find($pat_med->fk_patient_id);
        if($patient == null ){
            return response()->noContent();
        }
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }

        //check if treatment already ended and its duration is not indefinite
        if($pat_med->end_date < Carbon::now() && $pat_med->end_date != null){
            return response()->noContent();
        }

        $pat_med->end_date = Carbon::now();
        $pat_med->save();
    }


    //sets a medication as taken
    //request body params:
        // prescription_id MANDATORY string value obtained when listing the medications for a user for a day with /getMedicationForDay request
        // daily_intake_number MANDATORY numeric value of daily intakes for the given prescription id
            //example prescription_id 1 and daily_intake_number 1 is the first taking of the day for pat med 1
            //prescription_id 1 and daily_intake_number 2 is the second taking of the day for pat med 1
        // date : MANDATORY  -> string with date EX: '2018-06-15'
    
    public function setMedTaking(Request $req){
        $req->validate([
            'prescription_id' => 'required|string|min:18|max:18',
            'date' => 'required|date_format:Y-m-d',
            'daily_intake_number' => 'required|numeric|min:1'
        ]);
        //check if prescription exists
        $pat_med = PatientMedication::find($req->input("prescription_id"));
        if($pat_med == null){
            return response()->noContent();
        }
        //check if daily_intake_number is valid
        if($req->input("daily_intake_number") > count($pat_med->scheduled_intakes)){
            abort(422);
        }
        //check if patient exists
        $patient = Patient::find($pat_med->fk_patient_id);
        if($patient == null ){
            return response()->noContent();
        }
        
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }

        $date = Carbon::parse($req->input("date"));
        $med_taking_minute_timestamp_id = $pat_med->scheduled_intakes[ $req->input("daily_intake_number") - 1 ];
        $minute_timestamp = MinuteTimestamps::find($med_taking_minute_timestamp_id);
        $date->hour = $minute_timestamp->hour;
        $date->minute = $minute_timestamp->minute;

        $existing_med_intake = MedTaking::where('intake_date',$date)->where('fk_patient_medication_id',$pat_med->id)->get();
        //respond with conflict http status if med_taking already exists
        if($existing_med_intake != null && count($existing_med_intake) > 0){
            abort(409); 
        }
        MedTaking::create([
            'fk_patient_medication_id' => $pat_med->id,
            'intake_date' => $date
        ]);
    }


    /*
        gets the takings (or lack of them) for a patient's medication schedule in a given day
        params:
        Request body parameters:
            prescription_id MANDATORY numeric value obtained when listing the medications for a user for a day with /getMedicationForDay request
            date : MANDATORY  -> string with date EX: '2018-06-15'
        returns list of confirmed med takings for given date
    */
    public function getMedTakingsForDay(Request $req){
        $req->validate([
            'prescription_id' => 'required|string|min:18|max:18',
            'date' => 'required|date_format:Y-m-d'
        ]);

        //check if prescription exists
        $pat_med = PatientMedication::find($req->input("prescription_id"));
        if($pat_med == null){
            return response()->noContent();
        }
        //check if patient exists
        $patient = Patient::find($pat_med->fk_patient_id);
        if($patient == null ){
            return response()->noContent();
        }
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }
        $result_array = [];
        foreach($pat_med->scheduled_intakes as $si){
            $minute_timestamp = MinuteTimestamps::find($si);
            $date = Carbon::parse($req->input("date"));
            $date->hour = $minute_timestamp->hour;
            $date->minute = $minute_timestamp->minute;
            $med_taking = MedTaking::where('fk_patient_medication_id',$req->input("prescription_id"))
            ->where('intake_date','=',$date)
            ->first() ;
            if( $med_taking != null ){
                $result = new \stdClass();
                $result->is_taken = true;
                $result->intake_date = $med_taking->intake_date;
                array_push($result_array,$result);
            }else{
                $result = new \stdClass();
                $result->is_taken = false;
                $result->intake_date = date_format($date,"Y-m-d H:i:s");
                array_push($result_array,$result);
            }

        }
        
        return response()->json( $result_array , 200 );
        
    }


     /*
        removes the taking for a patient's intake schedule in a given day
        params:
        Request body parameters:
            prescription_id MANDATORY string value obtained when listing the medications for a user for a day with /getMedicationForDay request
            date : MANDATORY  -> string with date EX: '2018-06-15'
            // daily_intake_number MANDATORY numeric value of daily intakes for the given prescription id
            //example prescription_id 1 and daily_intake_number 1 is the first taking of the day for pat med 1
            //prescription_id 1 and daily_intake_number 2 is the second taking of the day for pat med 1
    */

    public function removeMedTaking(Request $req){
        $req->validate([
            'prescription_id' => 'required|string|min:18|max:18',
            'date' => 'required|date_format:Y-m-d',
            'daily_intake_number' => 'required|numeric|min:1'
        ]);
        //check if prescription exists
        $pat_med = PatientMedication::find($req->input("prescription_id"));
        if($pat_med == null){
            return response()->noContent();
        }
        //check if daily_intake_number is valid
        if($req->input("daily_intake_number") > count($pat_med->scheduled_intakes)){
            abort(422);
        }
        //check if patient exists
        $patient = Patient::find($pat_med->fk_patient_id);
        if($patient == null ){
            return response()->noContent();
        }
        
        //check if professional owns the patient
        $currentPro = $req->apiUser->getRoleData();
        if (!$currentPro->mayAccess($patient)) {
            abort(401);
        }

        $date = Carbon::parse($req->input("date"));
        $med_taking_minute_timestamp_id = $pat_med->scheduled_intakes[ $req->input("daily_intake_number") - 1 ];
        $minute_timestamp = MinuteTimestamps::find($med_taking_minute_timestamp_id);
        $date->hour = $minute_timestamp->hour;
        $date->minute = $minute_timestamp->minute;

        $existing_med_intake = MedTaking::where('intake_date',$date)->where('fk_patient_medication_id',$pat_med->id)->first();
        
        if($existing_med_intake != null){
            $existing_med_intake->delete();
        }else{
            return response()->noContent();
        }
    }



//validates if a medication type given as a string and returns its numeric value for the database records
    public function getMedicationTypeId($medication_type_string){
        switch($medication_type_string){
            case "capsule":
                return 10;
            case "pill":
                return 20;
            case "syrup":
                return 30;
            case "supository":
                return 40;
            case "other":
                return 99;
            default:
                return false;
        }
    }

    public function getMedicationId($med_name,$med_dosage,$med_type){
        $med_query = Medication::where('name',$med_name)
                ->where('pill_dosage',$med_dosage)
                ->where('type',$med_type)
                ->first();
        if($med_query == NULL){
            //if medication does not exist, add it to medication table
            $newMedication = Medication::create([
                'name' => $med_name,
                'pill_dosage' => $med_dosage,
                'type' => $med_type
            ]);
            return $newMedication->id;
        }else{
            // if it does, return the med_id
            return $med_query->id;
        }
    }

    //receives a user crisis string key as parameter and returns the corresponding map value
    public function getUserCrisisId($user_crisis){
        switch($user_crisis){
            case 'other':
                return 1;
            case 'ep_absence_seizure':
                return 2;
            case 'ep_seizure':
                return 3;
            case 'loss_balance':
                return 4;
            case 'loss_consciousness':
                return 5;
            case 'fall':
                return 6;
            default:
                return false;
        }
    }
    //receives  user crisis id and returns its description
    public function getUserCrisisName($user_crisis_id){
        switch($user_crisis_id){
            case 1:
                return 'other';
            case 2:
                return 'ep_absence_seizure';
            case 3:
                return 'ep_seizure';
            case 4:
                return 'loss_balance';
            case 5:
                return 'loss_consciousness';
            case 6:
                return 'fall';
            default:
                return false;
        }
    }

   
}
