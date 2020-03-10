<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            BelongsTo::make('Houseguest')->sortable(),
            Number::make('Rating'),
            Number::make('Week')->sortable(),
        ];
    }
}
