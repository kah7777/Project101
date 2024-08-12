<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
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

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    public function Messages()
    {
        return $this->hasMany(Message::class);
    }

    public function fullName()
    {
        return $this->name;
    }

    public static function checkEmailIfExist(Request $request) : bool
{

        $email = $request->email;
        $userHasEmail = User::where('email',$email)->first();
        if($userHasEmail == null) {
            return false;

        }else {
            return true;
        }
}

    public static function validateData(Request $request)
    {
        $data = $request->validate([
            "name"=>"required|string",
            "email"=>"required|email|",
            "password"=>"required|max:20",
        ]);

        return $data;
    }

}
