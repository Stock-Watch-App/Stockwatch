<?php

use App\Models\Badge;
use App\Models\Image;
use App\Models\Leaderboard;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run()
    {
//        $this->bbcan7();
        $this->bb21();
        $this->bbcan8();
        $this->bb22();
    }

    public function bbcan7()
    {
        $season = Season::firstOrCreate(['short_name' => 'bbcan7'], [
            'name'         => 'Big Brother Canada 7',
            'status'       => 'ended',
            'current_week' => 0
        ]);

        $first = Badge::firstOrCreate([
            'name'      => 'BBCan 7 First Place',
            'rank'      => '1',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan7/BBCAN7_first.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $second = Badge::firstOrCreate([
            'name'      => 'BBCan 7 Second Place',
            'rank'      => '2',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan7/BBCAN7_second.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $third = Badge::firstOrCreate([
            'name'      => 'BBCan 7 Third Place',
            'rank'      => '3',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan7/BBCAN7_third.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfive = Badge::firstOrCreate([
            'name'      => 'BBCan 7 Top Five',
            'rank'      => '5',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan7/BBCAN7_topfive.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topten = Badge::firstOrCreate([
            'name'      => 'BBCan 7 Top Ten',
            'rank'      => '10',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan7/BBCAN7_topten.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);


//        User::find()->badges()->save($first); //
//        User::find()->badges()->save($second); //
//        User::find()->badges()->save($third); //
//        User::find()->badges()->save($topfive); //
//        User::find()->badges()->save($topfive); //
//        User::find()->badges()->save($topten); //
//        User::find()->badges()->save($topten); //
//        User::find()->badges()->save($topten); //
//        User::find()->badges()->save($topten); //
//        User::find()->badges()->save($topten); //
    }

    public function bb21()
    {
        $season = Season::firstOrCreate(['short_name' => 'bb21'], [
            'name'         => 'Big Brother 21',
            'status'       => 'ended',
            'current_week' => 0
        ]);

        $first = Badge::firstOrCreate([
            'name'      => 'BB21 First Place',
            'rank'      => '1',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb21/BB21_first.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $second = Badge::firstOrCreate([
            'name'      => 'BB21 Second Place',
            'rank'      => '2',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb21/BB21_second.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $third = Badge::firstOrCreate([
            'name'      => 'BB21 Third Place',
            'rank'      => '3',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb21/BB21_third.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfive = Badge::firstOrCreate([
            'name'      => 'BB21 Top Five',
            'rank'      => '5',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb21/BB21_topfive.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topten = Badge::firstOrCreate([
            'name'      => 'BB21 Top Ten',
            'rank'      => '10',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb21/BB21_topten.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);


        User::find(1727)->badges()->save($first); // HHRaptorPro
        User::find(1068)->badges()->save($second); // Justin Powell
        User::find(341)->badges()->save($third); // Taylor Allen
        User::find(4)->badges()->save($topfive); // Taran Armstrong
        User::find(12)->badges()->save($topfive); // Mel Hulst
//        User::find()->badges()->save($topten); // Action23
        User::find(986)->badges()->save($topten); // Andrew MacAskill
        User::find(895)->badges()->save($topten); // Gregory McBean
//        User::find()->badges()->save($topten); // Bridget Vellturo
        User::find(1339)->badges()->save($topten); // lyndoug
    }

    public function bbcan8()
    {
        $season = Season::firstOrCreate(['short_name' => 'bbcan8'], [
            'name'         => 'Big Brother Canada 8',
            'status'       => 'ended',
            'current_week' => 0
        ]);

        $first = Badge::firstOrCreate([
            'name'      => 'BBCan 8 First Place',
            'rank'      => '1',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_first.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $second = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Second Place',
            'rank'      => '2',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_second.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $third = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Third Place',
            'rank'      => '3',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_third.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfive = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top Five',
            'rank'      => '5',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_topfive.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topten = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top Ten',
            'rank'      => '10',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_topten.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $toponepercent = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top One Percent',
            'rank'      => '10',
            'type'      => 'percent',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_toponepercent.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfivepercent = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top Five Percent',
            'rank'      => '10',
            'type'      => 'percent',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bbcan8/BBCAN8_topfivepercent.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);

        $leaderboard = Leaderboard::where('season_id', $season->id)
                             ->where('week', $season->current_week)
                             ->orderBy('rank')->get();

        User::find(21)->badges()->save($first); // Teagan E.
        User::find(822)->badges()->save($second); // Jasmine C.
        User::find(408)->badges()->save($third); // Miss Priss
        User::find(788)->badges()->save($topfive); // Noah Arbz
        User::find(4)->badges()->save($topfive); // Taran Armstrong
        User::find(130)->badges()->save($topfive); // Dan W.
        User::find(1097)->badges()->save($topten); // Bill Hall
        User::find(322)->badges()->save($topten); // Shames Alchemy
        User::find(976)->badges()->save($topten); // mkfroboi
        User::find(593)->badges()->save($topten); // Detective Papaya

        $topone = $leaderboard->skip(10)->take(($leaderboard->count()/100)-10);
        $topone->each(function ($l) use ($toponepercent) {
            $l->user->badges()->save($toponepercent);
        });

        $topfive = $leaderboard->skip($topone->count())->take(($leaderboard->count()/20)-$topone->count());
        $topfive->each(function ($l) use ($topfivepercent) {
            $l->user->badges()->save($topfivepercent);
        });
    }

    public function bb22()
    {
        $season = Season::firstOrCreate(['short_name' => 'bb22'], [
            'name'         => 'Big Brother 22',
            'status'       => 'ended',
            'current_week' => 0
        ]);

        $first = Badge::firstOrCreate([
            'name'      => 'BB22 First Place',
            'rank'      => '1',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_first.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $second = Badge::firstOrCreate([
            'name'      => 'BB22 Second Place',
            'rank'      => '2',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_second.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $third = Badge::firstOrCreate([
            'name'      => 'BB22 Third Place',
            'rank'      => '3',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_third.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfive = Badge::firstOrCreate([
            'name'      => 'BB22 Top Five',
            'rank'      => '5',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_topfive.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topten = Badge::firstOrCreate([
            'name'      => 'BB22 Top Ten',
            'rank'      => '10',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_topten.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);

        $toponepercent = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top One Percent',
            'rank'      => '10',
            'type'      => 'percent',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_toponepercent.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfivepercent = Badge::firstOrCreate([
            'name'      => 'BBCan 8 Top Five Percent',
            'rank'      => '10',
            'type'      => 'percent',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/bb22/BB22_topfivepercent.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);

        $leaderboard = Leaderboard::where('season_id', $season->id)
                             ->where('week', $season->current_week)
                             ->orderBy('rank')->get();

        $leaderboard->where('rank', 1)->first()->user->badges()->save($first);
        $leaderboard->where('rank', 2)->first()->user->badges()->save($second);
        $leaderboard->where('rank', 3)->first()->user->badges()->save($third);
        $leaderboard->where('rank', 4)->first()->user->badges()->save($topfive);
        $leaderboard->where('rank', 5)->first()->user->badges()->save($topfive);
        $leaderboard->where('rank', 6)->first()->user->badges()->save($topten);
        $leaderboard->where('rank', 7)->first()->user->badges()->save($topten);
        $leaderboard->where('rank', 8)->first()->user->badges()->save($topten);
        $leaderboard->where('rank', 9)->first()->user->badges()->save($topten);
        $leaderboard->where('rank', 10)->first()->user->badges()->save($topten);

        $topone = $leaderboard->skip(10)->take(($leaderboard->count()/100)-10);
        $topone->each(function ($l) use ($toponepercent) {
            $l->user->badges()->save($toponepercent);
        });

        $topfive = $leaderboard->skip($topone->count())->take(($leaderboard->count()/20)-$topone->count());
        $topfive->each(function ($l) use ($topfivepercent) {
            $l->user->badges()->save($topfivepercent);
        });
    }
}
