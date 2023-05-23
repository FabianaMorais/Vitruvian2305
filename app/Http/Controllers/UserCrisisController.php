<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Patient;
use App\Models\ProfessionalPatient;
use App\Models\Users\User;
use App\Models\CrisisEvent;
use App\Models\PatientCrisisEvent;
use App\Models\MinuteTimestamps;

use App\Builders\PatientDescriptionData;

use Log;
use Carbon\Carbon;

class UserCrisisController extends Controller
{
    //
    public function getCrisisReportIndex(Request $request){
        $request->validate([
            'page_nr' => 'required|numeric',
            'p_id' => 'required|numeric'
        ]);
        
        $page_to_display = $request->page_nr ;
        
        if($request->p_id != null){
            $all_crisis_events = PatientCrisisEvent::where('fk_patient_id',$request->p_id)->orderBy('crisis_date','DESC')->orderBy('fk_minute_timestamps_id','DESC')->get();
            foreach($all_crisis_events as $ce){
                $ce->crisis_event_name = CrisisEvent::where('id',$ce->fk_crisis_event_id)->first()->name;
                $timestamp = MinuteTimestamps::where('id',$ce->fk_minute_timestamps_id)->first();
                if($timestamp != null) {
                    if(strlen($timestamp->hour)==1){
                        $timestamp->hour = '0'.$timestamp->hour;
                    }
                    if(strlen($timestamp->minute)==1){
                        $timestamp->minute = '0'.$timestamp->minute;
                    }
                    $ce->crisis_event_time = "" . $timestamp->hour . ":" . $timestamp->minute;
                }else{
                    $ce->crisis_event_time = "12:00";
                }
            }
            $crisis_event_list = $all_crisis_events;
            if(count($crisis_event_list) > 0 && count($crisis_event_list) >= $request->page_nr ){
                $patient_data = new PatientDescriptionData($request->p_id);
                //get all data ´
                $crisis_event = $crisis_event_list[$request->page_nr];
                $timestring = '' . $crisis_event->crisis_date . ' ' . $crisis_event->crisis_event_time; 
                
                $patient_data->getPatientCollectedDatav2( Carbon::parse( $timestring )->addMinutes(-60)->timestamp * 1000, Carbon::parse( $timestring )->addMinutes(60)->timestamp * 1000, $request->p_id );   
                
                $resp = new \stdClass();
                //renders data for latest crisis event automatically since it is for home page
                $resp = $patient_data->patient_description;
                $resp->entry_ui = view('professionals.user_crisis_events.main_page', compact(['page_to_display','crisis_event_list']))->render();
            }else{
                // replace the next view with a no user crisis registered one
                // $resp->entry_ui = view('professionals.user_crisis_events.main_page', compact(['page_to_display','crisis_event_list']))->render();
                $resp->entry_ui = 'no crisis events';
            }
            // get unix ts for start and end of the crisis event and send them as parameters to data retriever functions

            return response()->json($resp,200);
        }else{
            return abort(405);
        }
    }
}
