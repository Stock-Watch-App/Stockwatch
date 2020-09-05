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
        $total = (new WeeklyLeaderboards($this->season_id, $this->week))->count();

        if ($total == 0) {
            return 0;
        }

        return ceil($this->rank / $total * 100);
    }
}
