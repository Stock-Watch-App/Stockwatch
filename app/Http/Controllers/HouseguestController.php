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
        ];
        $houseguest->ratings->each(function ($rating) use (&$sortedRatings) {
            $sortedRatings[$rating->user->name][$rating->week] = $rating->rating;
        });

        return view('houseguest.show', compact('houseguest', 'sortedRatings'));
    }
}
