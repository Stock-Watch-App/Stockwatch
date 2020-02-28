<?php

namespace App\Models;

use App\Models\Bank;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned'            => 'boolean'
    ];

    public function bank()
    {
        return $this->hasOne(Bank::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
