<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\NewRegistries\NewProData;
use App\Models\NewRegistries\NewOrgData;
use  App\Models\Organization;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class NewUser extends Authenticatable implements MustVerifyEmail {

    
    protected $guard = 'new_reg'; // new registries

    protected $connection = 'mysql_new_users';
    protected $table = "new_users";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use Notifiable;

    use Uuid;
    protected $keyType = 'string'; // The "type" of the auto-incrementing ID.
    public $incrementing = false; // Indicates if the IDs are auto-incrementing.

    // New registration types
    // NOTE: Values can't be the same as User model's
    public const NEW_RESEARCHER = 1000;
    public const NEW_DOCTOR = 1200;
    public const NEW_CAREGIVER = 1300;
    public const NEW_ORGANIZATION = 2000;

    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Checks if the current user is of the passed type
     */
    public function isType($type) : bool {
        return ($this->type == $type)? true : false;
    }

    public function isProfessional() : bool {
        // if it is not an organization, it's a professional. There ar no admins for new users
        return ($this->type == NewUser::NEW_ORGANIZATION)? false : true;
    }

    public function isOrganization() : bool {
        return ($this->type == NewUser::NEW_ORGANIZATION)? true : false;
    }

    public function isAdmin() : bool {
        return false;
    }

    /**
     * Returns this user's role data model, whether it is a
     * new researcher, new doctor, new caregiver, or new organization
     * @return Model depending on user type
     */
    public function getRoleData() {
        if ($this->isProfessional()) {
            return NewProData::where('fk_new_user_id', $this->id)->get()->first();

        } else if ($this->isOrganization()) {
            return NewOrgData::where('fk_new_user_id', $this->id)->get()->first();

        } else {
            return new \stdClass();
        }
    } // TODO: Improve! use eloquent's system!

    /**
     * Retrieves the full name, no matter if it is a new professional
     * or a new organization
     */
    public function getFullName() {
         if ($this->type == NewUser::NEW_ORGANIZATION) {
            $orgData = NewOrgData::where('fk_new_user_id', $this->id)->get()->first();
            return $orgData->full_name;

        } else {
            $proData = NewProData::where('fk_new_user_id', $this->id)->get()->first();
            if (isset($proData)) {
                return $proData->full_name;
            } else {
                return "";
            }
        }
    }

    /**
     * Retrieves data concerning the new registered entity
     * @return stdClass data depending on the registry type
     */
    public function getData() : \stdClass {

        $data = new \stdClass();
        $data->id = $this->id;
        $data->type = $this->type;
        $data->username = $this->name;
        $data->email = $this->email;
        $data->avatar = $this->avatar;

        switch($this->type) {
            case NewUser::NEW_ORGANIZATION:
                $data->role = ucfirst(trans('generic.ORGANIZATION'));
            break;
            
            case NewUser::NEW_DOCTOR:
                $data->role = ucfirst(trans('generic.DOCTOR'));
            break;
            
            case NewUser::NEW_CAREGIVER:
                $data->role = ucfirst(trans('generic.CAREGIVER'));
            break;
            
            default:
                $data->role = ucfirst(trans('generic.RESEARCHER'));
            break;
        }

        $regDate = date_create($this->email_verified_at); // converting to readable date
        $data->registered_at = date_format($regDate,"d/m/Y - H:i");

        if ($this->type == NewUser::NEW_ORGANIZATION) {
            $orgData = NewOrgData::where('fk_new_user_id', $this->id)->get()->first();

            $data->full_name = $orgData->full_name;
            $data->leader_name = $orgData->leader_name;
            $data->fiscal_number = $orgData->fiscal_number;
            $data->address = $orgData->address;
            $data->phone = $orgData->phone;

        } else {
            $proData = NewProData::where('fk_new_user_id', $this->id)->get()->first();

            if (isset($proData)) {
                $data->full_name = $proData->full_name;
                $data->address = $proData->address;
                $data->phone = $proData->phone;
    
                // if this new professional has an associated organization
                if (isset($proData->fk_organization_id)) {
                    $org = Organization::find($proData->fk_organization_id);
                    $data->organization_id = $org->id;
                    $data->organization_name = $org->full_name;
    
                } else { // if not, we retrieve his custom organization
                    $data->organization_name = $proData->custom_organization;
                }
            } else { // safeguarding against bugs
                $data->full_name = "";
                $data->address = "";
                $data->phone = "";
                $data->organization_name = "";
            }
        }
        return $data;
    }

    /**
     * Deletes the user's account, as well as all its data, depending on user type
     * NOTE: New users are always hard deleted
     * 
     * @return true if user was deleted
     */
    public function deleteAccount() : bool{
        switch($this->type) {
            case NewUser::NEW_RESEARCHER:
            case NewUser::NEW_DOCTOR:
            case NewUser::NEW_CAREGIVER:
                $data = NewProData::where('fk_new_user_id', $this->id)->get()->first();
                break;

            case NewUser::NEW_ORGANIZATION:
                $data = NewOrgData::where('fk_new_user_id', $this->id)->get()->first();
                break;
        }

        if (isset($data)) {
            $data->delete();
            $this->delete();
            return true;
        }

        // User type not recognized
        return false;
    }

}