<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');
Route::get('/blogs', function () {
    return Inertia::render('Blogs');
})->name('blogs');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Dashboard route
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Blogs route
    Route::get('blogs', function () {
        return Inertia::render('Admin/Blogs');
    })->name('blogs');
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
