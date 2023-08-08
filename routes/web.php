<?php

use App\Http\Livewire\AdminPanel\AdminPanelComponent;
use App\Http\Livewire\AdminPanel\Branch\BranchComponent;
use App\Http\Livewire\AdminPanel\Category\CategoryComponent;
use App\Http\Livewire\AdminPanel\Order\OrderComponent;
use App\Http\Livewire\AdminPanel\Product\ProductComponent;
use App\Http\Livewire\AdminPanel\Reports\YearSales;
use App\Http\Livewire\AdminPanel\Reports\DailySales;
use App\Http\Livewire\AdminPanel\Reports\MonthlySales;
use App\Http\Livewire\AdminPanel\Reports\WeeklySales;
use App\Http\Livewire\AdminPanel\SubCategory\SubCategoryComponent;
use App\Http\Livewire\AdminPanel\User\UserComponent;
use App\Http\Livewire\AdminPanel\Slider\SliderComponent;
use App\Http\Livewire\AdminPanel\UpagosDirect\UpagosDirectComponent;
use App\Http\Livewire\Cart\CartDetailComponent;
use App\Http\Livewire\DashboardComponent;
use App\Http\Livewire\Payment\ConfirmComponent;
use App\Http\Livewire\Payment\DeliveryComponent;
use App\Http\Livewire\Payment\PaymentComponent;
use App\Http\Livewire\Policy\AboutUs;
use App\Http\Livewire\Policy\RefundPolicy;
use App\Http\Livewire\Product\ProductDetailComponent;
use App\Http\Livewire\Profile\MyOrder\MyOrderComponent;
use App\Http\Livewire\WelcomeComponent;
use App\Http\Livewire\WholesalerComponent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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

Route::get('/greeting/{locale}', function (string $locale) {
    session()->put('locale', $locale);
    return Redirect::back();
})->name('app.lang');

Route::get('/wholesaler', WholesalerComponent::class)->name('wholesaler');

Route::get('/product/details/{slug}', ProductDetailComponent::class)->name('product.details');

Route::middleware([
    'auth:sanctum',
    'user.enabled',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/cart/cart-details', CartDetailComponent::class)->name('cart.details');
    Route::get('/payment', PaymentComponent::class)->name('payment.payment');
    Route::get('/payment/delivery', DeliveryComponent::class)->name('payment.delivery');
    Route::get('/payment/confirm/{method?}', ConfirmComponent::class)->name('payment.confirm');
    Route::get('/profile/my-orders', MyOrderComponent::class)->name('profile.my-orders');
});

Route::middleware([
    'auth:sanctum',
    'user.enabled',
    config('jetstream.auth_session'),
    'verified',
    'role:administrator|editor',
])->group(function () {
    Route::get('/admin-panel', AdminPanelComponent::class)->name('admin-panel.panel');
    Route::get('/admin-panel/products', ProductComponent::class)->name('admin-panel.products');
    Route::get('/admin-panel/categories', CategoryComponent::class)->name('admin-panel.categories');
    Route::get('/admin-panel/subcategories', SubCategoryComponent::class)->name('admin-panel.subcategories');
    Route::get('/admin-panel/branches', BranchComponent::class)->name('admin-panel.branches');
    Route::get('/admin-panel/orders', OrderComponent::class)->name('admin-panel.orders');
    Route::get('/admin-panel/report/year-sales', YearSales::class)->name('admin-panel.report.year-sales');
    Route::get('/admin-panel/report/daily-sales', DailySales::class)->name('admin-panel.report.daily-sales');
    Route::get('/admin-panel/report/weekly-sales', WeeklySales::class)->name('admin-panel.report.weekly-sales');
    Route::get('/admin-panel/report/monthly-sales', MonthlySales::class)->name('admin-panel.report.monthly-sales');
    Route::get('/admin-panel/users', UserComponent::class)->name('admin-panel.users');
    Route::middleware(['role:administrador'])->group(function() {
        Route::get('/admin-panel/sliders', SliderComponent::class)->name('sliders');
        Route::get('/admin-panel/upagosdirect', UpagosDirectComponent::class)->name('upagosdirect');
    });
});

Route::get('/', WelcomeComponent::class)->name('dashboard');
Route::get('/products/{search?}', DashboardComponent::class)->name('products');
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');
Route::get('/customer-support', function () {
    return view('policy.customer-support');
})->name('customer-support');
Route::get('/return-policy', function () {
    return view('policy.return-policy');
})->name('return-policy');
Route::get('/delivery-policy', function () {
    return view('policy.delivery-policy');
})->name('delivery-policy');
