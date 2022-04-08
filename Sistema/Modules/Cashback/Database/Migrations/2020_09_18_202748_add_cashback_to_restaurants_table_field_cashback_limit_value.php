<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashbackToRestaurantsTableFieldCashbackLimitValue extends Migration
      
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('restaurants', 'cashback_limit_value')){
            Schema::table('restaurants', function (Blueprint $table) {
                $table->decimal('cashback_limit_value', 8, 2)->default(0);
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
            $table->dropColumn(['cashback_status', 'cashback_value', 'cashback_percentage']);
        });
        */
    }
}
