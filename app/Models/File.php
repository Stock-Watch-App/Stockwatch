<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;

class File extends BaseModel
{
    use Userstamps;

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
