<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\JuhanController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['admin'])->group(function(){
    Route::get('/create_product', [ProductController::class, 'displayUI'])->name('tampilanTambahProduk');
    Route::post('/create_product', [ProductController::class, 'addProduct'])->name('tambahProduk');
    Route::get('/edit_detail_product/{product}',[ProductController::class, 'show_edit'])->name('showEditProduct');
    Route::patch('/update_product/{product}',[ProductController::class, 'update_product_data'])->name('updateDataProduct');
    Route::delete('/delete_product/{product}', [ProductController::class, 'delete_product_data'])->name('deleteDataProduct');

    Route::get('/verify_order',[OrderController::class, 'show_order_confirmation'])->name('showOrderConfirmation');
    Route::post('/verify_confirm_order/{order}', [OrderController::class, 'confirm_payment'])->name('confirmOrder');
});

Route::middleware(['auth'])->group(function(){
    Route::post('/create_cart/{product}',[CartController::class, 'create_cart'])->name('createCart');

    Route::post('/edit_cart/{cart}',[CartController::class, 'change_to_cart'])->name('changeCartQty');
    Route::delete('/delete_cart/{cart}', [CartController::class, 'delete_cart'])->name('deleteCart');

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/show_detail_order/{order}', [OrderController::class, 'show_detail'])->name('showDetailOrder');
    Route::post('/submit_payment/{order}', [OrderController::class, 'submit_payment'])->name('submitPayment');
});

Route::get('/show_product', [ProductController::class, 'show_product'])->name('showAllProduct');
Route::get('/show_detail_product/{product}_{angka}',[ProductController::class, 'show_detail'])->name('showDetailProduct');

Route::get('/show_cart_lists', [CartController::class, 'show_cart'])->name('showCartLists');

Route::get('/show_order_list',[OrderController::class, 'show_order'])->name('showOrderList');

Route::get('/edit_profile', [ProfileController::class, 'display_profile'])->name('displayProfile');
Route::post('/change_profile', [ProfileController::class, 'change_profile'])->name('changeProfile');