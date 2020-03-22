<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Season;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load('bank', 'transactions');
        $user->load([
            'stocks' => function ($query) {
                $query->where('quantity', '>', 0);
            }
        ]);
        $season = Season::current();

        $houseguests = Houseguest::where('season_id', $season->id)->withoutGlobalScope('active')->get();
        $houseguests->load('prices');


        return view('dashboard', compact('user', 'houseguests'));
    }
}
