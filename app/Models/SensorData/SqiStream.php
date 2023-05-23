<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class SqiStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "sqi_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'sqiSlot','sequenceNumber','reserved', 'algoStatus', 'sqi', 'timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
