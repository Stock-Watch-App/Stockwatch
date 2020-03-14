<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;
use App\Models\Houseguest;

class LeaderboardController extends Controller
{
    public function index()
    {
        $houseguests = Houseguest::where('season_id', Season::current())->get();

        return view('leaderboard', compact('houseguests'));
    }
}
