<?php

use App\Http\Controllers\Admin\RaffleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AssignmentController;
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

Route::get('/', function () {
    $rifas = Raffle::paginate(50);
    return view('welcome', compact(['rifas']));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//intranet

Route::resource('users', UserController::class);
Route::resource('rifas', RaffleController::class);

Route::get('assignaciones', [AssignmentController::class, 'index'])->name('assignaciones.index');
Route::post('assignaciones', [AssignmentController::class, 'store'])->name('assignaciones.store');
Route::get('rifas-asignadad/{id}', [AssignmentController::class, 'detail'])->name('assignaciones.detail');
