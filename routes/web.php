<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/request-form', [HomeController::class, 'index']);
Route::get('/search-customer', [HomeController::class, 'searchCustomer']);
Route::post('/submit-request', [HomeController::class, 'submitRequest']);

