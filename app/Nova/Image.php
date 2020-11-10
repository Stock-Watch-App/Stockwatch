<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Image extends Resource
{
    public static $model = \App\Image::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            Text::make('Filename'),
        ];
    }
}
