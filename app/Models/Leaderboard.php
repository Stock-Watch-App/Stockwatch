<?php

namespace App\Models;

use App\WeeklyLeaderboards;

class Leaderboard extends BaseModel
{
    protected $table = 'leaderboard';

    protected $casts = [
        'stocks' => 'array'
    ];

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //=== METHODS ===//
}
