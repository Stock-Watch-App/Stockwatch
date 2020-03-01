<?php

namespace App\Models;

use App\Formula;

class Houseguest extends BaseModel
{

    public $projectionsComputed;

    protected $cache_attributes = [
        'projection',
        'current_rate',
        'current_price',
    ];

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

    //=== ATTRIBUTES ===//
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    public function getCurrentPriceAttribute(){
        return (float) $this->prices()->limit(1)->orderBy('week', 'desc')->value('price');
    }
    public function getCurrentRateAttribute(){
        return (int) round($this->ratings()->limit(4)->orderBy('week', 'desc')->pluck('rating')->sum()/4);
    }
//    public function getAttribute(){}

    public function getProjectionAttribute()
    {
        $formula = new Formula();

        $projections = [
          'to1' => $formula->calculate($this->current_rate, 1, $this->current_price),
          'to2' => $formula->calculate($this->current_rate, 2, $this->current_price),
          'to3' => $formula->calculate($this->current_rate, 3, $this->current_price),
          'to4' => $formula->calculate($this->current_rate, 4, $this->current_price),
          'to5' => $formula->calculate($this->current_rate, 5, $this->current_price),
          'to6' => $formula->calculate($this->current_rate, 6, $this->current_price),
          'to7' => $formula->calculate($this->current_rate, 7, $this->current_price),
          'to8' => $formula->calculate($this->current_rate, 8, $this->current_price),
          'to9' => $formula->calculate($this->current_rate, 9, $this->current_price),
          'to10' => $formula->calculate($this->current_rate, 10, $this->current_price),
        ];

        return $projections;
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
}
