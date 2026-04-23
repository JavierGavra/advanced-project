<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailTutorialController;
use App\Http\Controllers\FinishedController;
use App\Http\Controllers\MasterTutorialController;
use App\Http\Controllers\PresentationController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth.session')->group(function () {
    Route::get('/', function () {
        return redirect('/master');
    });

    Route::prefix('master')->group(function () {
        Route::get('/', [MasterTutorialController::class, 'index']);
        Route::get('/create', [MasterTutorialController::class, 'create']);
        Route::post('/store', [MasterTutorialController::class, 'store']);
        Route::get('/{master}/edit', [MasterTutorialController::class, 'edit']);
        Route::post('/{master}/update', [MasterTutorialController::class, 'update']);
        Route::delete('/{master}/delete', [MasterTutorialController::class, 'destroy']);

        Route::prefix('/{master}/detail')->group(function () {
            Route::get('/', [DetailTutorialController::class, 'index']);
            Route::get('/create', [DetailTutorialController::class, 'create']);
            Route::post('/store', [DetailTutorialController::class, 'store']);
            Route::get('/{detail}/edit', [DetailTutorialController::class, 'edit']);
            Route::post('/{detail}/update', [DetailTutorialController::class, 'update']);
            Route::delete('/{detail}/delete', [DetailTutorialController::class, 'destroy']);
            
            Route::post('/{detail}/toggle-status', [DetailTutorialController::class, 'toggleStatus'])->name('detail.toggleStatus');
        });
    });

});

Route::prefix('presentation')->group(function () {
    Route::get('/{slug}', [PresentationController::class, 'show']);
    Route::get('/{slug}/poll', [PresentationController::class, 'poll']);
});

Route::prefix('finished')->group(function () {
    Route::get('/{slug}', [FinishedController::class, 'show']);
});
    
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
