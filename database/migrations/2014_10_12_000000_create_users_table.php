<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('suffix', 255)->nullable();
            $table->string('email')->unique();
            $table->boolean('no_email_check')->nullable();
            $table->string('social_security_number', 255)->nullable();
            $table->date('dob')->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('phone_work', 255)->nullable();
            $table->string('ext', 255)->nullable();
            $table->string('phone_m', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->text('mailing_address')->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->text('picture')->nullable();
            $table->integer('type');
            $table->string('iq_username', 255)->nullable();
            $table->string('iq_password', 255)->nullable();
            $table->integer('last_four_ssn')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('business_id')->unsigned()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
