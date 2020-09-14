<?php

namespace App\Models;


use App\Models\Season;
use App\Models\User;

class VanityTag extends BaseModel
{
    //=== RELATIONSHIPS ==//
    public function taggable()
    {
        return $this->morphTo();
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
