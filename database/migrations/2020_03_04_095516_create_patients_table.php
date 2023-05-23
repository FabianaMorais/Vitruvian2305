<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_user_id')->nullable();
            $table->foreign('fk_user_id')->references('id')->on('users');
            $table->string('inscription_code')->unique();

            $table->timestamp('first_login')->nullable();

            $table->string('phone', 30)->nullable()->unique();
            $table->string('full_name', 80)->nullable();
            $table->smallInteger('gender')->unsigned()->default(0); // 0 = unspecified
            $table->date('date_of_birth')->nullable();
            $table->char('country', 2)->nullable();
            $table->float('weight_kg', 5, 2)->nullable();
            $table->smallInteger('blood_type')->unsigned()->default(0); // 0 = unspecified

            $table->string('diagnosed')->nullable(); // Diagnosed conditions
            $table->string('other')->nullable(); // Other conditions

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
