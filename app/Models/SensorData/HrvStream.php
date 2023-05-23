<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class HrvStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "hrv_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'rr_interval','is_gap','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
