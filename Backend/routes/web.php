<?php

use App\Http\Controllers\Api\InfrastrukturController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\LingkunganController;
use App\Models\Jalan;
use Illuminate\Support\Facades\Route;
use Gemini\Laravel\Facades\Gemini;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/data-jalan', function () {
//     $jalan = Jalan::with('segmenJalans')->orderBy('nama_ruas_jalan')->get();
//     return view('jalan.index', compact('jalan'));
// });

Route::get('/data-jalan', [JalanController::class, 'indexBlade'])
    ->name('jalan.index');
Route::get('/data-jalan/tambah', [JalanController::class, 'create'])
    ->name('jalan.create');
Route::post('/data-jalan', [JalanController::class, 'store'])
    ->name('jalan.store');
Route::get('/data-jalan/{id}', [JalanController::class, 'show'])
    ->name('jalan.show');
Route::get('/data-jalan/{id}/edit', [JalanController::class, 'edit'])
    ->name('jalan.edit');
Route::put('/data-jalan/{id}', [JalanController::class, 'update'])
    ->name('jalan.update');
Route::delete('/data-jalan/{id}', [JalanController::class, 'destroy'])
    ->name('jalan.destroy');


Route::get('/infrastruktur', [InfrastrukturController::class, 'view'])
    ->name('infrastruktur.view');
Route::get('/infrastruktur/tambah', [InfrastrukturController::class, 'create'])
    ->name('infrastruktur.create');
Route::post('/infrastruktur', [InfrastrukturController::class, 'store'])
    ->name('infrastruktur.store');
Route::get('/infrastruktur/{id}/edit', [InfrastrukturController::class, 'edit'])
    ->name('infrastruktur.edit');
Route::put('/infrastruktur/{id}', [InfrastrukturController::class, 'update'])
    ->name('infrastruktur.update');
Route::get('/infrastruktur/{id}', [InfrastrukturController::class, 'show'])
    ->name('infrastruktur.show');
Route::delete('/infrastruktur/{id}', [InfrastrukturController::class, 'destroy'])
    ->name('infrastruktur.destroy');

Route::get('/lingkungan', [LingkunganController::class, 'index'])
    ->name('lingkungan.index');
Route::get('/lingkungan/{id}/view', [LingkunganController::class, 'view'])
    ->name('lingkungan.view');
Route::get('/lingkungan/{id}/edit', [LingkunganController::class, 'edit'])
    ->name('lingkungan.edit');
Route::put('/lingkungan/{id}', [LingkunganController::class, 'update'])
    ->name('lingkungan.update');

Route::get('/cek-model', function () {
    try {
        // Menggunakan ->models()->list()
        $response = Gemini::models()->list();
        
        $list = [];
        foreach ($response->models as $model) {
            $list[] = [
                'name'        => $model->name,        // Contoh: models/gemini-1.5-flash
                'displayName' => $model->displayName,
                'description' => $model->description,
            ];
        }

        return response()->json($list);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});