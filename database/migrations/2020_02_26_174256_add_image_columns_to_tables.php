<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('images');
        Schema::table('users',static function (Blueprint $table) {
            $table->string('avatar');
            $table->boolean('avatar_approved');
        });
        Schema::table('houseguests',static function (Blueprint $table) {
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',static function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('avatar_approved');
        });
        Schema::table('houseguests',static function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::create('images',static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->integer('imageable_id');
            $table->string('imageable_type');
            $table->timestamps();
        });
    }
}
