<?php

use App\Http\Livewire\AbautUs;
use App\Http\Livewire\AdminPanel\AdminPanel;
use App\Http\Livewire\AdminPanel\Branch\Branch;
use App\Http\Livewire\AdminPanel\Category\Category;
use App\Http\Livewire\AdminPanel\Order\Order;
use App\Http\Livewire\AdminPanel\Product\Product;
use App\Http\Livewire\AdminPanel\SubCategory\SubCategory;
use App\Http\Livewire\Cart\CartDetails;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Payment\Confirm;
use App\Http\Livewire\Payment\Delivery;
use App\Http\Livewire\Payment\Payment;
use App\Http\Livewire\Product\ProductDetails;
use App\Http\Livewire\Profile\MyOrder\MyOrder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/order-mail', function() {
    $user_order = App\Models\UserOrder::find(1);

    return new App\Mail\OrderShipped($user_order);
});

Route::get('/abaut-us', AbautUs::class)->name('abaut-us');

Route::get('/product/details/{slug}', ProductDetails::class)->name('product.details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function() {
    Route::get('/cart/cart-details', CartDetails::class)->name('cart.details');
    Route::get('/payment', Payment::class)->name('payment.payment');
    Route::get('/payment/delivery', Delivery::class)->name('payment.delivery');
    Route::get('/payment/confirm/{method?}', Confirm::class)->name('payment.confirm');
    Route::get('/profile/my-orders', MyOrder::class)->name('profile.my-orders');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:administrator'
])->group(function () {
    Route::get('/admin-panel', AdminPanel::class)->name('admin-panel.panel');
    Route::get('/admin-panel/products', Product::class)->name('admin-panel.products');
    Route::get('/admin-panel/categories', Category::class)->name('admin-panel.categories');
    Route::get('/admin-panel/subcategories', SubCategory::class)->name('admin-panel.subcategories');
    Route::get('/admin-panel/branches', Branch::class)->name('admin-panel.branches');
    Route::get('/admin-panel/orders', Order::class)->name('admin-panel.orders');
});

Route::get('/{search?}', Dashboard::class)->name('dashboard');

