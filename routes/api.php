<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestinationController;

Route::post('/destinations', [DestinationController::class, 'store']);
