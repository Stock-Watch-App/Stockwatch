<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends BaseModel
{
    public function user()
    {
        return $this->hasOne(User::class, 'avatar_id');
    }
    public function badge()
    {
        return $this->hasOne(Badge::class);
    }
}
