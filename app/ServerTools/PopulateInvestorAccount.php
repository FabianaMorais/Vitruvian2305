<?php

namespace App\ServerTools;

use App\Models\Users\User;
use App\Models\Professional;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\PatientOwner;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Medication;
use App\Models\PatientMedication;
use App\Models\CrisisEvent;
use App\Models\PatientCrisisEvent;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Log;

/**
 * Populates an organization with professionals
 * number of professionals argument refers to the number of professionals PER TYPE
 * 
 */
class PopulateInvestorAccount
{
    public static function populateOrganization($orgUser,$number_of_professionals) {
        $professionals = [];
        for ( $i=0; $i<$number_of_professionals; $i++ ){
            $docData = PopulateInvestorAccount::addProfessional($orgUser,USER::RESEARCHER);
            array_push($professionals,$docData);
        }
        for ( $i=0; $i<$number_of_professionals; $i++ ){
            $docData = PopulateInvestorAccount::addProfessional($orgUser,USER::DOCTOR);
            array_push($professionals,$docData);
        }
        for ( $i=0; $i<$number_of_professionals; $i++ ){
            $docData = PopulateInvestorAccount::addProfessional($orgUser,USER::CAREGIVER);
            array_push($professionals,$docData);
        }
        return $professionals;
    }


    public static function populateProfessional($professional_user,$number_of_patients) {
        $patients = [];
        for ( $i=0; $i<$number_of_patients; $i++ ){
            $patientData = PopulateInvestorAccount::addPatient($professional_user);
            array_push($patients,$patientData);
        }
        return $patients;
    }


    public static function createTeams($professional_list,$org_user){
        //create 2 teams
        $newMedTrialTeam = Team::create([
            'name' => "Heart Medication Trial",
            'description' => "Clinical trial for a medication for Cardiovascular diseases",
        ]);

        $newClinicTeam = Team::create([
            'name' => "Healthcare Clinic",
            'description' => "Clinic with multiple specialties in which professionals can monitor all patients that acquire their services",
        ]);
        //add owner organization for each team
        TeamUser::create([
            'fk_team_id' => $newMedTrialTeam->id,
            'fk_user_id' => $org_user->id,
            'role' => TeamUser::PARTICIPANT_ORG,
            'access' => TeamUser::WRITE,
        ]);

        TeamUser::create([
            'fk_team_id' => $newClinicTeam->id,
            'fk_user_id' => $org_user->id,
            'role' => TeamUser::PARTICIPANT_ORG,
            'access' => TeamUser::WRITE,
        ]);

        foreach($professional_list as $professional){
            //add researchers to med trial team
            if($professional->type == User::RESEARCHER){
                TeamUser::create([
                    'fk_team_id' => $newMedTrialTeam->id,
                    'fk_user_id' => $professional->id,
                    'role' => TeamUser::WRITE,
                    'access' => TeamUser::READ,
                ]);
                //add this professional's patients to the team
                $patient_list = $professional->getRoleData()->getPatients();
                foreach($patient_list as $patient){
                    TeamUser::create([ // Professional entry
                        'fk_team_id' => $newMedTrialTeam->id,
                        'fk_user_id' => $patient->user->id,
                        'role' => TeamUser::SUBJECT,
                        'access' => TeamUser::READ,
                    ]);
                }
            }else if($professional->type == USER::DOCTOR){
                //add doctors to clinic team
                TeamUser::create([
                    'fk_team_id' => $newClinicTeam->id,
                    'fk_user_id' => $professional->id,
                    'role' => TeamUser::MEMBER,
                    'access' => TeamUser::READ,
                ]);
                //add this professional's patients to the team
                $patient_list = $professional->getRoleData()->getPatients();
                foreach($patient_list as $patient){
                    TeamUser::create([ // Professional entry
                        'fk_team_id' => $newClinicTeam->id,
                        'fk_user_id' => $patient->user->id,
                        'role' => TeamUser::SUBJECT,
                        'access' => TeamUser::READ,
                    ]);
                }
            }
        }
        
    }


    public static function populatePatientList($patient_list){
        // use first 2 medications in database
        //create them if medications table does not have id 1 and 2
        $med_1 = Medication::find(1);
        if($med_1 == null){
            $med_1 = Medication::create([
                'name' => 'furozemide',
                'pill_dosage' => 40,
                'type' => 1,
            ]);
        }
        $med_2 = Medication::find(2);
        if($med_2 == null){
            $med_2 = Medication::create([
                'name' => 'omeprazole',
                'pill_dosage' => 100,
                'type' => 1,
            ]);
        }

        $crisis_event_1 = CrisisEvent::find(1);
        if($crisis_event_1 == null){
            $crisis_event_1 = create([
                'name' => 'Absence seizure'
            ]);
        }
        $crisis_event_2 = CrisisEvent::find(2);
        if($crisis_event_2 == null){
            $crisis_event_2 = create([
                'name' => 'Loss Of Balance'
            ]);
        }
        
        foreach($patient_list as $patient){
            PopulateInvestorAccount::addMedicationToPatient($med_1->id,$patient->getRoleData()->id);
            PopulateInvestorAccount::addMedicationToPatient($med_2->id,$patient->getRoleData()->id);
            PopulateInvestorAccount::addCrisisEventToPatient($crisis_event_1->id,$patient->getRoleData()->id,100);
            PopulateInvestorAccount::addCrisisEventToPatient($crisis_event_2->id,$patient->getRoleData()->id,500);
        }
        
    }


