<?php

namespace App\Models;

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
