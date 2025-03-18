<?php

// Admin
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HistoryController as AdminHistoryController;
use App\Http\Controllers\Admin\AdminAuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

//Customer
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CustomerOrderController as CustomerOrderController;

// use App\Http\Controllers\OrderController;
use App\Http\Controllers\Customer\CustomerProductController as CustomerProductController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

//customer
Route::get('/', [CustomerDashboardController::class,'index'])->name('dashboard.customer');
// Route::get('/dashboard', [DashboardController::class,'indexCustomer'])->name('dashboard.customer');


Route::get('product', [CustomerProductController::class, 'index'])->name('customer.product.index');
Route::get('/product/{product:slug}', [CustomerProductController::class, 'show'])->name('customer.product.show');

// Rute autentikasi
Route::get('/login', [AuthController::class, 'showLoginFormCustomer'])->name('login.customer');
Route::post('/login', [AuthController::class, 'loginCustomer']);
Route::post('/logout', [AuthController::class, 'logoutCustomer'])->name('logout.customer');

Route::get('/register', [AuthController::class, 'showRegistrationFormCustomer'])->name('register.customer');
Route::post('/register', [AuthController::class, 'registerCustomer']);




// Routes requiring authentication
Route::middleware('auth:customer')->group(function () {
    Route::resource('cart', CustomerCartController::class); 
    // kasi as biar gak tabrakan sama admin
    Route::resource('order', CustomerOrderController::class, ['as' => 'customer']);
    Route::get('checkout',[CustomerCartController::class,'checkout'])->name('checkout');

    Route::resource('profile', CustomerProfileController::class);
    Route::delete('profile/{id}/image', [CustomerProfileController::class, 'destroyImage'])->name('profile.destroyImage');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.page');

});



//admin
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');

    Route::post('login', [AdminAuthController::class, 'loginAdmin'])->name('admin.login');
    Route::post('logout', [AdminAuthController::class, 'logoutAdmin'])->name('admin.logout');

    // Protected routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('customers', AdminCustomerController::class);
        Route::resource('order', AdminOrderController::class);
        Route::get('history', [AdminHistoryController::class, 'index'])->name('admin.history');
        Route::get('invoice/{order}', [InvoiceController::class, 'show'])->name('admin.invoice.show');
    });
});
