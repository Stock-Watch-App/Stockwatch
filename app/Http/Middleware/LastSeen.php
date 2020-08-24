<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class LastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        $user->timestamps = false;
        $user->last_seen = Carbon::now()->toDateTimeString();
        $user->save();

        return $next($request);
    }
}
