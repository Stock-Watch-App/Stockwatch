<?php

namespace App\Models;

class Rating extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function rater()
    {
        return $this->belongsTo(User::class);
    }
    public function houseguest()
    {
        return $this->belongsTo(Houseguest::class);
    }
}
