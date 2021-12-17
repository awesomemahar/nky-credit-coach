<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureauReportAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_report_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bureau_id')->unsigned();
            $table->foreign('bureau_id')->references('id')->on('bureaus');
            $table->bigInteger('bureau_report_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('bureau_account_title_id')->unsigned();
            $table->string('account')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_type_detail')->nullable();
            $table->string('bureau_code')->nullable();
            $table->string('account_status')->nullable();
            $table->string('monthly_payment')->nullable();
            $table->string('date_opened')->nullable();
            $table->string('balance')->nullable();
            $table->string('no_of_months')->nullable();
            $table->string('high_credit')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('past_due')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('last_reported')->nullable();
            $table->string('comments')->nullable();
            $table->string('date_last_active')->nullable();
            $table->string('date_of_last_payment')->nullable();
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
        Schema::dropIfExists('bureau_report_accounts');
    }
}
