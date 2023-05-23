<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class TemperatureStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "temperature_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'skin_temperature', 'ambient_temperature','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
