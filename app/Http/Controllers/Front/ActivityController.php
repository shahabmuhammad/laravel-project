<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display user's activity history (downloads, views, bookmarks)
     */
    public function index()
    {
        $user = Auth::user();

        // Get viewed papers from session
        $viewedPapers = session()->get('viewed_papers', []);
        $viewedPaperIds = array_keys($viewedPapers);

        $recentViews = collect([]);
        if (!empty($viewedPaperIds)) {
            $viewedResearches = Research::with('user')
                ->whereIn('id', $viewedPaperIds)
                ->whereIn('status', ['published', 'approved'])
                ->get();

            $recentViews = $viewedResearches->map(function ($paper) use ($viewedPapers) {
                $paper->user_views = $viewedPapers[$paper->id]['count'] ?? 1;
                $paper->last_viewed_at = $viewedPapers[$paper->id]['last_viewed'] ?? now();
                $paper->categories = $paper->categories();
                return $paper;
            })->sortByDesc('last_viewed_at')->take(20)->values();
        }

        // Get downloaded papers from session
        $downloadedPapers = session()->get('downloaded_papers', []);
        $downloadedPaperIds = array_keys($downloadedPapers);

        $recentDownloads = collect([]);
        if (!empty($downloadedPaperIds)) {
            $downloadedResearches = Research::with('user')
                ->whereIn('id', $downloadedPaperIds)
                ->whereIn('status', ['published', 'approved'])
                ->get();

            $recentDownloads = $downloadedResearches->map(function ($paper) use ($downloadedPapers) {
                $paper->download_count = $downloadedPapers[$paper->id]['count'] ?? 1;
                $paper->last_downloaded_at = $downloadedPapers[$paper->id]['last_downloaded'] ?? now();
                $paper->categories = $paper->categories();
                return $paper;
            })->sortByDesc('last_downloaded_at')->take(20)->values();
        }

        // Get bookmarked papers
        $bookmarks = $user->bookmarks()
            ->where('status', 'published')
            ->with(['user', 'publisher', 'type'])
            ->latest('bookmarks.created_at')
            ->take(20)
            ->get();

        // Add categories to bookmarks
        $bookmarks = $bookmarks->map(function ($paper) {
            $paper->categories = $paper->categories();
            return $paper;
        });

        // Calculate statistics
        $stats = [
            'total_views' => count($viewedPapers),
            'total_downloads' => count($downloadedPapers),
            'total_bookmarks' => $bookmarks->count(),
            'unique_papers_viewed' => count(array_unique($viewedPaperIds)),
        ];

        return view('front.activity', compact('recentViews', 'recentDownloads', 'bookmarks', 'stats'));
    }
}
