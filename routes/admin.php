<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    RoleController,UserController, DashboardController,
    PublisherController,CategoryController,TypeController,ResearchController,
    AnalyticsController,HelpController,SettingsController,ProfileController,
    BookmarkController,NotificationController,AdminContactController

};

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Management Resources
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('types', TypeController::class);



    // REMOVE edit/update/destroy from resource
    Route::resource('researches', ResearchController::class)->except(['edit','update','show','destroy']);

    // Custom Encrypted ID Routes (Correct Position)
    Route::get('/researches/{encryptedId}/edit', [ResearchController::class, 'edit'])
        ->name('researches.edit');

    Route::put('/researches/{encryptedId}', [ResearchController::class, 'update'])
        ->name('researches.update');

    Route::delete('/researches/{encryptedId}', [ResearchController::class, 'destroy'])
        ->name('researches.destroy');
        Route::get('/researches/{encryptedId}', [ResearchController::class, 'show'])
            ->name('researches.show');


    // Approval Routes
    Route::post('/researches/{id}/approve', [ResearchController::class, 'approve'])->name('researches.approve');
    Route::post('/researches/{id}/reject', [ResearchController::class, 'reject'])->name('researches.reject');

    // Analytics, Help, Settings
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    // PROFILE MANAGEMENT 
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:Admin')->group(function () {
        Route::get('/profiles', [ProfileController::class, 'allProfiles'])->name('profiles.index');
        Route::get('/profiles/view/{id}', [ProfileController::class, 'view'])->name('profiles.view');
    });
       // **User-only routes for show/download/bookmark**
    Route::middleware('role:User')->group(function() {
        // Use distinct route names to avoid duplication
        Route::get('/researches/{encryptedId}', [ResearchController::class, 'show'])->name('researches.show.user');
        Route::get('/researches/download/{id}', [ResearchController::class, 'download'])->name('researches.download.user');
        Route::post('/bookmark/toggle/{research}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle.user');
    });

    // Show + Download
    // Remove duplicate routes that conflict with names above
    // Route::get('/researches/{id}', [ResearchController::class, 'show'])->name('researches.show');
    // Route::get('/researches/download/{id}', [ResearchController::class, 'download'])->name('researches.download');

    // Bookmark
    Route::get('/bookmark', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmark/toggle/{research}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    //contact routes
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
});
   // Research show & download – only User role
    Route::middleware('role:User')->group(function() {
        Route::get('/researches/{encryptedId}', [ResearchController::class, 'show'])->name('researches.show');
        Route::get('/researches/download/{id}', [ResearchController::class, 'download'])->name('researches.download');
        Route::post('/bookmark/toggle/{research}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    });