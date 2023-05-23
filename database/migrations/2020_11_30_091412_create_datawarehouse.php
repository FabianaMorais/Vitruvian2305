<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatawarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //date and time dim
        Schema::connection('mysql_v_dw')->create('date_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('day')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            //TODO: add generic stuff such as quarter, week of month and such
        });

        Schema::connection('mysql_v_dw')->create('time_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hour')->nullable();
            $table->integer('minute')->nullable();
            $table->integer('second')->nullable();
            $table->integer('millisseconds')->nullable();
        });
        
        //sensor data dims
        Schema::connection('mysql_v_dw')->create('adpd_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('adpd_data')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('adxl_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('x_axis')->nullable();
            $table->integer('y_axis')->nullable();
            $table->integer('z_axis')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('ecg_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mode')->nullable();
            $table->integer('data')->nullable();
            $table->integer('hr')->nullable();
            $table->boolean('leads_off_status')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('eda_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->double('admittance_real')->nullable();
            $table->double('admittance_img')->nullable();
            $table->double('impedance_real')->nullable();
            $table->double('impedance_img')->nullable();
            $table->double('admittance_magnitude')->nullable();
            $table->double('admittance_phase')->nullable();
            $table->double('impedance_magnitude')->nullable();
            $table->double('impedance_phase')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('pedometer_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_steps')->nullable();
            $table->integer('algo_status')->nullable();
            $table->integer('reserved')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('ppg_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('adpllibstate')->nullable();
            $table->float('confidence')->nullable();
            $table->float('hr')->nullable();
            $table->integer('type')->nullable();
            $table->integer('interval')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('syncppg_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('ppg_data')->nullable();
            $table->integer('x_axis')->nullable();
            $table->integer('y_axis')->nullable();
            $table->integer('z_axis')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('temperature_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skin_temperature')->nullable();
            $table->integer('ambient_temperature')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('hrv_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rr_interval')->nullable();
            $table->integer('is_gap')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('med_taking_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('med_id')->nullable();
            $table->integer('dosage')->nullable();
        });

        Schema::connection('mysql_v_dw')->create('med_sub_dim', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->nullable();
            $table->float('pill_dosage')->nullable();
            $table->integer('type')->nullable();
        });

        //create user table only to ensure user_id is unique
        Schema::connection('mysql_v_dw')->create('user_dim', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('db_user_id')->nullable(); 
        });


        
        Schema::connection('mysql_v_dw')->create('crisis_event_facts', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('date_id')->nullable();
            $table->integer('time_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('adpd_id')->nullable();
            $table->integer('adxl_id')->nullable();
            $table->integer('ecg_id')->nullable();
            $table->integer('eda_id')->nullable();
            $table->integer('pedometer_id')->nullable();
            $table->integer('ppg_id')->nullable();
            $table->integer('syncppg_id')->nullable();
            $table->integer('temperature_id')->nullable();
            $table->integer('hrv_id')->nullable();
            $table->integer('med_taking_id')->nullable();
            //fact we want to store (if it is a record for a user crisis or not)
            //string for data analysis, able to do classification this way
            $table->string('crisis_event',80)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_dim');
    }
}
