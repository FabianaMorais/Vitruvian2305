<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TeamUser;

class CreateTeamsTables extends Migration
{

    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 80);
            $table->string('description');
            $table->string('code')->nullable()->unique(); // unique identifier to identify teams through the API
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('teams_users', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('fk_team_id');
            $table->foreign('fk_team_id')->references('id')->on('teams')->onDelete('cascade'); // These relationships are deleted if a team is deleted

            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade'); // These relationships are deleted if a user is deleted

            $table->integer('role')->unsigned(); // Team leader, etc...
            $table->integer('access')->unsigned()->default(TeamUser::READ); // Read, write, creator, etc...

            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Table for associations between patients and
         * professionals and/or institutions
         */
        Schema::create('patients_owners', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fk_patient_id')->unsigned(); // PATIENT Model
            $table->foreign('fk_patient_id')->references('id')->on('patients');

            $table->uuid('fk_owner_id'); // USER model
            $table->foreign('fk_owner_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes(); // We'll keep a history record of which professionals owned which patients
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients_owners');
        Schema::dropIfExists('teams_users');
        Schema::dropIfExists('teams');
    }
}
