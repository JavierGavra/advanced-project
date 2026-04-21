<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth.session')->group(function () {
    Route::get('/', function () {
        return view('master.index');
    });
});

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);