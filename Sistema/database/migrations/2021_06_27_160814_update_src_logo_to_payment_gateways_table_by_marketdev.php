<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSrcLogoToPaymentGatewaysTableByMarketdev extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('payment_gateways')->where('id',1)->update([
            'description' => 'checkoutCodMoney',
            'logo' => '/assets/img/various/cod.png'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::table('payment_gateways', function (Blueprint $table) {
            //
        //});
    }
}
