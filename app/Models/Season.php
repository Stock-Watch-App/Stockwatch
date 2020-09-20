<?php

namespace App\Models;

use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Season extends BaseModel
{
    protected $dates = [
        'closes_at',
    ];

    //=== RELATIONSHIPS ===//
    public function houseguests()
    {
        return $this->hasMany(Houseguest::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    //=== SCOPES ===/
    public function scopeCurrent($query)
    {
        if (request()->has('season')) {
            return request()->get('season');
        }

        $season = $query->orWhere('status', 'pre-season')
                        ->orWhere('status', 'open')
                        ->orWhere('status', 'closed')
                        ->first();
        if ($season === null) {
            $season = $query->orWhere('status', 'ended')
                            ->orderBy('created_at', 'desc')
                            ->first();
        }
        return $season;
    }

    //=== ATTRIBUTES ===//
    public function getClosesAtAttribute()
    {
        if (isset($this->attributes['closes_at']))
            return Carbon::parse($this->attributes['closes_at']);
        return null;
    }

    public function setClosesAtAttribute($value)
    {
        $this->attributes['closes_at'] = Carbon::parse($value)->format('H:i');
    }
}
