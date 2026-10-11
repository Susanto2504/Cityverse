<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SatuDataSektoral;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class SatuDataController extends Controller
{
    private string $url =
        'https://data.makassarkota.go.id/datasektorals/20/272/2025';

    public function index()
    {
        $record = SatuDataSektoral::where('kode_sektor', '20')
            ->where('kode_data', '272')
            ->where('tahun', 2025)
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Data belum tersimpan. Jalankan sinkronisasi terlebih dahulu.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $record->data,
            'disinkronkan_pada' => $record->disinkronkan_pada,
        ]);
    }

    public function sync()
    {
        try {
            $response = Http::acceptJson()
                ->timeout(30)
                ->get($this->url);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API Makassar mengembalikan HTTP ' . $response->status(),
                ], 502);
            }

            $rows = $response->json();

            if (!is_array($rows) || !array_is_list($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format respons API bukan array JSON yang diharapkan.',
                ], 502);
            }

            DB::transaction(function () use ($rows) {
                SatuDataSektoral::updateOrCreate(
                    [
                        'sumber' => 'data.makassarkota.go.id',
                        'kode_sektor' => '20',
                        'kode_data' => '272',
                        'tahun' => 2025,
                    ],
                    [
                        'data' => $rows,
                        'disinkronkan_pada' => Carbon::now(),
                    ]
                );
            });

            return response()->json([
                'success' => true,
                'message' => 'Sinkronisasi data sektoral berhasil.',
                'jumlah_data' => count($rows),
                'tahun' => 2025,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Sinkronisasi gagal. Periksa log Laravel.',
            ], 500);
        }
    }
}
