<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ContactController;
use App\Models\Research;

// Bind the {research} route parameter so it resolves either by slug or by id.
// This allows links to pass either a slug (preferred) or an id fallback.
Route::bind('research', function ($value) {
    return Research::where('slug', $value)->orWhere('id', $value)->firstOrFail();
});


Route::get('/', [FrontController::class, 'index'])->name('front.home');

Route::get('/about', function () {
    return view('front.about');
})->name('front.about');

Route::get('/browse', [FrontController::class, 'browse'])->name('front.browse');

Route::get('/view-category', [FrontController::class, 'viewAllCategories'])
    ->name('front.view-category');
Route::get('/key-features', function () {
    return view('front.key-features');
})->name('front.key-features');
Route::get('/publications', function () {
    return view('front.publications');
})->name('front.publications');
//contact
Route::get('/contact', [ContactController::class, 'index'])->name('front.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('front.contact.store');

// Category filtered publications (public)
Route::get('/publications/category/{category}', [\App\Http\Controllers\Front\PublicationController::class, 'category'])
    ->name('front.publications.category');

// PROTECTED ROUTES - Require authentication
Route::middleware('auth')->group(function () {
    // Publication detail (show full research details) — requires login
    Route::get('/publications/{research}', [\App\Http\Controllers\Front\PublicationController::class, 'show'])
        ->name('front.publication.show');

    // Download route for publications (protected)
    Route::get('/publications/{research}/download', [\App\Http\Controllers\Front\PublicationController::class, 'download'])
        ->name('front.publication.download');

    // Bookmark routes
    Route::post('/bookmark/toggle/{research}', [\App\Http\Controllers\Front\BookmarkController::class, 'toggle'])
        ->name('front.bookmark.toggle');
    Route::get('/my-bookmarks', [\App\Http\Controllers\Front\BookmarkController::class, 'index'])
        ->name('front.bookmark.index');
    Route::delete('/bookmark/remove/{research}', [\App\Http\Controllers\Front\BookmarkController::class, 'remove'])
        ->name('front.bookmark.remove');

    // My Activity page
    Route::get('/my-activity', [\App\Http\Controllers\Front\ActivityController::class, 'index'])
        ->name('front.activity.index');
});
