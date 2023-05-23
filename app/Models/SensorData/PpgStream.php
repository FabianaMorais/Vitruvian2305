<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class PpgStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "ppg_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'adpllibstate', 'confidence','hr','type','interval','timestamp_utc','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
