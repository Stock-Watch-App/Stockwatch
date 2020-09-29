<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Season;
use App\Models\Houseguest;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    //=== ROUTES ===//
    public function index(Request $request)
    {
        //is someone logged in?
        if (!auth()->check()) {
            return $this->guestIndex($request, 'guest');
        }

        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            return $this->guestIndex($request, 'unverified');
        }

        $season = Season::current();

        //is the user registered for the season?
        if (!$user->isPlaying($season)) {
            return $this->guestIndex($request, 'spectator');
        }

        $bank = $user->bank;

        $stocks = $this->getStocks($user, $season);

        $networth = $bank->money + $stocks->map(function ($stock) {
                return $stock->quantity * $stock->houseguest->current_price;
            })->sum();


        return view('trades', compact('user', 'bank', 'stocks', 'networth', 'season'));
    }

    public function guestIndex(Request $request, $stateOfUser = '')
    {
        $season = Season::current();
        $season->load(['houseguests.prices', 'houseguests.ratings', 'houseguests.season',
                'houseguests.vanitytags' => function ($q) use ($season) {
                    $q->where('week', $season->current_week);
                },]);
        $stocks = $season->houseguests->map(static function ($h) {
            return ['houseguest' => $h];
        });

        return view('trades', compact('stocks', 'season', 'stateOfUser'));
    }

    public function savestocks(Request $request)
    {
        $season = Season::current();
        if ($season->status !== 'open') {
            return json_encode(['success' => false]);
        }
        $data = $request->all();
        $user = $request->user();
        $bank = $user->bank;
        $stocks = $this->getStocks($user, $season);
        $networth = $bank->money + $stocks->map(function ($stock) {
                return $stock->quantity * $stock->houseguest->current_price;
            })->sum();

        $proposedTransactionValue = collect($data['stocks'])->map(function ($order) use ($stocks) {
            return max(0, $order['quantity']) * $stocks->first(function ($value) use ($order) {
                    return $value->houseguest_id === $order['houseguest'];
                })->houseguest->current_price;
        })->sum();

        if ($proposedTransactionValue > $networth) {
            return json_encode(['success' => false]);
        }

        $transactions = [];

        $stocks->each(function ($stock) use ($data, &$transactions, $user, $season) {
            $oldQuantity = $stock->quantity;
            $newQuantity = max(0, collect($data['stocks'])->first(function ($value) use ($stock) {
                return $value['houseguest'] === $stock->houseguest_id;
            })['quantity']);

            if ($oldQuantity === $newQuantity) {
                return;
            }

            $transactions[] = [
                'user_id'       => $user->id,
                'houseguest_id' => $stock->houseguest_id,
                'action'        => $oldQuantity < $newQuantity ? 'buy' : 'sell',
                'quantity'      => abs($oldQuantity - $newQuantity),
                'week'          => $season->current_week,
                'current_price' => $stock->houseguest->current_price,
                'created_at'    => date('Y-m-d h:i:s'),
                'updated_at'    => date('Y-m-d h:i:s'),
            ];

            $stock->quantity = $newQuantity;

            $stock->save();
        });

        Transaction::insert($transactions);

        $bank->money = $networth - $proposedTransactionValue;
        $bank->save();

        return json_encode(['success' => true]);
    }

    //=== METHODS ===//
    protected function initGame()
    {
        $user = auth()->user();
        $season = Season::current();

        Bank::firstOrCreate([
            'user_id'   => $user->id,
            'season_id' => $season->id,
            'money'     => 200
        ]);

        $houseguests = Houseguest::whereHas('season', function (Builder $query) use ($season) {
            $query->where('id', $season->id);
        })->get();


        $stocks = collect();
        $houseguests->each(function ($item, $key) use (&$stocks, $user) {
            $stocks->push(Stock::firstOrCreate([
                'user_id'       => $user->id,
                'houseguest_id' => $item->id,
                'quantity'      => 0
            ]));
        });

        return redirect()->route('trade');
    }

    protected function getStocks($user, $season)
    {
        $user->load([
            'stocks' => function ($query) use ($season) {
                $query->whereHas('houseguest', function ($q) use ($season) {
                    $q->where('status', 'active')
                      ->where('season_id', $season->id);
                })->with('houseguest');
            }
        ]);
//        dd($user);

        $stocks = $user->stocks->load('houseguest.season');


        $stocks->each(static function ($stock, $key) use ($season) {
            $stock->houseguest->load([
                'ratings' => function ($query) use ($season) {
                    $query->where('week', $season->current_week);
                },
                'vanitytags' => function ($q) use ($season) {
                    $q->where('week', $season->current_week);
                },
                'prices'
            ]);
        });

        return $stocks;
    }
}
