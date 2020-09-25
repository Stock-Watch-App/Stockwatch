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
            'ratings.user',
            'season'
        ])->appendAttribute('projections');

        $ratings = [];
            $houseguest->map()

        return view('houseguest.show', compact('houseguest'));
    }
}
