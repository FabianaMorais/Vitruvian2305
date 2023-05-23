<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class AdpdStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "adpd_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'signalData','darkData','sequenceNum','channel','sampleNum','timestamp_utc' ,'user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
