<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/invoice', function () {
    return "test";
})->name('invoice')->middleware('auth.admin');


