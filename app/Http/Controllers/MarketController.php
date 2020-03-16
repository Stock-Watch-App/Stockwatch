<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Bank;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    public function open($season)
    {
        $season->current_week += 1;
        $this->calculatePrices($season);
        $this->payStipend($season);
    }

    protected function calculatePrices($season)
    {
        $f = new Formula();
        $week = $season->current_week;

        $houseguests = Houseguest::where('season_id', $season->id)->get();
        foreach ($houseguests as $houseguest) {
            if ($season->getOriginal('status') === 'closed') {
                $rating = $houseguest->current_rate;
                $last_rating = (int)round($houseguest->ratings()->where('week', $week - 1)->pluck('rating')->sum() / 4);
                $last_price = $houseguest->prices()->where('week', $week - 1)->first()->value('price');

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
}
