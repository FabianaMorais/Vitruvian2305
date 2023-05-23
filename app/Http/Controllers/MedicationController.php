<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientMedication;
use App\Models\Medication;
use App\Models\MinuteTimestamps;

use Log;
use Carbon\Carbon;

/** TODO:
 * CRUD medication (private funcs)
 * 
 * List
 * 
 */
class MedicationController extends Controller
{

    public function deleteMedication(Request $req) {

        // TODO: If end date == created date, really delete it
            // && takings == 0
            $req->validate([
                'pat_med_id' => 'required|string',
            ], [
    
                'required' => trans('validation.VAL_REQUIRED')
            ]);
            $result = new PatientMedication();
            $result->finishTreatment($req->pat_med_id);

            if ($result == false) {
                return abort(406);
            }else{
                return response()->json('OK',200);
            }

    }

    public function getTreatmentEditionData(Request $req){
        $req->validate([
            'pat_med_id' => 'required|string',
        ], [

            'required' => trans('validation.VAL_REQUIRED')
        ]);
        $result = PatientMedication::where('id',$req->pat_med_id)->first();
        if($result != null){
            
            $return_data = new \stdClass();
            $return_data->id = $result->id;
            $return_data->medication_data = Medication::find($result->fk_medication_id);
            $return_data->periodicity = $result->periodicity;
            $clean_scheduled_intakes = [];
            foreach($result->scheduled_intakes as $scheduled_intake){
                array_push($clean_scheduled_intakes, MinuteTimestamps::find($scheduled_intake));
            }
            $return_data->scheduled_intakes = $clean_scheduled_intakes;
            $return_data->nr_of_pills_each_intake = $result->nr_of_pills_each_intake;
            $return_data->end_date = $result->end_date;
            $return_data->treatment_duration = Carbon::parse($result->end_date)->diffInDays(Carbon::today());
            $return_data->notes = $result->notes;
            return response()->json($return_data,200);
        }else{
            return abort(406);
        }
    }


    public function editTreatment(Request $req){
        $req->validate([
            'pat_med_id' => 'required|string',
        ], [

            'required' => trans('validation.VAL_REQUIRED')
        ]);
        $result = new PatientMedication();
        $result->finishTreatment($req->pat_med_id);

        if ($result == false) {
            return abort(406);
        }

        $patient_medication = new PatientMedication();
        $query_results = Medication::where('name',strtolower($req->medication_name))
                                    ->where('pill_dosage',$req->medication_dosage)
                                    ->where('type',$req->medication_type)
                                    ->first();

        if($query_results!=null){
            $med_id = $query_results->id;

        }else{
            $med = new Medication();
            $med->name = strtolower($req->medication_name);
            $med->pill_dosage = $req->medication_dosage;
            $med->type = $req->medication_type;
            $med->save();

            $med_id = Medication::where('name',strtolower($req->medication_name))
                                ->where('pill_dosage',$req->medication_dosage)
                                ->where('type',$req->medication_type)
                                ->first()
                                ->id;
        }

        $patient_medication->fk_medication_id = $med_id;
        $patient_medication->fk_patient_id = $req->patient_id;
        $patient_medication->periodicity = $req->periodicity;
        $patient_medication->nr_of_pills_each_intake = $req->nr_of_pills_each_intake;
        $clean_intake_schedule = [];

        foreach($req->scheduled_intakes as $scheduled_intake) {
            array_push($clean_intake_schedule, MinuteTimestamps::where('hour',$scheduled_intake[0])->where('minute',$scheduled_intake[1])->first()->id);
        }

        $patient_medication->scheduled_intakes = $clean_intake_schedule;
        $patient_medication->start_date = Carbon::now();

        if(intval($req->treatment_duration) != -1){
            $patient_medication->end_date = Carbon::now()->add($req->treatment_duration,'days');
        }

        $patient_medication->save();
        
        $resp = new \stdClass();
        $resp->reset_form_html = view('professionals.patient_description_components.edit_medication')->render();
        return response()->json($resp,200);
    }
}
