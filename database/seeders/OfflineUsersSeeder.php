<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\Administrator;
use App\Models\Professional;
use App\Models\Organization;
use App\Models\Users\NewUser;
use App\Models\NewRegistries\NewProData;
use App\Models\NewRegistries\NewOrgData;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Patient;
use App\Models\PatientOwner;
use Illuminate\Support\Facades\Hash;

use App\Database\Seeds\SeedData;


class OfflineUsersSeeder extends Seeder
{

    public function run()
    {
        // test users
        $this->createTestAdmin("admin");
        $this->createTestAdmin("admin2");
        $this->createTestAdmin("admin3");

        $resOrg = $this->createTestOrg("testOrg1");
        $this->createTestOrg("testOrg2");
        $this->createTestOrg("testOrg3");

        for ($i = 0; $i < 20; $i ++) { // Bulk creation for organziation 1

            ($i > 11)? $genre = SeedData::MALE : $genre = SeedData::FEMALE;

            $this->createTestPro("testRes" . $i, User::RESEARCHER, $genre, $resOrg);
        }

        $testDoc1 = $this->createTestPro("testDoc1", User::DOCTOR, SeedData::MALE);
        $this->createTestPro("testDoc2", User::DOCTOR, SeedData::FEMALE);

        $this->createTestPro("testCare1", User::CAREGIVER, SeedData::FEMALE);
        $this->createTestPro("testCare2", User::CAREGIVER, SeedData::FEMALE);




        // Pending registry requests
        $this->createTestNewPro("testNewRes1", NewUser::NEW_RESEARCHER, $resOrg);
        $this->createTestNewPro("testNewRes2", NewUser::NEW_RESEARCHER, $resOrg);

        $this->createTestNewPro("testNewDoc1", NewUser::NEW_DOCTOR, $resOrg);

        $this->createTestNewPro("testNewCare1", NewUser::NEW_CAREGIVER, $resOrg);

        $this->createTestNewOrg("testNewOrg1");
        $this->createTestNewOrg("testNewOrg2");


        // Patients
        $testRes1 = User::where('name', 'testRes1')->get()->first(); // retrieving pros with patients
        $testRes2 = User::where('name', 'testRes2')->get()->first();

        for ($i = 0; $i < 12; $i ++) { // Bulk creation of patients

            ($i < 8)? $pro = $testRes1 : $pro = $testRes2; // 7 patients for the first pro

            $this->createPatient("testPat" . $i, $pro);
        }

        // TEAMS

    }

    /**
     * Creates a new test Adminitrator
     * @return User the newly created user model
     */
    private function createTestAdmin($username) : User {

        $userData = User::create([
            'name' => $username,
            'email' => $username . '@email.email',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => User::ADMIN,
        ]);

        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        Administrator::create([
            'fk_user_id' => $userData->id,
            'full_name' => ucwords( $username . "'s Full Name"),
        ]);

        return $userData;
    }

    /**
     * Creates a new test Professional
     * @return User the newly created user model
     */
    private function createTestPro($username, $type, $genre = SeedData::MALE, User $orgUser = NULL) : User {

        $userData = User::create([
            'name' => $username,
            'email' => $username . '@doctoreemail.dc',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => $type,
        ]);

        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        $docData = Professional::create([
            'fk_user_id' => $userData->id,
            'full_name' => SeedData::generateFullName($genre),
            'address' => "Address for test professional " . $username,
            'phone' => "911111111 + " . $username,
        ]);

        if (isset($orgUser) && $orgUser->isOrganization()) {
            $docData->fk_organization_id = $orgUser->getRoleData()->id;
            $docData->save();
        }

        return $userData;
    }

    /**
     * Creates a new test Organization
     * @return User the newly created user model
     */
    private function createTestOrg($username) : User {

        $userData = User::create([
            'name' => $username,
            'email' => $username . '@organizationemail.og',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => User::ORGANIZATION,
        ]);

        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        $orgData = Organization::create([
            'fk_user_id' => $userData->id,
            'full_name' => ucwords( "Vitruvian Test Organization " . $username ),
            'official_email' => $username . "@email.email",
            'leader_name' => "Leader name for test org " . $username,
            'fiscal_number' => "000000000",
            'address' => "Address for test org " . $username,
            'phone' => "911111111 + " . $username,
        ]);

        return $userData;
    }


    /**
     * Creates a new patient registry
     * 
     * @param owner The owner User of this patient
     * @return User the newly created user model
     */
    private function createPatient($username, User $owner) : User {

        $userData = User::create([
            'name' => $username,
            'email' => $username . '@email.email',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => User::PATIENT,
        ]);

        // NOTE: WILL PATIENTS HAVE AN AVATAR?
        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        $patient = Patient::create([
            'fk_user_id' => $userData->id,
            'full_name' => SeedData::generateFullName(),
            'phone' => 'phone patient ' . $username,
            'first_login' => Carbon::now(),
        ]);

        PatientOwner::create([
            'fk_patient_id' => $patient->id,
            'fk_owner_id' => $owner->id,
        ]);

        // Patients also belong to the professional's organizations, if they ahve one
        if ($owner->isProfessional() && $owner->getRoleData()->hasOrganization()) {
            PatientOwner::create([
                'fk_patient_id' => $patient->id,
                'fk_owner_id' => $owner->getRoleData()->organization->user->id,
            ]);
        }

        return $userData;
    }


    /**
     * Creates a new pending test professional registry
     * @return NewUser the newly created user model
     */
    private function createTestNewPro($username, $type, User $orgUser = NULL) : NewUser {

        $userData = NewUser::create([
            'name' => $username,
            'email' => $username . '@newdoctoreemail.dc',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => $type,
        ]);

        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        $docData = NewProData::create([
            'fk_new_user_id' => $userData->id,
            'full_name' => ucwords( "Test NEW Professional " . $username ),
            'address' => "Address for test NEW professional " . $username,
            'phone' => "911111111 + " . $username,
        ]);

        if (isset($orgUser) && $orgUser->isOrganization()) {
            $docData->fk_organization_id = $orgUser->getRoleData()->id;
            $docData->save();
        }

        return $userData;
    }

    /**
     * Creates a new pending test organization registry
     * @return NewUser the newly created user model
     */
    private function createTestNewOrg($username) : NewUser {

        $userData = NewUser::create([
            'name' => $username,
            'email' => $username . '@neworganizationemail.og',
            'password' => Hash::make('123123'),
            'email_verified_at' => Carbon::now(),
            'type' => NewUser::NEW_ORGANIZATION,
        ]);

        // using existing avatar in case there is one in the folder
        if (file_exists( public_path('/user_uploads/avatars/' . $username . "_avt.jpg") )) {
            $userData->avatar = $username . "_avt.jpg";
            $userData->save();
        }

        NewOrgData::create([
            'fk_new_user_id' => $userData->id,
            'full_name' => ucwords( "Vitruvian Test NEW Organization " . $username ),
            'leader_name' => "Leader name for test NEW org " . $username,
            'fiscal_number' => "000000000",
            'address' => "Address for test NEW org " . $username,
            'phone' => "911111111 + " . $username,
        ]);

        return $userData;
    }

}
