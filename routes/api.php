<?php

use App\Http\Controllers\Api\MataKuliahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/{kode_matkul}', [MataKuliahController::class, 'index']);