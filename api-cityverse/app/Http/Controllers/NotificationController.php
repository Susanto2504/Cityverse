<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    public function unreadCount()
    {
        $count = Notification::where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'data' => $count,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil disimpan.',
            'data' => $notification,
        ], 201);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi telah ditandai sebagai dibaca.',
            'data' => $notification,
        ]);
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update([
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca.',
        ]);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }
}