<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrakiraanCuaca;
use App\Models\RiwayatPengambilanCuaca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class CuacaController extends Controller
{
    // Fetch data dari API BMKG dan simpan/update di DB
    public function syncCuacaBmkg($kodeWilayah)
    {
        $waktuSekarang = now();
        $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kodeWilayah}";

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                throw new Exception("Gagal terhubung ke API BMKG: " . $response->status());
            }

            $data = $response->json();
            $count = 0;

            // Mengambil array list prakiraan cuaca dari struktur API BMKG
            $cuacaList = $data['data'][0]['cuaca'] ?? [];

            // Jika $cuacaList berupa array bertingkat (berisi list per rentang hari)
            if (!empty($cuacaList)) {
                foreach ($cuacaList as $item) {
                    // Beberapa endpoint BMKG mengembalikan array cuaca bertingkat per harinya
                    if (is_array(reset($item))) {
                        foreach ($item as $subItem) {
                            $this->savePrakiraan($kodeWilayah, $subItem, $waktuSekarang);
                            $count++;
                        }
                    } else {
                        $this->savePrakiraan($kodeWilayah, $item, $waktuSekarang);
                        $count++;
                    }
                }
            }

            // Catat riwayat sukses
            RiwayatPengambilanCuaca::create([
                'kode_wilayah' => $kodeWilayah,
                'waktu_pengambilan' => $waktuSekarang,
                'status' => 'berhasil',
                'pesan' => 'Data berhasil dicocokkan & disimpan',
                'jumlah_data' => $count,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "Data cuaca berhasil diperbarui ($count data)",
            ], 200);

        } catch (Exception $e) {
            // Catat riwayat gagal
            RiwayatPengambilanCuaca::create([
                'kode_wilayah' => $kodeWilayah,
                'waktu_pengambilan' => $waktuSekarang,
                'status' => 'gagal',
                'pesan' => $e->getMessage(),
                'jumlah_data' => 0,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper method untuk menyimpan/mengubah data prakiraan cuaca
     */
    private function savePrakiraan($kodeWilayah, array $item, $waktuSekarang)
    {
        // BMKG biasa menggunakan key 'local_datetime' atau 'datetime'
        $waktuPrakiraan = $item['local_datetime'] ?? $item['datetime'] ?? $waktuSekarang;

        PrakiraanCuaca::updateOrCreate(
            [
                'kode_wilayah'    => $kodeWilayah,
                'waktu_prakiraan' => $waktuPrakiraan,
            ],
            [
                'suhu'             => $item['t'] ?? $item['suhu'] ?? 0,
                'kelembapan'       => $item['hu'] ?? $item['kelembapan'] ?? 0,
                'kode_cuaca'       => $item['weather'] ?? $item['kode_cuaca'] ?? '',
                'keterangan_cuaca' => $item['weather_desc'] ?? $item['keterangan_cuaca'] ?? '',
                'kecepatan_angin'  => $item['ws'] ?? $item['kecepatan_angin'] ?? null,
                'arah_angin'       => $item['wd'] ?? $item['arah_angin'] ?? null,
                'tutupan_awan'     => $item['tcc'] ?? $item['tutupan_awan'] ?? null,
                'jarak_pandang'    => $item['vs_text'] ?? $item['vs'] ?? $item['jarak_pandang'] ?? null,
                'gambar_cuaca'     => $item['image'] ?? $item['gambar_cuaca'] ?? null,
                'waktu_diambil'    => $waktuSekarang,
            ]
        );
    }

    // Endpoint API Backend untuk dikonsumsi Frontend/Mobile
    public function getCuacaByWilayah($kodeWilayah)
    {
        $cuaca = PrakiraanCuaca::where('kode_wilayah', $kodeWilayah)
                    ->orderBy('waktu_prakiraan', 'asc')
                    ->get();

        // Jika data di database kosong, lakukan sync otomatis dari BMKG
        if ($cuaca->isEmpty()) {
            $this->syncCuacaBmkg($kodeWilayah);
            
            // Ambil ulang data setelah di-sync
            $cuaca = PrakiraanCuaca::where('kode_wilayah', $kodeWilayah)
                        ->orderBy('waktu_prakiraan', 'asc')
                        ->get();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $cuaca
        ]);
    }
}