<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CustomersGroupsController;
use App\Http\Controllers\SendingsController;
use App\Http\Controllers\TemplatesController;

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

Route::get('/', [SendingsController::class, 'index'])->name('dashboard');

Route::prefix('sendings')->group(function () {
    Route::get('/create', [SendingsController::class, 'create'])->name('sendings-create');
    Route::post('/store', [SendingsController::class, 'store'])->name('sendings-store');
});

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomersController::class, 'index'])->name('customers');
    Route::get('/create', [CustomersController::class, 'create'])->name('customers-create');
    Route::post('/store', [CustomersController::class, 'store'])->name('customers-store');
});

Route::prefix('customers-groups')->group(function () {
    Route::get('/', [CustomersGroupsController::class, 'index'])->name('customers-groups');
    Route::post('/store', [CustomersGroupsController::class, 'store'])->name('customers-groups-store');
    Route::post('{customerGroup}/update', [CustomersGroupsController::class, 'update'])->name('customers-groups-update');
    Route::get('{customerGroup}/show/', [CustomersGroupsController::class, 'show'])->name('customers-groups-show');
    Route::post('{customerGroup}/delete/', [CustomersGroupsController::class, 'delete'])->name('customers-groups-delete');
    Route::post('/add-customer/', [CustomersGroupsController::class, 'addCustomer'])->name('customers-groups-add-customer');
    Route::post('/remove-customer/', [CustomersGroupsController::class, 'removeCustomer'])->name('customers-groups-remove-customer');
});

Route::prefix('templates')->group(function () {
    Route::get('/', [TemplatesController::class, 'index'])->name('templates');
    Route::get('/create', [TemplatesController::class, 'create'])->name('templates-create');
    Route::post('/store', [TemplatesController::class, 'store'])->name('templates-store');
});
