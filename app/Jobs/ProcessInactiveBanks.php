<?php

namespace App\Jobs;

use App\Actions\ProcessInactiveBanks as ProcessInactiveBanksAction;
use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInactiveBanks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $season;

    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function handle()
    {
        (new ProcessInactiveBanksAction($this->season))->handle();
    }
}
