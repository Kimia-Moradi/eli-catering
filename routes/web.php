<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site — a single page. No customer-facing routes beyond this exist
| in Version 1 (no accounts, cart, checkout — see the spec's scope section).
|--------------------------------------------------------------------------
*/
Route::get('/', [MenuController::class, 'index'])->name('home');

Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
})->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1'); // 5 attempts per minute per IP+email — see AuthenticatedSessionController for the matching lockout message
});

Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Protected admin area — 'auth' confirms a session exists, 'admin' confirms
| that user's role is actually 'admin' (see EnsureUserIsAdmin).
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::patch('products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])
        ->name('products.toggle-availability');
    Route::patch('products/{product}/restore', [ProductController::class, 'restore'])
        ->name('products.restore');

    Route::get('menus/{date?}', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::patch('menus/{menu}/activate', [AdminMenuController::class, 'activate'])->name('menu.activate');
    Route::post('menu-items', [AdminMenuController::class, 'addItem'])->name('menu.items.add');
    Route::patch('menu-items/{menuItem}/order', [AdminMenuController::class, 'updateOrder'])->name('menu.items.order');
    Route::delete('menu-items/{menuItem}', [AdminMenuController::class, 'removeItem'])->name('menu.items.remove');
});
