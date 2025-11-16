<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Auto detect role and open correct profile page
    public function index()
    {
        $user = Auth::user();

        //  Admin → show dashboard + all profiles
        if ($user->hasRole('Admin')) {
            $users = User::with('roles')->get();
            return view('admin.profile.admin', compact('user', 'users'));
        }

        if ($user->hasRole('Author')) {
            return view('admin.profile.author', compact('user'));
        }

      
        return view('admin.profile.user', compact('user'));
    }

    //  Update current logged-in user's profile
    public function update(Request $request)
    {
        $user = Auth::user();

        //  AUTHOR UPDATE 
        if ($user->hasRole('Author')) {
            $validated = $request->validate([
                'full_name'     => 'required|string|max:255',
                'paper_title'   => 'nullable|string|max:255',
                'abstract'      => 'nullable|string',
                'keywords'      => 'nullable|string|max:255',
                'category'      => 'nullable|string|max:100',
                'profile_image' => 'nullable|image|max:2048',
                'file_upload'   => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            ]);

        
            $user->update([
                'name' => $validated['full_name'],
            ]);

            // Profile image upload (via Spatie Media Library)
            if ($request->hasFile('profile_image')) {
                $user->clearMediaCollection('profile_image');
                $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
            }

            // Research paper upload
            if ($request->hasFile('file_upload')) {
                $user->clearMediaCollection('paper_upload');
                $user->addMediaFromRequest('file_upload')->toMediaCollection('paper_upload');
            }

            return back()->with('success', 'Author profile updated successfully.');
        }

        //  USER UPDATE 
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'email'            => 'required|email|max:255',
            'contact'          => 'nullable|string|max:20',
            'country'          => 'nullable|string|max:100',
            'city'             => 'nullable|string|max:100',
            'institute'        => 'nullable|string|max:255',
            'about'            => 'nullable|string|max:500',
            'current_password' => 'nullable|string|min:6',
            'new_password'     => 'nullable|string|min:6|confirmed',
            'profile_image'    => 'nullable|image|max:2048',
        ]);

        // Update name + email
        $user->update([
            'name'  => $validated['first_name'] . ' ' . ($validated['last_name'] ?? ''),
            'email' => $validated['email'],
        ]);

        // Profile image upload
        if ($request->hasFile('profile_image')) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);
            } else {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    //  Admin: list all users/authors
    public function allProfiles()
    {
        $users = User::with('roles')->get();
        return view('admin.profile.adminprofile', [
            'user' => Auth::user(),
            'users' => $users
        ]);
    }

    //  Admin: view specific user/author profile
    public function view($id)
    {
        $profileUser = User::findOrFail($id);
        return view('admin.profile.view', compact('profileUser'));
    }
}
