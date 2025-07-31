<?php

use App\Http\Controllers\Guest\Calculator\ProcessLitigationFeeController;
use App\Http\Controllers\Guest\Calculator\ShowLitigationFeeController;
use Illuminate\Support\Facades\Route;


Route::prefix('kalkulator')->group(function () {
    Route::get('/ar-kalkulator', [ShowLitigationFeeController::class, 'index'])->name('litigation-fee.index');
    Route::get('/ar-kalkulator/calculate', [ProcessLitigationFeeController::class, 'handle'])->name('litigation-fee.process');
});
