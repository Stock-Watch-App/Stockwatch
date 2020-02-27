<?php

namespace App\Models;

class Stock extends BaseModel
{

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function houseguest()
    {
        return $this->belongsTo(Houseguest::class);
    }
}
