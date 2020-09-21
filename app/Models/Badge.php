<?php

namespace App\Models;

class Badge extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
