<?php

use App\Models\Leaderboard;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRankToLeaderboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaderboard', function (Blueprint $table) {
            $table->integer('rank')->after('week');
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
            $table->dropColumn('rank');
        });
    }

    public function seed()
    {
        $seasons = DB::table('leaderboard')->select(DB::raw('distinct season_id, week'))->get();
        $seasons->each(function ($season) {

            $leaderboard = Leaderboard::where('season_id', $season->season_id)
                                      ->where('week', $season->week)
                                      ->orderByDesc('networth')
                                      ->get();
            $rank = 1;
            $lastValue = '1';
            $hiddenRank = 1;
            $leaderboard->each(function ($l) use (&$rank, &$lastValue, &$hiddenRank) {
                if ($lastValue === $l->networth) {
                    $newRank = $rank;
                } else {
                    $newRank = $hiddenRank;
                    $rank = $hiddenRank;
                }
                $lastValue = $l->networth;
                $hiddenRank++;

                $l->rank = $newRank;
                $l->save();
            });
        });
    }
}
