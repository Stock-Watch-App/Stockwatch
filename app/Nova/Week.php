<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Week extends Resource
{
    public static $model = \App\Models\Week::class;

    public static $title = 'week';

    public static $search = [
        'week',
        'start_date',
        'end_date',
    ];

    public function fields(Request $request)
    {
        return [
            Number::make('Week'),
            Date::make('Week Start'),
            Date::make('Week End'),
            BelongsTo::make('Season')
        ];
    }
}
