<?php

use App\Http\Controllers\Admin\RaffleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartShopingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RaffleController as RaffleControllerPublic;
use App\Http\Controllers\Client\LoginClientController;
use App\Models\Raffle;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/', [RaffleControllerPublic::class, 'index'])->name('welcome');


Auth::routes();
// uuid value example: 1b9d6bcd-bbfd-4b2d-9b5d-ab8dfbbd4bed
 // other example whit diferent uuid value: 2adff3d4-ff2b-4c15-9f9c-1d92eeb8e1a1
 

Route::get('/user-register/1b9d6bcd-bbfd-4b2d-9b5d-ab8dfbbd4bed', [App\Http\Controllers\UserRegisterController::class, 'showRegistrationUserForm'])->name('registerUser');
Route::post('/user-register/store', [App\Http\Controllers\UserRegisterController::class, 'userRegister'])->name('user.register-store');


Route::get('/admin-register/2adff3d4-ff2b-4c15-9f9c-1d92eeb8e1a1', [App\Http\Controllers\UserRegisterController::class, 'showRegistrationAdminForm'])->name('registerAdmin');
Route::post('/admin-register/store', [App\Http\Controllers\UserRegisterController::class, 'adminRegister'])->name('admin.register-store');


Route::get('/client/login', [LoginClientController::class, 'showClientLoginForm'])->name('login-client-view');
Route::post('/client/login', [LoginClientController::class, 'login'])->name('login-client');
Route::get('/client/register', [App\Http\Controllers\Client\RegisterClientController::class, 'showClientRegisterForm'])->name('register-client');
Route::post('/client/register', [App\Http\Controllers\Client\RegisterClientController::class, 'register'])->name('register-client-store');
Route::get('/client/update', [App\Http\Controllers\Client\RegisterClientController::class, 'showClientUpdateForm'])->name('client-update-view');
Route::put('/client/update', [App\Http\Controllers\Client\RegisterClientController::class, 'update'])->name('client-update');
Route::post('/client/logout', [App\Http\Controllers\Client\LoginClientController::class, 'logout'])->name('logout-client');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/cart', [CartShopingController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartShopingController::class, 'addItem'])->name('cart.addItem');
Route::delete('/cart/{id}', [CartShopingController::class, 'removeItem'])->name('cart.remove');
Route::post('/checkout', [CartShopingController::class, 'checkout'])->name('cart.checkout');
Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::post('/purchases/store-invoice-payment-image', [PurchaseController::class, 'storeInvoicePaymentImage'])->name('purchases.storeInvoicePaymentImage');
Route::delete('/purchases/delete-invoice-payment-image/{id}', [PurchaseController::class, 'deleteInvoicePaymentImage'])->name('purchases.deleteInvoicePaymentImage');

//intranet


Route::group(['middleware' => 'auth:web'], function () {
    Route::resource('users', UserController::class);
    Route::post('/rifas/store-file', [RaffleController::class, 'storeFile'])->name('rifas.storeFiles');
    Route::delete('/rifas/delete-file/{id}', [RaffleController::class, 'deleteFile'])->name('rifas.deleteFile');
    Route::get('/rifas-status', [RaffleController::class, 'status'])->name('rifas.status');
    Route::post('rifas/request-change-status', [RaffleController::class, 'requestChangeStatus'])->name('rifas.requestChangeStatus');
    Route::get('request-change-status-detail/{id}', [App\Http\Controllers\Admin\ChangeStatusRequestController::class, 'requestChangeStatusDetail'])->name('rifas.requestChangeStatusDetail');
    Route::post('change-status-requests', [App\Http\Controllers\Admin\ChangeStatusRequestController::class, 'changeStatusRequest'])->name('changeStatusRequest.changeStatus');
    Route::get('change-status-requests', [App\Http\Controllers\Admin\ChangeStatusRequestController::class, 'index'])->name('change-status-requests.index');
    Route::resource('rifas', RaffleController::class);

    Route::get('assignaciones', [AssignmentController::class, 'index'])->name('assignaciones.index');
    Route::post('assignaciones', [AssignmentController::class, 'store'])->name('assignaciones.store');

    Route::post('/orders/change-status', [OrderController::class, 'changeStatus'])->name('orders.changeStatus');
    Route::post('/orders/store-file', [OrderController::class, 'storeFile'])->name('orders.storeFiles');
    Route::post('/orders/store-payment', [OrderController::class, 'storePayment'])->name('orders.storePayment');
    Route::delete('/orders/delete-file/{id}', [OrderController::class, 'deleteFile'])->name('orders.deleteFile');
    Route::resource('orders', OrderController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('payments', PaymentController::class);
});


Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return 'success';
});

Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'success';
});
