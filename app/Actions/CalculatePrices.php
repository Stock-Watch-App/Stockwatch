<?php

namespace App\Actions;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Season;

class CalculatePrices
{
    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        $f = new Formula();
        $week = $this->season->current_week;
        $houseguests = Houseguest::where('season_id', $this->season->id)->get();

        foreach ($houseguests as $houseguest) {
            if ($this->season->getOriginal('status') === 'closed') {
                $rating = (int)round($houseguest->ratings()->where('week', $week)->pluck('rating')->sum() / 4);
                $last_rating = (int)round($houseguest->ratings()->where('week', $week - 1)->pluck('rating')->sum() / 4);
                $last_price = $houseguest->prices()->where('week', $week - 1)->first()->price;

                $new_price = $f->calculate($last_rating, $rating, $last_price, $houseguest->strikes);
                Price::create(['price' => $new_price, 'houseguest_id' => $houseguest->id, 'season_id' => $this->season->id, 'week' => $week]);
            }
            if ($this->season->getOriginal('status') === 'pre-season') {
                Price::create([
                    'price'         => (int)round($houseguest->ratings()->limit(4)->where('week', $this->season->current_week)->pluck('rating')->sum() / 4),
                    'houseguest_id' => $houseguest->id,
                    'season_id'     => $this->season->id,
                    'week'          => $week
                ]);
            }
        }
    }
}
