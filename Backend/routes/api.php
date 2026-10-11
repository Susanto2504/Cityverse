<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CuacaController;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\LingkunganController;
use App\Http\Controllers\Api\InfrastrukturController;
use App\Http\Controllers\SimulasiKebijakanController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SatuDataController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

Route::get('/wilayah', [WilayahController::class, 'index']);
Route::get('/cuaca/{kode_wilayah}', [CuacaController::class, 'getCuacaByWilayah']);
Route::get('/simulasi-kebijakan', [SimulasiKebijakanController::class, 'index']);
Route::get('/jalan', [JalanController::class, 'index']);
Route::get('/lingkungan/ambil', [LingkunganController::class, 'ambilData']);
Route::get('/lingkungan', [LingkunganController::class, 'dataLingkungan']);
Route::get('/infrastruktur', [InfrastrukturController::class, 'index']);
Route::get('/satu-data/2025', [SatuDataController::class,'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/users', [AuthController::class, 'users']);
    Route::post('/users', [AuthController::class, 'createUser']);
    Route::put('/user/password', [AuthController::class, 'updatePassword']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::post('/user/email/verification-notification',[AuthController::class, 'sendVerificationEmail']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/users/{id}',[AuthController::class, 'deleteUser']);

    Route::post('/satu-data/sync/2025', [SatuDataController::class,'sync']);

    Route::get('/wilayah/{kode_wilayah}', [WilayahController::class, 'show']);
    Route::get('/cuaca/sync/{kode_wilayah}', [CuacaController::class, 'syncCuacaBmkg']);
    
    Route::post('/gemini/generate', [GeminiController::class, 'generate']);

    Route::post('/simulasi-kebijakan', [SimulasiKebijakanController::class, 'store']);
    Route::get('/simulasi-kebijakan/{simulasiKebijakan}', [SimulasiKebijakanController::class, 'show']);
    Route::put('/simulasi-kebijakan/{simulasiKebijakan}', [SimulasiKebijakanController::class, 'update']);
    Route::delete('/simulasi-kebijakan/{simulasiKebijakan}', [SimulasiKebijakanController::class, 'destroy']);

    Route::post('/jalan/sync-osm', [JalanController::class, 'syncOSM']);
    Route::post('/jalan/generate-traffic', [JalanController::class, 'generateTraffic']);

    Route::get('/lingkungan/simpan/iku', [LingkunganController::class, 'simpanIku']);
    Route::get('/lingkungan/simpan/ika', [LingkunganController::class, 'simpanIKA']);
    Route::get('/lingkungan/simpan/persampahan-data', [LingkunganController::class, 'simpanPersampahanData']);
    Route::get('/lingkungan/simpan/persampahan-capaian', [LingkunganController::class, 'simpanPersampahanCapaian']);
    Route::get('/lingkungan/simpan/persampahan-terkelola', [LingkunganController::class, 'simpanPersampahanTerkelola']);
    Route::get('/lingkungan/simpan/persampahan-komposisi', [LingkunganController::class, 'simpanPersampahanKomposisi']);
    Route::get('/lingkungan/simpan/risiko-banjir', [LingkunganController::class, 'simpanRisikoBanjir']);

    Route::post('/infrastruktur/sync', [InfrastrukturController::class, 'sync']);
});

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals(
        sha1($user->getEmailForVerification()),
        $hash
    )) {
        abort(403, 'Link verifikasi tidak valid.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return response()->json([
        'message' => 'Email berhasil diverifikasi.',
    ]);
})->middleware('signed')->name('verification.verify');


