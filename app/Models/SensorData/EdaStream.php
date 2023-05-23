<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class EdaStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "eda_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
       'realData', 'imaginaryData','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
