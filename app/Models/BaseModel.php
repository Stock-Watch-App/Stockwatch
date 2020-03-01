<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = ['id'];

    private $cached_attributes = [];

    protected $cache_attributes = [];

    public function getAttribute($key)
    {
        if (!$key) {
            return;
        }

        $cacheable = in_array($key, $this->cache_attributes);

        if ($cacheable && array_key_exists($key, $this->cached_attributes)) {
            return $this->cached_attributes[$key];
        }

        $value = parent::getAttribute($key);

        if ($cacheable) {
            $this->cached_attributes[$key] = $value;
        }

        return $value;
    }

    public function refreshAttribute($key)
    {
        if (!in_array($key, $this->cache_attributes)) {
             return false;
        }

        $value = parent::getAttribute($key);

        $this->cached_attributes[$key] = $value;

        return $value;
    }

    public function dumpCache()
    {
        $this->cached_attributes = [];

        return $this;
    }
}
