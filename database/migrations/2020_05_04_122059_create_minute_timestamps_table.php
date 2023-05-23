<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinuteTimestampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_v_watch')->create('minute_timestamps', function (Blueprint $table) {
            $table->id();
            $table->integer('hour');
            $table->integer('minute');
        });

        //medication

        Schema::connection('mysql_v_watch')->create('medications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->float('pill_dosage'); //pill dosage in mg (for distinguishing between benuron 500 and 1000 i.e.)
            $table->integer('type');
            
            $table->timestamps();
        });
        Schema::connection('mysql_v_watch')->create('patient_medications', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('fk_patient_id')->unsigned(); 
            $table->integer('fk_medication_id')->unsigned(); 
            $table->integer('periodicity'); // should take this once every "this var's number of days", 
            //so if periodicity = 1, every 1 days and if periodicity = 2, once every 2 days
            $table->json('scheduled_intakes'); // array of ints with the ts of the takings
            $table->json('nr_of_pills_each_intake'); // array of number of pills to take each taking (FLOAT)
            // [10:00, 16:00, 22:00] scheduled intakes would have 
            //i.e. [1,3,2.5] meaning 1 pill at 10:00, 3 pills at 16:00 and 2.5 pills at 22:00 
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable(); // if null it means the treatment should go on indefinitely
            $table->string('notes',30)->nullable();
            $table->boolean('prescribed_by_professional')->default(true);
            $table->timestamps();
        });

        Schema::connection('mysql_v_watch')->create('med_takings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fk_patient_medication_id',18);
            $table->dateTime('intake_date');// date of taking + time in position of the scheduled_intakes in patient med table
            $table->timestamps();
        });
        // user crisis

        Schema::connection('mysql_v_watch')->create('crisis_events', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',400);
            $table->timestamps();
        });
        Schema::connection('mysql_v_watch')->create('patient_crisis_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_patient_id')->unsigned();
            $table->integer('fk_crisis_event_id')->unsigned();
            $table->integer('fk_minute_timestamps_id')->nullable();
            $table->date('crisis_date');
            $table->integer('duration_in_seconds')->nullable();
            $table->string('notes',300)->nullable();
            $table->boolean('submitted_by_doctor')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_v_watch')->dropIfExists('minute_timestamps');
        Schema::connection('mysql_v_watch')->dropIfExists('patient_medications');
        Schema::connection('mysql_v_watch')->dropIfExists('med_takings');
        Schema::connection('mysql_v_watch')->dropIfExists('crisis_events');
        Schema::connection('mysql_v_watch')->dropIfExists('patient_crisis_events');
    }
}
