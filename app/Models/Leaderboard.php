<?php

namespace App\Models;

use DB;

class Leaderboard extends BaseModel
{
    protected $table = 'leaderboard';

    protected $casts = [
        'stocks' => 'array'
    ];

    protected $appends = [
        'percentage_ranking'
    ];

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function seasonalLeaderboards()
    {
        return $this->hasMany(Leaderboard::class, 'season_id', 'season_id');
    }

    //=== SCOPES ===//

    //=== METHODS ===//

    //=== ATTRIBUTES ===//
    public function getPercentageRankingAttribute()
    {
        return $this->seasonal_leaderboards_count > 0 ? round($this->rank / $this->seasonal_leaderboards_count * 100) : 'n/a';
    }
}
