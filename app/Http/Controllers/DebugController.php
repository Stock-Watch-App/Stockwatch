<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function showme($route)
    {
        $vars = $this->getTempVars($route);
        $route = preg_replace('/\//', '.', $route);
        return view($route, $vars);
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
}
