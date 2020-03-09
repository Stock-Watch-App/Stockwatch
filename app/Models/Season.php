<?php

namespace App\Models;

use App\Models\Bank;

class Season extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function houseguests()
    {
        return $this->hasMany(Houseguest::class);
    }
    public function banks()
    {
        return $this->hasMany(Bank::class);
    }
    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    //=== SCOPES ===/
    public function scopeCurrent($query)
    {
        return $query->orWhere('status', 'pre-season')
            ->orWhere('status', 'open')
            ->orWhere('status', 'closed')
            ->first();
    }
}
