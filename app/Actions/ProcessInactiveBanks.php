<?php

namespace App\Actions;

use App\Models\Bank;
use App\Models\Season;
use Carbon\Carbon;

class ProcessInactiveBanks
{
    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        //  Update all banks as inactive whose user has
        //  no transactions made in the past 2 weeks and
        //  whose user was created more than 2 weeks ago.
        Bank::query()
            ->where('season_id', $this->season->id)
            ->whereDoesntHave('user.transactions', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->change('-2 weeks'));
            })
            ->whereHas('user', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->change('-2 weeks'));
            })
            ->update([
                'inactive_at' => Carbon::now()
            ]);
    }
}
