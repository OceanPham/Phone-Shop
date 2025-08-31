<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Product routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/quick-view', [ProductController::class, 'quickView'])->name('quick-view');

    // Comment and review routes (require auth)
    Route::middleware('auth')->group(function () {
        Route::post('/{product}/comments', [ProductController::class, 'storeComment'])->name('comments.store');
        Route::post('/{product}/reviews', [ProductController::class, 'storeReview'])->name('reviews.store');
    });
});

// Category routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
});

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('store');
    Route::put('/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/{productId}', [CartController::class, 'destroy'])->name('destroy');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');

    // API routes for AJAX
    Route::get('/api/data', [CartController::class, 'getCart'])->name('api.data');
    Route::get('/api/count', [CartController::class, 'getCartCount'])->name('api.count');
    Route::post('/api/validate', [CartController::class, 'validateCart'])->name('api.validate');
});

// Search route (could be in products group)
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Chatbot routes
Route::post('/chatbot/chat', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chatbot.chat');
Route::get('/chatbot/health', [App\Http\Controllers\ChatbotController::class, 'health'])->name('chatbot.health');

Route::post('/chatbot/stream', [App\Http\Controllers\ChatbotController::class, 'chatStream'])->name('chatbot.stream'); // stream
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [App\Http\Controllers\Admin\AdminController::class, 'changePassword'])->name('password.change');

    // Product Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

    // Debug route for testing multipart parsing
    Route::post('/products/{masanpham}/test', function (Request $request, $masanpham) {

        return response()->json([
            'success' => true,
            'message' => 'Debug route working',
            'data' => $request->all(),
            'masanpham' => $masanpham
        ]);
    });




    Route::patch('/products/{product}/stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock'])->name('products.update-stock');
    Route::patch('/products/{product}/visibility', [App\Http\Controllers\Admin\ProductController::class, 'toggleVisibility'])->name('products.toggle-visibility');
    Route::post('/products/bulk-action', [App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])->name('products.bulkAction');

    // Category Management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::patch('/categories/{category}/visibility', [App\Http\Controllers\Admin\CategoryController::class, 'toggleVisibility'])->name('categories.toggle-visibility');
    Route::post('/categories/bulk-action', [App\Http\Controllers\Admin\CategoryController::class, 'bulkAction'])->name('categories.bulkAction');
    Route::get('/categories/stats', [App\Http\Controllers\Admin\CategoryController::class, 'stats'])->name('categories.stats');

    // Order Management
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/payment', [App\Http\Controllers\Admin\OrderController::class, 'updatePayment'])->name('orders.update-payment');
    Route::post('/orders/bulk-action', [App\Http\Controllers\Admin\OrderController::class, 'bulkAction'])->name('orders.bulkAction');
    Route::get('/orders/{order}/print', [App\Http\Controllers\Admin\OrderController::class, 'print'])->name('orders.print');
    Route::get('/orders/stats', [App\Http\Controllers\Admin\OrderController::class, 'getStats'])->name('orders.stats');

    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulkAction');
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');

    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/products', [App\Http\Controllers\Admin\ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/export-sales', [App\Http\Controllers\Admin\ReportController::class, 'exportSales'])->name('reports.export-sales');
});

// Debug Route - Update passwords (REMOVE IN PRODUCTION)
Route::get('/debug/update-passwords', function () {
    $users = \App\Models\User::all();
    foreach ($users as $user) {
        $user->mat_khau = md5('123'); // MD5 hash of "123"
        $user->save();
    }
    return 'Updated ' . $users->count() . ' users with password: 123 (MD5: ' . md5('123') . ')';
});

// Debug Route - Add test product to cart
Route::get('/debug/add-to-cart', function () {
    $product = \App\Models\Product::first();
    if (!$product) {
        return 'No products found. Please seed data first.';
    }

    $cartService = app(\App\Services\CartService::class);
    $result = $cartService->addToCart($product->masanpham, 1);

    return [
        'message' => 'Added product to cart',
        'product' => $product->tensp,
        'result' => $result,
        'cart_count' => $cartService->getCartCount()
    ];
});

// Temporary test route for development
Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel application is working!',
        'timestamp' => now(),
        'environment' => app()->environment()
    ]);
})->name('test');
