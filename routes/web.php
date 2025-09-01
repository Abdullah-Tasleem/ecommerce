<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserContactController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCommentController;
use App\Http\Controllers\UserBlogCommentController;
use App\Http\Controllers\UserBlogController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;


// ───── Frontend Routes ─────
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('/shop', [FrontendController::class, 'all_products'])->name('show_products');
Route::get('/search/suggest', [FrontendController::class, 'searchProduct'])->name('search.suggest');
Route::get('/product/quick-view/{id}', [FrontendController::class, 'quickView'])->name('product.quickView');
Route::get('/product/{product}/{slug}', [FrontendController::class, 'view'])->name('details');

// ───── Authenticated Dashboard ─────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ───── Profile (Auth Required) ─────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ───── Admin Dashboard ─────
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        $usersCount = User::count();
        $ordersCount = Order::count();
        $productsCount = Product::count();
        return view('dashboard.dashboard', compact('usersCount', 'ordersCount' , 'productsCount'));
    })->name('admin.dashboard');
});

// ───── Products Routes ─────
Route::get('admin/products', [ProductController::class, 'index'])->middleware(['auth', 'admin'])->name('products.index');
Route::get('admin/products/create', [ProductController::class, 'create'])->middleware(['auth', 'admin'])->name('products.create');
Route::post('admin/products', [ProductController::class, 'store'])->middleware(['auth', 'admin'])->name('products.store');
Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->middleware(['auth', 'admin'])->name('products.edit');
Route::get('admin/products/{product}', [ProductController::class, 'show'])->middleware(['auth', 'admin'])->name('products.show');
Route::put('admin/products/{product}', [ProductController::class, 'update'])->middleware(['auth', 'admin'])->name('products.update');
Route::delete('admin/products/{product}', [ProductController::class, 'destroy'])->middleware(['auth', 'admin'])->name('products.destroy');

// ───── Categories Routes ─────
Route::get('admin/categories', [CategoryController::class, 'index'])->middleware(['auth', 'admin'])->name('categories.index');
Route::get('admin/categories/create', [CategoryController::class, 'create'])->middleware(['auth', 'admin'])->name('categories.create');
Route::post('admin/categories', [CategoryController::class, 'store'])->middleware(['auth', 'admin'])->name('categories.store');
Route::get('admin/categories/{category}', [CategoryController::class, 'show'])->middleware(['auth', 'admin'])->name('categories.show');
Route::get('admin/categories/{category}/edit', [CategoryController::class, 'edit'])->middleware(['auth', 'admin'])->name('categories.edit');
Route::put('admin/categories/{category}', [CategoryController::class, 'update'])->middleware(['auth', 'admin'])->name('categories.update');
Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy'])->middleware(['auth', 'admin'])->name('categories.destroy');

// ───── Tags Routes ─────
Route::get('admin/tags', [TagController::class, 'index'])->middleware(['auth', 'admin'])->name('tags.index');
Route::get('admin/tags/create', [TagController::class, 'create'])->middleware(['auth', 'admin'])->name('tags.create');
Route::post('admin/tags', [TagController::class, 'store'])->middleware(['auth', 'admin'])->name('tags.store');
Route::get('admin/tags/{tag}/edit', [TagController::class, 'edit'])->middleware(['auth', 'admin'])->name('tags.edit');
Route::put('admin/tags/{tag}', [TagController::class, 'update'])->middleware(['auth', 'admin'])->name('tags.update');
Route::delete('admin/tags/{tag}', [TagController::class, 'destroy'])->middleware(['auth', 'admin'])->name('tags.destroy');

// ───── Coupons Routes ─────
Route::get('admin/coupons', [CouponController::class, 'index'])->middleware(['auth', 'admin'])->name('coupons.index');
Route::get('admin/coupons/create', [CouponController::class, 'create'])->middleware(['auth', 'admin'])->name('coupons.create');
Route::post('admin/coupons', [CouponController::class, 'store'])->middleware(['auth', 'admin'])->name('coupons.store');
Route::get('admin/coupons/{coupon}/view', [CouponController::class, 'show'])->middleware(['auth', 'admin'])->name('coupons.show');
Route::get('admin/coupons/{coupon}/edit', [CouponController::class, 'edit'])->middleware(['auth', 'admin'])->name('coupons.edit');
Route::put('admin/coupons/{code}', [CouponController::class, 'update'])->middleware(['auth', 'admin'])->name('coupons.update');
Route::delete('admin/coupons/{code}', [CouponController::class, 'destroy'])->name('coupons.destroy');