    //function from SeedData.php (could not use it in this context because of a different namespace)
    //if a solution is found for the namespace issue this can be removed
    public const MALE = 0;
    public const FEMALE = 1;

    private static $maleNames = [ "Adam", "Alex", "Aaron", "Ben", "Carl", "Dan", "David", "Edward", "Fred", "Frank", "George", "Hal", "Hank", "Ike", "John", "Jack", "Joe", "Larry", "Monte", "Matthew", "Mark", "Nathan", "Otto", "Paul", "Peter", "Roger", "Roger", "Steve", "Thomas", "Tim", "Ty", "Victor", "Walter" ];
    private static $femaleNames = ["Emily","Hannah","Madison","Ashley","Sarah","Alexis","Samantha","Jessica","Elizabeth","Taylor","Lauren","Alyssa","Kayla","Abigail","Brianna","Olivia","Emma","Megan","Grace","Victoria","Rachel","Anna","Sydney","Destiny","Morgan","Jennifer","Jasmine","Haley","Julia","Kaitlyn","Nicole","Amanda","Katherine","Natalie","Hailey","Alexandra","Savannah","Chloe","Rebecca","Stephanie","Maria","Sophia","Mackenzie","Allison","Isabella","Amber","Mary","Danielle","Gabrielle","Jordan","Brooke","Michelle","Sierra","Katelyn","Andrea","Madeline","Sara","Kimberly","Courtney","Erin","Brittany","Vanessa","Jenna","Jacqueline","Caroline","Faith","Makayla","Bailey","Paige","Shelby","Melissa","Kaylee","Christina","Trinity","Mariah","Caitlin","Autumn","Marissa","Breanna","Angela","Catherine","Zoe","Briana","Jada","Laura","Claire","Alexa","Kelsey","Kathryn","Leslie","Alexandria","Sabrina","Mia","Isabel","Molly","Leah","Katie","Gabriella","Cheyenne","Cassandra","Tiffany","Erica","Lindsey","Kylie","Amy","Diana","Cassidy","Mikayla","Ariana","Margaret","Kelly","Miranda","Maya","Melanie","Audrey","Jade","Gabriela","Caitlyn","Angel","Jillian","Alicia","Jocelyn","Erika","Lily","Heather","Madelyn","Adriana","Arianna","Lillian","Kiara","Riley","Crystal","Mckenzie","Meghan","Skylar","Ana","Britney","Angelica","Kennedy","Chelsea","Daisy","Kristen","Veronica","Isabelle","Summer","Hope","Brittney","Lydia","Hayley","Evelyn","Bethany","Shannon","Michaela","Karen","Jamie","Daniela","Angelina","Kaitlin","Karina","Sophie","Sofia","Diamond","Payton","Cynthia","Alexia","Valerie","Monica"];
    private static $lastNames = ["Anderson", "Ashwoon", "Aikin", "Bateman", "Bongard", "Bowers", "Boyd", "Cannon", "Cast", "Deitz", "Dewalt", "Ebner", "Frick", "Hancock", "Haworth", "Hesch", "Hoffman", "Kassing", "Knutson", "Lawless", "Lawicki", "Mccord", "McCormack", "Miller", "Myers", "Nugent", "Ortiz", "Orwig", "Ory", "Paiser", "Pak", "Pettigrew", "Quinn", "Quizoz", "Ramachandran", "Resnick", "Sagar", "Schickowski", "Schiebel", "Sellon", "Severson", "Shaffer", "Solberg", "Soloman", "Sonderling", "Soukup", "Soulis", "Stahl", "Sweeney", "Tandy", "Trebil", "Trusela", "Trussel", "Turco", "Uddin", "Uflan", "Ulrich", "Upson", "Vader", "Vail", "Valente", "Van Zandt", "Vanderpoel", "Ventotla", "Vogal", "Wagle", "Wagner", "Wakefield", "Weinstein", "Weiss", "Woo", "Yang", "Yates", "Yocum", "Zeaser", "Zeller", "Ziegler", "Bauer", "Baxter", "Casal", "Cataldi", "Caswell", "Celedon", "Chambers", "Chapman", "Christensen", "Darnell", "Davidson", "Davis", "DeLorenzo", "Dinkins", "Doran", "Dugelman", "Dugan", "Duffman", "Eastman", "Ferro", "Ferry", "Fletcher", "Fietzer", "Hylan", "Hydinger", "Illingsworth", "Ingram", "Irwin", "Jagtap", "Jenson", "Johnson", "Johnsen", "Jones", "Jurgenson", "Kalleg", "Kaskel", "Keller", "Leisinger", "LePage", "Lewis", "Linde", "Lulloff", "Maki", "Martin", "McGinnis", "Mills", "Moody", "Moore", "Napier", "Nelson", "Norquist", "Nuttle", "Olson", "Ostrander", "Reamer", "Reardon", "Reyes", "Rice", "Ripka", "Roberts", "Rogers", "Root", "Sandstrom", "Sawyer", "Schlicht", "Schmitt", "Schwager", "Schutz", "Schuster", "Tapia", "Thompson", "Tiernan", "Tisler"];
    private static $orgNames = [];

