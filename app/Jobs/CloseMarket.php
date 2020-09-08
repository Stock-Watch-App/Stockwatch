<?php

namespace App\Jobs;

use App\Actions\CalculatePrices;
use App\Actions\GenerateLeaderboard;
use App\Actions\ZeroOutEvictees;
use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseMarket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        $this->season->status = 'closed';
        $this->season->save();
    }
}
