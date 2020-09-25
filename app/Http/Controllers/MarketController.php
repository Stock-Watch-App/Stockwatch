<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function foo\func;

class MarketController extends Controller
{
    public function open($season)
    {
        $season->current_week += 1;
        $this->calculatePrices($season);
        if ($season->getOriginal('status') !== 'pre-season') {
            $this->zeroOutEvictees($season);
            $this->payStipend($season);
            $this->generateLeaderboard($season);
        }
    }

    public function end($season)
    {
        $season->current_week += 1;
        $this->calculatePrices($season);
        $this->zeroOutEvictees($season);
        $this->generateLeaderboard($season);
    }

    public function calculatePrices($season)
    {
        $f = new Formula();
        $week = $season->current_week;
        $houseguests = Houseguest::where('season_id', $season->id)->get();
        foreach ($houseguests as $houseguest) {
            if ($season->getOriginal('status') === 'closed') {
                $rating = (int)round($houseguest->ratings()->where('week', $week)->pluck('rating')->sum() / 4);
                $last_rating = (int)round($houseguest->ratings()->where('week', $week - 1)->pluck('rating')->sum() / 4);
                $last_price = $houseguest->prices()->where('week', $week - 1)->first()->price;

                $new_price = $f->calculate($last_rating, $rating, $last_price, $houseguest->strikes);
                Price::create(['price' => $new_price, 'houseguest_id' => $houseguest->id, 'season_id' => $season->id, 'week' => $week]);
            }
            if ($season->getOriginal('status') === 'pre-season') {
                Price::create([
                    'price'         => (int)round($houseguest->ratings()->limit(4)->where('week', $season->current_week)->pluck('rating')->sum() / 4),
                    'houseguest_id' => $houseguest->id,
                    'season_id'     => $season->id,
                    'week'          => $week
                ]);
            }
        }
    }

    public function payStipend($season)
    {
        $pdo = DB::connection()->getPdo();

        $sql = "UPDATE banks SET money = (money+20) WHERE season_id = :season_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':season_id', $season->id);
        $stmt->execute();

//        $banks = Bank::where('season_id', $season->id);
//        $banks->each(function ($bank) {
//            $bank->money += 20;
//            $bank->save();
//        });
    }

    public function zeroOutEvictees($season)
    {
        $houseguests = Houseguest::withoutGlobalScope('active')
                                 ->where('status', 'evicted')
                                 ->where('season_id', $season->id)
                                 ->get();
        $houseguests->each(function ($houseguest) use ($season) {
            Price::create([
                'price'         => 0.00,
                'houseguest_id' => $houseguest->id,
                'season_id'     => $season->id,
                'week'          => $season->current_week
            ]);
        });
    }

    public function generateLeaderboard($season)
    {
        // Temporarily increase memory limit to 256MB
        ini_set('memory_limit', '256M');

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

        $stocks = User::with([
            'stocks' => function ($s) use ($season) {
                $s->whereHas('houseguest', function ($h) use ($season) {
                   $h->where('season_id', $season->id);
                });
            }
        ])->get()->mapToAssoc(function ($u) {
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

        $totalActivePlayers = $networth->reject(function ($value) {
            return $value === null;
        })->count();

        $insert = $networth->map(function ($net) use ($stocks, $season, $totalActivePlayers, &$rank, &$lastValue, &$hiddenRank) {
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
                    'user_id'           => $net->user_id,
                    'season_id'         => $season->id,
                    'week'              => $season->current_week,
                    'rank'              => $newRank,
                    'rank_percentage'   => ceil($newRank / $totalActivePlayers * 100),
                    'networth'          => $net->networth,
                    'stocks'            => $stocks[$net->user_id]
                ];
            }
        })->reject(function ($value) {
            return $value === null;
        })->toArray();

        DB::table('leaderboard')->insertOrIgnore($insert);
    }
}
