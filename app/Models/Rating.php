<?php

namespace App\Models;

class Rating extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function rater()
    {
        $this->belongsTo(User::class);
    }
}
