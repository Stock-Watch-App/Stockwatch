<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class Bank extends Resource
{
    public static $model = 'App\Models\Bank';

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User'),
            BelongsTo::make('Season'),
            Currency::make('Money')
        ];
    }
}
