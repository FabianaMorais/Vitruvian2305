<?php

namespace App\Http\Controllers\PublicAPI;

use App\Http\Controllers\PublicAPI\BaseApiDataHandler;
use Illuminate\Http\Request;
use App\Models\TeamUser;

class ProfessionalDataController extends BaseApiDataHandler
{

    /**
     * Controller protected by PublicApiAccess middleware
     */
    public function __construct()
    {
        $this->middleware('api.public');
    }

    /**
     * Retrieves the list of patients associated with the
     * current professional whether by teams or by directly
     * owning them
     */
    public function getPatients(Request $req) {
        $pats = $req->apiUser->getRoleData()->getPatients(true);

        $list = array();

        foreach($pats as $p) {
            if ($p->isFullyRegistered()) { // We only add patients which already logged in for the first time
                array_push($list, $p->inscription_code);
            }
        }

        return response()->json(['patients' => json_encode($list)], 200);
    }

    /**
     * Retrieves the list of patients directly associated
     * with the current professional
     * 
     */
    public function getOwnedPatients(Request $req) {
        $pats = $req->apiUser->getRoleData()->getPatients();

        $list = array();

        foreach($pats as $p) {
            if ($p->isFullyRegistered()) { // We only add patients which already logged in for the first time
                array_push($list, $p->inscription_code);
            }
        }

        return response()->json(['patients' => json_encode($list)], 200);
    }

    /**
     * Retrieves the list of patients associated with the
     * passed teams if, and only if, the current professional
     * participates in the passed teams
     *
     */
    public function getTeamPatients(Request $req) {
        $teams = $this->allowTeamsOrFail($req); // Validating passed teams

        $list = array();

        foreach ($teams as $t) {
            $patients = $t->getPatients();

            $teamPatsList = array();

            foreach($patients as $p) {
                if ($p->isFullyRegistered()) { // We only add patients which already logged in for the first time
                    array_push($teamPatsList, $p->inscription_code);
                }
            }

            // Creating team model that will be returned
            $teamEntry = new \stdClass();
            $teamEntry->team_name = $t->name;
            $teamEntry->code = $t->code;
            $teamEntry->patients = $teamPatsList;

            // Adding it to the list
            array_push($list, $teamEntry);
        }

        return response()->json(['teams' => json_encode($list)], 200);

    }

    /**
     * Retrieves the list of teams in which the current professional
     * participates
     * 
     */
    public function getTeams(Request $req) {
        $teams = $req->apiUser->getRoleData()->getTeams();

        $list = array();

        foreach($teams as $t) {
            array_push($list, $t->code);
        }

        return response()->json(['teams' => json_encode($list)], 200);
    }

    /**
     * Retrieves the list of teams in the current professional's
     * organization
     * 
     */
    public function getOrgTeams(Request $req) {
        $org = $teams = $req->apiUser->getRoleData()->organization;

        if (!isset($org)) { // If the current user does not have an organization
            return response()->json(['teams' => json_encode( array() )], 200); // we return an empty array
        }

        $teams = $org->getTeams();

        $list = array();

        foreach($teams as $t) {
            array_push($list, $t->code);
        }

        return response()->json(['teams' => json_encode($list)], 200);
    }

    /**
     * Retrieves the list of professionals associated with the
     * passed teams
     *
     */
    public function getTeamProfessionals(Request $req) {
        $teams = $this->allowTeamsOrFail($req); // Validating passed teams

        $list = array();

        foreach ($teams as $t) {
            $teamProParticipations = TeamUser::where('fk_team_id', $t->id)
                            ->where(function($query)
                            { // All participating professionals have one of these roles
                                $query->where('role', TeamUser::MEMBER)
                                    ->orWhere('role', TeamUser::LEADER);
                            })
                            ->get();

            $teamProsList = array();

            foreach($teamProParticipations as $p) {

                $userData = $p->user->getData();

                $proInfo = new \stdClass();
                $proInfo->name = $userData->full_name;
                $proInfo->role = ($p->role == TeamUser::LEADER)? "leader" : "member" ;
                $proInfo->type = $userData->role;

                if (isset($userData->organization_name)) {
                    $proInfo->organization = $userData->organization_name;
                }

                array_push($teamProsList, $proInfo);
            }

            // Creating team model that will be returned
            $teamEntry = new \stdClass();
            $teamEntry->team_name = $t->name;
            $teamEntry->code = $t->code;
            $teamEntry->professionals = $teamProsList;

            // Adding it to the list
            array_push($list, $teamEntry);
        }

        return response()->json(['teams' => json_encode($list)], 200);


    }
}
