<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function message()
    {
        $messages = Message::latest()->paginate(5);
        return view('dashboard.super-admin.message.index', compact('messages'))->with('title', 'Message');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'asal' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Hitung jumlah pesan yang sudah dikirim hari ini
        $todayCount = Message::whereDate('created_at', Carbon::today())->count();

        if ($todayCount >= 20) {
            return redirect()->back()->with('error', 'Sudah mencapai batas Limit Pesan hari ini. Coba lagi besok.');
        }

        $validated['is_read'] = false;

        Message::create($validated);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }

    public function destroyAll()
    {
        Message::truncate();

        return redirect()->back()->with('success', 'Semua data berhasil dihapus!');
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return response()->json(['status' => 'success']);
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada pesan yang dipilih.'
            ], 400);
        }

        Message::whereIn('id', $ids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan terpilih berhasil dihapus.'
        ]);
    }
}
