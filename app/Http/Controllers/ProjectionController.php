<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    public function index()
    {
        $season = Season::current();

        $houseguests = Houseguest::with([
                                     'ratings',
                                     'prices',
                                     'season',
                                     'vanitytags' => function ($q) use ($season) {
                                         $q->where('week', $season->current_week);
                                     },
                                 ])
                                 ->where('season_id', $season->id)
                                 ->cacheFor(now()->addHours(24))
                                 ->get();

        $houseguests->each(function ($houseguest) {
            $houseguest->append('projections');
        });

        return view('projections', compact('houseguests'));
    }
}
