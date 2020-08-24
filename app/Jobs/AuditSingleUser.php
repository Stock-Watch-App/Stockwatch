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
        //if they are not playing, there is no point to check anything
        if ($user->isPlaying()) {
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
//        if ($networth) {
//            //if the networth is broken, its not worth checking transactions
//            $this->checkTransactions($user);
//        }
            //update timestamp
            $user->timestamps = false;
            $user->last_audited_at = Carbon::now()->toDateTimeString();
            $user->save();
        }
    }

    public function checkNetworth(User $user)
    {
        $leaderboard = $user->leaderboard->sortByDesc('week')->first();

        if ($leaderboard === null) {
            $leaderboard = (new \stdClass());
            $leaderboard->networth = 200.00;
        }

        $stockTotal = $user->stocks->map(function ($stock) {
                $price = (float)$stock->houseguest->prices->sortByDesc('week')->first()->price;
                $quantity = (int)$stock->quantity;
                return $quantity * $price;
            })->sum() + $user->banks->first()->money;

        // if net worth does not match stocks
        // AND does not equal 200 (new player, accounted for above)
        // AND does not equal 220 (new player who manage to get stipend, accounted for below)
        if ((float)$leaderboard->networth !== (float)$stockTotal && (float)$stockTotal !== 220.00) {
            $this->saveAnomaly($user->id, 'Incorrect networth');
            return false;
        }
        return true;
    }


    public function checkTransactions(User $user)
    {
//        $season = Season::current();
//        $user = User::find(2);
//        $user->load([
//            'banks'       => function ($bank) use ($season) {
//                $bank->where('season_id', $season->id);
//            },
//            'transactions',
//            'stocks'      => function ($stock) use ($season) {
//                $stock->with([
//                    'houseguest' => function ($houseguest) {
//                        $houseguest->withoutGlobalScope('active')->with('prices');
//                    }
//                ])->whereHas('houseguest', function ($houseguest) use ($season) {
//                    $houseguest->withoutGlobalScope('active')
//                               ->where('season_id', $season->id);
//                });
//            },
//            'leaderboard' => function ($leaderboard) use ($season) {
//                $leaderboard->where('season_id', $season->id);
//            }
//        ]);
//
//        $l = $user->leaderboard->sortByDesc('week')->first();
//
//        //todo what is the point of running transactions?
//        dump($l);
//        dump($l->stocks);
//        //make array for stocks
//        collect($l->stocks)->each(function ($stock) {
//            //find starting point for bank
//        });
//        //run transactions
//
//        //match with current bank


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
