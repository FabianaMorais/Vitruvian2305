<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \stdClass;

use Carbon\Carbon;
use Log;

class PatientMedication extends Model
{
    //
    protected $connection = 'pgsql_v_watch';
    protected $table = "patient_medications";
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_patient_id', 'fk_medication_id', 'periodicity', 'start_date', 'end_date', 'prescribed_by_professional','scheduled_intakes','nr_of_pills_each_intake'
    ];
    protected $casts = [
        'scheduled_intakes' => 'array',
        'nr_of_pills_each_intake' => 'array',
        'id' => 'string',
    ];
    protected $hidden = [
        'id','fk_patient_id','fk_medication_id', 'periodicity', 'scheduled_intakes','nr_of_pills_each_intake','end_date', 'notes','created_at', 'updated_at',
    ];
    
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) PatientMedication::generatePatMedCode(18);
        });
    }


    private static function generatePatMedCode($strLength){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // Shufle the $str_result and returns substring
        // currently string with 12 characters of length
        return substr(str_shuffle($str_result), 0, $strLength);
    }

    public static function getPatientMedicationSchedule($date_to_query, $patient_id) {
        $med_query_results = PatientMedication::where('fk_patient_id', $patient_id )->where('start_date','<=',$date_to_query)->get();
        if (count($med_query_results) == 0){
            return null ;
        }
        $return_med_schedule = [];
        foreach($med_query_results as $pat_med) {
            //if treatment is ongoing or 
            if($pat_med->end_date >= $date_to_query || $pat_med->end_date == null) {
                $med_schedule = new stdClass();
                $medication_info = Medication::find($pat_med->fk_medication_id);
                $med_schedule->name = $medication_info->name;
                $med_schedule->dosage = $medication_info->pill_dosage;
                $med_schedule->type = $medication_info->type;
                $med_schedule->pat_med_id = $pat_med->id;
                $med_schedule->start_date = $pat_med->start_date;
                $med_schedule->end_date = $pat_med->end_date;
                $med_schedule->periodicity = $pat_med->periodicity;
                if($pat_med->notes != null) {
                    $med_schedule->notes = $pat_med->notes;
                }
                $med_schedule->prescribed_by_professional = $pat_med->prescribed_by_professional;

                $intakes = [];
                
                for($i=0;$i<count($pat_med->scheduled_intakes);$i++){
                    $time = MinuteTimestamps::find($pat_med->scheduled_intakes[$i]);
                    $intake = new \stdClass();
                    $intake->hour = $time->hour;
                    $intake->minute = $time->minute;
                    $intake->number_pills = $pat_med->nr_of_pills_each_intake[$i];
                    $intake_date_to_query = Carbon::create($date_to_query->year,$date_to_query->month,$date_to_query->day, $time->hour,$time->minute);
                    $med_is_taken = MedTaking::where('fk_patient_medication_id',$pat_med->id)->where('intake_date',$intake_date_to_query)->first();
                    if ($med_is_taken != null){
                        $intake->taken_today = true; 
                    } else {
                        $intake->taken_today = false; 
                    }
                    array_push($intakes, $intake);
                }
                $med_schedule->intakes = $intakes;
                array_push($return_med_schedule, $med_schedule);
            }
        }
        return $return_med_schedule;
    }

    //sets the end date of a patient medication to that moment
    //Returns true if successfull, false if medication does not exist
    public function finishTreatment($pat_med_id) {
        $med_query_result = PatientMedication::where('id', $pat_med_id )->first();
        if ($med_query_result == null ){
            return false ;
        }else{
            $med_query_result->end_date = Carbon::now();
            $med_query_result->save();
            return true ;
        }
    }


    //NOTE: needs intake time to be converted from datetime into MinuteTimestamps id 
    //updates a patient medication
    //Returns true if successfull, false if medication does not exist
    public function updateMedication($patient_medication_entry) {
        $med_query_result = PatientMedication::where('id', $patient_medication_entry->id )->first();
        if ($med_query_result == null ){
            return false ;
        }else{
            $submit = false;
            if($patient_medication_entry->periodicity != null) {
                $med_query_result->periodicity = $patient_medication_entry->periodicity;
                $submit = true;
            }
            if($patient_medication_entry->scheduled_intakes != null) {
                $med_query_result->scheduled_intakes = $patient_medication_entry->scheduled_intakes;
                $submit = true;
            }
            if($patient_medication_entry->nr_of_pills_each_intake != null) {
                $med_query_result->nr_of_pills_each_intake = $patient_medication_entry->nr_of_pills_each_intake;
                $submit = true;
            }
            if($patient_medication_entry->start_date != null) {
                $med_query_result->start_date = $patient_medication_entry->start_date;
                $submit = true;
            }
            if($patient_medication_entry->end_date != null) {
                $med_query_result->end_date = $patient_medication_entry->end_date;
                $submit = true;
            }
            if($patient_medication_entry->notes != null) {
                $med_query_result->notes = $patient_medication_entry->notes;
                $submit = true;
            }
            if($submit = true) {
                $med_query_result->save();
                return true ;
            }else{
                return false ;
            }
            
        }
    }
}
