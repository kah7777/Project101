<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
        'conversation_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
