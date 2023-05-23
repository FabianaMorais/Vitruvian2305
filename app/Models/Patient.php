<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Users\User;
use App\Models\PatientOwner;

use Carbon\Carbon;

class Patient extends Model
{
    protected $table = "patients";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fk_user_id', 'full_name', 'phone',
    ];

    public const BLOOD_UNSPECIFIED = 0;
    public const BLOOD_A_POS = 1;
    public const BLOOD_A_NEG = 2;
    public const BLOOD_B_POS = 3;
    public const BLOOD_B_NEG = 4;
    public const BLOOD_O_POS = 5;
    public const BLOOD_O_NEG = 6;
    public const BLOOD_AB_POS = 7;
    public const BLOOD_AB_NEG = 8;

    public const GENDER_UNSPECIFIED = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // assigning unique code on model creation
            $model->inscription_code = Patient::generatePatientCode(12);
        });
    }

    /**
     * Algorithm to generate unique patient codes
     * 
     * @return String unique patient codes
     */
    private static function generatePatientCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz!#%&';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Checking if the code is already taken
        $existingCode = Patient::where('inscription_code', $randomString)->get()->first();

        if (isset($existingCode)) { // NOTE: Recursive function!
            return Patient::generatePatientCode($length);

        } else {
            return $randomString;
        }
    }

    /**
     * @return String with the passed blood type as string in
     * the current user's language
     */
    public static function getBloodTypeString($type) {
        switch($type) {
            case Patient::BLOOD_A_POS:
                return trans('health.BLOOD_A_POS');

            case Patient::BLOOD_A_NEG:
                return trans('health.BLOOD_A_NEG');

            case Patient::BLOOD_B_POS:
                return trans('health.BLOOD_B_POS');

            case Patient::BLOOD_B_NEG:
                return trans('health.BLOOD_B_NEG');

            case Patient::BLOOD_O_POS:
                return trans('health.BLOOD_O_POS');

            case Patient::BLOOD_O_NEG:
                return trans('health.BLOOD_O_NEG');

            case Patient::BLOOD_AB_POS:
                return trans('health.BLOOD_AB_POS');

            case Patient::BLOOD_AB_NEG:
                return trans('health.BLOOD_AB_NEG');

            default:
                return trans('health.BLOOD_UNSPECIFIED');
        }
    }

    /**
     * @return String with the passed gender as string in
     * the current user's language
     */
    public static function getGenderString($gender) {
        switch($gender) {
            case Patient::GENDER_MALE:
                return trans('generic.GENDER_MALE');

            case Patient::GENDER_FEMALE:
                return trans('generic.GENDER_FEMALE');

            default:
                return trans('generic.GENDER_UNDEFINED');
        }
    }

    /**
     * Get the user associated with this Patient
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }

    /**
     * Checks if the user with the passed id owns this Patient
     * Owning means this Patient is directly associated with the
     * passed user, which is a Professional.
     * NOTE: Being on shared teams does NOT count as owning.
     *
     * @return bool true if owned
     */
    public function isOwnedBy($userId) : bool {

        $owner = PatientOwner::where('fk_patient_id', $this->id)
                                ->where('fk_owner_id', $userId)
                                ->get()->first();

        if(isset($owner)) {
            return true;

        } else {
            return false;
        }
    }

    /**
     * Checks if this patient entry was created by the professional with the passed user id
     * Note that creators and owners are different
     * A professional may own a patient but not be his creator
     * 
     * @return true if creator is the user with the passed id
     */
    public function wasCreatedBy(User $user) : bool {
        // All we do is retrieve the very first ownership of this patient, even if it was deleted
        $creatorOwn = PatientOwner::withTrashed()->where('fk_patient_id', $this->id)->get->first();
        return ($creatorOwn->fk_owner_id == $user->id)? true : false;
    }

    /**
     * Retrieves the full list of this patient's owners
     * as User models
     *
     * @return array[User] of this patient's owners
     */
    public function getOwners() : array {

        $ownerList = PatientOwner::where('fk_patient_id', $this->id)->get();

        $owners = array();
        foreach($ownerList as $ol) {
            array_push($owners, $ol->owner);
        }

        return $owners;
    }

    /**
     * Retrieves all teams on which this patient participates
     * 
     * @return Collection[Team] with all the teams on which this patient participates
     */
    public function getTeams() : Collection {

        $teams = array();

        // get teams on which this patient participates
        $tParticipations = TeamUser::where('fk_user_id', $this->fk_user_id)->get();

        foreach($tParticipations as $part) {
            $teams[$part->fk_team_id] = $part->team; // We index by ID to override redundancies
        }
        return new Collection($teams);
    }

    /**
     * Retrieves this patient's health profile data
     * 
     * @return stdClass with this patient's health profile
     */
    public function getHealthProfile() {

        $profile = new \stdClass();
        $myUser = $this->user; // some data comes from the user entry

        $profile->user_id = $myUser->id;
        $profile->patient_id = $this->id;

        $profile->name = $myUser->name;
        $profile->phone = $this->phone;
        $profile->email = $myUser->email;

        $profile->full_name = $this->full_name;
        $profile->country = $this->country;
        $profile->gender = $this->gender;
        $profile->weight = $this->weight_kg;


        if (isset($this->date_of_birth)) {
            $bDate = Carbon::parse($this->date_of_birth);

            $profile->b_day = $bDate->day;
            $profile->b_month = $bDate->month;
            $profile->b_year = $bDate->year;

            $profile->age = $bDate->age;
            $profile->b_day_string = $profile->b_year . "/" . $profile->b_month . "/" . $profile->b_day;

        } else { // if brithdate is not set
            $profile->b_day = NULL;
            $profile->b_month = NULL;
            $profile->b_year = NULL;
            $profile->age = NULL;
            $profile->b_day_string = "-";
        }

        $profile->blood_type = $this->blood_type;
        $profile->diagnosed = $this->diagnosed;
        $profile->other = $this->other;

        return $profile;
    }

    /**
     * Checks if the passed user may access data from this patient
     *
     * This function defines the criteria with which a user (usually
     * a professional) may or may not access a patient's health data
     * 
     * @return true if this patient may be accessed by the passed user
     */
    public function mayBeAcessedBy(User $user) : bool {
         // Patient must be fully registered to be accessed
        if (!$this->isFullyRegistered()) {
            return false;
        }

        // Only professionals may access user data
        if (!$user->isProfessional()) {
            return false;
        }

        // Patient must either be directly owned by the professional
        if ($this->isOwnedBy($user->id)) {
            return true;
        }

        // Or be in a team in which the professional participates as well
        if ( Team::isSharedBy($this->user, $user) ) {
            return true;
        }

        return false;
    }

    /**
     * Checks if this patient can be released by a professional or organization
     * without being left without any owners
     * 
     * @return true if this patient may be let go by a professional or organization
     * without being left alone with no owners
     */
    public function mayBeReleased() : bool {

        return true;
    } // TODO: STUB!!!

    /**
     * Checks if the patient completed his fitst registration
     */
    public function isFullyRegistered() : bool {
        return ( isset($this->first_login) )? true : false;
    }



    //gets a list of medication intakes scheduled for a patient in a date
    //Returns med list if results are found, false if no results
    public function getPatientMedicationForDay($patient,$date){
        $med_list = PatientMedication::where('fk_patient_id',$patient->getRoleData()->id)
            ->where('start_date','<',$date)
            ->where(function($query) use ($date) {
                $query = $query->where('end_date', NULL)->orWhere('end_date', '<',$date);
            })
        ->get();

        $clean_med_list = [];
        foreach($med_list as $pat_med){
            $pat_med->prescription_id = $pat_med->id;
            $pat_med->patient = $patient->name;
            $intake_description = Medication::find($pat_med->fk_medication_id);
            $pat_med->medication = '' . $intake_description->name . ' (' . $intake_description->pill_dosage . ' mg)';
            $days_since_start = $date->diffInDays($pat_med->start_date);
            //every x days means diffInDays % x needs to be 0 to be a take day
            if($days_since_start % $pat_med->periodicity == 0){
                //associate the nr of pills to the scheduled intakes , arrays have same lengths, 1-1 mapping
                for($i=0; $i<count($pat_med->scheduled_intakes); $i++){
                    $result_time = MinuteTimestamps::find($pat_med->scheduled_intakes[$i]);
                    //add 0 before single digit hours and minutes
                    if($result_time->hour < 10){
                        $result_time->hour = '0' . $result_time->hour;
                    }
                    if($result_time->minute < 10){
                        $result_time->minute = '0' . $result_time->minute;
                    }
                    $pat_med->intake_time = '' . $result_time->hour . ':' . $result_time->minute;
                    $pat_med->intake_amount = $pat_med->nr_of_pills_each_intake[$i];
                    array_push($clean_med_list,$pat_med);
                }
            }
            
        }
        if(count($clean_med_list)>0){
            return $clean_med_list;
        }else{
            return false;
        }
    }
}
