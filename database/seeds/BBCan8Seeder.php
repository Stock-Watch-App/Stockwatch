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
        $robotaudience = User::create(['name' => 'Robot Audience', 'email' => 'robotaudience@realitystockwatch.com']);

        $bbcan8 = \App\Models\Season::firstOrCreate(['name' => 'Big Brother Canada 8', 'short_name' => 'bbcan8', 'status' => 'pre-season']);

        $houseguests = [
            'chris'    => Houseguest::create(['first_name' => 'Chris', 'last_name' => 'Wyllie', 'nickname' => 'Chris', 'season_id' => $bbcan8->id]),
            'minh'     => Houseguest::create(['first_name' => 'Minh-ly', 'last_name' => 'Nguyen-cao', 'nickname' => 'Minh-ly', 'season_id' => $bbcan8->id]),
            'john'     => Houseguest::create(['first_name' => 'John luke', 'last_name' => 'Kieper', 'nickname' => 'John luke', 'season_id' => $bbcan8->id]),
            'carol'    => Houseguest::create(['first_name' => 'Carol', 'last_name' => 'Rosher', 'nickname' => 'Carol', 'season_id' => $bbcan8->id]),
            'jamar'    => Houseguest::create(['first_name' => 'Jamar', 'last_name' => 'Lee', 'nickname' => 'Jamar', 'season_id' => $bbcan8->id]),
            'rianne'   => Houseguest::create(['first_name' => 'Rianne', 'last_name' => 'Swanson', 'nickname' => 'Rianne', 'season_id' => $bbcan8->id]),
            'hira'     => Houseguest::create(['first_name' => 'Hira', 'last_name' => 'Deol', 'nickname' => 'Hira', 'season_id' => $bbcan8->id]),
            'angie'    => Houseguest::create(['first_name' => 'Angie', 'last_name' => 'Tackie', 'nickname' => 'Angie', 'season_id' => $bbcan8->id]),
            'micheal'  => Houseguest::create(['first_name' => 'Micheal', 'last_name' => 'Stubley', 'nickname' => 'Micheal', 'season_id' => $bbcan8->id]),
            'brooke'   => Houseguest::create(['first_name' => 'Brooke', 'last_name' => 'Warnock', 'nickname' => 'Brooke', 'season_id' => $bbcan8->id]),
            'sheldon'  => Houseguest::create(['first_name' => 'Sheldon', 'last_name' => 'Jean', 'nickname' => 'Sheldon', 'season_id' => $bbcan8->id]),
            'susanne'  => Houseguest::create(['first_name' => 'Susanne', 'last_name' => 'Fuda', 'nickname' => 'Susanne', 'season_id' => $bbcan8->id]),
            'kyle'     => Houseguest::create(['first_name' => 'Kyle', 'last_name' => 'Rozendal', 'nickname' => 'Kyle', 'season_id' => $bbcan8->id]),
            'vanessa'  => Houseguest::create(['first_name' => 'Vanessa', 'last_name' => 'Clements', 'nickname' => 'Vanessa', 'season_id' => $bbcan8->id]),
            'nico'     => Houseguest::create(['first_name' => 'Nico', 'last_name' => 'Vera', 'nickname' => 'Nico', 'season_id' => $bbcan8->id]),
            'madeline' => Houseguest::create(['first_name' => 'Madeline', 'last_name' => 'Di Nunzio', 'nickname' => 'Madeline', 'season_id' => $bbcan8->id]),
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
