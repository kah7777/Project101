<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function Tests()
    {
        return $this->hasMany(Test::class);
    }

    public static function checkEmailIfExist($email) : bool
{

        $userHasEmail = User::where('email',$email)->first();
        if($userHasEmail == null) {
            return false;

        }else {
            return true;
        }
}

    public function token()
    {
        return $this->morphOne(Sanctum::$personalAccessTokenModel, 'tokenable')->latest();
    }

    public function isDoctor(): bool
    {
        return filled($this->doctor);
    }

    public function isGuardian(): bool
    {
        return filled($this->guardian);
    }

}
