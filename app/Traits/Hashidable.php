<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait Hashidable
{
    public function getRouteKey()
    {
        return Hashids::connection(get_called_class())->encode($this->getKey());
    }

    public function getHashidAttribute()
    {
        return Hashids::connection(get_called_class())->encode($this->attributes['id']);
    }

    public static function findViaHash($hash)
    {
        $id = Hashids::connection(get_called_class())->decode($hash)[0] ?? null;
        return self::findOrFail($id);
    }
}
