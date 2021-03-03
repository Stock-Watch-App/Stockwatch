<?php

use App\Models\Price;
use App\Models\Rating;
use App\Models\User;
use App\Models\Week;
use Illuminate\Database\Seeder;
use App\Models\Houseguest;

class BBCan8TestingSeeder extends Seeder
{

    public $number_of_week_to_mock = 1;

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
        $robotguest = User::create(['name' => 'Robot Guest', 'email' => 'robotguest@realitystockwatch.com']);
        $robotmelissa = User::create(['name' => 'Robot Melissa', 'email' => 'robotmelissa@realitystockwatch.com']);
        $robotaudience = User::create(['name' => 'Robot Audience', 'email' => 'robotaudience@realitystockwatch.com']);

        $bbcan8 = \App\Models\Season::firstOrCreate(['name' => 'Big Brother Canada 8', 'short_name' => 'bbcan8', 'status' => 'pre-season']);

        Week::create(['week' => 1, 'week_start' => '2020-02-29', 'week_end' => '2020-03-05', "season_id" => $bbcan8->id]);
        Week::create(['week' => 2, 'week_start' => '2020-03-06', 'week_end' => '2020-03-12', "season_id" => $bbcan8->id]);
        Week::create(['week' => 3, 'week_start' => '2020-03-13', 'week_end' => '2020-03-19', "season_id" => $bbcan8->id]);
        Week::create(['week' => 4, 'week_start' => '2020-03-20', 'week_end' => '2020-03-26', "season_id" => $bbcan8->id]);
        Week::create(['week' => 5, 'week_start' => '2020-03-27', 'week_end' => '2020-04-02', "season_id" => $bbcan8->id]);
        Week::create(['week' => 6, 'week_start' => '2020-04-03', 'week_end' => '2020-04-09', "season_id" => $bbcan8->id]);
        Week::create(['week' => 7, 'week_start' => '2020-04-10', 'week_end' => '2020-04-16', "season_id" => $bbcan8->id]);
        Week::create(['week' => 8, 'week_start' => '2020-04-17', 'week_end' => '2020-04-23', "season_id" => $bbcan8->id]);
        Week::create(['week' => 9, 'week_start' => '2020-04-24', 'week_end' => '2020-04-30', "season_id" => $bbcan8->id]);
        Week::create(['week' => 10, 'week_start' => '2020-05-01', 'week_end' => '2020-05-07', "season_id" => $bbcan8->id]);
        Week::create(['week' => 11, 'week_start' => '2020-05-08', 'week_end' => '2020-05-14', "season_id" => $bbcan8->id]);
        Week::create(['week' => 12, 'week_start' => '2020-05-15', 'week_end' => '2020-05-21', "season_id" => $bbcan8->id]);

        $houseguests = [
            'chris'    => Houseguest::create(['first_name' => 'Chris', 'last_name' => 'Wyllie', 'nickname' => 'Chris', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/chris.jpg']),
            'minh'     => Houseguest::create(['first_name' => 'Minh-ly', 'last_name' => 'Nguyen-cao', 'nickname' => 'Minh-ly', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/minh-ly.jpg']),
            'john'     => Houseguest::create(['first_name' => 'John luke', 'last_name' => 'Kieper', 'nickname' => 'John Luke', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/john-luke.jpg']),
            'carol'    => Houseguest::create(['first_name' => 'Carol', 'last_name' => 'Rosher', 'nickname' => 'Carol', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/carol.jpg']),
            'jamar'    => Houseguest::create(['first_name' => 'Jamar', 'last_name' => 'Lee', 'nickname' => 'Jamar', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/jamar.jpg']),
            'rianne'   => Houseguest::create(['first_name' => 'Rianne', 'last_name' => 'Swanson', 'nickname' => 'Rianne', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/rianne.jpg']),
            'hira'     => Houseguest::create(['first_name' => 'Hira', 'last_name' => 'Deol', 'nickname' => 'Hira', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/hira.jpg']),
            'angie'    => Houseguest::create(['first_name' => 'Angie', 'last_name' => 'Tackie', 'nickname' => 'Angie', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/angie.jpg']),
            'micheal'  => Houseguest::create(['first_name' => 'Micheal', 'last_name' => 'Stubley', 'nickname' => 'Micheal', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/micheal.jpg']),
            'brooke'   => Houseguest::create(['first_name' => 'Brooke', 'last_name' => 'Warnock', 'nickname' => 'Brooke', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/brooke.jpg']),
            'sheldon'  => Houseguest::create(['first_name' => 'Sheldon', 'last_name' => 'Jean', 'nickname' => 'Sheldon', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/sheldon.jpg']),
            'susanne'  => Houseguest::create(['first_name' => 'Susanne', 'last_name' => 'Fuda', 'nickname' => 'Susanne', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/susanne.jpg']),
            'kyle'     => Houseguest::create(['first_name' => 'Kyle', 'last_name' => 'Rozendal', 'nickname' => 'Kyle', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/kyle.jpg']),
            'vanessa'  => Houseguest::create(['first_name' => 'Vanessa', 'last_name' => 'Clements', 'nickname' => 'Vanessa', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/vanessa.jpg']),
            'nico'     => Houseguest::create(['first_name' => 'Nico', 'last_name' => 'Vera', 'nickname' => 'Nico', 'season_id' => $bbcan8->id, 'status' => 'evicted', 'image' => '/houseguests/bbcan8/nico.jpg']),
            'madeline' => Houseguest::create(['first_name' => 'Madeline', 'last_name' => 'Di Nunzio', 'nickname' => 'Madeline', 'season_id' => $bbcan8->id, 'image' => '/houseguests/bbcan8/madeline.jpg']),
        ];

        //rating
        $price = 0;
        $old = 0;
        $f = new \App\Formula();
        foreach ($houseguests as $houseguest) {
            for ($i = 1; $i <= $this->number_of_week_to_mock; $i++) {
                $t = Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robottaran->id])->rating;
                $b = Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotguest->id])->rating;
                $m = Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotmelissa->id])->rating;
                $a = Rating::create(['rating' => mt_rand(1,10), 'houseguest_id' => $houseguest->id, 'week' => $i, 'user_id' => $robotaudience->id])->rating;
                $rating = round(($t+$b+$m+$a)/4);

                if ($i === 1) {
                    $price = round(($t + $b + $m + $a) / 4);
                } else if ($i === $this->number_of_week_to_mock) {
                    continue;
                } else {
                    $price = $f->calculate($old, $rating, $price, $houseguest->strikes);
                }

                Price::create(['price' => $price, 'houseguest_id' => $houseguest->id, 'week' => $i]);
                $old = $rating;
            }
        }

    }
}
