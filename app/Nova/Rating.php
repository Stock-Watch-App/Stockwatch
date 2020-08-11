<?php

namespace App\Nova;

use App\Models\Houseguest;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;

class Rating extends Resource
{
    public static $model = 'App\Models\Rating';

    public static $title = 'rating';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User')->sortable(),
            BelongsTo::make('Houseguest')->hideWhenCreating()->hideWhenUpdating()->sortable(),
            NovaBelongsToDepend::make('Houseguest')
                               ->placeholder('Houseguest')
                               ->options(Houseguest::where('season_id', 2)->get())
                               ->hideFromIndex()->hideFromDetail(),
            Number::make('Rating'),
            Number::make('Week')->sortable(),
        ];
    }
}
