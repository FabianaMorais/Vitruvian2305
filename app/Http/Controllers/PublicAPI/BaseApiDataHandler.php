<?php

namespace App\Http\Controllers\PublicAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Collection;

/**
 * Handles all API data access between users
 * 
 * Checks data access and aborts requests if access is not
 * approved
 */
class BaseApiDataHandler extends Controller
{
    /**
     * Retrieves the requested patients for the current professional user or fails the request
     * If any of the requested patients is unaccessible for the current professional,
     * aborts the request entirely
     * 
     * @return Collection of Patient models or aborts the request
     */
    protected function allowPatientsOrFail(Request $req) {
        if ($req->input('patients') == NULL || !is_array($req->input('patients')) || count($req->input('patients')) == 0 ) {
            abort(422);
        }

        // Building the query
        $patients = Patient::where(function($query) use ($req) {
            foreach($req->input('patients') as $patCode) {
                $query = $query->orWhere('inscription_code', $patCode);
            }
        })->get();

        $currentPro = $req->apiUser->getRoleData();

        $approvedPats = array();

        // Checking to see if the current professional may access each patient's info
        foreach($patients as $p) {
            if (!$currentPro->mayAccess($p)) {
                abort(401);

            } else {
                array_push($approvedPats, $p);
            }
        }

        // If not all patients were found
        if (count($req->input('patients')) != count($patients )) {
            abort(422);
        }

        return new Collection($approvedPats);
    }

    /**
     * Retrieves the requested list of teams for the current professional user or fails the request
     * If any of the requested teams is unaccessible for the current professional,
     * aborts the request entirely
     * 
     * @return Collection of Team models or aborts the request
     */
    protected function allowTeamsOrFail(Request $req) {
        if ($req->input('teams') == NULL || !is_array($req->input('teams')) || count($req->input('teams')) == 0 ) {
            abort(422);
        }

        // Building the query
        $teams = Team::where(function($query) use ($req) {
            foreach($req->input('teams') as $teamCode) {
                $query = $query->orWhere('code', $teamCode);
            }
        })->get();

        $userId = $req->apiUser->id;

        foreach($teams as $t) {
            $participation = TeamUser::where('fk_user_id', $userId)->where('fk_team_id', $t->id)->get()->first();

            if (!isset($participation)) {
                abort(401);
            }

        }

        // If not all teams were found
        if (count($req->input('teams')) != count($teams )) {
            abort(422);
        }

        // If current user may view every team, we simply return the list of teams
        return new Collection($teams);
    }
}
