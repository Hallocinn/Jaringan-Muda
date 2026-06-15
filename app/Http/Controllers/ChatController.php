<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Ambil semua pesan berdasarkan topik
    public function getMessages($topic) {
        $messages = Message::where('topic', $topic)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    // Simpan pesan baru
    public function storeMessage(Request $request) {
        $message = Message::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'message' => $request->message,
            'topic' => $request->topic
        ]);
        return response()->json(['status' => 'success']);
    }
}