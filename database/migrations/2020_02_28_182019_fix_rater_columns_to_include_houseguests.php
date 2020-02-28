<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRaterColumnsToIncludeHouseguests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', static function (Blueprint $table) {
            $table->renameColumn('rater' , 'houseguest_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', static function (Blueprint $table) {
            $table->renameColumn('houseguest_id' , 'rater');
        });
    }
}
