<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Badge extends Resource
{
    public static $model = \App\Badge::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Image'),
            Text::make('Name'),
            Number::make('Rank'),
            Select::make('Type')->options([
                'ordinal' => 'Ordinal',
                'percent' => 'Percent'
            ])
        ];
    }
}
