<?php

namespace App\Actions;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Season;

class GenerateLeaderboard
{
    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        $networth = DB::table('stocks')
            ->select(DB::raw('stocks.user_id, ANY_VALUE(sum(stocks.quantity*prices.price)+banks.money) as networth'))
            ->join('prices', 'stocks.houseguest_id', '=', 'prices.houseguest_id')
            ->join('banks', 'stocks.user_id', '=', 'banks.user_id')
            ->whereRaw('banks.season_id = ?', $season->id)
            ->whereRaw('prices.season_id = ?', $season->id)
            ->whereRaw('prices.week = ?', $season->current_week)
            ->groupBy('stocks.user_id')
            ->orderByDesc('networth')
            ->get();

        $stocks = User::with('stocks')->get()->mapToAssoc(function ($u) {
            return [
            $u->id,
            json_encode($u->stocks->mapToAssoc(function ($stock) {
                return [$stock->houseguest_id, $stock->quantity];
            }))
        ];
        });

        $rank = 1;
        $lastValue = '1';
        $hiddenRank = 1;

        $insert = $networth->map(function ($net) use ($stocks, $season, &$rank, &$lastValue, &$hiddenRank) {
            if ($stocks->has($net->user_id)) {
                if ($lastValue === $net->networth) {
                    $newRank = $rank;
                } else {
                    $newRank = $hiddenRank;
                    $rank = $hiddenRank;
                }
                $lastValue = $net->networth;
                $hiddenRank++;

                return [
                'user_id'   => $net->user_id,
                'season_id' => $season->id,
                'week'      => $season->current_week,
                'rank'      => $newRank,
                'networth'  => $net->networth,
                'stocks'    => $stocks[$net->user_id]
            ];
            }
        })->reject(function ($value) {
            return $value === null;
        })->toArray();

        DB::table('leaderboard')->insertOrIgnore($insert);
    }
}
