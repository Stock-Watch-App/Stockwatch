<?php

namespace App\Jobs;

use App\Models\Anomaly;
use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function Clue\StreamFilter\fun;

class AuditUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $season;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->season = Season::current();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->tooManyBanks();
        $this->missingStocks();
        $this->tooManyStocks();
    }

    public function tooManyBanks()
    {
        $results = DB::table('banks')
                     ->select('user_id', DB::raw('count(1) as count'))
                     ->where('season_id', $this->season->id)
                     ->groupBy('user_id')
                     ->having('count', '>', 1)
                     ->get();

        $this->saveAnomalies($results, 'Too many banks');
    }

    public function missingStocks()
    {
        $results = DB::table('stocks')
                     ->select('stocks.user_id', DB::raw('count(1) as count'))
                     ->join('houseguests', function ($join) {
                         $join->on('stocks.houseguest_id', '=', 'houseguests.id');
                         $join->where('houseguests.status', '=', 'active');
                     })
                     ->where('houseguests.season_id', $this->season->id)
                     ->groupBy('stocks.user_id')
                     ->having('count', '<', Houseguest::where('season_id', $this->season->id)->get()->count())
                     ->get();

        $this->saveAnomalies($results, 'Missing stocks');
    }

    public function tooManyStocks()
    {
        $results = DB::table('stocks')
                     ->select('stocks.user_id', DB::raw('count(1) as count'))
                     ->join('houseguests', 'stocks.houseguest_id', '=', 'houseguests.id')
                     ->where('houseguests.season_id', $this->season->id)
                     ->groupBy('stocks.user_id')
                     ->having('count', '>', 16)
                     ->get();

        $this->saveAnomalies($results, 'Too many stocks');
    }

    public function saveAnomalies($results, $message)
    {
        $results->each(function ($result) use ($message) {
            Anomaly::firstOrCreate([
                'user_id'   => $result->user_id,
                'season_id' => $this->season->id,
                'week'      => $this->season->current_week,
                'message'   => $message
            ]);
        });
    }
}
