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

// Publication detail (show full research details) — uses slug binding once migration is applied
Route::get('/publications/{research}', [\App\Http\Controllers\Front\PublicationController::class, 'show'])
    ->name('front.publication.show');

// Category filtered publications
Route::get('/publications/category/{category}', [\App\Http\Controllers\Front\PublicationController::class, 'category'])
    ->name('front.publications.category');

// Signed download route for publications (protects direct access)
Route::get('/publications/{research}/download', [\App\Http\Controllers\Front\PublicationController::class, 'download'])
    ->name('front.publication.download');
