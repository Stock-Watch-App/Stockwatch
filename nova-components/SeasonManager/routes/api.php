<?php

use App\Models\Houseguest;
use App\Models\Season;
use App\Models\VanityTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/season/current', function (Request $request) {
    return Season::current();
});

Route::post('/season/update/status', function (Request $request) {
    Season::current()->update(['status' => $request->all()['status']]);
});

Route::post('/save/tags', function (Request $request) {
    $data = $request->all();
    $search = [
        'season_id'     => $request->season->id,
        'week'          => $data['week'],
        'taggable_type' => Houseguest::class
    ];
    if ($data['tags']['hoh'] !== null) {
        VanityTag::firstOrCreate($search + ['tag' => 'HOH'], [
            'taggable_id' => Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $data['tags']['hoh'])->first()->id
        ]);
    }
    if ($data['tags']['veto'] !== null) {
        VanityTag::firstOrCreate($search + ['tag' => 'Veto'], [
            'taggable_id' => Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $data['tags']['veto'])->first()->id
        ]);
    }

    $nominated = VanityTag::where('season_id', $request->season->id)
                          ->where('week', $data['week'])
                          ->where('tag', 'Nominated')
                          ->with([
                              'taggable' => function ($q) {
                                  $q->withoutGlobalScope('active');
                              }
                          ])
                          ->get();

    while ($nominated->count() < 2) {
        dump($nominated->count());
        $tag = new VanityTag();
        $tag->season_id = $request->season->id;
        $tag->week = $data['week'];
        $tag->taggable_type = Houseguest::class;
        $nominated->push($tag);
    }
    if ($data['tags']['nom1'] !== null) {
        $nom = $nominated->first();
        $nom->taggable_id = Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $data['tags']['nom1'])->first()->id;
        $nom->save();
    }
    if ($data['tags']['nom2'] !== null) {
        $nom = $nominated->last();
        $nom->taggable_id = Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $data['tags']['nom2'])->first()->id;
        $nom->save();
    }
});

Route::get('/houseguests', function (Request $request) {
    return Houseguest::currentSeason()
                     ->withoutGlobalScope('active')
                     ->get();
});

Route::get('/week/{week}', function (Request $request, $week) {
    $tags = VanityTag::where('week', $week)
                     ->currentSeason()
                     ->with([
                         'taggable' => function ($q) {
                             $q->withoutGlobalScope('active');
                         }
                     ])
                     ->get();

    $ratings = Houseguest::currentSeason()
                          ->withoutGlobalScope('active')
                          ->with([
                              'ratings' => function ($q) use ($week) {
                                  $q->where('week', $week);
                              },
                              'ratings.user'
                          ])
                        ->orderBy('status')
                        ->orderBy('nickname')
                          ->get()
                          ->mapToAssoc(function ($h) {
                              return [$h->nickname, $h->ratings->mapToAssoc(function ($r) {
                                 return [explode(' ',$r->user->name)[0], $r->rating];
                              })];
                          });

//    dd()

    $results = [
        'tags'     => [
            'hoh'  => ($tag = $tags->where('tag', 'HOH')->first()) ? $tag->taggable->nickname : '',
            'veto' => ($tag = $tags->where('tag', 'Veto')->first()) ? $tag->taggable->nickname : '',
            'nom1' => ($tag = $tags->where('tag', 'Nominated')->first()) ? $tag->taggable->nickname : '',
            'nom2' => ($tag = $tags->where('tag', 'Nominated')->last()) ? $tag->taggable->nickname : '',
        ],
        'ratings' => $ratings
    ];
    return json_encode($results);
});
