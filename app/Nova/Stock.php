<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Stock extends Resource
{
    public static $model = \App\Models\Stock::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User', 'user', User::class),
            BelongsTo::make('Houseguest', 'houseguest', Houseguest::class),
            Number::make('Quantity'),
        ];
    }
}
