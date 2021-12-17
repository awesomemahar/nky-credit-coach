<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureauReportInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_report_inquiries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bureau_report_id')->unsigned();
            $table->string('creditor_name')->nullable();
            $table->string('type_of_business')->nullable();
            $table->string('date_of_inquiry')->nullable();
            $table->string('credit_bureau')->nullable();
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
        Schema::dropIfExists('bureau_report_inquiries');
    }
}
