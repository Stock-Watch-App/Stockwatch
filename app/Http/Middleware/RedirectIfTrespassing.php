<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class RedirectIfTrespassing
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
        if (strpos($request->fullUrl(), 'admin.realitystockwatch.com') !== false
        && $request->user()->permissions->isEmpty()
        && $request->user()->roles->isEmpty()) {
            return Redirect::to('realitystockwatch.com/'.$request->requestUri());
        }
        return $next($request);
    }
}
