<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Http\Requests\NovaRequest;

class Houseguest extends Resource
{
    public static $model = \App\Models\Houseguest::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('First Name'),
            Text::make('Last Name'),
            Text::make('Nickname')->help('Optional. First name will be used by default.'),
            BelongsTo::make('Season', 'season', Season::class),
            Avatar::make('Image')->disk('public')
        ];
    }
}
