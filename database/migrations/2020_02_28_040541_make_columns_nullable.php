<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houseguests', static function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
        Schema::table('users', static function (Blueprint $table) {
            $table->string('avatar')->nullable()->change();
            $table->integer('avatar_approved')->default(0)->change();
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
            $table->string('image')->change();
        });
        Schema::table('users', static function (Blueprint $table) {
            $table->string('avatar')->change();
            $table->integer('avatar_approved')->change();
        });
    }
}
