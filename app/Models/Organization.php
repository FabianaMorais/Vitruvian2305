<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Professional;
use App\Models\TeamUser;
use App\Models\PatientOwner;
use Illuminate\Database\Eloquent\Collection;

use Log;

class Organization extends Model
{
    protected $table = "organizations";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fk_user_id', 'full_name', 'official_email', 'leader_name', 'fiscal_number', 'address', 'phone'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // assigning unique code on model creation
            $model->code = Organization::generateOrgCode(5);
        });
    }

    /**
     * Algorithm to generate unique organization code
     * 
     * @return String unique organization code
     */
    private static function generateOrgCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz!#$%&/=_:.,;';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Checking if the code is already taken
        $existingCode = Organization::where('code', $randomString)->get()->first();

        if (isset($existingCode)) { // NOTE: Recursive function!
            return Organization::generateOrgCode($length);

        } else {
            return $randomString;
        }
    }

    /**
     * Get the user associated with this Organization
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User', 'fk_user_id');
    }

    /**
     * Retrieves all teams on which this organization participates
     * @param createdOnly if true will only return teams directly created by this organization
     *        if false, returns all teams on which this organization participates, even if they
     *        were created by anotehr organization.
     *        True by default.
     * 
     * @return Collection[Team] with all the teams on which this organization participates
     */
    public function getTeams($createdOnly = true) : Collection {

        $teams = array();

        if ($createdOnly === false) { // If we want to include all teams
            $tParticipations = TeamUser::where('fk_user_id', $this->fk_user_id)->get();

            foreach($tParticipations as $part) {
                $teams[$part->team->id] = $part->team; // We index by ID to override redundancies
            }

        } else { // the default behaviour is only retrieving the teams created by this organization

            $tParts = TeamUser::where('fk_user_id', $this->fk_user_id)->get();

            // we have to filter if the current organization was the team's creator
            foreach($tParts as $p) {
                if ($p->team->wasCreatedBy($this->user)) {
                    $teams[$p->team->id] = $p->team;
                }
            }
        }

        // We convert our array of results to an Eloquent's collection so it is compatible
        // with our code structure
        return new Collection($teams);
    }


    /**
     * Get all patients associated with this organization
     * @param includeTeams Should the request include patients which are
     *        shared with this organization through teams?
     *        May also include patients from other organizations
     *        False by default
     * 
     * @return Patient models associated with this organization
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

            // we retrieve all teams in which this organization participates
            $teams = $this->getTeams(false);

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




    // Data for UI
    /**
     * Retrieves all professionals for the current organization to be presented in the UI
     * sorted by full name
     * 
     * @return array[user_uuid] with all this organization's professionals
     */
    public function getProUIList() : array {

        $orgPros = Professional::where( 'fk_organization_id', $this->id )->get();

        $resultList = array();
        foreach ($orgPros as $pro) {

            $u = $pro->user;
            $entry = $u->getUIData();
            $resultList[$entry->key] = $entry; // We index in the array with the user's key so it is easily reachable by uuid
        }

        // sorting professionals alphabetically
        uasort($resultList, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });

        return $resultList;
    }

}