<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Leaderboard;
use App\Models\User;
use App\Models\Price;
use App\Models\Season;

//use App\Nova\Season;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Clue\StreamFilter\fun;

class DebugController extends Controller
{
    public function showme($blade)
    {
        $vars = $this->getTempVars($blade);
        $blade = preg_replace('/\//', '.', $blade);
        return view($blade, $vars);
    }

    protected function getTempVars($blade): array
    {

        $content = file_get_contents(resource_path("views/{$blade}.blade.php"));

        $pattern = '/{(?:{|!!)[ ]{0,1}\$(?:(\S*?)(?:\[\'(.*?)\'\])?)[ ]{0,1}(?:!!|})}/';

        preg_match_all($pattern, $content, $variables);

        $tempVars = [];

        foreach ($variables[1] as $i => $var) {
            if ($variables[2][$i] !== '') {
                $tempVars[$var][$variables[2][$i]] = "\${$var}['{$variables[2][$i]}']";
            } else {
                $tempVars[$var] = "\${$var}";
            }

        }
        return $tempVars;
    }

    public function xyz()
    {
    // get data
    $season = Season::current();
    $data = Transaction::whereHas('user')->whereHas('houseguest', function ($q) use ($season) {
        $q->withoutGlobalScope('active');
        $q->where('season_id', $season->id);
    })->with([
        'houseguest' => function ($q) use ($season) {
            $q->withoutGlobalScope('active');
        }
    ])->where('week', $season->current_week)->get();

    dump($data);
    }

    public function testaudit()
    {
        $season = Season::current();


        $houseguests = Houseguest::with('prices')
                                 ->currentSeason()
                                 ->withOutGlobalScope('active')
                                 ->get();

        $price_breaks = $houseguests->map(function ($hg) {
            return $hg->prices->map(function ($p) {
                return $p->created_at->format('Y-m-d');
            });
        })->flatten()->unique()->sort();

        $user = User::with([
            'transactions' => function ($q) {
            }
        ])
                    ->find(2);

//        $this->checkWeek(1, 2630);
        $this->rollbackFrom(2, 2630);
    }

    public function rollbackFrom($week, $user_id)
    {
        $transactions = Transaction::with('houseguest')
                                   ->whereHas('houseguest', function ($q) {
                                       $q->where('season_id', 2);
                                   })->where('user_id', $user_id)
                                   ->where('week', $week)
                                   ->orderByDesc('created_at')
                                   ->get();

        $oldPrices = Price::with('houseguest')->whereHas('houseguest', function ($hg) {
            $hg->where('season_id', 2);
        })->where('week', $week)->get()->mapToAssoc(function ($price) {
            return [$price->houseguest->id, $price->price];
        });

        $leaderboardSays = Leaderboard::where('user_id', $user_id)->where('season_id', 2)->where('week', $week)->first();
        $startWith = Leaderboard::where('user_id', $user_id)->where('season_id', 2)->where('week', $week + 1)->first();

        $networth = $leaderboardSays->networth;

        $tiedUp = 0;
        $stocks = collect($startWith->stocks)->each(function ($stock, $hg) use (&$tiedUp, $oldPrices) {
            $tiedUp += $stock * ($oldPrices->has($hg) ? $oldPrices[$hg] : 0);
        });


        $bank = $networth - $tiedUp;

        $transactions->each(function($t) use (&$bank, $stocks) {
            if ($bank < 0) {
            switch ($t->action) {
                case 'buy':
                    $stocks[$t->houseguest->id] -= $t->quantity;
                    $bank += $t->quantity * $t->current_price;
                    break;
                case 'sell':
                    $stocks[$t->houseguest->id] += $t->quantity;
                    $bank -= $t->quantity * $t->current_price;
                    break;
            }

            }
        });

        dump($bank);
        dump($stocks);

        $calcNetworth = 0;
        $stocks->each(function ($stock, $hg) use (&$calcNetworth, $oldPrices) {
            $calcNetworth += $stock * ($oldPrices->has($hg) ? $oldPrices[$hg] : 0);
        });
        $calcNetworth += $bank;

        dump($calcNetworth);
        dump($calcNetworth == $networth);
        $stocks->each(function ($stock, $hg) use ($user_id) {
           echo "UPDATE stocks SET quantity = {$stock} WHERE houseguest_id = {$hg} AND user_id = {$user_id};". PHP_EOL;
        });
    }

    public function checkWeek($week, $user_id)
    {
        $transactions = Transaction::with('houseguest')
                                   ->whereHas('houseguest', function ($q) {
                                       $q->where('season_id', 2);
                                   })->where('user_id', $user_id)->where('week', $week)->get();

        $leaderboards = Leaderboard::where('user_id', $user_id)->where('season_id', 2)->get();

        $newPrices = Price::with('houseguest')->whereHas('houseguest', function ($hg) {
            $hg->where('season_id', 2);
        })->where('week', $week + 1)->get()->mapToAssoc(function ($price) {
            return [$price->houseguest->nickname, $price->price];
        });
        $oldPrices = Price::with('houseguest')->whereHas('houseguest', function ($hg) {
            $hg->where('season_id', 2);
        })->where('week', $week)->get()->mapToAssoc(function ($price) {
            return [$price->houseguest->nickname, $price->price];
        });

        $networth = ($week > 1) ? $leaderboards->where('week', $week)->first()->networth : 200;

        $nextNetworth = $leaderboards->where('week', $week + 1)->first()->networth;

        $stocks = Houseguest::where('season_id', 2)->withOutGlobalScope('active')->get()->mapToAssoc(function ($hg) use ($leaderboards, $week) {
            if ($week === 1) {
                return [$hg->nickname, 0];
            } else {
                return [$hg->nickname, $leaderboards->where('week', $week)->first()->stocks[$hg->id]];
            }
        });
        $stocks->each(function ($stock, $hg) use (&$networth, $oldPrices) {
            $networth -= $stock * ($oldPrices->has($hg) ? $oldPrices[$hg] : 0);
        });

        $transactions->each(function ($t) use (&$networth, &$stocks) {
            switch ($t->action) {
                case 'buy':
                    $stocks[$t->houseguest->nickname] += $t->quantity;
                    $networth -= $t->quantity * $t->current_price;
                    break;
                case 'sell':
                    $stocks[$t->houseguest->nickname] -= $t->quantity;
                    $networth += $t->quantity * $t->current_price;
                    break;
            }
            dump("{$networth} | {$t->action} {$t->quantity} of {$t->houseguest->nickname} at {$t->current_price}");
        });
        dump('---END OF WEEK---');
        $stocks->each(function ($stock, $hg) use (&$networth, $newPrices) {
            $networth += $stock * ($newPrices->has($hg) ? $newPrices[$hg] : 0);
        });
        $networth += 20.00;
        dump((float)$networth === (float)$nextNetworth);
        dump($networth);
        dump($nextNetworth);
        dump('-----------------');
    }
}
