<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PatientOwner;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

class Professional extends Model
{
    protected $table = "professionals";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fk_user_id', 'full_name', 'address', 'phone',
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at', 'code',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // assigning unique code on model creation
            $model->code = Professional::generateProCode(6);
        });
    }

    /**
     * Algorithm to generate unique professional codes
     * 
     * @return String unique professional code
     */
    private static function generateProCode($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Checking if the code is already taken
        $existingCode = Professional::where('code', $randomString)->get()->first();

        if (isset($existingCode)) { // NOTE: Recursive function!
            return Professional::generateProCode($length);

        } else {
            return $randomString;
        }
    }

    /**
     * Get the user associated with this Professional
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }

    /**
     * Retrieves the Organization associated with this professional
     * 
     * @return Organization|Null Organization might be null
     */
    public function organization() {
        return $this->belongsTo('App\Models\Organization', 'fk_organization_id');
    }

    /**
     * Checks if this professional belongs to an organziation
     * 
     * @return true if professional belongs to an organization
     */
    public function hasOrganization() : bool {
        return (isset($this->organization))? true : false;
    }

    /**
     * Checks if this professional belongs to the passed organization
     * @param organizationId is the id from the ORGANIZATION model!
     */
    public function belongsToOrg($organizationId) : bool {
        return ($this->fk_organization_id == $organizationId)? true : false;
    }

    /**
     * Retrieves all teams on which this professional participates
     * 
     * @return Collection[Team] with all the teams on which this professional participates
     */
    public function getTeams() : Collection {

        $teams = array();

        // get teams on which this professional participates
        $tParticipations = TeamUser::where('fk_user_id', $this->fk_user_id)->get();

        foreach($tParticipations as $part) {
            $teams[$part->team->id] = $part->team; // We index by ID to override redundancies
        }

        // We convert our array of results to an Eloquent's collection so it is compatible
        // with our code structure
        return new Collection($teams);
    }

    /**
     * Get all patients associated with this professional
     * @param includeTeams Should the request include patients which are
     *        shared with this professional through teams?
     *        May also include patients from other organizations
     *        False by default
     * 
     * @return Patient models associated with this professional
     */
    public function getPatients(bool $includeTeams = false) : Collection {

        $patients = array(); // We'll store all professionals in an array

        // Directly owned patients
        $ownedPats = PatientOwner::where('fk_owner_id', $this->fk_user_id)->get();
        foreach($ownedPats as $op) {
            // bookkeeping patients with id as index, so we don't get repeated entries when adding the team's patients
            $patients[$op->fk_patient_id] = $op->patient;
        }

        // Patients shared through teams
        if ($includeTeams === true) {

            $teams = $this->getTeams(); // we retrieve all teams in which this professional aprticipates

            foreach($teams as $t) {

                // get patients from each team
                $tPats = TeamUser::where('fk_team_id', $t->id)
                                ->where('role', TeamUser::SUBJECT)
                                ->get();

                foreach($tPats as $tu) {
                    if ($tu->user->isPatient()) { // safeguarding
                        $pat = $tu->user->getRoleData();

                        if (!isset($patients[$pat->id])) { // if a patient with that key is not stored in our array
                            $patients[$pat->id] = $pat; // we add it
                        }
                    }
                }

            }
        }

        // We convert our array of results to an Eloquent's collection so it is compatible
        // with our code structure
        return new Collection($patients);
    }

    /**
     * Checks if this professional may access data from the passed patient
     * @param patient: The Patient model which is being checked
     * 
     * @return true if patient data is accessible for the current professional
     */
    public function mayAccess(Patient $patient) : bool {
        return $patient->mayBeAcessedBy( $this->user );
    }
}