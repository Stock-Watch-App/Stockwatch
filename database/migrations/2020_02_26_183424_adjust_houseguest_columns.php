<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustHouseguestColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houseguests', static function (Blueprint $table) {
            $table->renameColumn('nick_name', 'nickname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houseguests', static function (Blueprint $table) {
            $table->renameColumn('nickname', 'nick_name');
        });
    }
}
