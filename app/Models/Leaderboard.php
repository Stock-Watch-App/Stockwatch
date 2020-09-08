<?php

namespace App\Models;

use App\RankPercentile;
use App\WeeklyLeaderboards;

class Leaderboard extends BaseModel
{
    protected $table = 'leaderboard';

    protected $casts = [
        'stocks' => 'array'
    ];

    protected $appends = [
        'rank_percentile'
    ];

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //=== METHODS ===//
    public function getRankPercentileAttribute()
    {
        return (new RankPercentile($this))->calculate();
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    //=== SCOPES ===//
    public function scopeWhereSeasonEnded($query)
    {
        $query->whereHas('season', function ($query) {
            $query->where('status', 'ended');
        });
    }

    //=== METHODS ===//
}
