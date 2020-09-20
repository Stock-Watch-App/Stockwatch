<?php

namespace App\Models;

class Session extends BaseModel
{
	public $timestamps = false;

    //=== RELATIONSHIPS ===//
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
