<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToHouseguests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('houseguests', function (Blueprint $table) {
            $table->string('slug');
        });

        \App\Models\Houseguest::withoutGlobalScope('active')->get()->each(function ($h) {
           $h->slug = str_replace([' ',"'"],['_',''],strtolower($h->nickname));
           $h->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('houseguests', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
