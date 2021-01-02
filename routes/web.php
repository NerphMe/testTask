<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CurrencyExchangeController;
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
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/dashboard', [AdminController::class, 'view'])->name('admin.view');
    Route::get('/dataTables', [AdminController::class, 'dataTables'])->name('dataTables');
    Route::get('/transactionsDatatables', [AdminController::class, 'transactionsDatatables'])->name('transactionsDatatables');
    Route::get('/transactionsDashboard', [AdminController::class, 'transactionsView'])->name('admin.transactions.view');



});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/exchangerView', [CurrencyExchangeController::class, 'view'])->name('exchanger.view');
Route::post('/exchanger', [CurrencyExchangeController::class, 'exchanger'])->name('exchanger');
Route::post('/crypto-exchanger', [CurrencyExchangeController::class, 'cryptoExchanger'])->name('crypto.exchanger');
Route::get('/userBalance', [CurrencyExchangeController::class, 'userBalance'])->name('userBalance');
