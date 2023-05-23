<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SensorData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        //adpd
        Schema::connection('mysql_v_watch')->create('adpd_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->double('signalData');
            $table->double('darkData');
            $table->integer('sequenceNum');
            $table->integer('channel');
            $table->integer('sampleNum');
            $table->bigInteger('timestamp_utc')->unsigned(); //ts received from watch for the reading
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //accelerometer
        Schema::connection('mysql_v_watch')->create('adxl_stream', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('x');
            $table->integer('y');
            $table->integer('z');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //ecg
        Schema::connection('mysql_v_watch')->create('ecg_stream', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('data');
            $table->integer('ecg_info');
            $table->integer('hr');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //eda
        Schema::connection('mysql_v_watch')->create('eda_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->double('realData');
            $table->double('imaginaryData');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //pedometer
        Schema::connection('mysql_v_watch')->create('pedometer_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->integer('num_steps');
            $table->integer('algo_status');
            $table->integer('reserved');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //ppg
        Schema::connection('mysql_v_watch')->create('ppg_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->integer('adpllibstate');//TODO: check what this is!
            $table->integer('confidence');
            $table->integer('hr');
            $table->integer('type');
            $table->integer('interval');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });
        

        //syncppg
        Schema::connection('mysql_v_watch')->create('syncppg_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->bigInteger('adxlTs')->unsigned();
            $table->integer('x');
            $table->integer('y');
            $table->integer('z');
            $table->bigInteger('ppgTs')->unsigned();
            $table->double('ppgData');
            $table->integer('user_db_patient_id');//patient id from user database
        });

        

        //temperature
        Schema::connection('mysql_v_watch')->create('temperature_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->integer('skin_temperature');
            $table->integer('ambient_temperature');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        //bcm
        Schema::connection('mysql_v_watch')->create('bcm_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->double('realData');
            $table->double('imaginaryData');
            $table->integer('frequencyIndex');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });

        // sqi
        Schema::connection('mysql_v_watch')->create('sqi_stream', function (Blueprint $table) {
            $table->increments('id'); // primary is unique by default
            $table->integer('sqiSlot');
            $table->integer('sequenceNumber');
            $table->integer('reserved');
            $table->integer('algoStatus');
            $table->float('sqi');
            $table->bigInteger('timestamp_utc')->unsigned();
            $table->integer('user_db_patient_id');//patient id from user database
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::connection('mysql_v_watch')->dropIfExists('adxl_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('ecg_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('pgg_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('adpd_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('syncppg_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('eda_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('temperature_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('pedometer_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('bcm_stream');
        Schema::connection('mysql_v_watch')->dropIfExists('sqi_stream');
        */
    }
}

