<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all'); // 'all', 'unread', 'read'

        $query = auth()->user()->notifications();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = auth()->user()->unreadNotifications()->count();
        $totalCount = auth()->user()->notifications()->count();

        return view('admin.notifications.index', compact('notifications', 'filter', 'unreadCount', 'totalCount'));
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        $targetUrl = $notification->data['link'] ?? route('admin.notifications');

        if ($targetUrl && $targetUrl !== route('admin.notifications')) {
            return redirect($targetUrl);
        }

        return redirect()->route('admin.notifications')->with('success', 'Notification marked as read.');
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification removed successfully.');
    }
}