    public static function generateFullName($genre = NULL) {

        if (!isset($genre) || ($genre < 0 || $genre > 1)) { // if no genre is defined, we assign a random one
            $genre = rand(0, 1);
        }

        if ($genre == PopulateInvestorAccount::FEMALE) {
            return PopulateInvestorAccount::$maleNames[ rand(0, count(PopulateInvestorAccount::$maleNames) - 1) ] . " " . PopulateInvestorAccount::$lastNames[ rand(0, count(PopulateInvestorAccount::$lastNames) - 1) ];

        } else {
            return PopulateInvestorAccount::$femaleNames[ rand(0, count(PopulateInvestorAccount::$femaleNames) - 1) ] . " " . PopulateInvestorAccount::$lastNames[ rand(0, count(PopulateInvestorAccount::$lastNames) - 1) ];
        }
    }


    public static function addProfessional($orgUser,$type){
        $full_name = PopulateInvestorAccount::generateFullName();
        $username = str_replace(' ','',$full_name);
        $userData = User::create([
            'name' => $username,
            'email' => $username . '@doctoreemail.dc',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => $type,
            'avatar' => 'prof_template' . rand(1,11) . '_avt.jpg'
        ]);

        $docData = Professional::create([
            'fk_user_id' => $userData->id,
            'full_name' => $full_name,
            'address' => "Address for test professional " . $username,
            'phone' => "9 " . $username,
        ]);

        if (isset($orgUser) && $orgUser->isOrganization()) {
            $docData->fk_organization_id = $orgUser->getRoleData()->id;
            $docData->save();
        }
        return $userData;
    }

    public static function addPatient($professional_user){
        // Creating user entry
        $full_name = PopulateInvestorAccount::generateFullName();
        $username = str_replace(' ','',$full_name);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz!#%&';
        $username = $username . $characters[rand(0, 38)] . $characters[rand(0, 38)];
        $newPatUser = User::create([
            'name' => $username,
            'email' => $username . '@gmail.com',
            'password' => Hash::make( '123123123' ),
            'type' => User::PATIENT,
        ]);

        // Creating patient entry
        $patient = Patient::create([
            'fk_user_id' => $newPatUser->id,
            'full_name' => $full_name,
            'phone' => "9 " . $username,
        ]);

        // Creating professional / user relationship
        PatientOwner::create([
            'fk_patient_id' => $patient->id,
            'fk_owner_id' => $professional_user->id,
        ]);
        Log::debug($professional_user->id);
        $orgId = Professional::where('fk_user_id', $professional_user->id)->get()->first()->fk_organization_id;

        if ($orgId != null) { // Professional may not have an organization
            $org = Organization::where('id', $orgId)->get()->first();

            if (isset($org)) {
                PatientOwner::create([ // Then this new patient belongs to the organization as well
                    'fk_patient_id' => $patient->id,
                    'fk_owner_id' => $org->user->id,
                ]);
            }
        }
        return $newPatUser;
    }

    public static function addMedicationToPatient($medication_id, $patient_id){
        $patient_medication = PatientMedication::create([
            'fk_patient_id' => $patient_id,
            'fk_medication_id' => $medication_id,
            'periodicity' => 1,
            'start_date' => Carbon::now(),
            'end_date' => null,
            'prescribed_by_professional' => true,
            'scheduled_intakes' => [ 481 , 1201],
            'nr_of_pills_each_intake' => [ 1 , 1 ],
        ]);
    }

    public static function addCrisisEventToPatient($crisis_event_id, $patient_id, $timestamp_id){
        $patient_crisis_event = PatientCrisisEvent::create([
            'fk_patient_id' => $patient_id,
            'fk_crisis_event_id' => $crisis_event_id,
            'fk_minute_timestamps_id' => $timestamp_id,
            'crisis_date' => Carbon::today(),
            'duration_in_seconds' => 45,
            'submitted_by_doctor' => true,
        ]);
    }


    public static function addPatientsToTeam($professional_user, $patient_list){
        $newClinicTeam = Team::create([
            'name' => "Healthcare Clinic",
            'description' => "Clinic with multiple specialties in which professionals can monitor all patients that acquire their services",
        ]);

        TeamUser::create([
            'fk_team_id' => $newClinicTeam->id,
            'fk_user_id' => $professional_user->id,
            'role' => TeamUser::LEADER,
            'access' => TeamUser::READ,
        ]);

        foreach($patient_list as $patient){
            TeamUser::create([ // Professional entry
                'fk_team_id' => $newClinicTeam->id,
                'fk_user_id' => $patient->id,
                'role' => TeamUser::SUBJECT,
                'access' => TeamUser::READ,
            ]);
        }
    }

}