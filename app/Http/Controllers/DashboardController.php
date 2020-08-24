<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $season = Season::current();

        $user = $request->user();
        $user->load('banks', 'leaderboard');
        $user->load([
            'stocks' => function ($query) {
                $query->where('quantity', '>', 0);
            },
            'transactions' => function ($query) use ($season) {
                $query->whereHas('houseguest', function ($q) use ($season) {
                    $q->where('season_id', $season->id);
                });
                $query->orderByDesc('created_at');
            }
        ]);

        $houseguests = Houseguest::where('season_id', $season->id)->withoutGlobalScope('active')->get();
        $houseguests->load('prices');


        return view('dashboard', compact('user', 'houseguests'));
    }
}
