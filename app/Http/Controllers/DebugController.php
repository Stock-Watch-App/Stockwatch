<?php

namespace App\Http\Controllers;

use App\Formula;
use App\Models\Houseguest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $num = [0.34,0.43,0.45,0.47,0.50,0.51,0.52,0.53,0.54,0.54,0.54,0.58,0.60,0.60,0.60,0.61,0.61,0.63,0.64,0.64,0.64,0.64,0.64,0.64,0.67,0.68,0.68,0.68,0.70,0.71,0.72,0.72,0.73,0.76,0.76,0.80,0.80,0.80,0.80,0.84,0.84,0.84,0.84,0.84,0.84,0.85,0.88,0.91,0.91,0.92,0.93,0.93,0.95,0.95,0.96,0.98,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.03,1.04,1.06,1.08,1.08,1.08,1.09,1.09,1.09,1.09,1.09,1.11,1.11,1.11,1.12,1.13,1.13,1.13,1.13,1.14,1.15,1.15,1.16,1.16,1.17,1.20,1.20,1.20,1.20,1.20,1.20,1.20,1.24,1.27,1.31,1.32,1.32,1.33,1.33,1.36,1.37,1.38,1.44,1.51,1.51,1.52,1.67,2.31,];

        foreach ($num as $n) {
            print_r(abs($n-1).PHP_EOL);
;        }
    }
}
