<?php

use App\Http\Controllers\Admin\RaffleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\CartShopingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RaffleController as RaffleControllerPublic;
use App\Models\Raffle;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cart', [CartShopingController::class,'index'])->name('cart.index');
Route::post('/cart', [CartShopingController::class,'addItem'])->name('cart.addItem');
Route::delete('/cart/{id}', [CartShopingController::class,'removeItem'])->name('cart.remove');
Route::post('/checkout', [CartShopingController::class,'checkout'])->name('cart.checkout');
Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');

//intranet

Route::resource('users', UserController::class);
Route::resource('rifas', RaffleController::class);

Route::get('assignaciones', [AssignmentController::class, 'index'])->name('assignaciones.index');
Route::post('assignaciones', [AssignmentController::class, 'store'])->name('assignaciones.store');
Route::get('rifas-asignadad/{id}', [AssignmentController::class, 'detail'])->name('assignaciones.detail');
