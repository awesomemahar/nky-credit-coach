<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetterFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_flows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Accounts', 'Inquiry','General'])->default('Accounts');
            $table->bigInteger('reason_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('bureau_letter_id')->unsigned()->nullable();
            $table->bigInteger('furnisher_letter_id')->unsigned()->nullable();
            $table->boolean('by_admin')->default(0);
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
        Schema::dropIfExists('letter_flows');
    }
}
