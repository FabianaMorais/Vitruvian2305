<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class BcmStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "bcm_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'realData','imaginaryData','frequencyIndex','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
