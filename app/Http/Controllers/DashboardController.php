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

class DashboardController extends Controller
{
    //=== ROUTES ===//
    public function index(Request $request)
    {
        $user = $request->user();
        //is the user registered for the seasons?
        $bank = $user->bank;
        if ($bank === null) {
            $stocks = $this->initGame($user);
            $user->load('bank');
            $bank = $user->bank;
        }

        $stocks = $this->getStocks($user);

        $networth = $bank->money + $stocks->map(function ($stock) {
                return $stock->quantity * $stock->houseguest->current_price;
            })->sum();

        $market = Season::current()->status;

        return view('dashboard', compact('user', 'bank', 'stocks', 'networth', 'market'));
    }

    public function savestocks(Request $request)
    {
        $data = $request->all();
        $user = $request->user();
        $bank = $user->bank;
        $stocks = $this->getStocks($user);
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

        $stocks->each(function ($stock) use ($data, &$transactions, $user) {
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
                'current_price' => $stock->houseguest->current_price,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
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

    protected function getStocks($user)
    {
        $user->load([
            'stocks' => function ($query) {
                $query->whereHas('houseguest', function ($query) {
                    $query->where('status', 'active');
                })->with('houseguest');
            }
        ]);

        $stocks = $user->stocks->load('houseguest');

        $stocks->each(static function ($stock, $key) {
            $stock->houseguest->load('ratings', 'prices');
        });

        return $stocks;
    }
}
