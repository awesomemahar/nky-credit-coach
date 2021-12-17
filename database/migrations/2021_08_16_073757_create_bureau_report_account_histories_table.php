<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureauReportAccountHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_report_account_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bureau_report_id')->unsigned();
            $table->bigInteger('bureau_account_title_id')->unsigned();
            $table->string('month');
            $table->string('year');
            $table->string('transunion')->nullable();
            $table->string('experian')->nullable();
            $table->string('equifax')->nullable();
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
        Schema::dropIfExists('bureau_report_account_histories');
    }
}
