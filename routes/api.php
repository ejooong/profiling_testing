<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GisController;

Route::prefix('api')->group(function () {
    // GIS API routes - accessible without authentication for map loading
    Route::prefix('gis')->name('api.gis.')->group(function () {
        Route::get('/data', [GisController::class, 'apiData'])->name('data');
        Route::get('/geojson/{type}/{id?}', [GisController::class, 'getGeojson'])->name('geojson');
        Route::get('/statistics', [GisController::class, 'getStatistics'])->name('statistics');
    });
});