<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use App\Models\Users\User;
use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Collection;

class Team extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use Uuid;
    protected $keyType = 'string'; // The "type" of the auto-incrementing ID.
    public $incrementing = false; // Indicates if the IDs are auto-incrementing.

    protected $table = "teams";
    protected $guarded = ['id'];
    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'description', 'code',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) { // assigning unique code on model creation
            $model->code = Team::generateTeamCode(8);
        });
    } // CONSIDER: Define creator user and creator organization here?

    /**
     * Algorithm to generate unique team keys
     * 
     * @return String unique team key
     */
    private static function generateTeamCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Checking if the code is already taken
        $existingCode = Team::where('code', $randomString)->get()->first();

        if (isset($existingCode)) { // NOTE: Recursive function!
            return Team::generateTeamCode($length);

        } else {
            return $randomString;
        }
    }

    /**
     * Checks if the passed user id has writing permissions on the
     * passed teamId
     * @return bool true is user has writing permissions
     */
    public static function hasWritingPermissions($userId, $teamId) : bool {
        $teamUser = TeamUser::where('fk_team_id', $teamId)
                            ->where('fk_user_id', $userId )
                            ->where('access', TeamUser::WRITE) // User MUST have editing rights
                            ->get()
                            ->last(); // the most recent

        return (isset($teamUser))? true : false;
    }

    /**
     * Checks if there is at least one shared team between two users
     * 
     * @return true if one or more teams are shared between the two passed users
     */
    public static function isSharedBy(User $userA, User $userB) : bool {

        // Log::debug("CHECKING A: " . $userA->name . " With id " . $userA->id);
        // Log::debug("CHECKING B: " . $userB->name . " With id " . $userB->id);

        // Finding the number of team participations for one of the users
        $tParticipations = TeamUser::where('fk_user_id', $userA->id)->get();

        foreach($tParticipations as $part) {
            $shared = TeamUser::where('fk_team_id', $part->fk_team_id)
                                ->where( 'fk_user_id', $userB->id )
                                ->get()->first();

            if (isset($shared)) { // Once we find a shared team entry
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if this team was created by the user with the passed id
     * 
     * @return bool True if the team was created by the passed user
     */
    public function wasCreatedBy(User $user) : bool {

        if ($user->isOrganization()) {
            // CONSIDER: If a professional WITHOUT an organization creates a team, and that team is later
            // associated with an organization, that organization is classified as its creator
            $creatorPart = TeamUser::withTrashed()->where('fk_team_id', $this->id)->where('role', TeamUser::PARTICIPANT_ORG)->get()->first();

        } else {
            // All we do is retrieve the very first participation on this team, even if it was deleted
            $creatorPart = TeamUser::withTrashed()->where('fk_team_id', $this->id)->get()->first();
        }

        return ($creatorPart->fk_user_id == $user->id)? true : false;

    } // CONSIDER:


    /**
     * Retrieves all professional models associated with this team
     * @return Collection[Professional] compatibe with eloquent queries
     */
    public function getProfessionals() : Collection {
        $tPros = TeamUser::where('fk_team_id', $this->id)
                            ->where(function($query)
                            { // All participating professionals have one of these roles
                                $query->where('role', TeamUser::MEMBER)
                                    ->orWhere('role', TeamUser::LEADER);
                            })
                            ->get();

        $data = array();
        foreach($tPros as $p) {
            if ($p->user->isProfessional()) { // safeguarding
                array_push($data, $p->user->getRoleData());
            }
        }

        return new Collection($data);
    }

    /**
     * Retrieves all patient models associated with this team
     * @return Collection[Patient] compatibe with eloquent queries
     */
    public function getPatients() : Collection {
        $tPats = TeamUser::where('fk_team_id', $this->id)
                        ->where('role', TeamUser::SUBJECT)
                        ->get();

        $data = array();
        foreach($tPats as $p) {
            if ($p->user->isPatient()) { // safeguarding
                array_push($data, $p->user->getRoleData());
            }
        }

        return new Collection($data);
    }

    /**
     * Retrieves all organization models associated with this team
     * @return Collection[Organization] compatibe with eloquent queries
     */
    public function getOrganizations() : Collection {
        $tOrgs = TeamUser::where('fk_team_id', $this->id)
                        ->where('role', TeamUser::PARTICIPANT_ORG)
                        ->get();

        $data = array();
        foreach($tOrgs as $o) {
            if ($o->user->isOrganization()) { // safeguarding
                array_push($data, $o->user->getRoleData());
            }
        }

        return new Collection($data);
    }



    // Data for UI
    /**
     * Get a list of all professionals associated with this team
     * NOTE: May retrieve professionals and patients from other organizations
     */
    public function getTeamUIData() : \stdClass {

        $data = new \stdClass();
        $data->key = $this->id;
        $data->name = $this->name;
        $data->description = $this->description;
        $data->professionals = $this->getUIPros();
        $data->organizations = $this->getUIOrgs();
        $data->patients = $this->getUIPatients();

        return $data;
    }

    /**
     * Retrieves a list of all professionals associated with this team
     * to be presented in the UI
     * NOTE: May retrieve professionals from other organizations
     * 
     * @return array[user_uuid] so each user is easily reachable by uuid
     */
    public function getUIPros() : array {
        $tPros = TeamUser::where('fk_team_id', $this->id)
                            ->where(function($query)
                            { // All participating professionals have one of these roles
                                $query->where('role', TeamUser::MEMBER)
                                    ->orWhere('role', TeamUser::LEADER);
                            })
                            ->get();

        $data = array();
        foreach($tPros as $p) {
            $pro = $p->user->getUIData();
            $pro->role = $p->role; // we also add role
            $pro->access = $p->access; // and access level

            $data[$pro->key] = $pro; // We index in the array with the user's key so it is easily reachable by uuid
        }

        uasort($data, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });

        return $data;
    }

    /**
     * Retrieves a list of all organizations associated with this team
     * to be presented in the UI
     * 
     * @return array[user_uuid] so each user is easily reachable by uuid
     */
    public function getUIOrgs() : array {
        $tOrgs = TeamUser::where('fk_team_id', $this->id)
                    ->where('role', TeamUser::PARTICIPANT_ORG)
                    ->get();

        $data = array();
        foreach($tOrgs as $o) {
            $org = $o->user->getUIData();
            $org->role = $o->role; // we also add role
            $org->access = $o->access; // and access level

            $data[$org->key] = $org; // We index in the array with the user's key so it is easily reachable by uuid
        }

        uasort($data, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });

        return $data;
    }

    /**
     * Retrieves a list of all patients associated with this team
     * to be presented in the UI
     * NOTE: May retrieve patients from other organizations
     * 
     * @return array[user_uuid] so each user is easily reachable by uuid
     */
    public function getUIPatients() : array {
        $tPats = TeamUser::where('fk_team_id', $this->id)
                        ->where('role', TeamUser::SUBJECT)
                        ->get();

        $data = array();
        foreach($tPats as $p) {
            $pat = $p->user->getUIData();
            $data[$pat->key] = $pat; // We index in the array with the user's key so it is easily reachable by uuid
        }

        uasort($data, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });

        return $data;
    }

    /**
     * Retrieves this teams's basic entry data to be displayed in the UI as an entry on a list
     * @return stdClass with data to be used in this team's UI card
     */
    public function getTeamCardUI() : \stdClass {

        // We could use this models functions to retrieve the data, but this way
        // is more efficient

        $data = new \stdClass();
        $data->key = $this->id;
        $data->name = $this->name;
        $data->org_count = 0; // default values
        $data->pro_count = 0;
        $data->patient_count = 0;
        $data->leaders = array();
        $data->pros = array();

        $teamUsers = TeamUser::where('fk_team_id', $this->id)->get();

        // list of professionals and count update
        foreach($teamUsers as $tu) {
            $u = $tu->user; // retrieving user entry

            if (isset($u)) { // preventing problems
                if ($u->isProfessional()) {

                    $data->pro_count ++;

                    if ($tu->role == TeamUser::LEADER) { // We Set leaders appart
                        array_push($data->leaders, $u->getUIData());

                    } else {
                        array_push($data->pros, $u->getUIData());
                    }

                } else if ($u->isOrganization()) {
                    $data->org_count ++;

                } else if ($u->isPatient()) {
                    $data->patient_count ++;
                }
                // Unnown cases are ignored
            }
        }
        return $data;
    }

}
