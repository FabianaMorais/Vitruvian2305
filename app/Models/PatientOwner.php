<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientOwner extends Model
{
    protected $table = "patients_owners";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'fk_patient_id', 'fk_owner_id',
    ];

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient', 'fk_patient_id');
    }

    /**
     *@return User model
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_owner_id');
    }

}
