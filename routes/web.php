<?php

use App\Http\Controllers\CheskyFogelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fogel', [CheskyFogelController::class, 'export_date']);
