<?php

namespace App\Models;

class Houseguest extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    //=== ATTRIBUTES ===//
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

        //=== SCOPES ===/
    public function scopeActive($query)
    {
        return $query->orWhere('status', 'active');
    }
    public function scopeEvicted($query)
    {
        return $query->orWhere('status', 'evicted');
    }
}
