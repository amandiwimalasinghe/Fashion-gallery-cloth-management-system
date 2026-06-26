<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TryOnController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function (Request $request) {
    $query = Product::with('user');


    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    if ($request->has('size') && $request->size != '') {
        $query->where('size', 'like', '%' . $request->size . '%');
    }

    if ($request->has('min_price') && $request->min_price != '') {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price != '') {
        $query->where('price', '<=', $request->max_price);
    }


    if ($request->has('sort')) {
        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->latest();
        }
    } else {
        $query->latest();
    }

    $products = $query->paginate(12)->withQueryString();

    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');


Route::post('/designer/banner', [DesignerController::class, 'updateBanner'])->name('designer.banner.update');

Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');


Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');



Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');


Route::post('/orders/{id}/complete', [OrderController::class, 'markAsComplete'])->name('orders.complete');


Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


Route::get('/designer/orders', [OrderController::class, 'designerOrders'])->name('designer.orders');
Route::post('/designer/orders/{id}/update', [OrderController::class, 'updateStatus'])->name('designer.orders.update');

Route::get('/designer/orders', [OrderController::class, 'designerOrders'])->name('designer.orders');

Route::get('/designer/reviews', [ReviewController::class, 'designerReviews'])->name('designer.reviews');

Route::get('/designer/{id}', [DesignerController::class, 'show'])->name('designer.show');


Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');


Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
Route::post('/inquiry/store', [InquiryController::class, 'store'])->name('inquiry.store');


Route::get('/admin/inquiries', [InquiryController::class, 'adminIndex'])->name('admin.inquiries');
Route::post('/admin/inquiries/{id}', [InquiryController::class, 'adminUpdate'])->name('admin.inquiries.update');

Route::get('/TryOn', [TryOnController::class, 'TryOn'])->name('TryOn');

Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/customizer', [DesignerController::class, 'index'])->name('customizer.index');
Route::post('/save-design', [DesignerController::class, 'saveDesign']);

require __DIR__ . '/auth.php';
