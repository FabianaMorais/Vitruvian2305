<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{

    /**
     * All functions in this controller are acessible to
     * organizations and professionals only
     */
    public function __construct() {
        // IMPORTANT: Controller code is dependent on the professional
        // having an organziation or on the user being an organization itself
        $this->middleware('requires.org');
    }

    /**
     * Displays the view with all accessible team cards
     * 
     * @link 'teams.index'
     */
    public function index() {

        if (Auth::user()->isOrganization()) {
            $org = Organization::where('id', Auth::user()->getRoleData()->id )->get()->first();
            $acessibleTeams = $org->getTeams(false);

        } else if (Auth::user()->isProfessional()) { // showing only teams in which the user participates
            $acessibleTeams = Auth::user()->getRoleData()->getTeams();
        }

        $teams = array(); // Teams' UI cards
        foreach ($acessibleTeams as $team) {
            array_push($teams, $team->getTeamCardUI());
        }

        // sorting teams alphabetically
        usort($teams, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });

        return view('teams.index_teams', compact('teams'));
    }

    /**
     * Displays the create new team page
     * @link 'teams.new'
     */
    public function addTeamForm()
    {
        return view('teams.add_team');
    }

    /**
     * Saves a new team entry in the database and proceeds to the edit page
     * @link 'teams.save'
     */
    public function saveNewTeam(Request $req)
    {
        $req->validate([
            'name' => 'required|string|min:5|max:80',
            'description' => 'required|string|min:5|max:900',
        ], [
            'name.required' => trans('validation.VAL_REQUIRED'),
            'name.min' => trans('validation.VAL_MIN_5'),

            'description.required' => trans('validation.VAL_REQUIRED'),
            'description.min' => trans('validation.VAL_MIN_5'),
        ]);

        // We create the team, add the team user and proceed to view page
        $newTeam = Team::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
        ]);


        // The creator is the owner of the very first participation on this team, so it must always be created first
        if (Auth::user()->isOrganization()) {
            TeamUser::create([ // CONSIDER: REPLACE THIS IN TEAM's BOOT! So we can guarantee it!
                'fk_team_id' => $newTeam->id,
                'fk_user_id' => Auth::user()->id,
                'role' => TeamUser::PARTICIPANT_ORG,
                'access' => TeamUser::WRITE,
            ]);

        } else if (Auth::user()->isProfessional()) {

            $pro = Auth::user()->getRoleData();

            // Middleware guarantees taht the professional's organization is never null, but even so
            if (!isset($pro->fk_organization_id)) {
                abort(401);
            }

            TeamUser::create([ // Professional entry
                'fk_team_id' => $newTeam->id,
                'fk_user_id' => Auth::user()->id,
                'role' => TeamUser::LEADER,
                'access' => TeamUser::WRITE,
            ]);

            // If pro doesn't have an organization, he isn't able to create teams. Even so, we should safeguard this code
            if ($pro->hasOrganization()) {
                TeamUser::create([ // Professinal's organization entry // CONSIDER: REPLACE THIS IN TEAM's BOOT! So we can guarantee it!
                    'fk_team_id' => $newTeam->id,
                    'fk_user_id' => $pro->organization->user->id,
                    'role' => TeamUser::PARTICIPANT_ORG,
                    'access' => TeamUser::WRITE,
                ]);
            }
        }

        return redirect( route('teams.view', $newTeam->id) );
    }

    /**
     * Displays the team roster. Allows edition if the current user has the right permissions
     * @link 'teams.view'
     */
    public function viewTeam(Request $req, $teamKey)
    {
        // Testing team key as UUID
        $uuidPattern = '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/';
        if( !preg_match($uuidPattern, $teamKey) || strlen($teamKey) != 36 ) {
            abort(400);
        }

        // Checking relationship between the current user and the passed team
        $teamUser = TeamUser::where('fk_team_id', $teamKey)
                            ->where('fk_user_id', Auth::user()->id )
                            ->get()
                            ->last(); // the most recent

        if (!isset($teamUser)) { // If the current user is not on that team's roster
            abort(401);
        }

        $t = Team::find($teamKey); // retrieving team

        if (!isset($t)) {
            abort(404);
        }

        $teamData = $t->getTeamUIData(); // retrieving team data

        // Converting team data to UI
        $team = new \stdClass();
        $team->key = $teamData->key;
        $team->name = $teamData->name;
        $team->description = $teamData->description;

        // Professionals
        $team->leaders = array(); // we separate between team leaders and members
        $team->members = array();

        foreach ($teamData->professionals as $pro) {
            $entry = view('teams.components.team_record_elements.team_pro_entry', compact('pro'))->render();

            if ($pro->role == TeamUser::LEADER) {
                array_push($team->leaders, $entry);
            } else {
                array_push($team->members, $entry);
            }
        }

        // Organizations
        $team->organizations = array();
        foreach ($teamData->organizations as $org) {
            $entry = view('teams.components.team_record_elements.team_org_entry', compact('org'))->render();
            array_push($team->organizations, $entry);
        }

        // Patients
        $team->patients = array();
        foreach ($teamData->patients as $pat) {
            $entry = view('teams.components.team_record_elements.team_patient_entry', compact('pat'))->render();
            array_push($team->patients, $entry);
        }

        // checking edit permissions
        if ($teamUser->access == TeamUser::WRITE) {
            $is_editor = true;
            return view('teams.view_team', compact('team', 'is_editor'));
        }

        // for all other cases we present the non editable page
        return view('teams.view_team', compact('team'));
    }

    /**
     * Retrieves a list of the current organization professionals and
     * along with their roles and access levels on the current team
     * NOTE: The current team may have professionals which are not from the current organization
     * 
     * @link 'teams.pros_vs_team'
     * 
     * @return Json with a list of UI elements, one for each professional
     */
    public function getProsVsTeamUIList(Request $req) {

        $req->validate([
            'key' => 'required|uuid'
        ]);

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $req->input('key'))) {
            abort(401);
        }

        // retrievng complete list of the current organization's professionals
        if (Auth::user()->isOrganization()) {
            $orgPros = Auth::user()->getRoleData()->getProUIList();

        } else if (Auth::user()->isProfessional()) {
            $orgPros = Auth::user()->getRoleData()->organization->getProUIList();

        } else {
            abort(401);
        }

        // retrievng complete list of the current teams's professionals
        $teamPros = TeamUser::where('fk_team_id', $req->input('key'))
                    ->where(function($query)
                    { // All participating professionals have one of these roles
                        $query->where('role', TeamUser::MEMBER)
                            ->orWhere('role', TeamUser::LEADER);
                    })
                    ->get();

        $resp = array(); // response

        // Now we use the user keys (uuids) to add some data to each entry
        foreach($teamPros as $tp) { // we cycle through the team professionals

            if (isset($orgPros[ $tp->fk_user_id ])) { // Once we find it, we add some data to it
                // and find each one in the full list of the organziation's professionals
                $orgPros[ $tp->fk_user_id ]->role = $tp->role;
                $orgPros[ $tp->fk_user_id ]->access = $tp->access;
            }

        }

        // Now we generate UI entries for each professional. If they have a role, it's because they are selected for that team
        foreach($orgPros as $pro) {
            $entry = view('teams.components.team_record_elements.team_pro_edit_entry', compact('pro'))->render();
            array_push($resp, $entry);
        }

        return response()->json($resp, 200);
    }

    /**
     * Updates the professional roster from the passed team
     * Organizations and users may only manage professionals from their
     * own organization
     * 
     * The passed list MUST have at least one professional with writing
     * permissions
     * 
     * @link 'teams.update.pros'
     */
    public function updateTeamProfessionals(Request $req) {

        $req->validate([
            'key' => 'required|uuid',
            'pros' => 'array',
            'pros.*.key' => 'required|uuid', // NOTE: USER model uuids
            'pros.*.role' => 'required|string|in:member,leader',
            'pros.*.access' => 'required|string|in:read,write',
        ]);

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $req->input('key'))) {
            abort(401);
        }

        // we'll store the updated pros in an array indexed by uuid
        $updatedMembers = array();

        // Flagging if the list has at least one writing member
        $hasWriter = false;

        // "pros" must be an array with at least one member with writing permissions
        if (is_array($req->input('pros')) && count($req->input('pros')) > 0) {
            foreach($req->input('pros') as $m){

                $updatedMembers[$m['key']] = $m;

                // once we find a member with writing permissions
                if (!$hasWriter && $m['access'] == 'write') {
                    $hasWriter = true;
                }

            }
        } else {
            abort(422);
        }

        // If we reach the end and didn't find at least one member with writing permissions
        if (!$hasWriter) {
            abort(422);
        }

        // Keeping current user's ORGANIZATION model id
        if (Auth::user()->isOrganization()) {
            $currentOrgId = Auth::user()->getRoleData()->id;

        } else if (Auth::user()->isProfessional()) { // Professional from the current organization may access as well
            $currentOrgId = Auth::user()->getRoleData()->fk_organization_id;

        } else {
            abort(401);
        }

        $oldMembers = TeamUser::where('fk_team_id', $req->input('key'))
                                ->where(function($query)
                                { // All participating professionals have one of these roles
                                    $query->where('role', TeamUser::MEMBER)
                                        ->orWhere('role', TeamUser::LEADER);
                                })
                                ->get();


        // Updating or deleting existing members from the team
        foreach ($oldMembers as $oldM) { // for each of the current members of the team
            if (isset($updatedMembers[$oldM->fk_user_id])) { // If we find its key in the updated members array

                // We update his data
                // Updating access to write status
                if ($updatedMembers[$oldM->fk_user_id]['access'] == 'write') {
                    $oldM->access = TeamUser::WRITE;

                } else { // Updating from read to write
                    $oldM->access = TeamUser::READ;
                }

                // updating role
                ($updatedMembers[$oldM->fk_user_id]['role'] == 'leader')? $oldM->role = TeamUser::LEADER : $oldM->role = TeamUser::MEMBER;

                unset($updatedMembers[$oldM->fk_user_id]); // We remove the updated users from the update array
                $oldM->save(); // saving changes in the TeamUser model

            } else {
                // We have to be careful because there might be professionals from other organizations in the current team
                if ($oldM->user->isProfessional() && $oldM->user->getRoleData()->belongsToOrg($currentOrgId)) {
                    $oldM->delete(); // We only remove members from the current organization
                }
            }
        }

        // Now we iterate through the remaining updated members, and add them all
        foreach($updatedMembers as $newM) {

            // setting input values in the model. We must guarantee to always have a value by default
            ($newM['role'] == 'leader')? $role = TeamUser::LEADER : $role = TeamUser::MEMBER;
            ($newM['access'] == 'write') ? $access = TeamUser::WRITE : $access = TeamUser::READ;

            TeamUser::create([
                'fk_team_id' => $req->input('key'), // team key from direct input
                'fk_user_id' => $newM['key'], // New member's USER id
                'role' => $role,
                'access' => $access,
            ]);
        }


        // Finally, we build the updated list of members for the UI and return it
        $team = Team::find($req->input('key'));
        $teamMembers = $team->getUIPros();

        $resp = new \stdClass();
        $resp->leaders = array(); // we separate between team leaders and members
        $resp->members = array();

        foreach ($teamMembers as $pro) {
            $entry = view('teams.components.team_record_elements.team_pro_entry', compact('pro'))->render();

            if ($pro->role == TeamUser::LEADER) {
                array_push($resp->leaders, $entry);
            } else {
                array_push($resp->members, $entry);
            }
            
        }
        return response()->json($resp, 200);
    }

    /**
     * Retrieves a list of the current organization patients
     * NOTE: The current team may have patients which are not from the current organization
     * 
     * @link 'teams.patients_vs_team'
     * 
     * @return Json with a list of UI elements, one for each patient
     */
    public function getPatientsVsTeamUIList(Request $req) {

        $req->validate([
            'key' => 'required|uuid'
        ]);

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $req->input('key'))) {
            abort(401);
        }

        if (Auth::user()->isOrganization()) {
            // retrievng complete list of the current organization's patients
            $patients = Auth::user()->getRoleData()->getPatients();

        } else if (Auth::user()->isProfessional()) { // or single professional patients
            $patients = Auth::user()->getRoleData()->getPatients(false);

        } else {
            abort(401);
        }

        // Setting patients as UI entries
        $orgPats = array();
        foreach ($patients as $p) {
            $u = $p->user;
            $entry = $u->getUIData();
            $orgPats[$entry->key] = $entry; // We index in the array with the user's key so it is easily reachable by uuid
        }
        // sorting professionals alphabetically
        uasort($orgPats, function ($a, $b) { return strcmp( strtolower($a->name), strtolower($b->name) ); });


        // retrievng complete list of the current teams's patients
        $teamPats = TeamUser::where('fk_team_id', $req->input('key'))
                    ->where('role', TeamUSer::SUBJECT)
                    ->get();

        $resp = array(); // response

        // Now we use the user keys (uuids) to add some data to each entry
        foreach($teamPats as $tp) { // we cycle through the team patients
            if (isset($orgPats[ $tp->fk_user_id ])) { // Once we find it, we add some data to it
                $orgPats[ $tp->fk_user_id ]->selected = true;
            }
        }

        // Now we generate UI entries for each patient. If (selected == true), it's because they are selected for that team
        foreach($orgPats as $pat) {
            $entry = view('teams.components.team_record_elements.team_patient_edit_entry', compact('pat'))->render();
            array_push($resp, $entry);
        }

        return response()->json($resp, 200);
    }

    /**
     * Updates the patient roster from the passed team
     * Organizations and users may only manage patients from their
     * own organization
     *
     * Note: Owner may only remove from team patients which it owns
     *
     * @link 'teams.update.patients'
     */
    public function updateTeamPatients(Request $req) {

        $req->validate([
            'key' => 'required|uuid',
            'patients' => 'array',
            'patients.*.key' => 'required|uuid', // NOTE: USER model uuids
        ]);

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $req->input('key'))) {
            abort(401);
        }

        // we'll store the updated patients in an array indexed by uuid
        $updatedMembers = array();

        if (is_array($req->input('patients'))) {
            foreach($req->input('patients') as $m){
                $updatedMembers[$m['key']] = $m;
            }
        }

        $oldMembers = TeamUser::where('fk_team_id', $req->input('key'))
                                ->where('role', TeamUser::SUBJECT)
                                ->get();


        // Updating or deleting existing members from the team
        foreach ($oldMembers as $oldM) { // for each of the current members of the team

            if (isset($updatedMembers[$oldM->fk_user_id])) { // If we find its key in the updated members array
                unset($updatedMembers[$oldM->fk_user_id]); // We remove the maintained users from the "to update" array

            } else {
                // we also remove the patients which were deselected
                // We have to be careful because there might be patients from other organizations in the current team
                // so we test for ownership
                if ($oldM->user->isPatient() && $oldM->user->getRoleData()->isOwnedBy( Auth::user()->id )) {
                    $oldM->delete(); // We only remove members from the current organization
                }
            }
        }

        // Now we iterate through the remaining updated members, and add them all
        foreach($updatedMembers as $newM) {
            TeamUser::create([
                'fk_team_id' => $req->input('key'), // team key from direct input
                'fk_user_id' => $newM['key'], // New member's USER model key
                'role' => TeamUser::SUBJECT,
            ]);
        }

        // Finally, we build the updated list of members for the UI and return it
        $team = Team::find($req->input('key'));
        $teamMembers = $team->getUIPatients();

        $resp = new \stdClass();
        $resp->patients = array(); // we separate between team leaders and members

        foreach ($teamMembers as $pat) {
            $entry = view('teams.components.team_record_elements.team_patient_entry', compact('pat'))->render();
            array_push($resp->patients, $entry);
        }

        return response()->json($resp, 200);
    }

    /**
     * Updates the passed team's settings
     * 
     * @link teams.update.settings
     */
    public function updateSettings(Request $req) {
        $req->validate([
            'key' => 'uuid',
            'name' => 'required|string|min:5|max:80',
            'description' => 'required|string|min:5|max:900',
        ]);

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $req->input('key'))) {
            abort(401);
        }

        $team = Team::find($req->input('key'));
        if (!isset($team)) {
            abort(404);
        }

        $team->name = $req->input('name');
        $team->description = $req->input('description');
        $team->save();

        return response(200);
    }

    /**
     * Deletes the passed team, along with all its associations
     * 
     * @link teams.update.delete
     */
    public function deleteTeam(Request $req, $teamKey) {
        
        $uuidPattern = '/[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}/';
        if( !preg_match($uuidPattern, $teamKey) || strlen($teamKey) != 36 ) {
            abort(400);
        }

        // If the current user is not on that team's roster and/or does not have the appropriate permissions
        if (!Team::hasWritingPermissions(Auth::user()->id, $teamKey)) {
            abort(401);
        }

        $team = Team::find($teamKey);
        if (!isset($team)) {
            abort(404);
        }

        // NOTE: onDelete('cascade) doesn't work?
        $tus = TeamUser::where('fk_team_id', $teamKey)->get();
        foreach($tus as $tu) {
            $tu->delete();
        }

        $team->delete(); // delete cascade deletes all related TeamUser entries

        return view('teams.delete_team_complete');
    }
}
