<?php

namespace App\Http\Controllers\PrivateAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Users\User;
use App\Models\MinuteTimestamps;
use App\Models\PatientCrisisEvent;
use App\Models\Patient;

use App\ServerTools\Mailer;
use Carbon\Carbon;
use Log;

class UserInputController extends Controller
{

    /**
     * Sends feedback to the development team from an Android User
     */
    public function sendAppFeedback(Request $request) {
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }

        $rules = [
            'text' => 'required|string|min:10|max:1100',
            'device' => 'required|string|in:android,ios',
            'app_version' => 'required|string',
        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'),
            'min' => trans('pg_professionals.REQUIRED_FIELD'),
        ];
        $request->validate($rules, $messages);

        $text = "Sent from " . $request->device . " device<br>App version: " . $request->app_version . "<br><br>" . $request->text;

        Mailer::sendFeedbackEmail($request->user(), $request->text);

        return response()->json("success", 200); 
    } // TODO: TEST!

    
    public function addUserCrisisEvent(Request $request){
        if (!$request->user()->isType(User::PATIENT)){
            return abort(401);
        }
        $rules = [

            'event_min' => 'numeric|min:0|max:59',
            'event_hour' => 'numeric|min:0|max:24',
            'duration_secs' => 'numeric',
            'crisis_date' => 'required|date',
            'crisis_type' => 'required'

        ];
        $messages = [
            'required' => trans('pg_professionals.REQUIRED_FIELD'), 
            'numeric' => trans('pg_professionals.NUMERIC_FIELD')
            
        ];
        $request->validate($rules,$messages);
        if ($request->notes != null){
            //validate note length if it is present in request
            $note_rule = ['notes' => 'string|max:300|min:3'];
            $note_message = ['notes.max' => trans('pg_professionals.MAX_CHARS_FIELD_300')];
            $request->validate($note_rule,$note_message);
        }
        $pat_crisis = new PatientCrisisEvent();
        $pat_crisis->fk_patient_id = $request->user()->getRoleData()->id;
        switch($request->crisis_type){
            case 'other':
                $pat_crisis->fk_crisis_event_id = 1;
                break;
            case 'ep_absence_seizure':
                $pat_crisis->fk_crisis_event_id = 2;
                break;
            case 'ep_seizure':
                $pat_crisis->fk_crisis_event_id = 3;
                break;
            case 'loss_balance':
                $pat_crisis->fk_crisis_event_id = 4;
                break;
            case 'loss_consciousness':
                $pat_crisis->fk_crisis_event_id = 5;
                break;
            case 'fall':
                $pat_crisis->fk_crisis_event_id = 6;
                break;
            default:
                return abort(401);
        }
        if ($request->event_min.'' != '' && $request->event_hour.'' != ''){
            $tsqueryresult = MinuteTimestamps::where('minute',$request->event_min)->where('hour',$request->event_hour)->first();
            $pat_crisis->fk_minute_timestamps_id = $tsqueryresult->id;
        }
        if ($request->duration_secs .'' != ''){
            $pat_crisis->duration_in_seconds = $request->duration_secs;
        }
        $pat_crisis->crisis_date = Carbon::createFromFormat('d-m-Y', $request->crisis_date)->toDateString();
        if ($request->notes != null){
            $pat_crisis->notes = $request->notes;
        }
        $pat_crisis->submitted_by_doctor = false;
        $pat_crisis->save();
        return response()->json("success",200); 
    }
}
