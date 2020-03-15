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

        $leaderboard = Leaderboard::where('week', $season->current_week)->orderBy('networth', 'desc')->get();;

        return view('leaderboard', compact('houseguests', 'leaderboard'));
    }

    public function calculate()
    {
        $networth = DB::table('stocks')
                      ->select(DB::raw('stocks.user_id, ANY_VALUE(sum(stocks.quantity*prices.price)+banks.money) as networth'))
                      ->join('prices', 'stocks.houseguest_id', '=', 'prices.houseguest_id')
                      ->join('banks', 'stocks.user_id', '=', 'banks.user_id')
                      ->whereRaw('prices.week = (Select max(week) from prices)')
                      ->groupBy('stocks.user_id')
                      ->get()
                      ->mapToAssoc(function ($res) {
                          return [$res->user_id, $res->networth];
                      });
        $users = User::with('stocks')->get();
        $season = Season::current();

        $insert = $users->map(function ($user) use ($networth, $season) {
            if ($networth->has($user->id)) {
                return [
                    'user_id'   => $user->id,
                    'season_id' => $season->id,
                    'week'      => $season->current_week,
                    'networth'  => $networth[$user->id],
                    'stocks'    => json_encode($user->stocks->mapToAssoc(function ($stock) {
                        return [$stock->houseguest_id, $stock->quantity];
                    }))
                ];
            }
        })->reject(function ($value) {
            return $value === null;
        })->toArray();
//
//        dump(json_encode($users[1]->stocks->mapToAssoc(function ($stock) {
//            return [$stock->houseguest_id, $stock->quantity];
//        })));
//        dd($insert);
        DB::table('leaderboard')->insertOrIgnore($insert);
    }
}
