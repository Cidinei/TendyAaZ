<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashBackSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cashback_settings')) {
            Schema::create('cashback_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->tinyInteger('restaurant_edit')->default(1);
                $table->tinyInteger('sum_total_amount')->default(0);
                $table->timestamps();
            });

            DB::table('cashback_settings')->insert([
                ['restaurant_edit' => 1]

            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::dropIfExists('cashback_settings'); */
    }
}
