<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIsChangeStatusMarketdevToRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('restaurants', 'is_change_status')){
            Schema::table('restaurants', function (Blueprint $table) {
                $table->tinyInteger('is_change_status')->default(1);
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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('is_change_status');
        });
        */
    }
}
