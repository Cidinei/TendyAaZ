<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashbackToRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('restaurants', 'cashback_status')){
            Schema::table('restaurants', function (Blueprint $table) {
                $table->tinyInteger('cashback_status')->default(0);
                $table->decimal('cashback_value', 8, 2)->default(0);
                $table->text('cashback_percentage')->nullable();
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
            $table->dropColumn([
                'cashback_status', 
                'cashback_value', 
                'cashback_percentage']);
        });
        */
    }
}
