<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PcBuildController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProduct = Product::with('category')->featured()->first();
    $featuredProducts = Product::with('category')->latest()->take(4)->get();

    return view('welcome', compact('featuredProduct', 'featuredProducts'));
})->name('home');

Route::get('/products', [ProductController::class, 'catalog'])->name('products.catalog');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product:slug}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('products.reviews.store');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/items', [CartController::class, 'store'])->middleware('auth')->name('items.store');
    Route::patch('/items/{cartItem}', [CartController::class, 'update'])->name('items.update');
    Route::delete('/items/{cartItem}', [CartController::class, 'destroy'])->name('items.destroy');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.show');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/payment', [CartController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout/confirmation', [CartController::class, 'confirmation'])->name('checkout.confirmation');

Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/items', [WishlistController::class, 'store'])->name('store');
    Route::delete('/items/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::delete('/clear', [WishlistController::class, 'destroyAll'])->name('clear');
    Route::post('/add-all-to-cart', [WishlistController::class, 'addAllToCart'])->name('add-all-to-cart');
});

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'overview'])->name('overview');
    Route::get('/edit', [AccountController::class, 'edit'])->name('edit');
    Route::patch('/update', [AccountController::class, 'update'])->name('update');
    Route::get('/payments', [AccountController::class, 'payments'])->name('payments');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('addresses.store');
    Route::get('/orders/{order}/invoice', [AccountController::class, 'orderInvoice'])->name('orders.invoice');
    Route::get('/my-builds', [PcBuildController::class, 'myBuilds'])->name('my-builds');
    Route::delete('/my-builds/{build}', [PcBuildController::class, 'deleteBuild'])->name('my-builds.delete');
});

Route::get('/pc-builds', [PcBuildController::class, 'catalog'])->name('pc-builds.catalog');
Route::get('/pc-builds/builder', [PcBuildController::class, 'customBuilder'])->name('pc-builds.builder');
Route::get('/pc-builds/alternatives', [PcBuildController::class, 'getAlternativeProducts'])->name('pc-builds.alternatives');
Route::post('/pc-builds/save', [PcBuildController::class, 'saveBuild'])->name('pc-builds.save');
Route::post('/pc-builds/add-to-cart', [PcBuildController::class, 'addBuildToCart'])->name('pc-builds.add-to-cart');
Route::get('/pc-builds/{pcBuild}', [PcBuildController::class, 'show'])->name('pc-builds.show');

Route::get('/bantuan', [HelpController::class, 'index'])->name('help.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        
        // Product Management
        Route::resource('products', AdminProductController::class);
        Route::get('products-low-stock', [AdminProductController::class, 'lowStock'])->name('products.low-stock');
        Route::post('products-mass-update-preview', [AdminProductController::class, 'massUpdatePreview'])->name('products.mass-update-preview');
        Route::post('products-mass-update', [AdminProductController::class, 'massUpdate'])->name('products.mass-update');
        
        // Order Management
        Route::resource('orders', AdminOrderController::class);
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // User Management
        Route::resource('users', AdminUserController::class);
        
        // Reports
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('reports/sales', [AdminReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/products', [AdminReportController::class, 'products'])->name('reports.products');
    });
