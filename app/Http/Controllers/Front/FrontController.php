<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Category;
use App\Models\User;

class FrontController extends Controller
{
    // Homepage
    public function index()
    {
        $featuredResearches = Research::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::latest()->take(6)->get();

        $totalUsers = User::count();
        $totalPublications = Research::count();
        $totalRegistered = User::count();

        return view('front.index', compact(
            'featuredResearches',
            'categories',
            'totalUsers',
            'totalPublications',
            'totalRegistered'
        ));
    }

 public function browse(Request $request)
{
    $query = $request->input('query');
    $category = $request->input('category');
    $year = $request->input('year');
    $author = $request->input('author');

    $publications = Research::query()
        ->when($query, function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })
        ->when($year, function($q) use ($year) {
            $q->whereYear('created_at', $year);
        })
        ->when($author, function($q) use ($author) {
            $q->whereHas('user', function($u) use ($author) {
                $u->where('name', 'like', "%{$author}%");
            });
        })
        ->latest()
        ->paginate(12);

    return view('front.browse', compact('publications'));
}



    // View all categories
    public function viewAllCategories()
    {
        $categories = Category::latest()->get();
        return view('front.view-category', compact('categories'));
    }
}
