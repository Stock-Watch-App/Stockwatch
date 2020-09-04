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
    public function weeklyLeaderboards()
    {
        return $this->hasMany(Leaderboard::class, 'season_id', 'season_id')->whereRaw('`week` = `leaderboard`.`week`');
    }

    //=== SCOPES ===//
    public function scopeSearch($query, $terms)
    {
        collect(explode(' ', $terms))->filter()->each(function ($term) use ($query) {
            $term = "%{$term}%";
            $query->where(function ($builder) use ($term) {
                $builder->where('rank', $term)
                    ->orWhereHas('user', function ($builder) use ($term) {
                        $builder->where('name', 'like', $term);
                    });
            });
        });

        return $this;
    }

    //=== METHODS ===//

    //=== ATTRIBUTES ===//
    public function getPercentageRankingAttribute()
    {
        return $this->weekly_leaderboards_count > 0 ? ceil($this->rank / $this->weekly_leaderboards_count * 100) : 'n/a';
    }
}
