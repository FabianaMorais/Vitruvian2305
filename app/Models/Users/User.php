<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

use App\Models\Administrator;
use App\Models\Professional;
use App\Models\Organization;
use App\Models\Patient;

use Log;

class User extends Authenticatable implements MustVerifyEmail
{
    protected $table = "users";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use Notifiable, HasApiTokens;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use Uuid;
    protected $keyType = 'string'; // The "type" of the auto-incrementing ID.
    public $incrementing = false; // Indicates if the IDs are auto-incrementing.

    // NOTE: Values can't be the same as NewUser model's
    public const RESEARCHER = 100;
    public const DOCTOR = 120;
    public const CAREGIVER = 130;
    public const ORGANIZATION = 200;
    public const PATIENT = 500;
    public const ADMIN = 700;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at', 'type', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];

    /**
     * Checks if the current user is of the passed type
     */
    public function isType($type) : bool {
        return ($this->type == $type)? true : false;
    }

    public function isProfessional() : bool {
        return ($this->type == User::RESEARCHER
            || $this->type == User::DOCTOR
            || $this->type == User::CAREGIVER)? true : false;
    }

    public function isOrganization() : bool {
        return ($this->type == User::ORGANIZATION)? true : false;
    }

    public function isAdmin() : bool {
        return ($this->type == User::ADMIN)? true : false;
    }

    public function isPatient() : bool {
        return ($this->type == User::PATIENT)? true : false;
    }

    /**
     * Returns this user's role data model, whether it is a
     * researcher, doctor, caregiver, admin or patient
     * @return Model depending on user type
     */
    public function getRoleData() {
        if ($this->isProfessional()) {
            return Professional::where('fk_user_id', $this->id)->get()->first();

        } else if ($this->isOrganization()) {
            return Organization::where('fk_user_id', $this->id)->get()->first();
        
        } else if ($this->isAdmin()) {
            return Administrator::where('fk_user_id', $this->id)->get()->first();

        } else if ($this->isPatient()) {
            return Patient::where('fk_user_id', $this->id)->get()->first();

        } else {
            return NULL;
        }
    } // TODO: improve with eloquent's system?

    /**
     * Retrieves this user's basic data for UI
     * Display name, avatar, user type and user key
     */
    public function getUIData() {

        $data = new \stdClass();

        // retrieving full name depending on type
        if ($this->isProfessional()
            || $this->isOrganization()
            || $this->isAdmin()) {
            $data->name = $this->getRoleData()->full_name;

        } else if ($this->isPatient()) { // Patient names are their full name followed by their username
            $data->name = $this->getRoleData()->full_name . ' (' . $this->name . ')';

        } else {
            $data->name = $this->name; // We display the username if no other is specified
        }

        $data->avatar = $this->avatar;
        $data->type = $this->type;
        $data->key = $this->id;

        return $data;
    }


    /**
     * Retrieves this user's data and role data
     * IMPORTANT: The data is NOT safe to be passed to the client side as Json. Must be filtered first
     * @return Json with all the user's data
     */
    public function getData() {


        // TODO: Retrieve professional's organization's name, depending on the situation (custom or not)

        // TODO: Maybe add bool argument to make data safe for UI?

        $jData = $this->getRoleData()->toJson();

        $data = json_decode($jData);
        $data->key = $this->id;
        $data->username = $this->name;
        $data->email = $this->email;
        $data->avatar = $this->avatar;
        $data->type = $this->type;

        $data->organization_name = NULL; // TODO: Already in use. Use this var name

        switch($this->type) { // we return type as string (role)
            case User::RESEARCHER:
                $data->role = ucwords( trans('generic.RESEARCHER') );
                break;
            case User::DOCTOR:
                $data->role = ucwords( trans('generic.DOCTOR') );
                break;
            case User::CAREGIVER:
                $data->role = ucwords( trans('generic.CAREGIVER') );
                break;
            case User::ORGANIZATION:
                $data->role = ucwords( trans('generic.ORGANIZATION') );
                break;
            case User::ADMIN:
                $data->role = ucwords( trans('generic.ADMINISTRATOR') );
                break;
            case User::PATIENT:
                $data->role = ucwords( trans('generic.PATIENT') );
                break;
            default:
                $data->role = ucwords( trans('generic.UNDEFINED') );
                break;
        }

        return $data;
    }

    /**
     * Deletes the user's account, as well as all its data, depending on user type
     * @param hardDelete: true if user's data should be hard deleted. False by default
     *
     * @return true if user was deleted
     */
    public function deleteAccount($hardDelete = false) : bool{

        $data = $this->getRoleData();

        switch($this->type) {
            case User::PATIENT:

                // TODO: delete models:
                // User
                // Patient
                // TeamUser
                // PatientOwner
                // PatientMedication
                // PatientCrisisEvent

                return false;

            case User::RESEARCHER:
            case User::DOCTOR:
            case User::CAREGIVER:

                // TODO: check if patients may be released
                // TODO: Can't delete pro if patients are left without owners
                // TODO: Remove TeamUser entries, PatientOwner entries, etc

                // TODO: delete models:
                // User
                // Professional
                // TeamUser
                // PatientOwner

                return false;

            case User::ORGANIZATION:
                // TODO: Removable organizations
                // TODO: All associated pros should be released?

                // TODO: check if patients may be released
                // TODO: Can't delete org if patients are left without owners?


                return false;

            case User::ADMIN:
                // TODO: Removable admin

                return false;
        }

        // If all user elements were found
        if (isset($data)) {

            $data->delete();
            $this->delete();

            return true;
        }

        // User type not recognized
        return false;
    } // TODO: STUB - COMPLETE THIS!



    /**
     * IMPORTANT: COMMENT ME!!!!!!!
     */
    public function getRoleColor(){
        if($this->type == User::RESEARCHER){
            return 'vicon-res';
        }
        if($this->type == User::DOCTOR){
            return 'vicon-doc';
        }
        if($this->type == User::CAREGIVER){
            return 'vicon-care';
        }
    }

}
