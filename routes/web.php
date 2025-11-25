<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home']);
Route::get('/dollar-request-form', [HomeController::class, 'index']);
Route::get('/search-customer', [HomeController::class, 'searchCustomer']);
Route::post('/submit-request', [HomeController::class, 'submitRequest'])->middleware('throttle:3,1');
Route::get('/request-success/{id}', [HomeController::class, 'requestSuccess'])->name('request.success')->middleware('signed');

