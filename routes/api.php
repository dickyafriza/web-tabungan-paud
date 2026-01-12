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

// ============================================================================
// Tier 1 (Strict): Authentication Endpoints - 5 requests/minute per IP
// Protects against brute force attacks
// ============================================================================
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
});

// ============================================================================
// JWT Authenticated Routes (Logout, Refresh, Me)
// ============================================================================
Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);
});

// ============================================================================
// Tier 3 (Permissive): Protected CRUD - 100 requests/minute per User ID
// For authenticated users performing CRUD operations
// ============================================================================
Route::middleware(['auth:api', 'throttle:100,1'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Protected tabungan endpoints (for admin operations)
    Route::get('tabungan', 'TabunganController@apiIndex')->name('api.tabungan.index');
    Route::get('tabungan/{id}', 'TabunganController@apiShow')->name('api.tabungan.show');
    Route::post('tabungan', 'TabunganController@apiStore')->name('api.tabungan.store');
    Route::put('tabungan/{id}', 'TabunganController@apiUpdate')->name('api.tabungan.update');
    Route::delete('tabungan/{id}', 'TabunganController@apiDestroy')->name('api.tabungan.destroy');
    
    // Protected siswa endpoints
    Route::get('siswa', 'SiswaController@apiIndex')->name('api.siswa.index');
    Route::get('siswa/{id}', 'SiswaController@apiShow')->name('api.siswa.show');
});

// ============================================================================
// Tier 2 (Moderate): Public Endpoints - 60 requests/minute per IP
// For general public access
// ============================================================================
Route::middleware(['throttle:60,1'])->group(function () {
    // Saldo endpoints
    Route::get('saldo/{siswa?}', 'SiswaController@getSaldo')->name('api.getsaldo');
    
    // Menabung endpoints
    Route::post('menabung/{siswa?}', 'TabunganController@menabung')->name('api.menabung');
    
    // Tagihan & SPP endpoints
    Route::get('tagihan/{siswa?}', 'TransaksiController@tagihan')->name('api.gettagihan');
    Route::post('transaksi-spp/{siswa?}', 'TransaksiController@store')->name('api.tagihan');
});