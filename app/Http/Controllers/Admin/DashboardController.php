<?php

namespace App\Http\Controllers\Admin;

use App\Models\Research;
use App\Models\Category;
use App\Models\User;
use App\Models\Publisher;
use App\Models\Type;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = [];

        //  ADMIN DASHBOARD 
        if ($user->hasRole('Admin')) {
            $totalPublications = Research::count();
            $pendingApprovals = Research::where('status', 'submitted')->count();
            $totalDownloads = Research::sum('downloads');
            $totalViews = Research::sum('views');
            $totalUsers = User::count();
            $totalCategories = Category::count();
            $totalPublishers = Publisher::count();
            $totalTypes = Type::count();
            $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
            $publishedResearch = Research::where('status', 'published')->count();
            $draftResearch = Research::where('status', 'draft')->count();
            $rejectedResearch = Research::where('status', 'rejected')->count();

            // Recent submissions
            $recentSubmissions = Research::with(['user'])
                ->latest()
                ->take(10)
                ->get();

            // Monthly submissions (last 6 months)
            $monthlyData = Research::select(
                DB::raw('DATE_FORMAT(created_at, "%b") as month'),
                DB::raw('COUNT(*) as count')
            )
                ->where('created_at', '>=', Carbon::now()->subMonths(6))
                ->groupBy('month')
                ->orderBy(DB::raw('MIN(created_at)'))
                ->get();

            // Top categories
            $topCategories = Category::all()->map(function ($category) {
                $count = Research::whereJsonContains('category_ids', $category->id)->count();
                $category->researches_count = $count;
                return $category;
            })->sortByDesc('researches_count')->take(5);

            // Research by status
            $researchByStatus = [
                'published' => $publishedResearch,
                'draft' => $draftResearch,
                'submitted' => $pendingApprovals,
                'rejected' => $rejectedResearch,
            ];

            // Most downloaded and most viewed
            $mostDownloaded = Research::with('user')
                ->orderBy('downloads', 'desc')
                ->take(5)
                ->get();

            $mostViewed = Research::with('user')
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();

            $data = [
                'totalPublications' => $totalPublications,
                'pendingApprovals' => $pendingApprovals,
                'totalDownloads' => $totalDownloads,
                'totalViews' => $totalViews,
                'totalUsers' => $totalUsers,
                'totalCategories' => $totalCategories,
                'totalPublishers' => $totalPublishers,
                'totalTypes' => $totalTypes,
                'newUsersToday' => $newUsersToday,
                'publishedResearch' => $publishedResearch,
                'draftResearch' => $draftResearch,
                'rejectedResearch' => $rejectedResearch,
                'recentSubmissions' => $recentSubmissions,
                'monthlyData' => $monthlyData,
                'topCategories' => $topCategories,
                'researchByStatus' => $researchByStatus,
                'mostDownloaded' => $mostDownloaded,
                'mostViewed' => $mostViewed,
            ];

            return view('admin.dashboard', $data);
        }

        //  AUTHOR DASHBOARD 
  if ($user->hasRole('Author')) {
    $myPublications = Research::where('user_id', $user->id)->count();
    $totalViews = Research::where('user_id', $user->id)->sum('views');
    // $totalCitations = Research::where('user_id', $user->id)->sum('citations'); // remove

    $recentUploads = Research::where('user_id', $user->id)
                        ->latest()->take(5)->get();

    $analytics = [
        'allPublications' => $myPublications,
        'totalViews' => $totalViews,
        // 'totalCitations' => $totalCitations, // remove
    ];

    return view('admin.dashboard', compact('analytics', 'recentUploads'));
}



// USER DASHBOARD
if ($user->hasRole('User')) {

    // Stats
    $data = [
        'bookmarks' => $user->bookmarks()->count(),
        'downloads' => Research::where('status', 'approved')->sum('downloads'),
        'papersViewed' => Research::where('status', 'approved')->count(),
    ];

    // Base query for search/explore
    $query = Research::with(['author', 'categories'])->where('status', 'approved');

    // Search
    if ($request->filled('search')) {
        $keywords = array_map('trim', explode(',', $request->search));
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $categoryIds = Category::where('name', 'like', "%{$word}%")->pluck('id')->toArray();
                $q->orWhere('title', 'like', "%{$word}%")
                    ->orWhere('keywords', 'like', "%{$word}%")
                    ->orWhereJsonContains('category_ids', $categoryIds);
            }
        });
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->whereJsonContains('category_ids', (int)$request->category);
    }

    $researches = $query->latest()->paginate(10);
    $categories = Category::all();

    // Most Viewed / Trending
    $chartData['mostViewed'] = Research::where('status', 'approved')
        ->orderBy('views', 'desc')->take(5)->get();

    return view('admin.dashboard', compact(
        'researches',
        'categories',
        'chartData'
    ) + $data);
}

// Default for roles without dashboard
$data['message'] = 'No dashboard configured for your role: ' . $user->getRoleNames()->implode(', ');
return view('admin.dashboard', $data);
    }
}
