<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// web.php
Route::get('/kabupaten/{provinsiId}', [LocationController::class, 'getKabupaten']);
Route::get('/kecamatan/{kabupatenId}', [LocationController::class, 'getKecamatan']);
Route::get('/desa/{kecamatanId}', [LocationController::class, 'getDesa']);



