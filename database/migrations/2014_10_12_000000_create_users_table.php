<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    public function up() {

        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 80)->unique();
            $table->string('email', 80)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->integer('type')->unsigned()->default(100); // by default all users are professionals
            $table->string('avatar')->default('avt_default.jpg'); // default avatar image
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_name', 80);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('full_name', 80);
            $table->string('address', 160);
            $table->string('phone', 30);
            $table->integer('fk_organization_id')->unsigned()->nullable(); // Foreign key of Organization model
            $table->string('custom_organization', 160)->nullable();
            $table->string('code',6);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_user_id');
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('code', 5)->unique(); // Ths organization's unique code
            $table->string('full_name', 80);
            $table->string('official_email', 80);
            $table->string('leader_name', 80);
            $table->string('fiscal_number', 80);
            $table->string('address', 160);
            $table->string('phone', 30);
            $table->timestamps();
            $table->softDeletes();
        });


        // New users
        Schema::connection('mysql_new_users')->create('new_users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // primary is unique by default
            $table->string('name', 80)->unique();
            $table->string('email', 80)->unique();
            $table->string('password');
            $table->integer('type')->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->default('avt_default.jpg'); // default avatar image
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::connection('mysql_new_users')->create('data_new_pros', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_new_user_id');
            $table->foreign('fk_new_user_id')->references('id')->on('new_users')->onDelete('cascade');
            $table->string('full_name', 80);
            $table->string('address', 160);
            $table->string('phone', 30);
            $table->integer('fk_organization_id')->unsigned()->nullable();
            $table->string('custom_organization', 160)->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_new_users')->create('data_new_orgs', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('fk_new_user_id');
            $table->foreign('fk_new_user_id')->references('id')->on('new_users')->onDelete('cascade');
            $table->string('full_name', 80);
            $table->string('leader_name', 80);
            $table->string('fiscal_number', 80);
            $table->string('address', 160);
            $table->string('phone', 30);
            $table->timestamps();
        });


        // Shared
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::connection('mysql_app')->create('sessions', function ($table) {
            $table->string('id')->unique();
            $table->string('user_id', 36)->nullable(); // uuid
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity');
        });
    }


    public function down() {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('password_resets');
        Schema::connection('mysql_new_users')->dropIfExists('organizations');
        Schema::connection('mysql_new_users')->dropIfExists('professionals');
        Schema::connection('mysql_new_users')->dropIfExists('new_users');
        Schema::dropIfExists('users');
    }
}
