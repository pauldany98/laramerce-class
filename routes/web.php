<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);

// Route::get('/products', [ProductController::class, 'index']);
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::resource('products', ProductController::class);

// Cart routes
Route::resource('cart', CartController::class)->only(['index', 'store'])->middleware('auth');
Route::delete('/cart/{cart?}', [CartController::class, 'clear'])->name('cart.clear')->middleware('auth');
Route::delete('/cart/{cart}/product/{product}', [CartController::class, 'remove'])->name('cart.remove')->middleware('auth');

// Route::get('/mimi/link-storage', function () {
//     Artisan::call('storage:link');
//     return 'success';
// });

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'role.is_admin'])->name('admin.dashboard');
