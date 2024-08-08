<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function Messages()
    {
        return $this->hasMany(Message::class);
    }

    public function scopePrivateConversationBetween(Builder $query, array $userIds = []): void
    {
        $query->whereHas(
            'users',
            fn ($usersQuery) => $usersQuery->whereIn('conversation_user.user_id', $userIds),
            '=',
            2
        );
    }

    public function userBelongsToConvesration(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }
}
