<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCrisisEvent extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "patient_crisis_events";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_patient_id','fk_crisis_event_id', 'fk_minute_timestamps_id', 'crisis_date','duration_in_seconds','submitted_by_doctor'
    ];
    protected $hidden = [
        'id','fk_patient_id','fk_crisis_event_id', 'fk_minute_timestamps_id','notes','created_at', 'updated_at'
    ];
}
