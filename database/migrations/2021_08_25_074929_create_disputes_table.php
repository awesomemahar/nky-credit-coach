<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->bigInteger('account_history_id')->unsigned();
            $table->bigInteger('bureau_creditor_contact_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('owner_id')->unsigned();
            $table->bigInteger('reason_id')->unsigned();
            $table->string('reason')->nullable();
            $table->boolean('is_tu')->default(0);
            $table->boolean('is_exp')->default(0);
            $table->boolean('is_eqfx')->default(0);
            $table->string('type');
            $table->string('tu_status')->default('N/A');
            $table->string('exp_status')->default('N/A');
            $table->string('eqfx_status')->default('N/A');
            $table->longText('remarks')->nullable();
            $table->string('account_status')->default('N/A');
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
        Schema::dropIfExists('disputes');
    }
}
