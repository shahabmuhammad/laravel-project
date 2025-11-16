<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        if ($user->hasRole('Admin')) {
            $analytics = [
                'totalPublications' => Research::count(),
                'totalReads' => Research::sum('views'),
                'totalCitations' => 0,
            ];

            $readsPerMonth = Research::selectRaw('MONTH(created_at) as month, SUM(views) as total')
                ->groupBy('month')
                ->pluck('total','month')
                ->toArray();

            // Fill missing months with 0
            $readsPerMonthFull = [];
            for ($i = 1; $i <= 12; $i++) {
                $readsPerMonthFull[$i] = $readsPerMonth[$i] ?? 0;
            }

            $chartData = [
                'months' => $months,
                'readsPerMonth' => array_values($readsPerMonthFull),
                // Dummy empty values to avoid undefined keys
                'viewsPerMonth' => [],
                'papers' => [],
                'views' => [],
                'topCategories' => [],
                'categoryCounts' => [],
                'mostViewed' => [],
            ];
        }
        elseif ($user->hasRole('Author')) {
            $analytics = [
                'allPublications' => Research::where('user_id', $user->id)->count(),
                'totalViews' => Research::where('user_id', $user->id)->sum('views'),
                'totalCitations' => 0,
            ];

            $viewsPerMonth = Research::where('user_id', $user->id)
                ->selectRaw('MONTH(created_at) as month, SUM(views) as total')
                ->groupBy('month')
                ->pluck('total','month')
                ->toArray();

            $viewsPerMonthFull = [];
            for ($i = 1; $i <= 12; $i++) {
                $viewsPerMonthFull[$i] = $viewsPerMonth[$i] ?? 0;
            }

            $chartData = [
                'months' => $months,
                'viewsPerMonth' => array_values($viewsPerMonthFull),
                // Dummy empty values
                'readsPerMonth' => [],
                'papers' => [],
                'views' => [],
                'topCategories' => [],
                'categoryCounts' => [],
                'mostViewed' => [],
            ];
        }
        else { // User
            $analytics = [
                'papersViewed' => Research::sum('views'),
                'downloads' => Research::sum('downloads'),
                'bookmarked' => $user->bookmarks()->count(),
            ];

            $chartData = [
                'papers' => Research::pluck('title')->toArray(),
                'views' => Research::pluck('views')->toArray(),
                'topCategories' => Category::all()->pluck('name')->toArray(),
                'categoryCounts' => Category::all()->map(function($cat){
                    return Research::whereJsonContains('category_ids', $cat->id)->count();
                })->toArray(),
                'mostViewed' => Research::with('author')->orderBy('views','desc')->take(5)->get(),
                // Dummy empty values
                'months' => [],
                'readsPerMonth' => [],
                'viewsPerMonth' => [],
            ];
        }

        return view('admin.analytics', compact('analytics','chartData','user'));
    }
}
