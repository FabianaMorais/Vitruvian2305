<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class PedometerStream extends Model
{
    //
    protected $connection = 'pgsql_v_watch';
    protected $table = "pedometer_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'num_steps', 'algo_status','reserved','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
