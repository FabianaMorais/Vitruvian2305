<?php

namespace App\Http\Controllers\PrivateAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Users\User;
use App\Models\Medication;
use App\Models\PatientMedication;
use App\Models\MinuteTimestamps;
use App\Models\MedTaking;
use App\Models\Patient;

use Carbon\Carbon;
use Log;

class MedicationController extends Controller
{

    public function getPatientFullMeds(Request $request) {
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $date_to_query = Carbon::now();
        $return_med_schedule = PatientMedication::getPatientMedicationSchedule($date_to_query, $request->user()->getRoleData()->id);
        if($return_med_schedule == null) {
            return abort(204);
        }
        return response()->json($return_med_schedule,200); 

    }

    public function getPatientFullFutureMedicationSchedule(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $date_to_query = Carbon::now();
        $med_query_results = PatientMedication::where('fk_patient_id', $request->user()->getRoleData()->id )->where('start_date','<',$date_to_query)->get();
        $future_med_schedule = [];
        if (count($med_query_results) == 0){
            return abort(204);
        }
        $return_med_schedule = [];
        foreach($med_query_results as $pat_med){
            if ($pat_med->end_date > $date_to_query || $pat_med->end_date == null){
                $med_schedule = new \stdClass();
                $med = Medication::find($pat_med->fk_medication_id);
                $name = $med->name;
                $dosage = $med->pill_dosage;
                $type = $med->type;
                $med_schedule->name = $name;
                $med_schedule->dosage = $dosage;
                $med_schedule->type = $type;

                $med_schedule->pat_med_id = $pat_med->id;
                $med_schedule->start_date = $pat_med->start_date;
                $med_schedule->end_date = $pat_med->end_date;
                $med_schedule->periodicity = $pat_med->periodicity;
                $med_schedule->notes = $pat_med->notes;
                $med_schedule->prescribed_by_professional = $pat_med->prescribed_by_professional;
                $med_schedule->nr_of_pills_each_intake = $pat_med->nr_of_pills_each_intake;
                $intake_times = [];
                for($i=0;$i<count($pat_med->scheduled_intakes);$i++){
                    $time = MinuteTimestamps::find($pat_med->scheduled_intakes[$i]);
                    $intake_time = new \stdClass();
                    $intake_time->hour = $time->hour;
                    $intake_time->minute = $time->minute;
                    
                    array_push($intake_times,$intake_time);
                }
                $med_schedule->scheduled_intakes = $intake_times;
                array_push($return_med_schedule,$med_schedule);
            }
        }
        return response()->json($return_med_schedule,200); 
    }

    public function getPatientMedicationByDay(Request $request){
        Log::debug("by day");
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }

        $date_to_query = Carbon::createFromTimestamp($request->unix_ts);
        $med_query_results = PatientMedication::where('fk_patient_id', $request->user()->getRoleData()->id )->where('start_date','<',$date_to_query)->get();
        $daily_med_schedule = [];
        if (count($med_query_results) == 0){
            return abort(204);
        }
        foreach($med_query_results as $pat_med){
            if ($pat_med->end_date > $date_to_query || $pat_med->end_date == null){
                //if it is a taking day, get data ready for the response
                if ($pat_med->periodicity == 1 || $date_to_query->diffInDays($pat_med->start_date) % $pat_med->periodicity == 0){
                    $med = Medication::find($pat_med->fk_medication_id);
                    $name = $med->name;
                    $dosage = $med->pill_dosage;
                    $type = $med->type;
                    for($i=0;$i<count($pat_med->scheduled_intakes);$i++){
                        $med_schedule_entry = new \stdClass();
                        $med_schedule_entry->pat_med_id = $pat_med->id;
                        $med_schedule_entry->name = $name;
                        $med_schedule_entry->dosage = $dosage;
                        $med_schedule_entry->type = $type;
                        
                        $med_schedule_entry->prescribed_by_professional = $pat_med->prescribed_by_professional;
                        $time = MinuteTimestamps::find($pat_med->scheduled_intakes[$i]);
                        $med_schedule_entry->hour = $time->hour;
                        $med_schedule_entry->minute = $time->minute;
                        $med_schedule_entry->number_of_pills = intval($pat_med->nr_of_pills_each_intake[$i]);
                        // 2020-05-21 08:00:00
                        $intake_date_to_query = Carbon::create($date_to_query->year,$date_to_query->month,$date_to_query->day, $time->hour,$time->minute);
                        Log::debug($intake_date_to_query);
                        $med_is_taken = MedTaking::where('fk_patient_medication_id',$pat_med->id)->where('intake_date',$intake_date_to_query)->first();
                        if ($med_is_taken != null){
                            $med_schedule_entry->is_taken = true; 
                        } else {
                            $med_schedule_entry->is_taken = false; 
                        }
                        if ($pat_med->notes != null){
                            $med_schedule_entry->notes = $pat_med->notes;
                        } else {
                            $med_schedule_entry->notes = '';
                        }
                        array_push($daily_med_schedule,$med_schedule_entry);
                    }
                }
            }
        }
        return response()->json($daily_med_schedule,200); 
    }


    public function getMedicationList(Request $request){
        Log::debug("list");
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $date_to_query = Carbon::now();
        $med_query_results = PatientMedication::where('fk_patient_id', $request->user()->getRoleData()->id )->get();
        $medication_list = [];
        if (count($med_query_results)==0){
            return abort(204);
        }
        foreach($med_query_results as $pat_med){
            if ($pat_med->end_date > Carbon::now() || $pat_med->end_date == null){
                $med = Medication::find($pat_med->fk_medication_id);
                $med_list_entry = new \stdClass();
                $med_list_entry->name = $med->name;
                $med_list_entry->dosage = floatval($med->pill_dosage);
                $med_list_entry->type = $med->type;
                $med_list_entry->pat_med_id = $pat_med->id;
                $med_list_entry->prescribed_by_professional = $pat_med->prescribed_by_professional;
                if ($pat_med->notes != null){
                    $med_list_entry->notes = $pat_med->notes;
                } else {
                    $med_list_entry->notes = '';
                }
                
                array_push($medication_list,$med_list_entry);
            }
        }
        return response()->json($medication_list,200); 
    }


    /* 
     * OBSOLETE: This is not used anymore, but it's here in case we want to reuse it
     */
    public function addMedication(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'name' => 'required|string|min:3|max:40',
            'pill_dosage' => 'required|numeric',
            'type' => 'required|numeric',
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $request->validate($rules,$messages);
        $name = strtolower($request->name);
        $pill_dosage = $request->pill_dosage;
        $query_results = Medication::where('name',$name)->get();
        if (count($query_results) != 0){
            foreach($query_results as $query_result){
                if (floatval($query_result->pill_dosage) == floatval($pill_dosage)){
                    return response()->json('Already exists',204); 
                }
            }
        }
        $med = new Medication();
        $med->name = strtolower($request->name);
        $med->pill_dosage = $request->pill_dosage;
        $med->type = $request->type;
        $med->save();
        return response()->json($med,200); 
    }

    public function addPatientMedication(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'data.*.name' => 'required|string|min:3|max:50',
            'data.*.pill_dosage' => 'required|numeric',
            'data.*.type' => 'required|numeric',
            'data.*.periodicity' => 'required|numeric',

            // 'nr_of_pills_each_intake'   => 'required|array',
            // 'nr_of_pills_each_intake.*' => 'integer',
            'data.*.scheduled_intakes'   => 'required|array',
            // 'scheduled_intakes.*.*' => 'integer',
            'data.*.start_date' => 'required|date',
            'data' => 'array|required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $request->validate($rules,$messages);
        $added_ids = array();
        
        foreach($request->data as $pat_med_data){
        
            $name = strtolower($pat_med_data['name']);
            $pill_dosage = $pat_med_data['pill_dosage'];
            $query_results = Medication::where('name',$name)->where('pill_dosage',$pat_med_data['pill_dosage'])->get();
            if (count($query_results) != 0){
                foreach($query_results as $query_result){
                    if (floatval($query_result->pill_dosage) == floatval($pill_dosage)){
                        $med_id = $query_result->id;
                    }
                }
            } else {
                $med = new Medication();
                $med->name = strtolower($pat_med_data['name']);
                $med->pill_dosage = $pat_med_data['pill_dosage'];
                $med->type = $pat_med_data['type'];
                $med->save();
                $med_id = Medication::where('name',$name)->where('pill_dosage',$pat_med_data['pill_dosage'])->first()->id;
            }
            
        

            // $patient_medication = new PatientMedication();
            // $patient_medication->fk_medication_id = 1;//$med_id;
            // $patient_medication->fk_patient_id = 1;//$pat_med_data->user()->getRoleData()->id;
            // $patient_medication->periodicity = 1;//$pat_med_data->periodicity;
            $patient_medication = new PatientMedication();
            $patient_medication->fk_medication_id = $med_id;
            $patient_medication->fk_patient_id = $request->user()->getRoleData()->id;
            $patient_medication->periodicity = $pat_med_data['periodicity'];
            $clean_intake_schedule = [];
            $clean_number_of_pills = [];
            // $clean_intake_schedule = array();
            // $clean_number_of_pills = array();
            foreach($pat_med_data['scheduled_intakes'] as $scheduled_intake){
                array_push($clean_number_of_pills,$scheduled_intake['pills']);
                array_push($clean_intake_schedule,MinuteTimestamps::where('hour',$scheduled_intake['hour'])->where('minute',$scheduled_intake['minute'])->first()->id);
            }
            
            // // foreach($pat_med_data->scheduled_intakes as $scheduled_intake){
            // //     array_push($clean_number_of_pills,$scheduled_intake['pills']);
            // //     array_push($clean_intake_schedule,MinuteTimestamps::where('hour',$scheduled_intake['hour'])->where('minute',$scheduled_intake['minute'])->first()->id);
            // // }
            $patient_medication->scheduled_intakes = $clean_intake_schedule;
            $patient_medication->nr_of_pills_each_intake = $clean_number_of_pills;
            $patient_medication->start_date = Carbon::createFromFormat('d-m-Y', $pat_med_data['start_date']);
            if ($pat_med_data['treatment_duration'] != -1){
                $patient_medication->end_date = Carbon::createFromFormat('d-m-Y', $pat_med_data['start_date'])->add($pat_med_data['treatment_duration'],'days');
            }
            
            
            $patient_medication->prescribed_by_professional = false;
            // $patient_medication->prescribed_by_professional = false;

            $patient_medication->save();
            array_push($added_ids, $patient_medication->id);
        }
        // $resp = 'success';
        return response()->json(['added_medication_ids' => $added_ids], 200);
    }

    public function removePatientMedication(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'data.*.pat_med_id' => 'required',
            'data' => 'array|required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $errors_array = array();
        $request->validate($rules,$messages);
        foreach($request->data as $key => $pat_med_to_remove){
            $query_result = PatientMedication::where('id',$pat_med_to_remove['pat_med_id'])->first();
            if ($query_result != null){
                if ($query_result->prescribed_by_professional == false){
                    $query_result->end_date = Carbon::now();
                    $query_result->save();
                    
                    
                } else {
                    
                    $error_in_index = $key;
                }
            } else {
                $error_in_index = $key;
                //invalid medication
                array_push($errors_array,$error_in_index);
            }
        }
        if(count($errors_array) == 0 ){
            return response()->json("success",200);
        }else{
            return response()->json(['error_in_index' => $errors_array],401); 
        }
    }

    public function addMedTaking(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'data.*.pat_med_id' => 'required',
            'data.*.intake_date' => 'required|date_format:d-m-Y H:i',
            'data' => 'array|required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $request->validate($rules,$messages);
        foreach($request->data as $key=>$med_taking_to_add){
            $query_result = MedTaking::where('fk_patient_medication_id',$med_taking_to_add['pat_med_id'])->where('intake_date',Carbon::createFromFormat('d-m-Y H:i', $med_taking_to_add['intake_date']))->get();
            if (count($query_result) ==0){
                $med_taking = new MedTaking();
                $med_taking->fk_patient_medication_id = $med_taking_to_add['pat_med_id'];
                // Log::debug(Carbon::createFromFormat('d-m-Y H:i', $request->current_date)); //TODO: add this field to model & set it here
                $med_taking->intake_date = Carbon::createFromFormat('d-m-Y H:i', $med_taking_to_add['intake_date']);
                $med_taking->save();
            } 
        }
        return response()->json('success',200);
        
        
        
    }

    public function removeMedTaking(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'data.*.pat_med_id' => 'required',
            'data.*.intake_date' => 'required|date_format:d-m-Y H:i',
            'data' => 'array|required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $request->validate($rules,$messages);
        foreach($request->data as $key=>$med_taking_to_remove){
            $query_result = MedTaking::where('fk_patient_medication_id',$med_taking_to_remove['pat_med_id'])->where('intake_date',Carbon::createFromFormat('d-m-Y H:i', $med_taking_to_remove['intake_date']))->first();
            if ($query_result != null){
                $query_result->delete();
                    
            }
        }
            return response()->json("success",200);
        
        

        
    }


    public function editPatientMedication(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [
            'data.*.pat_med_id' => 'required|string',
            'data.*.name' => 'required|string|min:3|max:50',
            'data.*.pill_dosage' => 'required|numeric',
            'data.*.type' => 'required|numeric',
            'data.*.periodicity' => 'required|numeric',

            // 'nr_of_pills_each_intake'   => 'required|array',
            // 'nr_of_pills_each_intake.*' => 'integer',
            'data.*.scheduled_intakes'   => 'required|array',
            // 'scheduled_intakes.*.*' => 'integer',
            'data.*.start_date' => 'required|date',
            'data' => 'array|required'
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
        ];
        $request->validate($rules,$messages);
        $added_ids = [];
        foreach($request->data as $pat_med_data){
            $result = new PatientMedication();
            $result->finishTreatment($pat_med_data['pat_med_id']);

            if ($result == false) {
                return abort(406);
            }

            $patient_medication = new PatientMedication();
            $query_results = Medication::where('name',strtolower($pat_med_data['name']))
                                        ->where('pill_dosage',$pat_med_data['pill_dosage'])
                                        ->where('type',$pat_med_data['type'])
                                        ->first();

            if($query_results!=null){
                $med_id = $query_results->id;

            }else{
                $med = new Medication();
                $med->name = strtolower($pat_med_data['name']);
                $med->pill_dosage = $pat_med_data['pill_dosage'];
                $med->type = $pat_med_data['type'];
                $med->save();

                $med_id = Medication::where('name',strtolower($pat_med_data['name']))
                                    ->where('pill_dosage',$pat_med_data['pill_dosage'])
                                    ->where('type',$pat_med_data['type'])
                                    ->first()
                                    ->id;
            }

            $patient_medication->fk_medication_id = $med_id;
            $patient_medication->fk_patient_id = $request->user()->getRoleData()->id;
            $patient_medication->periodicity = $pat_med_data['periodicity'];
            
            $clean_intake_schedule = [];
            $clean_nr_of_pills = [];

            foreach($pat_med_data['scheduled_intakes'] as $scheduled_intake) {
                array_push($clean_intake_schedule, MinuteTimestamps::where('hour',$scheduled_intake['hour'])->where('minute',$scheduled_intake['minute'])->first()->id);
                array_push($clean_nr_of_pills,$scheduled_intake['pills']);
            }

            $patient_medication->scheduled_intakes = $clean_intake_schedule;
            $patient_medication->nr_of_pills_each_intake = $clean_nr_of_pills;
            $patient_medication->start_date = Carbon::createFromFormat('d-m-Y', $pat_med_data['start_date']);

            if(intval($pat_med_data['treatment_duration']) != -1){
                $patient_medication->end_date = Carbon::now()->add($pat_med_data['treatment_duration'],'days');
            }

            $patient_medication->save();
            array_push($added_ids, $patient_medication->id);
        }
        return response()->json(['added_medication_ids' => $added_ids], 200);
    }

}
