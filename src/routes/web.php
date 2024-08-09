<?php

use Illuminate\Support\Facades\Route;
use Mohamedahmed01\FeatureFlag\Http\Controllers\FeatureFlagController;

Route::prefix('feature-flags')->group(function () {
    Route::get('/report', [FeatureFlagController::class, 'report'])->name('feature-flags-web.report');
    Route::get('/create', [FeatureFlagController::class, 'create'])->name('feature-flags-web.create');
    Route::get('/{featureFlag}', [FeatureFlagController::class, 'show'])->name('feature-flags-web.show');
    Route::get('/{featureFlag}/edit', [FeatureFlagController::class, 'edit'])->name('feature-flags-web.edit');
    Route::put('/{featureFlag}', [FeatureFlagController::class, 'update'])->name('feature-flags-web.update');
    Route::delete('/{featureFlag}', [FeatureFlagController::class, 'destroy'])->name('feature-flags-web.destroy');
    Route::get('/', [FeatureFlagController::class, 'index'])->name('feature-flags-web.index');
    Route::post('/', [FeatureFlagController::class, 'store'])->name('feature-flags-web.store');
});
