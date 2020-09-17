<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Session extends Resource
{
    public static $model = \App\Models\Session::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            BelongsTo::make('User')->nullable(),
            Text::make('IP Address')->nullable(),
            Text::make('User Agent')->nullable(),
            Text::make('Payload'),
            Number::make('Last Activity')
        ];
    }
}
