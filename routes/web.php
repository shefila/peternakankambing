<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminSavingController;
use App\Http\Controllers\AdminDataSavingController;
use App\Http\Controllers\WalletController;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Route;

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
    $min_price_product = ProductDetail::orderBy('price')->value('price');
    $products = Product::orderBy('id')->take(5)->get();
    return view('welcome', compact('min_price_product', 'products'));
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/my/order', [HomeController::class, 'order'])->name('my.order');
Route::get('/my/order/invoice/{order}', [HomeController::class, 'orderDetail'])->name('my.order.detail');
Route::get('/my/order/invoice/{order}/upload', [HomeController::class, 'uploadForm'])->name('my.order.detail.upload');
Route::patch('/my/order/invoice/{order}/upload', [HomeController::class, 'updatePayment'])->name('my.order.detail.upload.save');
Route::get('/my/order/new', [HomeController::class, 'createOrder'])->name('my.order.new');
Route::post('/my/order/new', [HomeController::class, 'addProduct'])->name('my.order.new.addProduct');
Route::post('/add-to-cart', [HomeController::class, 'addToCart']);
Route::post('/remove-from-cart/{id}', [HomeController::class, 'removeFromCart']);
Route::post('/create-order', [HomeController::class, 'submitOrder']);
Route::get('/my/withdrawal', [HomeController::class, 'withdrawalUser'])->name('my.withdrawal');
Route::post('/my/withdrawal', [HomeController::class, 'withdrawalUserSubmit'])->name('my.withdrawal.submit');
Route::get('/my/withdrawal/{transaction}/cancel', [HomeController::class, 'withdrawalUserCancel'])->name('my.withdrawal.cancel');
Route::get('/my/saving', [SavingController::class, 'index'])->name('my.saving');
Route::post('/my/saving/store', [SavingController::class, 'store'])->name('my.saving.store');
Route::get('/my/saving/detail/{saving}', [SavingController::class, 'detail'])->name('my.saving.detail');
Route::post('/my/saving/detail/{saving}/start', [SavingController::class, 'start'])->name('my.saving.detail.start');
Route::get('/my/saving/upload/{transaction}', [SavingController::class, 'upload'])->name('my.saving.upload');
Route::get('/my/saving/upload/{transaction}/cancel', [SavingController::class, 'cancel'])->name('my.saving.cancel');
Route::post('/my/saving/upload/{transaction}', [SavingController::class, 'updatePayment'])->name('my.saving.upload.payment');




Route::group(['middleware' => ['is_admin']], function () {


    Route::apiResource('product', ProductController::class, [
        'only' => ['index', 'store', 'show'],
    ]);

    Route::post('product/{product}/add', [ProductController::class, 'addVariant'])->name('productVariant.add');
    Route::delete('product/removeVariant/{productDetail}', [ProductController::class, 'removeVariant'])->name('productVariant.remove');
    Route::patch('product/updateVariant/{productDetail}', [ProductController::class, 'updateVariant'])->name('productVariant.update');

    Route::apiResource('order', OrderController::class, [
        'only' => ['index', 'show'],
    ]);

    Route::apiResource('report', ReportController::class, [
        'only' => ['index', 'store', 'show'],
    ]);

    Route::apiResource('saving', AdminSavingController::class, [
        'only' => ['index'],
    ]);
    Route::patch('saving/update/{transaction}',[AdminSavingController::class,'update'])->name('saving.update');

    Route::apiResource('withdrawal', WalletController::class, [
        'only' => ['index'],
    ]);
    Route::patch('withdrawal/update/{transaction}',[WalletController::class,'confirm'])->name('withdrawal.confirm');
    Route::patch('withdrawal/update/{transaction}/reject',[WalletController::class,'reject'])->name('withdrawal.reject');

    Route::apiResource('datasaving', AdminDataSavingController::class, [
        'only' => ['index', 'show'],
    ]);


    Route::post('order/{order}/update-status', [OrderController::class, 'updateStatus']);
});
