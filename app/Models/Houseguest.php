<?php

namespace App\Models;

class Houseguest extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
