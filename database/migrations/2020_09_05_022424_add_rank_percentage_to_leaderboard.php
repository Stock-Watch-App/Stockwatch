<?php

use App\Models\Leaderboard;
use App\WeeklyLeaderboards;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRankPercentageToLeaderboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaderboard', function (Blueprint $table) {
            $table->integer('rank_percentage')->after('rank')->index();
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaderboard', function (Blueprint $table) {
            $table->drop('rank_percentage');
        });
    }

    protected function seed()
    {
        $leaderboards = Leaderboard::query()->cursor();

        $leaderboards->each(function (Leaderboard $leaderboard) {
            $total = (new WeeklyLeaderboards($leaderboard->season_id, $leaderboard->week))->count();
            $leaderboard->rank_percentage = $total > 0 ? ceil($leaderboard->rank / $total * 100) : 0;
            $leaderboard->save();
        });
    }
}
