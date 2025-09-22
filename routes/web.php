<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Livewire\Products\Show;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\PaymentController as CustomerPayment;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\OrderController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [PaymentController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/order-stats', [PaymentController::class, 'getOrderStats'])->name('dashboard.stats');
    Route::get('/admin/revenue-stats', [PaymentController::class, 'getRevenueStats'])->name('dashboard.revenue');
    Route::get('/admin/new-orders', [PaymentController::class, 'getNewOrderStats'])->name('dashboard.newOrders');
    Route::get('/admin/new-customers', [PaymentController::class, 'getNewCustomerStats'])->name('dashboard.newCustomers');
    Route::get('/admin/sales-chart', [PaymentController::class, 'getSalesChart'])->name('dashboard.sales.chart');
    Route::get('/admin/popular-categories', [PaymentController::class, 'getPopularProducts'])->name('dashboard.popularProducts');
    Route::get('/dashboard/orders/data', [PaymentController::class, 'getRecentOrdersData'])->name('dashboard.orders.data');
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead']);
    Route::get('/admin/orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
    Route::post('/admin/orders/{order}/update-status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::get('/admin/orders/{order}/check-status', [OrderAdminController::class, 'checkStatus'])->name('admin.orders.check-status');
    Route::get('/admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders');
    Route::get('/orders/data', [OrderAdminController::class, 'getOrdersData'])->name('admin.orders.data');
    Route::post('/orders/{id}/update-status', [OrderAdminController::class, 'updateStatusIndex'])->name('admin.orders.update-status');
});

Route::get('/login', [AuthController::class, 'showLoginform'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::middleware(['guest'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ControllersProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ControllersProductController::class, 'show'])->name('products.show');

    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add')->middleware('auth');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear-all', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/orders/status', [OrderController::class, 'getStatuses'])->name('orders.status');
    // Route::get('/checkout', CheckoutIndex::class)->name('checkout.index');   
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');



    Route::get('/payment/{orderNumber}', [CustomerPayment::class, 'index'])->name('payments.show');
    Route::post('/payment/init', [CustomerPayment::class, 'initPayment'])->name('payment.init');
    Route::post('/payment/result', [CustomerPayment::class, 'handlePaymentResult'])->name('payment.result');
    // Route::get('/payments/{orderNumber}', Payment::class)->name('payments.show');
});

Route::post('/payments/notification', [MidtransWebhookController::class, 'handleMidtransNotification'])
    ->name('payments.notification')
    ->withoutMiddleware([VerifyCsrfToken::class]);
