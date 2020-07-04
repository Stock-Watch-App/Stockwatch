<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('bank', 'transactions', 'leaderboard');
        $user->load([
            'stocks' => function ($query) {
                $query->where('quantity', '>', 0);
            }
        ]);
        $season = Season::current();

        $houseguests = Houseguest::where('season_id', $season->id)->withoutGlobalScope('active')->get();
        $houseguests->load('prices');

        // $bank = $user->bank;
        // if ($bank === null) {
        //     $stocks = $this->initGame($user);
        //     $user->load('bank');
        //     $bank = $user->bank;
        // }

        // $stocks = $this->getStocks($user, $season);

        // $networth = $bank->money + $stocks->map(function ($stock) {
        //         return $stock->quantity * $stock->houseguest->current_price;
        //     })->sum();


        return view('profile', compact('user', 'houseguests'));
    }
}
