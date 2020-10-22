<?php

use App\Models\Badge;
use App\Models\Image;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run()
    {
        $this->bb21();
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
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/BB21_first.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $second = Badge::firstOrCreate([
            'name'      => 'BB21 Second Place',
            'rank'      => '2',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/BB21_second.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $third = Badge::firstOrCreate([
            'name'      => 'BB21 Third Place',
            'rank'      => '3',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/BB21_third.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topfive = Badge::firstOrCreate([
            'name'      => 'BB21 Top Five',
            'rank'      => '5',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/BB21_topfive.svg', 'mime_type' => 'image/svg+xml'])->id
        ]);
        $topten = Badge::firstOrCreate([
            'name'      => 'BB21 Top Ten',
            'rank'      => '10',
            'type'      => 'ordinal',
            'season_id' => $season->id,
            'image_id'  => Image::firstOrCreate(['filename' => '/badges/BB21_topten.svg', 'mime_type' => 'image/svg+xml'])->id
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
}
