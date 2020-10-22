<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class HouseguestController extends Controller
{
    public function show(Season $season, Houseguest $houseguest)
    {
        $houseguest->load([
            'prices',
            'ratings.user', //todo someday filter to LFC
            'season'
        ])->appendAttribute('projections');

        // RATINGS
        $sortedRatings = [
            'Taran' => [],
            'Brent' => [],
            'Melissa' => [],
            'Audience' => [],
            'Average' => []
        ];
        $houseguest->ratings->each(function ($rating) use (&$sortedRatings) {
            $sortedRatings[explode(' ', $rating->user->name)[0]][$rating->week] = $rating->rating;
            if (!array_key_exists($rating->week, $sortedRatings['Average'])) {
                $sortedRatings['Average'][$rating->week] = 0;
            }
            $sortedRatings['Average'][$rating->week] += $rating->rating;
        });

        foreach ($sortedRatings['Average'] as $week => $average) {
            $sortedRatings['Average'][$week] = round($average/4);
        }

        // PRICES
        $sortedPrices = $houseguest->prices->mapToAssoc(function ($p) {
            return [$p->week, $p->price];
        });


        return view('houseguest.show', compact('houseguest', 'sortedRatings', 'sortedPrices'));
    }
}
