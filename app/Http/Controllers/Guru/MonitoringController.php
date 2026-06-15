<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MonitoringController extends Controller
{
    // Menampilkan halaman ruang diskusi
    public function index()
    {
        return view('guru.monitoring');
    }

    // Mengambil pesan dari database via AJAX (Real-time)
    public function getMessages($topic)
    {
        $messages = Message::where('topic', $topic)->orderBy('created_at', 'asc')->get();
        
        // Mengecek apakah sesi diskusi untuk materi ini sedang dibuka oleh Guru
        $isActive = Cache::get("chat_session_{$topic}", false);

        return response()->json([
            'messages' => $messages,
            'is_active' => $isActive
        ]);
    }

    // Menyimpan pesan baru ke database
    public function storeMessage(Request $request)
    {
        $request->validate([
            'topic'   => 'required',
            'message' => 'required'
        ]);

        Message::create([
            'user_id'   => Auth::id(),
            'user_name' => Auth::user()->name,
            'topic'     => $request->topic,
            'message'   => $request->message
        ]);

        return response()->json(['status' => 'success']);
    }

    // Membuka / Menutup Sesi Diskusi (Tombol Kontrol Guru)
    public function toggleSession(Request $request)
    {
        $topic = $request->topic;
        $action = $request->action; // 'start' atau 'end'

        if ($action == 'start') {
            Cache::put("chat_session_{$topic}", true); // Buka Sesi
            
            // Kirim pesan otomatis dari Sistem
            Message::create([
                'user_id'   => Auth::id(),
                'user_name' => 'Sistem',
                'topic'     => $topic,
                'message'   => '🔔 Sesi diskusi telah DIMULAI oleh Guru. Silakan bertanya dan berdiskusi!'
            ]);
        } else {
            Cache::put("chat_session_{$topic}", false); // Tutup Sesi
            
            Message::create([
                'user_id'   => Auth::id(),
                'user_name' => 'Sistem',
                'topic'     => $topic,
                'message'   => '⛔ Sesi diskusi telah DIAKHIRI oleh Guru.'
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}