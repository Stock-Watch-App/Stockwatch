<?php

namespace App\Models;

class Session extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
