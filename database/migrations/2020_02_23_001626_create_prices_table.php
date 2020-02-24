<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('houseguest_id');
            $table->integer('week');
            $table->decimal('price');
            $table->timestamps();
        });

        Schema::table('stocks', function (Blueprint $table) {
           $table->renameColumn('amount', 'quantity');
        });

        Schema::table('transactions', function (Blueprint $table) {
           $table->dropColumn('amount');
           $table->unsignedInteger('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
