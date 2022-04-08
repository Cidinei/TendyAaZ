<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbackReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cashback_reports')) {
            Schema::create('cashback_reports', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('restaurant_id');
                $table->integer('user_id');
                $table->integer('order_id');
                $table->text('percentage')->nullable();
                $table->decimal('amount_real', 8, 2)->default(0);
                $table->decimal('amount_paid', 8, 2)->default(0);
                $table->timestamps();
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
        //Schema::dropIfExists('cashback_reports');
    }
}
