<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends BaseModel
{
    protected $casts = [
        'active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
