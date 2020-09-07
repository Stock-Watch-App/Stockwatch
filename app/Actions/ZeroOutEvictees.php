<?php

namespace App\Actions;

use App\Formula;
use App\Models\Houseguest;
use App\Models\Price;
use App\Models\Season;

class ZeroOutEvictees
{
    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        $houseguests = Houseguest::withoutGlobalScope('active')
                                 ->where('status', 'evicted')
                                 ->where('season_id', $this->season->id)
                                 ->get();

        $houseguests->each(function ($houseguest) {
            Price::create([
                'price'         => 0.00,
                'houseguest_id' => $houseguest->id,
                'season_id'     => $this->season->id,
                'week'          => $this->season->current_week
            ]);
        });
    }
}
