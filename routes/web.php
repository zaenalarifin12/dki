<?php

use App\Http\Controllers\NasabahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [NasabahController::class, "index"]);
    Route::get('/nasabah', [NasabahController::class, "add"]);
    Route::post('/nasabah', [NasabahController::class, "store"]);
    Route::get('/nasabah/{id}', [NasabahController::class, "detail"]);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::post('/nasabah/approve/{id}', [NasabahController::class, "approve"]);
});

Route::get('/data-nasabah', [NasabahController::class, "getNasabahData"]);



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
