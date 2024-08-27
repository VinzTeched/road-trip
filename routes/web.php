<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dd', function () {
    return view('welcome');
});

Route::get('/ddw', function () {
    return view('welcome');
});