<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicApiTables extends Migration
{

    public function up()
    {
        Schema::create('public_api_keys', function (Blueprint $table) {
            $table->id();
            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users');
            $table->string('key', 42); // Doesn't need to be unique since username will always be passed as well
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('public_api_keys');
    }
}
