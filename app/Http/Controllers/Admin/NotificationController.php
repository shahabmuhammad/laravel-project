<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show all notifications (Admin side)
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $notifications = Notification::latest()->get();
        } else {
            $notifications = Notification::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('admin.notifications.index', compact('notifications', 'user'));
    }

    // Show create form (Admin send)
    public function create()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['Author', 'User']);
        })->get();

        return view('admin.notifications.create', compact('users'));
    }

    // Store notification
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'type' => 'manual',
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification sent successfully!');
    }
    public function show($id)
{
    $notification = Notification::findOrFail($id);

    // Mark as read if not already
    if (!$notification->is_read) {
        $notification->update(['is_read' => true]);
    }

    return view('admin.notifications.show', compact('notification'));
}


 
    public function markAsRead($id)
    {
        $notify = Notification::findOrFail($id);
        $notify->update(['is_read' => true]);

        return redirect()->back();
    }
}
