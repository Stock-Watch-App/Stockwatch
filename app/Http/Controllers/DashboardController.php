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
        $user->load('stocks', 'bank', 'transactions');

        $houseguests = Houseguest::where('season_id', Season::current()->id)->withoutGlobalScope('active')->get();


        return view('dashboard', compact('user', 'houseguests'));
    }
}
