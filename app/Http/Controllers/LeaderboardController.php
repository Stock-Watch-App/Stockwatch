<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Houseguest;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $season = Season::current();
        $houseguests = Houseguest::where('season_id', $season->id)->get();

        $leaderboard = Leaderboard::where('week', $season->current_week)
                                  ->where('season_id', $season->id)
                                  ->with('user.banks')
                                  ->orderBy('rank')
                                  ->cacheFor(now()->addHours(24))
                                  ->get();

        return view('leaderboard', compact('houseguests', 'leaderboard', 'season'));
    }

    public function allTime()
    {
        $leaderboard = Leaderboard::with('user.banks')
                                  ->whereSeasonEnded()
                                  ->select(DB::raw('user_id, sum(networth) as networth'))
                                  ->where('week', static function ($q) {
                                      $q->select(DB::raw('max(week)'))
                                        ->from('leaderboard')
                                          ->where('season_id', 1)
                                        ->groupBy('season_id');
                                  })->groupBy('user_id')
                                  ->orderBy('networth', 'desc')
                                  ->cacheFor(now()->addHours(24))
                                  ->get();

        return view('leaderboards.alltime', compact('leaderboard'));
    }
}
