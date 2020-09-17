<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Season extends Resource
{
    public static $model = \App\Models\Season::class;

    public static $title = 'name';

    public static $search = [
        'name',
        'short_name',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Name'),
            Text::make('Short Name'),
            Select::make('Status')->options([
                'pre-season' => 'Pre Season',
                'open' => 'Open',
                'closed' => 'Closed',
                'ended' => 'Ended',
            ]),
            Number::make('Current Week'),
            DateTime::make('Closes At')->format("H:mm"),
            HasMany::make('Houseguests', 'houseguests', Houseguest::class)
        ];
    }
}
