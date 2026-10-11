<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class GeminiController extends Controller
{
    private string $model = 'gemini-3.5-flash';

    public function generate(Request $request)
    {
        set_time_limit(180);

        try {
            $apiKey = env('DEATCODE_API_KEY');

            if (!$apiKey) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'DEATCODE_API_KEY belum ada di file .env',
                ], 500);
            }

            $validated = $request->validate([
                'judul' => 'nullable|string|max:255',
                'jenis' => 'required|string|max:100',
                'jenis_label' => 'nullable|string|max:255',
                'skenario' => 'required|string',
                'target' => 'nullable',
                'baseline' => 'nullable',
                'domains' => 'nullable|array',

                'rekayasa_lalu_lintas' => 'nullable|array',

                'rekayasa_lalu_lintas.lokasi_awal' => 'nullable|array',
                'rekayasa_lalu_lintas.lokasi_awal.id_jalan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_awal.nama_ruas_jalan' => 'nullable|string',
                'rekayasa_lalu_lintas.lokasi_awal.panjang_m' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_awal.lebar_m' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_awal.kapasitas_jalan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_awal.volume_kendaraan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_awal.tingkat_kepadatan' => 'nullable',

                'rekayasa_lalu_lintas.lokasi_awal.kondisi_jalan' => 'nullable|array',
                'rekayasa_lalu_lintas.lokasi_awal.kondisi_jalan.*.kondisi_jalan' => 'nullable|string',
                'rekayasa_lalu_lintas.lokasi_awal.kondisi_jalan.*.panjang_kondisi_m' => 'nullable|numeric',
                'rekayasa_lalu_lintas.lokasi_awal.kondisi_jalan.*.kondisi_lainnya' => 'nullable|string',

                'rekayasa_lalu_lintas.lokasi_target' => 'nullable|array',
                'rekayasa_lalu_lintas.lokasi_target.id_jalan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_target.nama_ruas_jalan' => 'nullable|string',
                'rekayasa_lalu_lintas.lokasi_target.panjang_m' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_target.lebar_m' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_target.kapasitas_jalan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_target.volume_kendaraan' => 'nullable',
                'rekayasa_lalu_lintas.lokasi_target.tingkat_kepadatan' => 'nullable',

                'rekayasa_lalu_lintas.lokasi_target.kondisi_jalan' => 'nullable|array',
                'rekayasa_lalu_lintas.lokasi_target.kondisi_jalan.*.kondisi_jalan' => 'nullable|string',
                'rekayasa_lalu_lintas.lokasi_target.kondisi_jalan.*.panjang_kondisi_m' => 'nullable|numeric',
                'rekayasa_lalu_lintas.lokasi_target.kondisi_jalan.*.kondisi_lainnya' => 'nullable|string',
            ]);

            $judul = $validated['judul'] ?? 'Tanpa Judul';
            $jenis = $validated['jenis'];
            $jenisLabel = $validated['jenis_label'] ?? $jenis;
            $skenario = $validated['skenario'];
            $target = $validated['target'] ?? 'Tidak tersedia';
            $baseline = $validated['baseline'] ?? [];
            $domains = $validated['domains'] ?? [];
            $rekayasaLaluLintas = $validated['rekayasa_lalu_lintas'] ?? null;

            /*
            |--------------------------------------------------------------------------
            | VALIDASI REKAYASA LALU LINTAS
            |--------------------------------------------------------------------------
            */

            if ($jenis === 'rekayasa_lalu_lintas') {
                if (!$rekayasaLaluLintas) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data rekayasa lalu lintas belum dikirim.',
                    ], 422);
                }

                if (
                    empty($rekayasaLaluLintas['lokasi_awal']) ||
                    empty($rekayasaLaluLintas['lokasi_target'])
                ) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Lokasi awal dan lokasi target pengalihan wajib diisi.',
                    ], 422);
                }

                $idAwal = $rekayasaLaluLintas['lokasi_awal']['id_jalan'] ?? null;
                $idTarget = $rekayasaLaluLintas['lokasi_target']['id_jalan'] ?? null;

                if (
                    $idAwal !== null &&
                    $idTarget !== null &&
                    (string) $idAwal === (string) $idTarget
                ) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Lokasi awal dan lokasi target pengalihan tidak boleh sama.',
                    ], 422);
                }

                /*
                |--------------------------------------------------------------------------
                | BACA KONDISI JALAN DARI DATABASE
                |--------------------------------------------------------------------------
                |
                | Data diambil langsung dari tabel segmen_jalans berdasarkan id_jalan.
                |
                */

                if ($idAwal !== null) {
                    $rekayasaLaluLintas['lokasi_awal']['kondisi_jalan'] =
                        $this->getKondisiJalan($idAwal);
                }

                if ($idTarget !== null) {
                    $rekayasaLaluLintas['lokasi_target']['kondisi_jalan'] =
                        $this->getKondisiJalan($idTarget);
                }

                /*
                |--------------------------------------------------------------------------
                | MASUKKAN KONDISI JALAN KE BASELINE
                |--------------------------------------------------------------------------
                */

                if (!isset($baseline['jalan']) || !is_array($baseline['jalan'])) {
                    $baseline['jalan'] = [];
                }

                /*
                |--------------------------------------------------------------------------
                | RUAS TERDAMPAK
                |--------------------------------------------------------------------------
                */

                if ($idAwal !== null) {
                    if (
                        isset($baseline['jalan']['ruas_terdampak']) &&
                        is_array($baseline['jalan']['ruas_terdampak'])
                    ) {
                        $baseline['jalan']['ruas_terdampak'] =
                            $this->attachKondisiJalanToRoadBaseline(
                                $baseline['jalan']['ruas_terdampak'],
                                $idAwal
                            );
                    } else {
                        $baseline['jalan']['ruas_terdampak'] = [
                            'id_jalan' => $idAwal,
                            'nama_ruas_jalan' =>
                                $rekayasaLaluLintas['lokasi_awal']['nama_ruas_jalan'] ?? null,
                            'kondisi_jalan' =>
                                $this->getKondisiJalan($idAwal),
                        ];
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | RUAS TARGET
                |--------------------------------------------------------------------------
                */

                if ($idTarget !== null) {
                    if (
                        isset($baseline['jalan']['ruas_target_pengalihan']) &&
                        is_array($baseline['jalan']['ruas_target_pengalihan'])
                    ) {
                        $baseline['jalan']['ruas_target_pengalihan'] =
                            $this->attachKondisiJalanToRoadBaseline(
                                $baseline['jalan']['ruas_target_pengalihan'],
                                $idTarget
                            );
                    } else {
                        $baseline['jalan']['ruas_target_pengalihan'] = [
                            'id_jalan' => $idTarget,
                            'nama_ruas_jalan' =>
                                $rekayasaLaluLintas['lokasi_target']['nama_ruas_jalan'] ?? null,
                            'kondisi_jalan' =>
                                $this->getKondisiJalan($idTarget),
                        ];
                    }
                }

                Log::info('KONDISI JALAN DATABASE', [
                    'id_jalan_awal' => $idAwal,
                    'kondisi_jalan_awal' =>
                        $rekayasaLaluLintas['lokasi_awal']['kondisi_jalan'] ?? [],

                    'id_jalan_target' => $idTarget,
                    'kondisi_jalan_target' =>
                        $rekayasaLaluLintas['lokasi_target']['kondisi_jalan'] ?? [],
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | JIKA BUKAN REKAYASA LALU LINTAS
            |--------------------------------------------------------------------------
            |
            | Tetap coba membaca kondisi jalan dari ruas terpilih yang ada di baseline.
            |
            */

            if ($jenis !== 'rekayasa_lalu_lintas') {
                if (
                    isset($baseline['jalan']['ruas_terpilih']) &&
                    is_array($baseline['jalan']['ruas_terpilih'])
                ) {
                    $idJalanTerpilih =
                        $baseline['jalan']['ruas_terpilih']['id_jalan'] ?? null;

                    if ($idJalanTerpilih !== null) {
                        $baseline['jalan']['ruas_terpilih'] =
                            $this->attachKondisiJalanToRoadBaseline(
                                $baseline['jalan']['ruas_terpilih'],
                                $idJalanTerpilih
                            );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | JSON BASELINE
            |--------------------------------------------------------------------------
            */

            $baselineJson = json_encode(
                $baseline,
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES |
                JSON_PRETTY_PRINT
            );

            if ($baselineJson === false) {
                $baselineJson = '{}';
            }

            /*
            |--------------------------------------------------------------------------
            | JSON DOMAINS
            |--------------------------------------------------------------------------
            */

            $domainsJson = json_encode(
                $domains,
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES |
                JSON_PRETTY_PRINT
            );

            if ($domainsJson === false) {
                $domainsJson = '[]';
            }

            /*
            |--------------------------------------------------------------------------
            | JSON TARGET
            |--------------------------------------------------------------------------
            */

            $targetJson = json_encode(
                $target,
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES |
                JSON_PRETTY_PRINT
            );

            if ($targetJson === false) {
                $targetJson = '"Tidak tersedia"';
            }

            /*
            |--------------------------------------------------------------------------
            | JSON REKAYASA
            |--------------------------------------------------------------------------
            */

            $rekayasaJson = json_encode(
                $rekayasaLaluLintas,
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES |
                JSON_PRETTY_PRINT
            );

            if ($rekayasaJson === false) {
                $rekayasaJson = '{}';
            }

            /*
            |--------------------------------------------------------------------------
            | SYSTEM PROMPT
            |--------------------------------------------------------------------------
            */

            $systemPrompt = <<<'PROMPT'
Kamu adalah sistem pakar AI untuk simulasi kebijakan perkotaan Kota Makassar.

Tugas kamu adalah melakukan DUA HAL SEKALIGUS dalam satu proses:

1. Menganalisis dampak kebijakan berdasarkan DATA KONDISI SAAT INI sebagai baseline.
2. Membuat PROYEKSI HASIL PENERAPAN kebijakan berdasarkan kondisi sebelum kebijakan, skenario kebijakan, target kebijakan, dan data yang tersedia.

HASIL ANALISIS DAN HASIL PENERAPAN HARUS DIBEDAKAN.

ANALISIS:

Menjelaskan kondisi aktual, dampak, dampak positif, dampak negatif, risiko, rekomendasi, dan kesimpulan.

HASIL PENERAPAN:

Menjelaskan kondisi SEBELUM kebijakan dibandingkan dengan PROYEKSI kondisi SESUDAH kebijakan diterapkan.

HASIL PENERAPAN BUKAN DATA AKTUAL LAPANGAN.

Semua nilai sesudah harus dianggap sebagai PROYEKSI atau ESTIMASI AI.

ATURAN DATA:

1. Gunakan data baseline sebagai kondisi SEBELUM kebijakan.
2. Jangan mengubah nilai baseline.
3. Jangan menganggap baseline sebagai kondisi sesudah.
4. Gunakan skenario kebijakan sebagai intervensi.
5. Gunakan target kebijakan sebagai kondisi yang ingin dicapai.
6. Jangan membuat fakta aktual baru.
7. Jangan menggunakan data eksternal sebagai pengganti baseline.
8. Jangan membuat sumber data baru.
9. Jika suatu data tidak tersedia, nyatakan bahwa data tidak tersedia.
10. Jangan membuat angka yang tidak mempunyai dasar dari data yang diberikan.
11. Jika perubahan dapat dihitung secara matematis dari data yang tersedia, lakukan perhitungan secara transparan.
12. Jika perubahan tidak dapat dihitung secara matematis, gunakan analisis kualitatif.
13. Jika memberikan angka estimasi, wajib menyebutkan bahwa nilai tersebut adalah estimasi AI.
14. Jangan menganggap estimasi sebagai data aktual.
15. Jangan menyatakan kebijakan pasti berhasil.
16. Jangan menyatakan kebijakan pasti gagal.
17. Jika data tidak cukup, jelaskan keterbatasan data.
18. Jangan menyebut klasifikasi jalan seperti Jalan Nasional, Jalan Provinsi, Jalan Arteri, Trunk Road, dan sebagainya jika informasi tersebut tidak tersedia pada baseline.
19. Jangan membuat nilai emisi, PM10, karbon, volume kendaraan, kapasitas jalan, kepadatan, atau parameter lain yang tidak tersedia dan tidak dapat dihitung dari baseline.
20. Jangan menggunakan LaTeX.
21. Jangan menggunakan Markdown.
22. Jangan menggunakan escape seperti \%, \$, \_, \-, \( atau \).
23. Untuk persentase gunakan format "13%" bukan "13\%".
24. Untuk mata uang gunakan format "Rp 100.000".
25. Output wajib berupa JSON valid.
26. Jangan menambahkan ```json.
27. Jangan menambahkan teks sebelum JSON.
28. Jangan menambahkan teks setelah JSON.
29. Semua string JSON harus menggunakan escape JSON standar.

ATURAN KONDISI JALAN:

1. Data kondisi jalan berasal dari tabel segmen jalan pada database.
2. Gunakan kondisi_jalan sebagai DATA AKTUAL KONDISI SEBELUM kebijakan.
3. Gunakan panjang_kondisi_m sebagai panjang kondisi jalan dalam meter.
4. Jangan mengubah nilai panjang_kondisi_m.
5. Jangan membuat panjang kondisi baru.
6. Jika kondisi_jalan bernilai banjir, longsor, atau lainnya, analisis kondisi tersebut.
7. Jika kondisi_jalan bernilai lainnya, gunakan kondisi_lainnya jika tersedia.
8. Jika kondisi jalan tidak tersedia, nyatakan data kondisi jalan tidak tersedia.
9. Jangan menganggap kondisi jalan sebagai hasil proyeksi AI.
10. Untuk lokasi_awal dan lokasi_target, analisis kondisi jalan secara terpisah.
11. Jangan menggabungkan kondisi jalan lokasi_awal dan lokasi_target.
12. Jika terdapat beberapa segmen dengan kondisi berbeda, pertahankan setiap kondisi sebagai data segmen yang berbeda.
13. Jangan menjumlahkan panjang kondisi yang berbeda kecuali secara eksplisit diperlukan untuk analisis dan perhitungannya dapat dipertanggungjawabkan.

ATURAN ANALISIS:

1. Identifikasi kondisi aktual berdasarkan baseline.
2. Identifikasi hubungan antara skenario kebijakan dengan kondisi aktual.
3. Analisis dampak terhadap domain yang relevan.
4. Jelaskan dampak positif berdasarkan hubungan skenario dan baseline.
5. Jelaskan dampak negatif berdasarkan hubungan skenario dan baseline.
6. Identifikasi risiko yang dapat disimpulkan dari data.
7. Berikan rekomendasi yang relevan dengan skenario.
8. Kesimpulan harus didasarkan pada data yang tersedia.

ATURAN HASIL PENERAPAN:

1. Kondisi SEBELUM berasal dari baseline.
2. Kondisi SESUDAH adalah PROYEKSI atau ESTIMASI AI.
3. Jangan mengubah nilai kondisi sebelum.
4. Gunakan skenario sebagai intervensi.
5. Gunakan target sebagai tujuan kebijakan.
6. Tunjukkan perubahan antara kondisi sebelum dan sesudah.
7. Jika nilai sesudah tidak dapat dihitung, gunakan deskripsi kualitatif.
8. Jika memberikan angka sesudah, tandai sebagai "estimasi AI".
9. Jangan mengklaim bahwa nilai sesudah merupakan hasil pengukuran lapangan.
10. Jika data tidak cukup untuk membuat proyeksi numerik, jelaskan keterbatasannya.
11. Nilai sebelum harus berasal dari baseline.
12. Nilai sesudah tidak boleh dianggap sebagai data aktual.

ATURAN KHUSUS PROFIL HASIL PENERAPAN:

1. Profil hasil penerapan digunakan oleh frontend untuk menampilkan kartu kondisi sesudah kebijakan.
2. profil_sesudah harus mewakili kondisi sesudah untuk satu lokasi utama.
3. Jangan mengisi nilai yang tidak tersedia dengan angka buatan.
4. Gunakan null jika data tidak tersedia atau tidak dapat dihitung.
5. Nama ruas harus diambil dari baseline atau data rekayasa lalu lintas.
6. Jumlah segmen harus berasal dari data baseline jika tersedia.
7. Panjang harus berasal dari baseline jika kebijakan tidak mengubah panjang.
8. Lebar rata-rata sesudah boleh berubah jika skenario memang mengubah lebar jalan.
9. Kapasitas sesudah hanya boleh dihitung jika terdapat dasar perhitungan yang jelas dari data dan skenario.
10. Volume kendaraan sesudah tidak boleh dibuat secara sembarangan.
11. Jika volume sesudah tidak dapat dihitung, pertahankan nilai baseline jika kebijakan tidak secara langsung mengubah volume atau gunakan null jika tidak dapat dipertanggungjawabkan.
12. Tingkat kepadatan sesudah harus berupa proyeksi berdasarkan data yang tersedia.
13. Semua nilai numerik hasil penerapan adalah estimasi AI jika bukan hasil perhitungan langsung dari data.

ATURAN PERHITUNGAN:

Jika kapasitas sesudah dapat dihitung dari hubungan proporsional antara lebar sebelum dan lebar sesudah, jelaskan bahwa nilai tersebut merupakan estimasi berdasarkan asumsi proporsional.

Contoh:

kapasitas_sesudah = kapasitas_sebelum × lebar_sesudah / lebar_sebelum

Gunakan rumus ini HANYA jika lebar sebelum tersedia, lebar sesudah dapat diketahui dari skenario, dan tidak ada informasi lain yang menunjukkan hubungan tersebut tidak berlaku.

Jika lebar sebelum bernilai 0 atau tidak tersedia, jangan melakukan pembagian dengan 0 dan jangan membuat kapasitas baru.

ATURAN KHUSUS REKAYASA LALU LINTAS:

1. lokasi_awal adalah ruas jalan yang terdampak.
2. lokasi_target adalah ruas jalan yang menjadi target pengalihan.
3. Analisis kedua ruas secara terpisah.
4. Bandingkan kapasitas kedua ruas jika tersedia.
5. Bandingkan volume kendaraan kedua ruas jika tersedia.
6. Bandingkan tingkat kepadatan kedua ruas jika tersedia.
7. Analisis kondisi_jalan dan panjang_kondisi_m pada masing-masing ruas.
8. Jangan menganggap 100% kendaraan berpindah ke lokasi_target.
9. Jangan membuat persentase perpindahan kendaraan jika tidak diberikan atau tidak dapat dihitung.
10. Jika perubahan volume tidak dapat dihitung, gunakan penjelasan kualitatif.
11. Jika lokasi_target memiliki kapasitas lebih kecil dan terdapat potensi peningkatan beban, jelaskan sebagai risiko atau kemungkinan.
12. Jangan membuat nilai kapasitas atau volume baru tanpa dasar perhitungan.
13. Jangan menyatakan hasil rekayasa lalu lintas sebagai kepastian.
14. Gunakan profil_ruas_sesudah untuk menampilkan kondisi masing-masing ruas secara terpisah.
15. Jangan menggabungkan lokasi_awal dan lokasi_target menjadi satu profil.
16. Jika tidak ada perubahan numerik yang dapat dihitung, gunakan nilai baseline dan jelaskan bahwa kondisi sesudah merupakan proyeksi.

FORMAT JSON WAJIB:

{
    "ringkasan": "Ringkasan analisis kebijakan",
    "kondisi_awal": [
        {
            "parameter": "Nama parameter",
            "nilai": "Nilai aktual",
            "satuan": "Satuan",
            "analisis": "Analisis kondisi aktual"
        }
    ],
    "dampak": [
        {
            "domain": "Nama domain",
            "parameter": "Nama parameter",
            "nilai_awal": "Nilai awal",
            "nilai_simulasi": "Nilai simulasi atau estimasi",
            "perubahan": "Deskripsi perubahan",
            "analisis": "Analisis dampak"
        }
    ],
    "dampak_positif": [
        "Dampak positif"
    ],
    "dampak_negatif": [
        "Dampak negatif"
    ],
    "risiko": [
        {
            "risiko": "Nama risiko",
            "tingkat": "Rendah",
            "penjelasan": "Penjelasan risiko"
        }
    ],
    "rekomendasi": [
        "Rekomendasi berdasarkan data"
    ],
    "kesimpulan": "Kesimpulan analisis",
    "hasil_penerapan": {
        "status_proyeksi": "estimasi AI",
        "profil_sesudah": {
            "nama_ruas_jalan": "Nama ruas jika relevan",
            "jumlah_segmen": null,
            "panjang_m": null,
            "lebar_rata_rata_m": null,
            "kapasitas": null,
            "volume_kendaraan": null,
            "tingkat_kepadatan": null
        },
        "profil_ruas_sesudah": [
            {
                "peran": "lokasi_awal atau lokasi_target",
                "nama_ruas_jalan": "Nama ruas",
                "jumlah_segmen": null,
                "panjang_m": null,
                "lebar_rata_rata_m": null,
                "kapasitas": null,
                "volume_kendaraan": null,
                "tingkat_kepadatan": null,
                "analisis": "Penjelasan perubahan dan status estimasi AI"
            }
        ],
        "kondisi_sesudah": [
            {
                "parameter": "Nama parameter",
                "nilai_sebelum": "Nilai baseline",
                "nilai_sesudah": "Nilai proyeksi",
                "perubahan": "Deskripsi perubahan",
                "persentase_perubahan": "Persentase jika dapat dihitung",
                "satuan": "Satuan",
                "analisis": "Analisis perubahan"
            }
        ],
        "dampak_penerapan": [
            {
                "domain": "Nama domain",
                "parameter": "Nama parameter",
                "sebelum": "Kondisi sebelum",
                "sesudah": "Proyeksi kondisi sesudah",
                "analisis": "Analisis perubahan"
            }
        ],
        "perubahan": [
            {
                "parameter": "Nama parameter",
                "sebelum": "Nilai sebelum",
                "sesudah": "Nilai sesudah",
                "selisih": "Selisih jika dapat dihitung",
                "persentase": "Persentase jika dapat dihitung",
                "status": "Proyeksi AI"
            }
        ],
        "ringkasan": "Ringkasan kondisi setelah kebijakan diterapkan",
        "catatan": "Seluruh nilai sesudah merupakan proyeksi atau estimasi AI dan bukan hasil pengukuran lapangan"
    }
}

PROMPT;

            /*
            |--------------------------------------------------------------------------
            | USER PROMPT
            |--------------------------------------------------------------------------
            */

            $userPrompt = <<<PROMPT
IDENTITAS KEBIJAKAN

Judul:

{$judul}

Jenis:

{$jenisLabel}

Kode Jenis:

{$jenis}

SKENARIO KEBIJAKAN DARI PENGGUNA

{$skenario}

TARGET UTAMA

{$targetJson}

DATA REKAYASA LALU LINTAS

Jika jenis kebijakan bukan Rekayasa Lalu Lintas, bagian ini dapat diabaikan.

{$rekayasaJson}

DATA KONDISI SAAT INI DARI DATABASE

Data berikut adalah KONDISI SEBELUM kebijakan diterapkan.

{$baselineJson}

PERHATIAN KHUSUS KONDISI JALAN:

Data kondisi_jalan dan panjang_kondisi_m berasal dari database tabel segmen_jalans.

Gunakan data tersebut sebagai kondisi aktual sebelum kebijakan.

Jangan mengubah nilai kondisi_jalan.

Jangan mengubah nilai panjang_kondisi_m.

Jika terdapat beberapa segmen dengan kondisi berbeda, analisis masing-masing segmen.

Untuk rekayasa lalu lintas, analisis kondisi jalan lokasi_awal dan lokasi_target secara terpisah.

DOMAIN YANG HARUS DIANALISIS

{$domainsJson}

TUGAS UTAMA

Lakukan analisis kebijakan berdasarkan data yang diberikan.

Setelah analisis dilakukan, buat juga PROYEKSI HASIL PENERAPAN kebijakan.

Untuk hasil penerapan:

1. Gunakan baseline sebagai kondisi SEBELUM.
2. Gunakan skenario sebagai intervensi kebijakan.
3. Gunakan target sebagai tujuan kebijakan.
4. Tentukan parameter yang relevan untuk dibandingkan.
5. Tampilkan nilai sebelum.
6. Tampilkan nilai sesudah sebagai PROYEKSI atau ESTIMASI AI.
7. Jika perubahan dapat dihitung dari data yang tersedia, hitung secara transparan.
8. Jika tidak dapat dihitung, gunakan analisis kualitatif.
9. Jangan membuat angka baru tanpa dasar.
10. Jangan menganggap hasil proyeksi sebagai hasil pengukuran lapangan.

Untuk profil_sesudah:

1. Ambil nama ruas dari baseline atau data rekayasa lalu lintas.
2. Ambil jumlah segmen dari baseline jika tersedia.
3. Ambil panjang dari baseline jika tidak diubah oleh skenario.
4. Tentukan lebar sesudah berdasarkan skenario.
5. Tentukan kapasitas sesudah hanya jika dapat dihitung dengan dasar yang jelas.
6. Tentukan volume sesudah hanya jika dapat dihitung atau diproyeksikan secara bertanggung jawab.
7. Tentukan tingkat kepadatan berdasarkan hubungan volume dan kapasitas jika data mendukung.
8. Gunakan null jika nilai tidak dapat ditentukan.
9. Jangan membuat angka secara acak.

Untuk kondisi jalan:

1. Gunakan kondisi_jalan dari database sebagai kondisi sebelum.
2. Gunakan panjang_kondisi_m sebagai panjang kondisi dalam meter.
3. Pertahankan setiap kondisi per segmen.
4. Jangan mengubah nilai panjang kondisi.
5. Jangan membuat nilai panjang kondisi baru.
6. Jika kondisi jalan adalah banjir, longsor, atau lainnya, masukkan ke analisis dampak dan risiko.
7. Jika kondisi jalan adalah lainnya, gunakan kondisi_lainnya jika tersedia.
8. Jika tidak tersedia, nyatakan bahwa data kondisi jalan tidak tersedia.

Jika jenis kebijakan adalah pelebaran_jalan:

1. Identifikasi ruas jalan dari skenario atau baseline.
2. Gunakan panjang baseline sebagai panjang sesudah jika panjang tidak berubah.
3. Gunakan jumlah segmen baseline.
4. Hitung lebar sesudah berdasarkan tambahan lebar yang diberikan pengguna.
5. Jika kapasitas sebelum dan lebar sebelum tersedia, kapasitas sesudah dapat diestimasi secara proporsional terhadap perubahan lebar.
6. Jika lebar sebelum bernilai 0 atau tidak tersedia, jangan menghitung kapasitas dengan pembagian.
7. Berikan catatan bahwa kapasitas sesudah adalah estimasi AI.
8. Volume kendaraan jangan diubah tanpa dasar.
9. Kepadatan dapat berubah jika rasio volume terhadap kapasitas berubah.

Jika jenis kebijakan adalah rekayasa_lalu_lintas:

1. Gunakan profil_ruas_sesudah.
2. Buat satu profil untuk lokasi_awal.
3. Buat satu profil untuk lokasi_target.
4. Jangan menggabungkan kedua ruas.
5. Pertahankan data yang tidak berubah.
6. Analisis kondisi jalan pada lokasi_awal dan lokasi_target secara terpisah.
7. Gunakan kondisi_jalan dan panjang_kondisi_m dari baseline.
8. Jelaskan potensi perubahan volume dan kepadatan secara kualitatif jika tidak ada data perpindahan kendaraan.
9. Jangan menganggap seluruh kendaraan berpindah ke lokasi_target.
10. Jangan membuat persentase pengalihan tanpa dasar.

HASIL PENERAPAN HARUS MEMPUNYAI:

1. profil_sesudah untuk kebijakan dengan satu lokasi utama.
2. profil_ruas_sesudah untuk rekayasa lalu lintas.
3. kondisi_sesudah untuk perbandingan parameter.
4. dampak_penerapan untuk dampak setelah implementasi.
5. perubahan untuk daftar perubahan.
6. ringkasan untuk ringkasan hasil penerapan.
7. catatan untuk menjelaskan keterbatasan dan status estimasi AI.

HASIL AKHIR WAJIB MENGIKUTI FORMAT JSON YANG DIBERIKAN.

HASIL AKHIR HANYA BERUPA JSON VALID.
PROMPT;

            /*
            |--------------------------------------------------------------------------
            | LOG REQUEST
            |--------------------------------------------------------------------------
            */

            Log::info('DEATCODE REQUEST', [
                'model' => $this->model,
                'judul' => $judul,
                'jenis' => $jenis,
                'baseline_type' => gettype($baseline),
                'baseline_count' => is_array($baseline)
                    ? count($baseline)
                    : 0,
                'domains_count' => count($domains),
                'has_rekayasa_lalu_lintas' => !empty($rekayasaLaluLintas),
                'lokasi_awal' =>
                    $rekayasaLaluLintas['lokasi_awal']['nama_ruas_jalan']
                    ?? null,
                'lokasi_target' =>
                    $rekayasaLaluLintas['lokasi_target']['nama_ruas_jalan']
                    ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | REQUEST KE DEATCODE
            |--------------------------------------------------------------------------
            */

            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout(150)
                ->connectTimeout(30)
                ->post(
                    'https://copilot.api-github.com/v1/chat/completions',
                    [
                        'model' => $this->model,
                        'stream' => false,
                        'temperature' => 0.2,
                        'max_tokens' => 10000,

                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => $systemPrompt,
                            ],
                            [
                                'role' => 'user',
                                'content' => $userPrompt,
                            ],
                        ],
                    ]
                );

            /*
            |--------------------------------------------------------------------------
            | API ERROR
            |--------------------------------------------------------------------------
            */

            if ($response->failed()) {
                Log::error('DEATCODE API ERROR', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'DeatCode API gagal.',
                    'api_status' => $response->status(),
                    'api_body' => $response->json() ?: $response->body(),
                ], $response->status());
            }

            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            $data = $response->json();

            Log::info('DEATCODE FULL RESPONSE', [
                'response' => $data,
            ]);

            $reply = $data['choices'][0]['message']['content'] ?? null;

            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Response DeatCode tidak memiliki content.',
                    'raw_response' => $data,
                ], 500);
            }

            /*
            |--------------------------------------------------------------------------
            | CLEAN JSON
            |--------------------------------------------------------------------------
            */

            $reply = $this->cleanJsonResponse($reply);

            $parsedReply = json_decode(
                $reply,
                true
            );

            if (
                $parsedReply === null &&
                json_last_error() !== JSON_ERROR_NONE
            ) {
                Log::error('DEATCODE INVALID JSON', [
                    'json_error_code' => json_last_error(),
                    'json_error_message' => json_last_error_msg(),
                    'reply' => $reply,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'AI mengembalikan JSON yang tidak valid.',
                    'json_error_code' => json_last_error(),
                    'json_error' => json_last_error_msg(),
                    'reply' => $reply,
                ], 500);
            }

            if (!is_array($parsedReply)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Format response AI tidak sesuai.',
                    'reply' => $parsedReply,
                ], 500);
            }

            /*
            |--------------------------------------------------------------------------
            | HASIL PENERAPAN
            |--------------------------------------------------------------------------
            */

            $hasilPenerapan = is_array(
                $parsedReply['hasil_penerapan'] ?? null
            )
                ? $parsedReply['hasil_penerapan']
                : [];

            $profilSesudah = is_array(
                $hasilPenerapan['profil_sesudah'] ?? null
            )
                ? $hasilPenerapan['profil_sesudah']
                : [];

            $profilRuasSesudah = is_array(
                $hasilPenerapan['profil_ruas_sesudah'] ?? null
            )
                ? $hasilPenerapan['profil_ruas_sesudah']
                : [];

            $hasilPenerapan = [
                'status_proyeksi' =>
                    $hasilPenerapan['status_proyeksi']
                    ?? 'estimasi AI',

                'profil_sesudah' => [
                    'nama_ruas_jalan' =>
                        $profilSesudah['nama_ruas_jalan'] ?? null,

                    'jumlah_segmen' =>
                        $profilSesudah['jumlah_segmen'] ?? null,

                    'panjang_m' =>
                        $profilSesudah['panjang_m'] ?? null,

                    'lebar_rata_rata_m' =>
                        $profilSesudah['lebar_rata_rata_m'] ?? null,

                    'kapasitas' =>
                        $profilSesudah['kapasitas'] ?? null,

                    'volume_kendaraan' =>
                        $profilSesudah['volume_kendaraan'] ?? null,

                    'tingkat_kepadatan' =>
                        $profilSesudah['tingkat_kepadatan'] ?? null,
                ],

                'profil_ruas_sesudah' => array_values(
                    array_map(
                        function ($item) {
                            return [
                                'peran' =>
                                    $item['peran'] ?? null,

                                'nama_ruas_jalan' =>
                                    $item['nama_ruas_jalan'] ?? null,

                                'jumlah_segmen' =>
                                    $item['jumlah_segmen'] ?? null,

                                'panjang_m' =>
                                    $item['panjang_m'] ?? null,

                                'lebar_rata_rata_m' =>
                                    $item['lebar_rata_rata_m'] ?? null,

                                'kapasitas' =>
                                    $item['kapasitas'] ?? null,

                                'volume_kendaraan' =>
                                    $item['volume_kendaraan'] ?? null,

                                'tingkat_kepadatan' =>
                                    $item['tingkat_kepadatan'] ?? null,

                                'analisis' =>
                                    $item['analisis'] ?? '',
                            ];
                        },
                        $profilRuasSesudah
                    )
                ),

                'kondisi_sesudah' =>
                    is_array(
                        $hasilPenerapan['kondisi_sesudah'] ?? null
                    )
                        ? $hasilPenerapan['kondisi_sesudah']
                        : [],

                'dampak_penerapan' =>
                    is_array(
                        $hasilPenerapan['dampak_penerapan'] ?? null
                    )
                        ? $hasilPenerapan['dampak_penerapan']
                        : [],

                'perubahan' =>
                    is_array(
                        $hasilPenerapan['perubahan'] ?? null
                    )
                        ? $hasilPenerapan['perubahan']
                        : [],

                'ringkasan' =>
                    $hasilPenerapan['ringkasan'] ?? '',

                'catatan' =>
                    $hasilPenerapan['catatan']
                    ??
                    'Seluruh nilai sesudah merupakan proyeksi atau estimasi AI dan bukan hasil pengukuran lapangan.',
            ];

            /*
            |--------------------------------------------------------------------------
            | NORMALISASI RESPONSE
            |--------------------------------------------------------------------------
            */

            $parsedReply = [
                'ringkasan' =>
                    $parsedReply['ringkasan'] ?? '',

                'kondisi_awal' =>
                    is_array($parsedReply['kondisi_awal'] ?? null)
                        ? $parsedReply['kondisi_awal']
                        : [],

                'dampak' =>
                    is_array($parsedReply['dampak'] ?? null)
                        ? $parsedReply['dampak']
                        : [],

                'dampak_positif' =>
                    is_array($parsedReply['dampak_positif'] ?? null)
                        ? $parsedReply['dampak_positif']
                        : [],

                'dampak_negatif' =>
                    is_array($parsedReply['dampak_negatif'] ?? null)
                        ? $parsedReply['dampak_negatif']
                        : [],

                'risiko' =>
                    is_array($parsedReply['risiko'] ?? null)
                        ? $parsedReply['risiko']
                        : [],

                'rekomendasi' =>
                    is_array($parsedReply['rekomendasi'] ?? null)
                        ? $parsedReply['rekomendasi']
                        : [],

                'kesimpulan' =>
                    $parsedReply['kesimpulan'] ?? '',

                'hasil_penerapan' =>
                    $hasilPenerapan,
            ];

            /*
            |--------------------------------------------------------------------------
            | SUCCESS LOG
            |--------------------------------------------------------------------------
            */

            Log::info('DEATCODE ANALYSIS AND PENERAPAN SUCCESS', [
                'model' =>
                    $data['model'] ?? $this->model,

                'dampak_count' =>
                    count($parsedReply['dampak']),

                'risiko_count' =>
                    count($parsedReply['risiko']),

                'rekomendasi_count' =>
                    count($parsedReply['rekomendasi']),

                'profil_sesudah_available' =>
                    !empty($hasilPenerapan['profil_sesudah']),

                'profil_ruas_sesudah_count' =>
                    count($hasilPenerapan['profil_ruas_sesudah']),

                'kondisi_sesudah_count' =>
                    count($hasilPenerapan['kondisi_sesudah']),

                'dampak_penerapan_count' =>
                    count($hasilPenerapan['dampak_penerapan']),

                'perubahan_count' =>
                    count($hasilPenerapan['perubahan']),
            ]);

            /*
            |--------------------------------------------------------------------------
            | RESPONSE KE FRONTEND
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'status' => 'success',
                'message' =>
                    'Analisis kebijakan dan proyeksi hasil penerapan berhasil dibuat.',

                'model' =>
                    $data['model'] ?? $this->model,

                'reply' =>
                    $parsedReply,

                'usage' =>
                    $data['usage'] ?? null,
            ]);

        } catch (ValidationException $e) {

            Log::error('DEATCODE VALIDATION ERROR', [
                'errors' => $e->errors(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Data request tidak valid.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {

            Log::error('DEATCODE EXCEPTION', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL KONDISI JALAN DARI DATABASE
    |--------------------------------------------------------------------------
    |
    | Tabel:
    | segmen_jalans
    |
    | Field yang dibaca:
    | - id_segmen
    | - kondisi_jalan
    | - panjang_kondisi_m
    | - kondisi_lainnya
    |
    */

    private function getKondisiJalan($idJalan): array
    {
        if ($idJalan === null || $idJalan === '') {
            return [];
        }

        $segments = DB::table('segmen_jalans')
            ->where('jalan_id', $idJalan)
            ->select([
                'id_segmen',
                'kondisi_jalan',
                'panjang_kondisi_m',
                'kondisi_lainnya',
            ])
            ->orderBy('id_segmen')
            ->get();

        return $segments
            ->map(function ($segment) {
                return [
                    'id_segmen' => $segment->id_segmen,
                    'kondisi_jalan' => $segment->kondisi_jalan,
                    'panjang_kondisi_m' => $segment->panjang_kondisi_m !== null
                        ? (float) $segment->panjang_kondisi_m
                        : null,
                    'kondisi_lainnya' => $segment->kondisi_lainnya,
                ];
            })
            ->values()
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAHKAN KONDISI JALAN KE BASELINE RUAS
    |--------------------------------------------------------------------------
    */

    private function attachKondisiJalanToRoadBaseline(
        array $roadBaseline,
        $idJalan
    ): array {
        $kondisiJalan = $this->getKondisiJalan($idJalan);

        $roadBaseline['kondisi_jalan'] = $kondisiJalan;

        /*
        |--------------------------------------------------------------------------
        | Jika baseline sudah mempunyai segmen_jalans,
        | gabungkan kondisi dari database ke setiap segmen.
        |--------------------------------------------------------------------------
        */

        if (
            isset($roadBaseline['segmen_jalans']) &&
            is_array($roadBaseline['segmen_jalans'])
        ) {
            $kondisiBySegmen = collect($kondisiJalan)
                ->keyBy(function ($item) {
                    return (string) $item['id_segmen'];
                });

            $roadBaseline['segmen_jalans'] = array_map(
                function ($segment) use ($kondisiBySegmen) {

                    $idSegmen =
                        $segment['id_segmen']
                        ?? null;

                    if ($idSegmen !== null) {
                        $kondisi =
                            $kondisiBySegmen->get(
                                (string) $idSegmen
                            );

                        if ($kondisi) {
                            $segment['kondisi_jalan'] =
                                $kondisi['kondisi_jalan'];

                            $segment['panjang_kondisi_m'] =
                                $kondisi['panjang_kondisi_m'];

                            $segment['kondisi_lainnya'] =
                                $kondisi['kondisi_lainnya'];
                        }
                    }

                    return $segment;
                },
                $roadBaseline['segmen_jalans']
            );
        }

        return $roadBaseline;
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAN JSON RESPONSE AI
    |--------------------------------------------------------------------------
    */

    private function cleanJsonResponse(string $reply): string
    {
        $reply = trim($reply);

        $reply = preg_replace(
            '/^```(?:json)?\s*/i',
            '',
            $reply
        );

        $reply = preg_replace(
            '/\s*```$/',
            '',
            $reply
        );

        $reply = trim($reply);

        $reply = preg_replace(
            '/\\\\(?!["\\\\\/bfnrtu])/',
            '',
            $reply
        );

        $reply = preg_replace(
            '/[\x00-\x08\x0B\x0C\x0E-\x1F]/',
            '',
            $reply
        );

        $reply = trim($reply);

        $firstBrace = strpos($reply, '{');
        $lastBrace = strrpos($reply, '}');

        if (
            $firstBrace !== false &&
            $lastBrace !== false &&
            $lastBrace > $firstBrace
        ) {
            $jsonOnly = substr(
                $reply,
                $firstBrace,
                $lastBrace - $firstBrace + 1
            );

            $testJson = json_decode(
                $jsonOnly,
                true
            );

            if (
                is_array($testJson) &&
                json_last_error() === JSON_ERROR_NONE
            ) {
                $reply = $jsonOnly;
            }
        }

        return trim($reply);
    }
}