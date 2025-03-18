<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Dashboard route
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Blogs route
    Route::get('blogs', [BlogController::class, 'adminIndex'])->name('admin.blogs');
        Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store');
    
    Route::get('user',[UserController::class,'index'])->name('user');
    Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
