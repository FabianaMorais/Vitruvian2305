<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class EcgStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "ecg_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'data','ecg_info','hr','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
