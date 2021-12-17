<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('letters', function (Blueprint $table) {
            //
            $table->enum('letter_type', ['Bureau', 'Furnisher','Collection Agency'])->after('letter');
            $table->boolean('by_admin')->default(0)->after('letter_type');
            $table->boolean('bulk_letters')->default(0)->after('by_admin');
            $table->string('letter_status')->default('Created')->after('bulk_letters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('letters', function (Blueprint $table) {
            //
        });
    }
}
