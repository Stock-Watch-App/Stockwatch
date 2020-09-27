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

        $sortedRatings = [
            'Taran Armstrong' => [],
            'Brent Wolgamott' => [],
            'Melissa Deni' => [],
            'Audience' => [],
            'Average' => []
        ];
        $houseguest->ratings->each(function ($rating) use (&$sortedRatings) {
            $sortedRatings[$rating->user->name][$rating->week] = $rating->rating;
            if (!array_key_exists($rating->week, $sortedRatings['Average'])) {
                $sortedRatings['Average'][$rating->week] = 0;
            }
            $sortedRatings['Average'][$rating->week] += $rating->rating;
        });

        foreach ($sortedRatings['Average'] as $week => $average) {
            $sortedRatings['Average'][$week] = round($average/4);
        }


        return view('houseguest.show', compact('houseguest', 'sortedRatings'));
    }
}
