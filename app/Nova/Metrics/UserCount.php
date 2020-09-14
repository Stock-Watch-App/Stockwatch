<?php

namespace App\Nova\Metrics;

use App\Models\Season;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use App\Models\User;

class UserCount extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result(User::count());
//        return $this->result($this->currentSeason())->previous($this->lastSeason());
//        return $this->count($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
//    public function ranges()
//    {
//        return [
//            30 => '30 Days',
//            60 => '60 Days',
//            365 => '365 Days',
//            'TODAY' => 'Today',
//            'MTD' => 'Month To Date',
//            'QTD' => 'Quarter To Date',
//            'YTD' => 'Year To Date',
//        ];
//    }

    public function currentSeason()
    {
        return User::whereDate('created_at', '>=', Season::current()->created_at)->count();
    }
    public function lastSeason()
    {
        return User::whereDate('created_at', '<', Season::current()->created_at)->count();
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-count';
    }
}
