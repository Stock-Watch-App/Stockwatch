<?php

namespace App\Models;

class Season extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function houseguests()
    {
        $this->hasMany(Houseguest::class);
    }
}
