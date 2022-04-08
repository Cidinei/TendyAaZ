<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertOnesingalSettingsMarketdevToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = DB::table('settings')->where('key', 'delivery_onesignal_app_id')->first();
 
        if (empty($settings) || is_null($settings)) {
            DB::table('settings')->insertOrIgnore([
                ['key' => 'delivery_onesignal_app_id'],
                ['key' => 'delivery_onesignal_channell_id'],
                ['key' => 'delivery_onesignal_key_id'],
                ['key' => 'store_onesignal_app_id'],
                ['key' => 'store_onesignal_channell_id'],
                ['key' => 'store_onesignal_key_id']
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


    }
}
