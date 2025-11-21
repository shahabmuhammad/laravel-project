<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index() {
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->with(['author', 'publisher', 'type', 'categories'])->latest()->get();

        return view('admin.bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Request $request, $researchId) {
        $user = Auth::user();
        $research = Research::findOrFail($researchId);

        if ($user->bookmarks()->where('research_id', $researchId)->exists()) {
            $user->bookmarks()->detach($researchId);
            $message = 'Bookmark removed.';
        } else {
            $user->bookmarks()->attach($researchId);
            $message = 'Bookmark added.';
        }

        return response()->json(['message' => $message]);
    }
}
