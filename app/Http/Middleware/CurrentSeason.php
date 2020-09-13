<?php

namespace App\Http\Middleware;

use App\Models\Season;
use Closure;

class CurrentSeason
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //  Do not append the season to requests that have signed routes.
        //  This causes a 403 error.
        //  https://stackoverflow.com/a/54034735/5763389
        if ($request->route()->getName() != "verification.verify") {
            $request->merge(['season' => Season::current()]);
        }

        return $next($request);
    }
}
