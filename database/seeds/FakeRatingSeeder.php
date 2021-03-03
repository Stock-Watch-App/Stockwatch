<?php

use App\Models\Rating;
use App\Models\User;
use App\Models\Season;
use App\Models\Houseguest;
use Illuminate\Database\Seeder;

class FakeRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $season = Season::current();
        $houseguests = Houseguest::where('season_id', $season->id)->get();
        $taran = User::find(4);
        $guest = User::find(6);
        $melissa = User::find(9);
        $audience = User::find(1);

        foreach ($houseguests as $houseguest) {
            $t = Rating::create(['rating' => mt_rand(1, 10), 'houseguest_id' => $houseguest->id, 'week' => $season->current_week + 1, 'user_id' => $taran->id])->rating;
            $b = Rating::create(['rating' => mt_rand(1, 10), 'houseguest_id' => $houseguest->id, 'week' => $season->current_week + 1, 'user_id' => $guest->id])->rating;
            $m = Rating::create(['rating' => mt_rand(1, 10), 'houseguest_id' => $houseguest->id, 'week' => $season->current_week + 1, 'user_id' => $melissa->id])->rating;
            $a = Rating::create(['rating' => mt_rand(1, 10), 'houseguest_id' => $houseguest->id, 'week' => $season->current_week + 1, 'user_id' => $audience->id])->rating;
        }
    }
}
