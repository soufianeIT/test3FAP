<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Faker\Provider\ar_EG\Payment;
use Gloudemans\Shoppingcart\Facades\Cart;


Route::get('/', function () {
    return view('welcome');
});


// Route::get('/removebag', function () {
//     Cart::destroy();
// });


Route::get('/product', [ProductController::class,'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('products.show');

Route::get('/search', [ProductController::class,'search'])->name('products.search');


Route::get('/bag', [CartController::class,'index'])->name('cart.index');
Route::post('/bag/add', [CartController::class,'store'])->name('cart.store');
Route::patch('/bag/{rowId}', [CartController::class,'update'])->name('cart.update');
Route::delete('/bag/{rowId}', [CartController::class,'destroy'])->name('cart.destroy');  


Route::group(['middleware' => ['auth']], function () {
    Route::get('/payment', [PaymentController::class,'index'])->name('payment.index');
    Route::post('/payment', [PaymentController::class,'store'])->name('payment.store');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('order/{orderId}/download', [OrderController::class, 'downloadPdf'])->name('order.downloadPdf');
