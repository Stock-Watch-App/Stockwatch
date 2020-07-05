<?php

use App\Models\Houseguest;
use App\Models\Rating;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

Route::get('/rating-data/week/{week}', function (Request $request, $week) {
    if ($week === 'current') {
        $week = Season::current()->current_week;
    }

    //=== VERTICAL ===//
    $raters = User::role('lfc')->get(['id', 'name'])->mapToAssoc(static function ($user) {
        return [$user->id, $user->name];
    });

    $houseguests = Houseguest::with(['ratings' => static function ($q) use ($week) {
        $q->where('week', $week);
    }])->get()->map(static function ($hg) {
        return [
            'nickname' => $hg->nickname,
            'ratings' => $hg->ratings->mapToAssoc(static function ($rating) {
                return [$rating->user_id, $rating->rating];
            })
        ];
    });

    //=== HORIZONTAL ===//
//    $raters = User::role('lfc')
//                  ->with([
//                      'ratings' => static function ($q) use ($week) {
//                          $q->where('week', $week);
//                      }
//                  ])->get()
//                  ->map(static function ($u) {
//                      return [
//                          'name'    => $u->name,
//                          'ratings' => $u->ratings->mapToAssoc(static function ($rating) {
//                              return [$rating->houseguest_id, $rating->rating];
//                          })
//                      ];
//                  });
//
//    $houseguests = Houseguest::get(['id', 'nickname'])->mapToAssoc(static function ($hg) {
//        return [$hg->id, $hg->nickname];
//    });


    return json_encode([
        'raters'      => $raters,
        'houseguests' => $houseguests,
    ]);
});
