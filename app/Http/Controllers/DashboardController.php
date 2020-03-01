<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Season;
use App\Models\Houseguest;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //is the user registered for the seasons?
        $bank = $user->bank;
        if ($bank === null) {
            $stocks = $this->initGame($user);
        }

        $user->load(['stocks' => function ($query) {
            $query->whereHas('houseguest', function ($query) {
                $query->where('status', 'active');
            })->with('houseguest');
        }]);

        $stocks = $user->stocks->load('houseguest');

        $stocks->each(static function ($stock, $key) {
           $stock->houseguest->load('ratings', 'prices');
        });

        $market = Season::current()->status;

        return view('dashboard', compact('user', 'bank', 'stocks', 'market'));
    }

    protected function initGame($user)
    {
        $season = Season::current();

        Bank::create([
            'user_id'   => $user->id,
            'season_id' => $season->id,
            'money'     => 200
        ]);

        $houseguests = Houseguest::whereHas('season', function (Builder $query) use ($season) {
            $query->where('id', $season->id);
        })->get();

        $stocks = collect();
        $houseguests->each(function ($item, $key) use (&$stocks, $user) {
            $stocks->push(Stock::create([
                'user_id'       => $user->id,
                'houseguest_id' => $item->id,
                'quantity'      => 0
            ]));
        });

        return $stocks;
    }
}
