<?php

namespace App\Observers;

use App\Models\Houseguest;
use Illuminate\Support\Str;

class HouseguestObserver
{
    public function retrieved(Houseguest $houseguest)
    {
    }

    public function creating(Houseguest $houseguest)
    {
        if ($houseguest->nickname === null) {
            $houseguest->nickname = $houseguest->first_name;
        }

        if ($houseguest->slug == null) {
            $houseguest->slug = Str::slug($houseguest->name);
        }
    }

    public function created(Houseguest $houseguest)
    {
    }

    public function updating(Houseguest $houseguest)
    {
    }

    public function updated(Houseguest $houseguest)
    {
    }

    public function saving(Houseguest $houseguest)
    {
    }

    public function saved(Houseguest $houseguest)
    {
    }

    public function deleting(Houseguest $houseguest)
    {
    }

    public function deleted(Houseguest $houseguest)
    {
    }

    public function restoring(Houseguest $houseguest)
    {
    }

    public function restored(Houseguest $houseguest)
    {
    }

    public function forceDeleted(Houseguest $houseguest)
    {
    }
}
