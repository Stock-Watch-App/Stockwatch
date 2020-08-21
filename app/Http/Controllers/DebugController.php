<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Leaderboard;
use App\Models\User;
use App\Models\Week;
use App\Models\Season;

//use App\Nova\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $season = Season::current();
        $user = User::find(2);
        $user->load([
            'banks'       => function ($bank) use ($season) {
                $bank->where('season_id', $season->id);
            },
            'transactions',
            'stocks'      => function ($stock) use ($season) {
                $stock->with([
                    'houseguest' => function ($houseguest) {
                        $houseguest->withoutGlobalScope('active')->with('prices');
                    }
                ])->whereHas('houseguest', function ($houseguest) use ($season) {
                    $houseguest->withoutGlobalScope('active')
                               ->where('season_id', $season->id);
                });
            },
            'leaderboard' => function ($leaderboard) use ($season) {
                $leaderboard->where('season_id', $season->id);
            }
        ]);

        $l = $user->leaderboard->sortByDesc('week')->first()->networth;

        $s = $user->stocks->map(function ($stock) {
            $price = (float)$stock->houseguest->prices->sortByDesc('week')->first()->price;
            $quantity = (int)$stock->quantity;
            return $quantity * $price;
        })->sum() + $user->banks->first()->money;
        dump($l);
        dump($s);

    }
}
