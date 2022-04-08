<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddonproInAddonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('addon_categories', 'minimum_qty')){
            Schema::table('addon_categories', function (Blueprint $table) {
                $table->bigInteger('minimum_qty')->default(1);
                $table->bigInteger('maximum_qty')->default(999);
                $table->tinyInteger('add_required')->default(1);
            });
        } else {
            DB::table('addon_categories')->update([
                'add_required' => 1,
                ]);
        }

        if (Schema::hasColumn('addon_categories', 'addon_limit')){
            DB::table('addon_categories')->update([
                'addon_limit' => 0,
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

        DB::table('addon_categories')->update([
            'add_required' => 0,
            ]);

        //Schema::table('addon_categories', function (Blueprint $table) {
            //$table->dropColumn(['minimum_qty', 'maximum_qty', 'add_required']);
        //});
    }
}
