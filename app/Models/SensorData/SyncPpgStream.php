<?php

namespace App\Models\SensorData;

use Illuminate\Database\Eloquent\Model;

class SyncPpgStream extends Model
{
    protected $connection = 'pgsql_v_watch';
    protected $table = "syncppg_stream";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'adxlTs', 'x','y','z','ppgTs','ppgData','user_db_patient_id'
    ];
    protected $hidden = [
        'user_db_patient_id'
    ];
}
