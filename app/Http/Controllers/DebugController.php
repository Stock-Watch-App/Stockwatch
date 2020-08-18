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

        $networth = DB::table('stocks')
                      ->select(DB::raw('stocks.user_id, ANY_VALUE(sum(stocks.quantity*prices.price)+banks.money) as networth'))
                      ->join('prices', 'stocks.houseguest_id', '=', 'prices.houseguest_id')
                      ->join('banks', 'stocks.user_id', '=', 'banks.user_id')
                      ->whereRaw('banks.season_id = ?', $season->id)
                      ->whereRaw('prices.season_id = ?', $season->id)
                      ->whereRaw('prices.week = ?', $season->current_week)
            ->whereRaw('stocks.user_id = 692')
                      ->groupBy('stocks.user_id')
                      ->orderByDesc('networth')
                      ->toSql();
        dd($networth);
    }
}
