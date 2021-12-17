<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputeLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispute_letters', function (Blueprint $table) {
            $table->id();
            $table->string('dispute_uid');
            $table->bigInteger('owner_id')->unsigned();
            $table->string('company')->nullable();
            $table->longText('letter')->nullable();
            $table->string('status')->default('Created');
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
        Schema::dropIfExists('dispute_letters');
    }
}
