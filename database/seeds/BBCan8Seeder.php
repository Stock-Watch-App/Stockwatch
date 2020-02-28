<?php

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
        $bbcan8 = \App\Models\Season::firstOrCreate(['name' => 'Big Brother Canada 8', 'short_name' => 'bbcan8']);

        Houseguest::create(['first_name' => 'chris', 'last_name' => 'wyllie', 'nickname' => 'chris', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'minh-ly', 'last_name' => 'nguyen-cao', 'nickname' => 'minh-ly', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'john luke', 'last_name' => 'kieper', 'nickname' => 'john luke', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'carol', 'last_name' => 'rosher', 'nickname' => 'carol', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'jamar', 'last_name' => 'lee', 'nickname' => 'jamar', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'rianne', 'last_name' => 'swanson', 'nickname' => 'rianne', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'hira', 'last_name' => 'deol', 'nickname' => 'hira', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'angie', 'last_name' => 'tackie', 'nickname' => 'angie', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'micheal', 'last_name' => 'stubley', 'nickname' => 'micheal', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'brooke', 'last_name' => 'warnock', 'nickname' => 'brooke', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'sheldon', 'last_name' => 'jean', 'nickname' => 'sheldon', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'susanne', 'last_name' => 'fuda', 'nickname' => 'susanne', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'kyle', 'last_name' => 'rozendal', 'nickname' => 'kyle', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'vanessa', 'last_name' => 'clements', 'nickname' => 'vanessa', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'nico', 'last_name' => 'vera', 'nickname' => 'nico', 'season_id' => $bbcan8->id]);
        Houseguest::create(['first_name' => 'madeline', 'last_name' => 'di nunzio', 'nickname' => '', 'season_id' => $bbcan8->id]);

    }
}
