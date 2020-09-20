<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'email',
    ];

    public function fields(Request $request)
    {
        return [
//            Avatar::make('Avatar')->disk('public'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}')
                ->nullable(),

            Boolean::make('Email Verified', function() {
                return (bool) $this->email_verified_at;
            })->exceptOnForms(),

            Date::make('Email Verified At')->help('Set date to mark email verified.')->onlyOnForms(),

            Boolean::make('Avatar Approved'),
            Boolean::make('Use Robot Avatar'),

            Password::make('Password')
                    ->onlyOnForms()
                    ->creationRules('required', 'string', 'min:8')
                    ->updateRules('nullable', 'string', 'min:8'),

            Text::make('Logged In Via', 'provider'),
            DateTime::make('Last Seen')->hideWhenCreating()->hideWhenUpdating(),
            DateTime::make('Last Audited')->nullable(),

            HasMany::make('Ratings', 'ratings', Rating::class),
            HasMany::make('Transactions', 'transactions', Transaction::class),
            HasMany::make('Sessions', 'sessions', Session::class),

            \Vyuldashev\NovaPermission\RoleBooleanGroup::make('Roles'),
            \Vyuldashev\NovaPermission\PermissionBooleanGroup::make('Permissions'),
        ];
    }

    public function cards(Request $request)
    {
        return [
          new Metrics\UserCount
        ];
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        if ($request->route('resource') === 'ratings') {
            return $query->role('lfc');
        }
        return $query;
    }
}
