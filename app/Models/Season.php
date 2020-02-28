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
}
