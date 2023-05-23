<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class Permissions extends Model
{

    private $permissions;
     // permissions - NOTE: frontend needs to be changed accordingly upon changes to this model
    //1 -> list patients
    //2 -> add a new patient
    //3 -> recover patient password
    //4 -> view teams
    //5 -> Add teams
    //6 -> Download data in csv
    public const VIEW_PATIENTS_PERMISSION = 1;
    public const ADD_PATIENTS_PERMISSION = 2;
    public const RECOVER_PATIENT_PASSWORD_PERMISSION = 3;
    public const VIEW_TEAMS_PERMISSION = 4;
    public const ADD_TEAMS_PERMISSION = 5;
    public const DOWNLOAD_DATA_PERMISSION = 6;

    public static function getUserPermissions($user_type){
        if($user_type == USER::DOCTOR){
            $permissions = [
                PERMISSIONS::VIEW_PATIENTS_PERMISSION,
                PERMISSIONS::ADD_PATIENTS_PERMISSION,
                PERMISSIONS::RECOVER_PATIENT_PASSWORD_PERMISSION,
                PERMISSIONS::VIEW_TEAMS_PERMISSION,
                PERMISSIONS::ADD_TEAMS_PERMISSION
            ];
        }
        if($user_type == USER::RESEARCHER){
            $permissions = [
                PERMISSIONS::VIEW_PATIENTS_PERMISSION,
                PERMISSIONS::ADD_PATIENTS_PERMISSION,
                PERMISSIONS::RECOVER_PATIENT_PASSWORD_PERMISSION,
                PERMISSIONS::VIEW_TEAMS_PERMISSION,
                PERMISSIONS::ADD_TEAMS_PERMISSION,
                PERMISSIONS::DOWNLOAD_DATA_PERMISSION
            ];
        }
        if($user_type == USER::CAREGIVER){
            $permissions = [PERMISSIONS::VIEW_PATIENTS_PERMISSION,PERMISSIONS::RECOVER_PATIENT_PASSWORD_PERMISSION,PERMISSIONS::VIEW_TEAMS_PERMISSION,PERMISSIONS::ADD_TEAMS_PERMISSION];
        }
        return $permissions;
    }
}
