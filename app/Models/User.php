<?php

namespace App\Models;

use App\Models\Bank;
use App\Traits\Hashidable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, Hashidable;

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

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function leaderboard()
    {
        return $this->hasMany(Leaderboard::class);
    }

    public function setAvatar($avatar)
    {
        $path = "/users/images/user-{$this->id}_avatar.jpg";
        if ($contents = file_get_contents($avatar)) {
            Storage::disk('local')->put($path, $contents);
            $this->avatar = $path;
        }
        return $this;
    }

    //=== ATTRIBUTES ===//
    public function getBankAttribute()
    {
        return $this->banks->where('season_id', Season::current()->id)->first();
    }

    //=== METHODS ===//
    public function isPlaying()
    {
        return $this->bank !== null;
    }
}
