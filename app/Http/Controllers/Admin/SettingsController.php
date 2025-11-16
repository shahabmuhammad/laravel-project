<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::user(); // Logged-in admin info
        return view('admin.settings', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $admin->update($request->only(['name', 'email']));
        return back()->with('success', 'Settings updated successfully!');
    }
}
