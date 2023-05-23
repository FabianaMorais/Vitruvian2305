<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedTaking extends Model
{
    //
    protected $table = "med_takings";
    protected $guarded = ['id'];
    public $primaryKey = 'id';
    protected $connection = 'pgsql_v_watch';
    public $timestamps = true;

    protected $fillable = [
        'fk_patient_medication_id', 'intake_date'
    ];
    protected $hidden = [
        'id','created_at','updated_at','fk_patient_medication_id'
    ];
}
