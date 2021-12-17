<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureauReportSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_report_summaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bureau_id')->unsigned();
            $table->bigInteger('bureau_report_id')->unsigned();

            $table->string('total_accounts')->nullable();
            $table->string('open_accounts')->nullable();
            $table->string('closed_accounts')->nullable();
            $table->string('delinquent')->nullable();
            $table->string('derogatory')->nullable();
            $table->string('collection')->nullable();
            $table->string('balances')->nullable();
            $table->string('payments')->nullable();
            $table->string('public_records')->nullable();
            $table->string('inquiries')->nullable();
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
        Schema::dropIfExists('bureau_report_summaries');
    }
}
