<?php

namespace App\Jobs;

use App\Models\Anomaly;
use App\Models\Season;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class AuditSingleUser implements ShouldQueue
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
     * @param User $user
     * @return void
     */
    public function handle(User $user)
    {
        // load user
        $user->load([
            'banks'  => function ($bank) {
                $bank->where('season_id', $this->season->id);
            },
            'transactions',
            'stocks' => function ($stock) {
                $stock->with(['houseguest.prices'])
                      ->whereHas('houseguest', function ($houseguest) {
                          $houseguest->withoutGlobalScope('active')
                                     ->where('season_id', $this->season->id);
                      });
            },
            'leaderboard'
        ]);
        //run checks
        $networth = $this->checkNetworth($user);
        if ($networth) {
            //if the networth is broken, its not worth checking transactions
            $this->checkTransactions($user);
        }
        //update timestamp
        $user->timestamps = false;
        $user->last_audited_at = Carbon::now()->toDateTimeString();
        $user->save();
    }

    public function checkNetworth(User $user)
    {
        $leaderboard = $user->leaderboard->sortByDesc('week')->first();

        $stockTotal = $user->stocks->map(function ($stock) {
            $price = (float)$stock->houseguest->prices->sortByDesc('week')->first()->price;
            $quantity = (int)$stock->quantity;
            return $quantity * $price;
        })->sum() + $user->banks->first()->money;

        if ((float)$leaderboard->networth !== (float)$stockTotal) {
            $this->saveAnomaly($user->id, 'Incorrect networth');
            return false;
        }
        return true;
    }


    public function checkTransactions(User $user)
    {
        $leaderboard = $user->leaderboard->sortByDesc('week')->first();


    }

    public function saveAnomaly($user_id, $message)
    {
        Anomaly::firstOrCreate([
            'user_id'   => $user_id,
            'season_id' => $this->season->id,
            'week'      => $this->season->current_week,
            'message'   => $message
        ]);
    }
}
