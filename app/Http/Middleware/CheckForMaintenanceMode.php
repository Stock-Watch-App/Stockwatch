<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\IpUtils;

class CheckForMaintenanceMode extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'maintenance',
    ];

    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

            if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array)$data['allowed'])) {
                return $next($request);
            }

            if ($this->inExceptArray($request)) {
                return $next($request);
            }

            return redirect('/maintenance');
        }

        return $next($request);
    }
}
