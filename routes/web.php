<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    // If user is logged in → redirect to admin dashboard
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    // Otherwise show frontend home
    return view('front.index');
})->name('front.index');


Route::get('/search', [SearchController::class, 'index'])->name('search');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/front.php';

// Removed default Laravel auth routes to avoid name conflicts with custom routes in routes/auth.php


