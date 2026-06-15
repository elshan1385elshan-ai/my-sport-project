<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/' , [HomeController::class , 'home'])->name('home');

Route::get('/dashboard' , [HomeController::class , 'dashboard'])->name('dashboard');
Route::get('/profile' , [HomeController::class , 'profile']);
Route::get('/search/live', [ProductController::class, 'liveSearch'])->name('search.live');
// بخش پروفایل کاربر (برای تست‌ها)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// بخش ادمین
Route::middleware(['auth'])->group(function () {
    Route::middleware('admin')->group(function () {
        Route::resource('sport', SportController::class);
        Route::resource('categories', CategoryController::class);
    });
});

require __DIR__.'/auth.php';
