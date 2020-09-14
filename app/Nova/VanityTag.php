<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class VanityTag extends Resource
{
    public static $model = \App\Models\VanityTag::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Tag'),
            MorphTo::make('Taggable')->types([
                User::class,
                Houseguest::class
            ])->searchable(),
            BelongsTo::make('Season'),
            Number::make('Week')
        ];
    }

}

