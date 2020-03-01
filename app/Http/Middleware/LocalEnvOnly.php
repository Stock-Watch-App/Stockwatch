<?php

namespace App\Http\Middleware;

use Closure;

class LocalEnvOnly
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
        if ((env('APP_ENV', 'production') === 'local')) {
            return $next($request);
        }
        return redirect('404');
    }
}
