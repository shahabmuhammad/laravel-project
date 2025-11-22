<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display user's bookmarks
     */
    public function index()
    {
        $user = Auth::user();

        // Get user's bookmarked papers
        $bookmarks = $user->bookmarks()
            ->where('status', 'published')
            ->with(['user', 'publisher', 'type'])
            ->latest('bookmarks.created_at')
            ->paginate(12);

        return view('front.bookmarks', compact('bookmarks'));
    }

    /**
     * Toggle bookmark (add/remove)
     */
    public function toggle(Request $request, Research $research)
    {
        $user = Auth::user();

        // Check if already bookmarked
        if ($user->bookmarks()->where('research_id', $research->id)->exists()) {
            // Remove bookmark
            $user->bookmarks()->detach($research->id);
            $message = 'Bookmark removed successfully.';
            $bookmarked = false;
        } else {
            // Add bookmark
            $user->bookmarks()->attach($research->id);
            $message = 'Bookmark added successfully.';
            $bookmarked = true;
        }

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'bookmarked' => $bookmarked
            ]);
        }

        // Redirect back with message for regular requests
        return back()->with('success', $message);
    }

    /**
     * Remove a bookmark
     */
    public function remove(Research $research)
    {
        $user = Auth::user();

        $user->bookmarks()->detach($research->id);

        return back()->with('success', 'Bookmark removed successfully.');
    }
}
