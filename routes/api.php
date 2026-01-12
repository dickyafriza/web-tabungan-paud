<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

// Health Check Endpoint (for Render.com and monitoring)
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'app' => config('app.name'),
        'version' => '1.0.0'
    ]);
});

// JWT Authentication Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});

// Protected routes - Requires authentication
Route::middleware(['auth:api', 'throttle:5,1'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Public API Routes - No authentication required
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('saldo/{siswa?}', 'SiswaController@getSaldo')->name('api.getsaldo');
    Route::post('menabung/{siswa?}', 'TabunganController@menabung')->name('api.menabung');
    Route::get('tagihan/{siswa?}', 'TransaksiController@tagihan')->name('api.gettagihan');
    Route::post('transaksi-spp/{siswa?}', 'TransaksiController@store')->name('api.tagihan');
});