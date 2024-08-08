<?php

namespace App\Http\Controllers;

use App\Events\MessageNotification;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $user=Auth::user();
        abort_unless($conversation->userBelongsToConvesration($user), 403);
        $data = $request->validate([
            'text'=>'required|string|max:1024',
        ]);
        $message = Message::create([
            'user_id'=>$user->id,
            'conversation_id'=>$conversation->id,
            'text'=>$data['text'],
        ]);
        // send to pusher
        event(new MessageNotification($message));
        return response()->json([
            'message'=>'sent successfull',
        ]);
    }
}
