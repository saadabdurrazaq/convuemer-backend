<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\ShippingAddressesController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MegaMenuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuyCheckoutController;
use App\Http\Controllers\CartCheckoutController;
use App\Http\Controllers\UserOrderController;

/*
|--------------------------------------------------------------------------
| API Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|  
*/

Route::post('user/login', [LoginController::class, 'userLogin'])->name('userLogin');
Route::post('user/register', [RegisterController::class, 'register']);

Route::get('json-provinces', [AddressController::class, 'provinces']); // api/json-provinces
Route::get('json-regencies/{id}', [AddressController::class, 'regencies']);
Route::get('json-districts/{id}', [AddressController::class, 'districts']);
Route::get('json-village/{id}', [AddressController::class, 'villages']);

// Megamenu frontend
Route::get('mega-menu/get-menu-data', [MegaMenuController::class, 'getMenuData']);

// Sliders
Route::get('sliders/show', [SliderController::class, 'show']);

// Product sliders
Route::get('product-sliders/show-featured-products', [ProductSliderController::class, 'showFeaturedProduct']);

// Show single product in frontend page 
Route::get('product/{id}/{slug}', [ProductController::class, 'show']);

Route::get('products/list-products', [ProductController::class, 'listProducts']);

Route::get('couriers', [BuyCheckoutController::class, 'couriers']);

Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here 
    Route::get('dashboard', [LoginController::class, 'userDashboard']);
    Route::post('logout', [LoginController::class, 'logoutUser']);
    Route::post('change-password', [ProfileUserController::class, 'changePassword']);

    // Shipping addresses
    Route::post('shipping-addresses/store', [ShippingAddressesController::class, 'store']);
    Route::get('shipping-addresses/index/{id}', [ShippingAddressesController::class, 'index']);
    Route::put('shipping-addresses/update/{id}', [ShippingAddressesController::class, 'update']);
    Route::delete('shipping-addresses/force-delete/{id}', [ShippingAddressesController::class, 'forceDelete']);

    // Buy checkout
    Route::post('buy-checkout/insert-data', [BuyCheckoutController::class, 'insertData']);
    Route::get('buy-checkout/get-data', [BuyCheckoutController::class, 'getData']);
    Route::post('services', [BuyCheckoutController::class, 'services']);
    Route::post('buy-checkout/proceed', [BuyCheckoutController::class, 'proceed']);
    Route::get('buy-checkout/delete-data', [BuyCheckoutController::class, 'deleteData']);

    // Cart checkout
    Route::post('cart-checkout/services', [CartCheckoutController::class, 'services']);
    Route::post('cart-checkout/proceed', [CartCheckoutController::class, 'proceed']);

    // User order
    Route::get('my-order', [UserOrderController::class, 'myOrder']);
});

Route::middleware(['auth:user-api', 'scopes:user'])->get('/user', function (Request $request) {
    return $request->user();
});
