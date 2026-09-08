<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\{UserController, StockController, ProductController, CategoryController, CartController, CheckoutController, ClientController, ProfileController, AdminController, WishlistController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\site\WebsiteController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\SiteProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClientAuth\LoginController;
use App\Http\Controllers\ClientAuth\RegisterController;
use App\Http\Controllers\Admin\BannerController;

// Contact Route 
Route::get('/contact', function () {
    return view('site.contact');
})->name('contact');

// Change Language Route
Route::get('change-language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('change.language');

// Change Currency Route (USD / SYP)
Route::get('change-currency/{currency}', function ($currency) {
    if (in_array($currency, ['USD', 'SYP'])) {
        session()->put('currency', $currency);
    }
    return redirect()->back();
})->name('change.currency');

// Profile Routبes 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Site Routes 
Route::get('/', [WebsiteController::class, 'index'])->name('site.home');
Route::get('/categories', [WebsiteController::class, 'getcategory']);
Route::get('/site/products', [SiteProductController::class, 'index'])->name('site.products');
Route::get('/products/details/{id}', [SiteProductController::class, 'show'])->name('product.details');
Route::get('product/shop', [SiteProductController::class, 'shopGrid'])->name('product.shop');
Route::get('product/category/{id}', [SiteProductController::class, 'getProductByCategory'])->name('category.product');
Route::get('/filter-products', [SiteProductController::class, 'filterByPrice'])->name('filter.products');

// Cart Routes
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::get('cart/payload', [CartController::class, 'getCartPayload'])->name('cart.payload');
Route::get('search/ajax', [SiteProductController::class, 'searchAjax'])->name('search.ajax');
Route::match(['get', 'post'], 'add-to-cart/{id}', [CartController::class, 'addtocart'])->name('AddToCart');
Route::post('bundle/add-to-cart', [CartController::class, 'addBundle'])->name('bundle.add-to-cart');
Route::post('update-cart-quantity', [CartController::class, 'updateQuantity'])->name('update.cart.quantity');
Route::post('remove-from-cart', [CartController::class, 'removefromcart'])->name('removefromcart');
Route::post('clear-cart', [CartController::class, 'clearCart'])->name('clearcart');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

// WhatsApp Checkout Flow
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'placeOrder'])->middleware('throttle:checkout')->name('checkout.place');

// Dashboard Routes - Protected by auth & admin middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.index');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // Products & Featured toggle
    Route::post('/products/{id}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('/products/{id}/admin-toggle-featured', [ProductController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');
    Route::resource('/products', ProductController::class);
    Route::get('/products-admin', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products-admin/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/products-admin/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::delete('/products-admin/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Categories
    Route::resource('/categories', CategoryController::class);
    Route::get('/categories-admin', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories-admin/create', [CategoryController::class, 'create'])->name('admin.categories.create');

    // Orders & Status Lifecycle
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{id}/admin-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::resource('/orders', OrderController::class);
    Route::get('/orders-admin', [OrderController::class, 'index'])->name('admin.orders.index');

    // Bundle Offers (Multi-products discount)
    Route::resource('/bundles', \App\Http\Controllers\Admin\BundleController::class);
    Route::get('/bundles-admin', [\App\Http\Controllers\Admin\BundleController::class, 'index'])->name('admin.bundles.index');
    Route::get('/bundles-admin/create', [\App\Http\Controllers\Admin\BundleController::class, 'create'])->name('admin.bundles.create');
    Route::get('/bundles-admin/{bundle}/edit', [\App\Http\Controllers\Admin\BundleController::class, 'edit'])->name('admin.bundles.edit');
    Route::delete('/bundles-admin/{bundle}', [\App\Http\Controllers\Admin\BundleController::class, 'destroy'])->name('admin.bundles.destroy');
    Route::put('/bundles-admin/{bundle}', [\App\Http\Controllers\Admin\BundleController::class, 'update'])->name('admin.bundles.update');
    Route::post('/bundles-admin', [\App\Http\Controllers\Admin\BundleController::class, 'store'])->name('admin.bundles.store');

    // Single Deals & Discounts
    Route::resource('/deals', \App\Http\Controllers\Admin\DealController::class);
    Route::get('/deals-admin', [\App\Http\Controllers\Admin\DealController::class, 'index'])->name('admin.deals.index');

    // Banners & Sliders
    Route::resource('/banners', BannerController::class);
    Route::get('/banners-admin', [BannerController::class, 'index'])->name('admin.banners.index');

    // Global Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings-admin', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings-admin', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

    // WhatsApp Analytics & Clicks
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics-admin', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');

    // Abandoned Carts Follow-up
    Route::get('/abandoned-carts', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'index'])->name('abandoned-carts.index');
    Route::get('/abandoned-carts-admin', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'index'])->name('admin.abandoned-carts.index');
    Route::post('/abandoned-carts/{id}/recover', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'markAsRecovered'])->name('abandoned-carts.recover');
    Route::post('/abandoned-carts-admin/{id}/recover', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'markAsRecovered'])->name('admin.abandoned-carts.recover');
    Route::delete('/abandoned-carts/{id}', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'destroy'])->name('abandoned-carts.destroy');
    Route::delete('/abandoned-carts-admin/{id}', [\App\Http\Controllers\Admin\AbandonedCartController::class, 'destroy'])->name('admin.abandoned-carts.destroy');

    // User Management
    Route::resource('/users', UserController::class);
    Route::get('/users-admin', [UserController::class, 'index'])->name('admin.users.index');
});

require __DIR__ . '/auth.php';
