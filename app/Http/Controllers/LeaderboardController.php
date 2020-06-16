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
        $houseguests = [];

//        $leaderboard = Leaderboard::where('week', $season->current_week)->with('user')->orderBy('networth', 'desc')->get();


//        SELECT user_id, sum(networth)
//        FROM leaderboard
//        WHERE week = (SELECT max(week) from leaderboard group by season_id)
//        GROUP BY user_id


        return view('leaderboard', compact('houseguests', 'leaderboard', 'season'));
    }
}
