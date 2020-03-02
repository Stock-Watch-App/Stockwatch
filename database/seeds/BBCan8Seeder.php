<?php

use App\Models\Price;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Houseguest;

class BBCan8Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV', 'production') === 'local') {
            /**
             * U: test@test.com
             * P: password
             */
            User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => '$2y$10$TIvv.vwQkGiVgKLtLQjDiuJXfsCIIK/VseGropRW.Z0k36JwU.YyC']);
        }

        $robottaran = User::create(['name' => 'Robot Taran', 'email' => 'robottaran@realitystockwatch.com']);
        $robotbrent = User::create(['name' => 'Robot Brent', 'email' => 'robotbrent@realitystockwatch.com']);
        $robotmelissa = User::create(['name' => 'Robot Melissa', 'email' => 'robotmelissa@realitystockwatch.com']);
        $robotaudience = User::create(['name' => 'Robot Audience', 'email' => '$robotaudience@realitystockwatch.com']);

        $bbcan8 = \App\Models\Season::firstOrCreate(['name' => 'Big Brother Canada 8', 'short_name' => 'bbcan8', 'status' => 'pre-season']);

        $houseguests = [
            'chris'    => Houseguest::create(['first_name' => 'chris', 'last_name' => 'wyllie', 'nickname' => 'chris', 'season_id' => $bbcan8->id]),
            'minh'     => Houseguest::create(['first_name' => 'minh-ly', 'last_name' => 'nguyen-cao', 'nickname' => 'minh-ly', 'season_id' => $bbcan8->id]),
            'john'     => Houseguest::create(['first_name' => 'john luke', 'last_name' => 'kieper', 'nickname' => 'john luke', 'season_id' => $bbcan8->id]),
            'carol'    => Houseguest::create(['first_name' => 'carol', 'last_name' => 'rosher', 'nickname' => 'carol', 'season_id' => $bbcan8->id]),
            'jamar'    => Houseguest::create(['first_name' => 'jamar', 'last_name' => 'lee', 'nickname' => 'jamar', 'season_id' => $bbcan8->id]),
            'rianne'   => Houseguest::create(['first_name' => 'rianne', 'last_name' => 'swanson', 'nickname' => 'rianne', 'season_id' => $bbcan8->id]),
            'hira'     => Houseguest::create(['first_name' => 'hira', 'last_name' => 'deol', 'nickname' => 'hira', 'season_id' => $bbcan8->id]),
            'angie'    => Houseguest::create(['first_name' => 'angie', 'last_name' => 'tackie', 'nickname' => 'angie', 'season_id' => $bbcan8->id]),
            'micheal'  => Houseguest::create(['first_name' => 'micheal', 'last_name' => 'stubley', 'nickname' => 'micheal', 'season_id' => $bbcan8->id]),
            'brooke'   => Houseguest::create(['first_name' => 'brooke', 'last_name' => 'warnock', 'nickname' => 'brooke', 'season_id' => $bbcan8->id]),
            'sheldon'  => Houseguest::create(['first_name' => 'sheldon', 'last_name' => 'jean', 'nickname' => 'sheldon', 'season_id' => $bbcan8->id]),
            'susanne'  => Houseguest::create(['first_name' => 'susanne', 'last_name' => 'fuda', 'nickname' => 'susanne', 'season_id' => $bbcan8->id]),
            'kyle'     => Houseguest::create(['first_name' => 'kyle', 'last_name' => 'rozendal', 'nickname' => 'kyle', 'season_id' => $bbcan8->id]),
            'vanessa'  => Houseguest::create(['first_name' => 'vanessa', 'last_name' => 'clements', 'nickname' => 'vanessa', 'season_id' => $bbcan8->id]),
            'nico'     => Houseguest::create(['first_name' => 'nico', 'last_name' => 'vera', 'nickname' => 'nico', 'season_id' => $bbcan8->id]),
            'madeline' => Houseguest::create(['first_name' => 'madeline', 'last_name' => 'di nunzio', 'nickname' => '', 'season_id' => $bbcan8->id]),
        ];

        //rating
        foreach ($houseguests as $houseguest) {
            for ($i = 1; $i <= 4; $i++) {
                Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robottaran->id]);
                Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotbrent->id]);
                Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotmelissa->id]);
                Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotaudience->id]);
            }
        }

        //prices
        foreach ($houseguests as $houseguest) {
            Price::create(['price' => mt_rand (0.1*10, 20*10) / 10, 'houseguest_id' => $houseguest->id, 'week' => 1]);
            Price::create(['price' => mt_rand (0.1*10, 20*10) / 10, 'houseguest_id' => $houseguest->id, 'week' => 2]);
            Price::create(['price' => mt_rand (0.1*10, 20*10) / 10, 'houseguest_id' => $houseguest->id, 'week' => 3]);
            Price::create(['price' => mt_rand (0.1*10, 20*10) / 10, 'houseguest_id' => $houseguest->id, 'week' => 4]);
        }
    }
}
