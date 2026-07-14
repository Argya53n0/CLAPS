<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\MenuCatalogController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderHistoryController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\KaryawanDashboardController;

// Public Home
Route::get('/', function () {
    return view('welcome');
});

// Public Menu Catalog
Route::get('/menu', [MenuCatalogController::class, 'index'])->name('menu');

// Guest Only
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () { return view('auth.register'); })->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Users (Any Role)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Customer Profile & Dashboard
    Route::get('/profile', function () { 
        $recentOrders = \App\Models\Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->take(3)
            ->get();
        return view('profile.dashboard', compact('recentOrders')); 
    })->name('profile');

    // Customer Workflows
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('checkout');

        Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/rate', [OrderHistoryController::class, 'rate'])->name('orders.rate');
        Route::post('/orders/{order}/simulate-payment', [OrderHistoryController::class, 'simulatePayment'])->name('orders.simulate_payment');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Address Book
        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
    });
});

// Admin (Owner Only)
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
});

// Karyawan Only
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/admin/karyawan-dashboard', [KaryawanDashboardController::class, 'index'])->name('admin.karyawan.dashboard');
});

// Shared (Owner & Karyawan)
Route::middleware(['auth', 'role:owner,karyawan'])->group(function () {
    // Orders Management
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    // Menu Management
    Route::get('/admin/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::get('/admin/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/admin/menu', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/admin/menu/{product}/edit', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/admin/menu/{product}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/admin/menu/{product}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');
});
