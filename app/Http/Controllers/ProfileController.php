<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Leaderboard;
use App\Models\Season;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $season = Season::current();
        $user->load([
            'banks',
            'transactions',
            'leaderboard' => function ($query) use ($season) {
                $query->where('season_id', $season->id);
            },
            'stocks'      => function ($query) use ($season) {
                $query->where('quantity', '>', 0)
                      ->whereHas('houseguest', function ($h) use ($season) {
                          $h->where('season_id', $season->id);
                      });
            }
        ]);


//        $user->append(['alltime-rank' => Leaderboard::])

        $bank = $user->bank;
        $houseguests = Houseguest::with('prices')
                                 ->where('season_id', $season->id)
                                 ->withoutGlobalScope('active')
                                 ->get();

        return view('profile', compact('user', 'bank', 'houseguests', 'season'));
    }
}
