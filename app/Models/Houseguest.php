<?php

namespace App\Models;

class Houseguest extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function season()
    {
        $this->belongsTo(Season::class);
    }
}
