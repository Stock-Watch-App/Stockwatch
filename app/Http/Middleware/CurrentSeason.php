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
        return $next($request->merge(['season' => Season::current()]));
    }
}
