<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryRadiusProInDeliveryGuyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('delivery_guy_details', 'delivery_radius')){
            Schema::table('delivery_guy_details', function (Blueprint $table) {
                $table->bigInteger('delivery_radius')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('delivery_guy_details', function (Blueprint $table) {
            $table->dropColumn(['delivery_radius']);
        });
        */
    }
}
