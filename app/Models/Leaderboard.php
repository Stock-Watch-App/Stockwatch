<?php

namespace App\Models;

use App\WeeklyLeaderboards;

class Leaderboard extends BaseModel
{
    protected $table = 'leaderboard';

    protected $casts = [
        'stocks' => 'array'
    ];

    protected $appends = [
        'rank_percentage'
    ];

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //=== METHODS ===//

    //=== ATTRIBUTES ===//
    public function getRankPercentageAttribute()
    {
        return ceil($this->rank / (new WeeklyLeaderboards($this->season_id, $this->week))->count() * 100);
    }
}