// ───── Cart Routes (Frontend) ─────
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('cart/ajax-update', [CartController::class, 'ajaxUpdate'])->name('cart.ajax.update');
Route::post('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

// ───── Order Routes ─────
Route::get('/admin/orders', [OrderController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.orders.index');
Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->middleware(['auth', 'admin'])->name('admin.orders.show');
Route::get('/admin/orders/{order}/edit', [OrderController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.orders.edit');
Route::put('/admin/orders/{order}', [OrderController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.orders.update');
Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.orders.destroy');

// ───── User Order Routes ─────
Route::get('/my-orders', [UserOrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->middleware('auth')->name('orders.show');

// ───── Checkout Routes ─────
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [CheckoutController::class, 'paymentCancel'])->name('payment.cancel');


// ─────User Review Routes ─────
Route::post('/reviews', [UserReviewController::class, 'store'])->middleware('auth')->name('review.store');

// ─────Admin Review Routes ─────
Route::get('admin/reviews', [ReviewController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.reviews.index');
Route::get('admin/reviews/{review}', [ReviewController::class, 'show'])->middleware(['auth', 'admin'])->name('admin.reviews.show');
Route::get('admin/reviews/{review}/edit', [ReviewController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.reviews.edit');
Route::put('admin/reviews/{review}', [ReviewController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.reviews.update');
Route::delete('admin/reviews/{review}', [ReviewController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.reviews.destroy');

// ─────Contact Review Routes ─────
Route::get('/contact', [UserContactController::class, 'index'])->name('contact');
Route::post('/contact', [UserContactController::class, 'store'])->name('contact.store');
Route::get('/thankyou/{order}', [UserOrderController::class, 'thankYou'])->name('thankyou');
Route::post('/order/{order}/cancel', [UserOrderController::class, 'cancel'])->name('order.cancel');
Route::get('/order/cancelled', [UserOrderController::class, 'cancelPage'])->name('order.cancel.page');


// ───── Admin Blog Routes ─────
Route::get('admin/blogs', [BlogController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.blogs.index');
Route::get('admin/blogs/create', [BlogController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.blogs.create');
Route::post('admin/blogs', [BlogController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.blogs.store');
Route::get('admin/blogs/{blog}/edit', [BlogController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.blogs.edit');
Route::get('admin/blogs/{blog}', [BlogController::class, 'show'])->middleware(['auth', 'admin'])->name('admin.blogs.show');
Route::put('admin/blogs/{blog}', [BlogController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.blogs.update');
Route::delete('admin/blogs/{blog}', [BlogController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.blogs.destroy');
Route::post('/tinymce/upload', [BlogController::class, 'tinymceUpload'])->middleware(['auth' , 'admin'])->name('tinymce.upload');


// ───── User Blog Routes ─────
Route::get('/blogs', [UserBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [UserBlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/search/suggest', [UserBlogController::class, 'searchBlog'])->name('blogs.search');


// ───── User BlogComments Routes ─────
Route::post('/comments', [UserBlogCommentController::class, 'store'])->name('comments.store');

// ───── Admin BlogComments Routes ─────
Route::get('admin/comments', [BlogCommentController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.comments.index');
Route::get('admin/comments/{comment}/edit', [BlogCommentController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.comments.edit');
Route::put('admin/comments/{comment}', [BlogCommentController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.comments.update');
Route::get('admin/comments/{comment}', [BlogCommentController::class, 'show'])->middleware(['auth', 'admin'])->name('admin.comments.show');
Route::delete('admin/comments/{comment}', [BlogCommentController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.comments.destroy');





// ───── Auth Routes ─────
require __DIR__ . '/auth.php';
