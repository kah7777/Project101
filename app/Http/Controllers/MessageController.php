<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string',
            ]);
            $data['user_id'] = auth()->id();

            $message = Message::create($data);

            return ApiResponseService::success(
                ['subject' => $message->subject, 'message' => $message->message],
                'Message sent successfully'
            );
        } catch (\Exception $e) {
            return ApiResponseService::error(
                'Failed to send message: ' . $e->getMessage(),
                500
            );
        }
    }
}
