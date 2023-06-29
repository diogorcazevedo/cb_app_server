<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckOutController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\InstitucionalController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/home',                                         [HomeController::class, 'index'])->name('home');
Route::get('lojavirtual',                                   [StoreController::class, 'index'])->name('lojavirtual');
Route::get('lojavirtual/index',                             [StoreController::class, 'index'])->name('store.index');
Route::get('joalheria/lojavirtual',                         [StoreController::class, 'index'])->name('store.index');


Route::get('jewelry/collection/{collection}',               [StoreController::class, 'collection'])->name('store.collection');
Route::get('jewelry/collections/123',                       [StoreController::class, 'collections'])->name('store.collections');
Route::get('jewelry/all_collections/123',                   [StoreController::class, 'all_collections'])->name('store.all_collections');
Route::get('jewelry/collections_group/{group}',             [StoreController::class, 'collections_group'])->name('store.collections_group');
Route::get('jewelry/category/{category}',                   [StoreController::class, 'category'])->name('store.category');
Route::get('jewelry/subcategory/{category}',                [StoreController::class, 'subcategory'])->name('store.subcategory');
Route::get('jewelry/product/{product}',                     [StoreController::class, 'product'])->name('store.product');
Route::get('jewelry/topic/{topic}',                         [StoreController::class, 'topic'])->name('store.topic');
Route::get('jewelry/gem/{gem}',                             [StoreController::class, 'gem'])->name('store.gem');
Route::get('jewelry/cart',                                  [StoreController::class, 'cart'])->name('store.cart');
Route::get('jewelry/order',                                 [StoreController::class, 'order'])->name('store.order');
Route::get('jewelry/checkout/{id}/{operadora?}',            [StoreController::class, 'checkout'])->name('store.checkout');
Route::get('jewelry/exception/{id}',                        [StoreController::class, 'exception'])->name('store.exception');
Route::get('jewelry/success/{id}',                          [StoreController::class, 'success'])->name('store.success');

Route::get('jewelry/dear_collections/123',                  [StoreController::class, 'dear_collections'])->name('store.dear_collections');
//Route::get('jewelry/exclusive_collections/123',             [StoreController::class, 'exclusive_collections'])->name('store.exclusive_collections');
//Route::get('jewelry/static/high_jewelry',                   [StaticStoreController::class, 'high_jewelry'])->name('store.high_jewelry');
//Route::get('jewelry/static/iconic_designs',                 [StaticStoreController::class, 'iconic_designs'])->name('store.iconic_designs');
//Route::get('jewelry/static/unconventional',                 [StaticStoreController::class, 'unconventional'])->name('store.unconventional');
//Route::get('cart/get_session',                              [CartController::class, 'get_session'])->name('cart.get.session');
//Route::get('cart/add/{product}/{redirect}',                 [CartController::class, 'add'])->name('cart.add');
//Route::post('cart/add_ring_size/{product}/{redirect}',      [CartController::class, 'add_ring_size'])->name('cart.add.ring.size');
//Route::get('cart/remove/{id}',                              [CartController::class, 'remove'])->name('cart.remove');
//Route::get('cart/qtd_update/{id}/{qtd}/{aro1?}/{aro2?}',    [CartController::class, 'qtd_update'])->name('cart.qtd_update');


Route::post('checkout/order',                               [CheckOutController::class, 'order'])->name('checkout.order');
Route::post('checkout/submit/{id}',                         [CheckOutController::class, 'submit'])->name('checkout.submit');


Route::get('user/create',                                   [UserController::class, 'create'])->name('user.create');
Route::get('user/store',                                    [UserController::class, 'store'])->name('user.store');
Route::get('user/index',                                    [UserController::class, 'index'])->name('user.index')->middleware(['auth', 'verified','check']);
Route::get('user/edit/{user}',                              [UserController::class, 'edit'])->name('user.edit')->middleware(['auth', 'verified','check']);
Route::post('user/update/{user}',                           [UserController::class, 'update'])->name('user.update')->middleware(['auth', 'verified','check']);
Route::get('user/destroy/{user}',                           [UserController::class, 'destroy'])->name('user.destroy')->middleware(['auth', 'verified','check']);
Route::get('user/password/{user}',                          [UserController::class, 'password'])->name('user.password')->middleware(['auth', 'verified','check']);
Route::get('user/update_password/{user}',                   [UserController::class, 'update_password'])->name('user.update.password')->middleware(['auth', 'verified','check']);


Route::get('institutional/clipping/123',                    [InstitucionalController::class, 'clipping'])->name('institutional.clipping');
Route::get('institutional/events',                          [InstitucionalController::class, 'events'])->name('institutional.events');
Route::get('institutional/event/{id}}',                     [InstitucionalController::class, 'event'])->name('institutional.event');
//Route::get('institutional/highlight/{id}',                  [InstitucionalController::class, 'highlight'])->name('institutional.highlight');


//LANDING PAGES

Route::get('landing/multiplas',                              [LandingController::class, 'multiplas'])->name('landing.multiplas');


Route::get('order/show/{id}',                               [OrderController::class, 'show'])->name('order.show');
