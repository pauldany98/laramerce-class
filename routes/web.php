<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/locale', function () {
    $locale = request('locale');
    if (!in_array($locale, config('app.available_locales'))) {
        abort(404);
    }
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale.set');

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Route::get('/products', [ProductController::class, 'index']);

Route::resource('products', ProductController::class);

// Cart routes
Route::resource('cart', CartController::class)->except(['show', 'edit', 'update']);
Route::delete('/cart/{cart?}/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::delete('/cart/{cart}/product/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/payment/verify', [CartController::class, 'verify_payment'])->name('payment.verify');


Route::get('/orders', [CartController::class, 'orders'])->name('orders.index');

// Route::get('/mimi/link-storage', function () {
//     Artisan::call('storage:link');
//     return 'success';
// });

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
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

// Notification routes
Route::get('/notifications/mark_as_read', [NotificationController::class, 'mark_as_read'])->name('notifications.mark_as_read');
Route::delete('/notifications/remove_all', [NotificationController::class, 'delete_all'])->name('notifications.delete_all');
