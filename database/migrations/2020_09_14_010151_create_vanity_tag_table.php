<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVanityTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vanity_tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->string('taggable_type')->nullable();
            $table->integer('taggable_id')->nullable();
            $table->integer('season_id')->nullable();
            $table->integer('week')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vanity_tags');
    }
}
