<?php

namespace App\Observers;

use App\Formula;
use App\Http\Controllers\MarketController;
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
                $m = new MarketController();
                $m->open($season);
            }
            if ($season->status === 'ended') {
                $m = new MarketController();
                $m->end($season);
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
