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

    protected $dates = [
        'last_seen'
    ];

    protected $appends = [
        'avatar_url',
//        'times_played'
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

    public function avatar()
    {
        return $this->belongsTo(Image::class, 'avatar_id');
    }

    public function setAvatar($avatar)
    {
        $filename = Storage::putFile('avatars', file_get_contents($avatar), 'public');

        $image = Image::create([
            'filename' => 'storage/'.$filename
        ]);

        $image->user()->save($this);

        return $this;
    }

    //=== ATTRIBUTES ===//
    public function getBankAttribute()
    {
        return $this->banks->where('season_id', Season::current()->id)->first();
    }

    public function getTimesPlayedAttribute()
    {
        return $this->banks()->where('user_id', $this->id)->count();
    }

    //=== ATTRIBUTES ===//
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return $this->avatar->filename;
        }
        return null;
    }

    //=== METHODS ===//
    public function isPlaying()
    {
        return $this->bank !== null;
    }
}
