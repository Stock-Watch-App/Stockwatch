<?php

namespace App;

use App\Models\Leaderboard;
use Illuminate\Support\Facades\Cache;

class WeeklyLeaderboards
{
    protected $season;
    protected $week;

    public function __construct($season, $week)
    {
        $this->season = $season;
        $this->week = $week;
    }

    /**
     * Get a count of the weekly leaderboards.
     */
    public function count() : int
    {
        return Cache::remember("weekly_leaderboards_{$this->season}_{$this->week}", 10, function () {
            return Leaderboard::query()->where('season_id', $this->season)->where('week', $this->week)->count();
        });
    }
}
