<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class AdxlStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "adxl_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'x', 'y','z','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
