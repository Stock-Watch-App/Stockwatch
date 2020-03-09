<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends BaseModel
{
    protected $dates = [
        'week_start',
        'week_end'
    ];
    protected $cache_attributes = [
        'current'
    ];

    //=== RELATIONSHIPS ===//
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    //=== ATTRIBUTES ===//
    public function getCurrentAttribute()
    {
        return self::current()->week;
    }

    //=== SCOPES ===/
    public function scopeCurrent($query)
    {
        $current = date('Y-m-d');
        return $query->whereDate('week_start', '<', $current)
            ->whereDate('week_end', '>', $current)
            ->first();
    }
}
