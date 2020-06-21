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

        $leaderboard = Leaderboard::where('week', $season->current_week)->with('user')->orderBy('networth', 'desc')->get();

        return view('leaderboard', compact('houseguests', 'leaderboard', 'season'));
    }

    public function allTime()
    {
        $leaderboard = Leaderboard::with('user')->select(DB::raw('user_id, sum(networth) as networth'))
            ->where('week', static function ($q) {
                $q->select(DB::raw('max(week)'))->from('leaderboard')->groupBy('season_id');
            })->groupBy('user_id')->orderBy('networth', 'desc')->get();

        return view('leaderboards.alltime', compact('leaderboard'));
    }
}
