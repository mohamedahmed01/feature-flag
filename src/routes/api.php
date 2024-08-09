<?php

use Illuminate\Support\Facades\Route;
use Mohamedahmed01\FeatureFlag\Http\Controllers\API\FeatureFlagController;

Route::prefix('feature-flags')->group(function () {
    Route::get('/report', [FeatureFlagController::class, 'report'])->name('feature-flags.report');
    Route::get('/{id}', [FeatureFlagController::class, 'show'])->name('feature-flags.show');
    Route::put('/{id}', [FeatureFlagController::class, 'update'])->name('feature-flags.update');
    Route::delete('/{id}', [FeatureFlagController::class, 'destroy'])->name('feature-flags.destroy');
    Route::get('/', [FeatureFlagController::class, 'index'])->name('feature-flags.index');
    Route::post('/', [FeatureFlagController::class, 'store'])->name('feature-flags.store');

});
