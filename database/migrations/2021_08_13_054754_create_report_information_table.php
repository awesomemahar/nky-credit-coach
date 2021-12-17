<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bureau_id')->unsigned();
            $table->foreign('bureau_id')->references('id')->on('bureaus');
            $table->bigInteger('bureau_report_id')->unsigned();

            $table->string('report_date')->nullable();
            $table->string('name')->nullable();
            $table->string('also_known_as')->nullable();
            $table->string('former')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->text('current_address')->nullable();
            $table->text('previous_address')->nullable();
            $table->string('employers')->nullable();

            $table->string('credit_score')->nullable();
            $table->string('lender_rank')->nullable();
            $table->string('score_scale')->nullable();
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
        Schema::dropIfExists('report_information');
    }
}
