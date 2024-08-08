<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Conversions\Conversion;

use function PHPUnit\Framework\isNull;

class ConversationController extends Controller
{
    // public function create show uplade delete
    public function checkConversation(User $otherUser)
    {
        $currentUser = Auth::user();

        $user_ids=[
            $currentUser->id,
            $otherUser->id,
        ];
        $conversation = Conversation::privateConversationBetween($user_ids)->first();

        if (is_null($conversation)) {
            $conversation = Conversation::create();
            $conversation->users()->sync($user_ids);
        }

        return response()->json([
            'conversation'=>ConversationResource::make($conversation),
        ]);
    }
}
