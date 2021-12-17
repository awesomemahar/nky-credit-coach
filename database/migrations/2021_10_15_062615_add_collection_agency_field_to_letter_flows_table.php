<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollectionAgencyFieldToLetterFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letter_flows', function (Blueprint $table) {
            $table->bigInteger('collection_agency_letter_id')->unsigned()->nullable()->after('furnisher_letter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letter_flows', function (Blueprint $table) {
            //
        });
    }
}
