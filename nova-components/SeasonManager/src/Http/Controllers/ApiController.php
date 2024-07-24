<?php

namespace Stockwatch\SeasonManager\Http\Controllers;

use App\Models\Houseguest;
use App\Models\Rating;
use App\Models\Season;
use App\Models\User;
use App\Models\VanityTag;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{

    //=== ROUTES ===//
    public function getCurrentSeason(Request $request)
    {
        return Season::current();
    }

    public function getSeasonStatus(Request $request)
    {
        return Season::current()->update(['status' => $request->all()['status']]);

    }

    public function saveTags(Request $request)
    {

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
            $tag = new VanityTag();
            $tag->season_id = $request->season->id;
            $tag->week = $data['week'];
            $tag->taggable_type = Houseguest::class;
            $tag->tag = 'Nominated';
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
    }

    public function saveRating(Request $request, $rating, $week, $houseguest, $lfc)
    {
        if ($houseguest->season->status === 'ended') {
            $houseguest = Houseguest::where('slug', $houseguest->slug)->where('season_id', Season::current()->id)->first();
        }
        $user = User::where('id', $lfc)->role('lfc')->first();
        $ratingModel = Rating::updateOrCreate([
            'week'          => $week,
            'user_id'       => $user->id,
            'houseguest_id' => $houseguest->id
        ], [
            'rating' => $rating
        ]);

        return json_encode(['success' => ($ratingModel->rating === $rating)]);
    }

    public function getHouseguests()
    {
        return Houseguest::currentSeason()
                         ->withoutGlobalScope('active')
                         ->get();
    }

    public function getLfc()
    {
        return User::role('lfc')->get()->mapToAssoc(function ($user) {
            return [explode(' ', $user->name)[0], $user->id];
        });
    }

    public function getWeeklyData($week)
    {
        $tags = VanityTag::where('week', $week)
                         ->currentSeason()
                         ->with([
                             'taggable' => function ($q) {
                                 $q->withoutGlobalScope('active');
                             }
                         ])
                         ->get();

        $results = [
            'tags'        => [
                'hoh'  => ($tag = $tags->where('tag', 'HOH')->first()) ? $tag->taggable->nickname : '',
                'veto' => ($tag = $tags->where('tag', 'Veto')->first()) ? $tag->taggable->nickname : '',
                'nom1' => ($tag = $tags->where('tag', 'Nominated')->first()) ? $tag->taggable->nickname : '',
                'nom2' => ($tag = $tags->where('tag', 'Nominated')->last()) ? $tag->taggable->nickname : '',
            ],
            'houseguests' => [
                'active'  => $this->getActiveHouseguests($week),
                'evicted' => $this->getEvictedHouseguests($week)
            ]
        ];
        return json_encode($results);
    }

    public function evict($nickname)
    {
        $hg = Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $nickname)->first();
        $hg->status = 'evicted';
        $hg->save();

    }

    public function unevict($nickname)
    {
        $hg = Houseguest::withoutGlobalScope('active')->currentSeason()->where('nickname', $nickname)->first();
        $hg->status = 'active';
        $hg->save();

    }

    //=== UTILITIES ===//
    protected function getActiveHouseguests($week)
    {
        if ($week > Season::current()->current_week) {
            //next week, ready for input
            return Houseguest::currentSeason()
                             ->with([
                                 'ratings' => function ($q) use ($week) {
                                     $q->where('week', $week);
                                 },
                                 'ratings.user'
                             ])
                             ->orderBy('nickname')
                             ->get()
                             ->mapToAssoc(function ($houseguest) {
                                 return [
                                     $houseguest->nickname,
                                     [
                                         'status'  => 'active', // spoof for historical weeks. Status is determined by existence of ratings.
                                         'ratings' => collect([
                                             'Taran'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Melissa'  => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Guest'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Audience' => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                         ])->merge($houseguest->ratings->mapToAssoc(function ($r) {
                                             return [
                                                 explode(' ', $r->user->name)[0],
                                                 [
                                                     'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                     'rating' => $r->rating
                                                 ]
                                             ];
                                         }))
                                     ]
                                 ];
                             });
        } else {
            //historical week
            return Houseguest::currentSeason()
                             ->withoutGlobalScope('active')
                             ->whereHas('ratings', function ($q) use ($week) {
                                 $q->where('week', $week);
                             })
                             ->with([
                                 'ratings' => function ($q) use ($week) {
                                     $q->where('week', $week);
                                 },
                                 'ratings.user'
                             ])
                             ->orderBy('nickname')
                             ->get()
                             ->mapToAssoc(function ($houseguest) {
                                 return [
                                     $houseguest->nickname,
                                     [
                                         'status'  => 'active', // spoof for historical weeks. Status is determined by existence of ratings.
                                         'saved'   => false, // value for vue to use to denote if an updated value is saved to the db
                                         'ratings' => $houseguest->ratings->mapToAssoc(function ($r) {
                                             return [
                                                 explode(' ', $r->user->name)[0],
                                                 [
                                                     'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                     'rating' => $r->rating
                                                 ]
                                             ];
                                         })
                                     ]
                                 ];
                             });
        }

    }

    protected function getEvictedHouseguests($week)
    {
        if ($week > Season::current()->current_week) {
            //next week, ready for input
            return Houseguest::currentSeason()
                             ->withoutGlobalScope('active')
                             ->where('status', 'evicted')
                             ->orderByDesc('updated_at')
                             ->get()
                             ->mapToAssoc(function ($houseguest) {
                                 return [
                                     $houseguest->nickname,
                                     [
                                         'status'  => 'evicted', // spoof for historical weeks. Status is determined by existence of ratings.
                                         'ratings' => [
                                             'Taran'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Melissa'  => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Guest'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Audience' => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                         ]
                                     ]
                                 ];
                             });
        } else {
            //historical week
            return Houseguest::currentSeason()
                             ->withoutGlobalScope('active')
                             ->whereDoesntHave('ratings', function ($q) use ($week) {
                                 $q->where('week', $week);
                             })
                             ->orderByDesc('updated_at')
                             ->get()
                             ->mapToAssoc(function ($houseguest) {
                                 return [
                                     $houseguest->nickname,
                                     [
                                         'status'  => 'evicted', // spoof for historical weeks. Status is determined by existence of ratings.
                                         'ratings' => [
                                             'Taran'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Melissa'  => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Guest'    => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                             'Audience' => [
                                                 'saved'  => false, // value for vue to use to denote if an updated value is saved to the db
                                                 'rating' => null
                                             ],
                                         ]
                                     ]
                                 ];
                             });
        }

    }
}
