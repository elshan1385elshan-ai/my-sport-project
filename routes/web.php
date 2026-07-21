<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/search/live', [ProductController::class, 'liveSearch'])->name('search.live');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
// بخش پروفایل کاربر
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// پروفایل خریدار (نام، نام خانوادگی، عکس، شماره تماس) — بدون نیاز به لاگین برای مشاهده فرم
// Route::get('/buyer/profile', [BuyerProfileController::class, 'edit'])->name('buyer.profile.edit');
// Route::middleware('auth')->patch('/buyer/profile', [BuyerProfileController::class, 'update'])->name('buyer.profile.update');

// آدرس خریدار — بدون نیاز به لاگین برای مشاهده فرم
// Route::get('/buyer/address/create', [UserAddressController::class, 'create'])->name('profile.address.create');
// Route::get('/buyer/address', [UserAddressController::class, 'show'])->name('profile.address.show');
// Route::get('/buyer/address/edit', [UserAddressController::class, 'edit'])->name('profile.address.edit');
// Route::middleware('auth')->group(function () {
//     Route::post('/buyer/address', [UserAddressController::class, 'store'])->name('profile.address.store');
//     Route::put('/buyer/address', [UserAddressController::class, 'update'])->name('profile.address.update');
// });

// ورود ادمین (جدا از کاربران عادی)
// Route::prefix('admin')->group(function () {
//     Route::middleware('guest:admin')->group(function () {
//         Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
//         Route::post('/login', [AdminAuthController::class, 'login']);
//     });
//     Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
// });

// بخش ادمین
Route::middleware('admin')->prefix('/admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);

    Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address', [AddressController::class, 'show'])->name('address.show');
    Route::get('/address/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address', [AddressController::class, 'update'])->name('address.update');
});
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});
// // بخش فروشنده (چیزی بفروشید)
// Route::middleware('seller')->group(function () {
//     Route::get('/dashboard', [\App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('seller/products', \App\Http\Controllers\Seller\ProductController::class)->names('seller.products');
//     Route::resource('seller/orders', \App\Http\Controllers\Seller\OrderController::class)->names('seller.orders');
//     Route::post('/seller/settings', [\App\Http\Controllers\Seller\SettingsController::class, 'update'])->name('seller.settings.update');
// });

require __DIR__.'/auth.php';
