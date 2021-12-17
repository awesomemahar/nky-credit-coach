<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSubscriptionPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_packages', function (Blueprint $table) {
            //
            $table->double('per_fax_price')->default(0.00)->after('features');
            $table->bigInteger('no_of_clients')->unsigned()->default(0)->after('per_fax_price');
            $table->enum('package_type', ['Starter', 'Business'])->default('Starter')->after('no_of_clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_packages', function (Blueprint $table) {
            //
        });
    }
}
