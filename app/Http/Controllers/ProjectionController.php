<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class ProjectionController extends Controller
{
    public function index()
    {
        $houseguests = Houseguest::where('season_id', Season::current()->id)->get();
        $houseguests->load('ratings', 'prices');

        $houseguests->each(function ($houseguest) {
            $houseguest->append('projections');
        });

        return view('projections', compact('houseguests'));
    }
}
