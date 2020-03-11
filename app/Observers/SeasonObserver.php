<?php

namespace App\Observers;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Season;
use App\Models\Week;

class SeasonObserver
{
    public function retrieved(Season $season){}
    public function creating(Season $season){}
    public function created(Season $season){}
    public function updating(Season $season){
        if ($season->isDirty('status')) {
            if ($season->status === 'open') {
                $f = new Formula();
                $week = Week::current()->week;

                $houseguests = Houseguest::where('season_id', $season->id)->get();
                foreach ($houseguests as $houseguest) {
                    if ($season->getOriginal('status') === 'closed') {
                        $rating = $houseguest->current_rate;
                        $last_rating = (int)round($houseguest->ratings()->where('week', $week - 1)->pluck('rating')->sum() / 4);
                        $last_price = $houseguest->prices()->where('week', $week - 1)->first()->value('price');

                        $new_price = $f->calculate($last_rating, $rating, $last_price, $houseguest->strikes);

                        Price::create(['price' => $new_price, 'houseguest_id' => $houseguest->id, 'week' => $week]);
                    }
                    if ($season->getOriginal('status') === 'pre-season') {
                        Price::create(['price' => $houseguest->current_rate, 'houseguest_id' => $houseguest->id, 'week' => $week]);
                    }
                }
            }
        }
    }
    public function updated(Season $season){}
    public function saving(Season $season){}
    public function saved(Season $season){}
    public function deleting(Season $season){}
    public function deleted(Season $season){}
    public function restoring(Season $season){}
    public function restored(Season $season){}
    public function forceDeleted(Season $season){}
}
