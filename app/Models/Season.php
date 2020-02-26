<?php

namespace App\Models;

class Season extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function houseguests()
    {
        return $this->hasMany(Houseguest::class);
    }
}
