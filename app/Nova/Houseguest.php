<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Http\Requests\NovaRequest;

class Houseguest extends Resource
{
    public static $model = \App\Models\Houseguest::class;

    public static $title = 'nickname';

    public static $search = [
        'first_name',
        'last_name',
        'nickname',
    ];
    public static $perPageViaRelationship = 20; // incase there are more than 16 in a season for some reason


    public function fields(Request $request)
    {
        return [
            Text::make('First Name'),
            Text::make('Last Name'),
            Text::make('Nickname')->help('Optional. First name will be used by default.'),
            Text::make('Slug')->help('Optional. kebab-case nickname will be used by default.'),
            BelongsTo::make('Season', 'season', Season::class),
            Select::make('Status')->options([
                'active' => 'Active',
                'evicted' => 'Evicted'
            ]),
            Avatar::make('Image')->disk('public'),

            HasMany::make('Ratings', 'ratings', Rating::class),
            HasMany::make('Prices', 'prices', Price::class),
//            HasMany::make('Transactions', 'transactions', Transaction::class)
        ];
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        if (in_array($request->route('resource'), ['vanity-tags', 'seasons'])) {
            return $query->withoutGlobalScope('active');
        }
        return $query;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScope('active');
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScope('active');
    }
}
