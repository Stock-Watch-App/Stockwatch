<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Bank;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Season;
use App\Models\User;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function foo\func;

class MarketController extends Controller
{
    public function open($season)
    {
        $season->current_week += 1;
        $this->calculatePrices($season);
        $this->zeroOutEvictees($season);
        $this->payStipend($season);
        $this->generateLeaderboard($season);
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
                Price::create(['price' => $new_price, 'houseguest_id' => $houseguest->id, 'week' => $week]);
            }
            if ($season->getOriginal('status') === 'pre-season') {
                Price::create(['price' => $houseguest->current_rate, 'houseguest_id' => $houseguest->id, 'week' => $week]);
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
        $houseguests = Houseguest::withoutGlobalScope('active')->where('status', 'evicted')->get();
       $houseguests->each(function ($houseguest) use ($season) {
                Price::create(['price' => 0.00, 'houseguest_id' => $houseguest->id, 'week' => $season->current_week]);
       });
    }

    public function generateLeaderboard($season)
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

        DB::table('leaderboard')->insertOrIgnore($insert);
    }
}
