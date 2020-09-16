<?php

namespace App\Models;

use App\Formula;
use Illuminate\Database\Eloquent\Builder;

class Houseguest extends BaseModel
{

    public $projectionsComputed;

    protected $cache_attributes = [
        'projection',
        'current_rate',
        'current_price',
        'strikes',
    ];

    protected $appends = [
        'current_rate',
        'current_price'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', 'active')
                    ->orderBy('nickname', 'asc');
        });
    }

    //=== RELATIONSHIPS ===//
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function vanitytags()
    {
        return $this->morphOne(VanityTag::class, 'taggable');
    }

    //=== ATTRIBUTES ===//
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function getCurrentPriceAttribute()
    {
        return (float)$this->prices()->limit(1)->where('week', Season::current()->current_week)->value('price');
    }

    public function getCurrentRateAttribute()
    {
        return (int)round($this->ratings()->limit(4)->where('week', Season::current()->current_week)->pluck('rating')->sum() / 4);
    }

    public function getStrikesAttribute()
    {
        return $this->ratings()
                    ->groupBy('week')
                    ->selectRaw('round(sum(rating)/count(1)) as average_rating')
                    ->pluck('average_rating')
                    ->filter(function ($value) {
                        return $value <= 4;
                    })
                    ->count();
    }

//    public function getAttribute(){}

    public function getProjectionsAttribute()
    {
        $formula = new Formula();

        return [
            'to1'  => $formula->calculate($this->current_rate, 1, $this->current_price, $this->strikes + 1),
            'to2'  => $formula->calculate($this->current_rate, 2, $this->current_price, $this->strikes + 1),
            'to3'  => $formula->calculate($this->current_rate, 3, $this->current_price, $this->strikes + 1),
            'to4'  => $formula->calculate($this->current_rate, 4, $this->current_price, $this->strikes + 1),
            'to5'  => $formula->calculate($this->current_rate, 5, $this->current_price, $this->strikes),
            'to6'  => $formula->calculate($this->current_rate, 6, $this->current_price, $this->strikes),
            'to7'  => $formula->calculate($this->current_rate, 7, $this->current_price, $this->strikes),
            'to8'  => $formula->calculate($this->current_rate, 8, $this->current_price, $this->strikes),
            'to9'  => $formula->calculate($this->current_rate, 9, $this->current_price, $this->strikes),
            'to10' => $formula->calculate($this->current_rate, 10, $this->current_price, $this->strikes),
        ];
    }

    //=== SCOPES ===/
    public function scopeActive($query)
    {
        return $query->orWhere('status', 'active');
    }

    public function scopeEvicted($query)
    {
        return $query->orWhere('status', 'evicted');
    }

    public function scopeCurrentSeason($query)
    {
        return $query->whereHas('season', function($q) {
            $q->where('id', Season::current()->id);
        });
    }
}
