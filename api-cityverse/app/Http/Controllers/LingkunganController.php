<?php

namespace App\Http\Controllers;

use App\Models\SumberApiLingkungan;
use App\Models\DataLingkungan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LingkunganController extends Controller
{

    private function ambilSemuaHalaman($sumber)
    {
        $rows = [];
        $page = 1;
        $limit = 100;
        $totalPages = 1;
        do {
            $params = [
                'page' => $page,
                'limit' => $limit,
            ];

            if (!empty($sumber->sheet)) {
                $params['sheet'] = $sumber->sheet;
            }

            if (!empty($sumber->tahun)) {
                $params['tahun'] = $sumber->tahun;
            }

            $response = Http::timeout(30)
                ->get($sumber->endpoint, $params);

            if ($response->failed()) {

                return [
                    'success' => false,
                    'response' => $response,
                    'rows' => [],
                    'total_pages' => $totalPages,
                ];
            }

            $hasil = $response->json();

            if (
                isset($hasil['error']) &&
                is_array($hasil['error'])
            ) {
                return [
                    'success' => false,
                    'response' => $response,
                    'rows' => [],
                    'total_pages' => $totalPages,
                ];
            }

            $rowsPage = $hasil['data'] ?? [];

            if (!is_array($rowsPage)) {
                $rowsPage = [];
            }

            $rows = array_merge($rows, $rowsPage);

            $totalPages = (int) (
                $hasil['pages']
                ?? $hasil['total_pages']
                ?? $hasil['last_page']
                ?? 1
            );

            if ($totalPages < 1) {
                $totalPages = 1;
            }
            $page++;

        } while ($page <= $totalPages);
        return [
            'success' => true,
            'rows' => $rows,
            'total_pages' => $totalPages,
        ];
    }

    private function normalisasiTeks($value)
    {
        if ($value === null) {
            return '';
        }

        $value = trim((string) $value);

        $value = preg_replace('/\s+/', ' ', $value);

        return strtolower($value);
    }

    private function cariKotaMakassar($rows)
    {
        $fieldCandidates = [
            'Kabupaten/Kota',
            'kabupaten/kota',
            'Kabupaten Kota',
            'kabupaten kota',
            'kabkota',
            'nama_kabkota',
            'Nama Kabupaten/Kota',
            'Nama Kabupaten Kota',
            'nama_kabupaten_kota',
        ];

        foreach ($rows as $row) {

            if (!is_array($row)) {
                continue;
            }

            foreach ($fieldCandidates as $field) {

                if (array_key_exists($field, $row)) {

                    $nilai = $this->normalisasiTeks($row[$field]);

                    if ($nilai === 'kota makassar') {
                        return $row;
                    }
                }
            }

            foreach ($row as $value) {

                if (is_string($value)) {

                    $nilai = $this->normalisasiTeks($value);

                    if ($nilai === 'kota makassar') {
                        return $row;
                    }
                }
            }
        }

        return null;
    }

    public function ambilData()
    {
        $sumber = SumberApiLingkungan::where('kode', 'iku')
            ->where('aktif', true)
            ->firstOrFail();
        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API KLH.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'sumber' => $sumber->kode,
            'endpoint' => $sumber->endpoint,
            'sheet' => $sumber->sheet,
            'tahun' => $sumber->tahun,
            'total_data' => count($hasilApi['rows']),
            'total_pages' => $hasilApi['total_pages'],
            'data' => $hasilApi['rows'],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA IKU KE DATABASE
    |--------------------------------------------------------------------------
    */

    public function simpanIku()
    {
        $sumber = SumberApiLingkungan::where('kode', 'iku')
            ->where('aktif', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA HALAMAN
        |--------------------------------------------------------------------------
        */

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data API IKU.',
                'status' => $response->status(),
                'response' => $response->json(),
                'endpoint' => $sumber->endpoint,
                'sheet' => $sumber->sheet,
                'tahun' => $sumber->tahun,
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        /*
        |--------------------------------------------------------------------------
        | CARI KOTA MAKASSAR
        |--------------------------------------------------------------------------
        */

        $dataMakassar = $this->cariKotaMakassar($rows);

        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'endpoint' => $sumber->endpoint,
                'sheet' => $sumber->sheet,
                'tahun' => $sumber->tahun,
                'total_data' => count($rows),
                'total_pages' => $totalPages,

                /*
                |--------------------------------------------------------------------------
                | DEBUG
                |--------------------------------------------------------------------------
                */

                'contoh_data' => array_slice($rows, 0, 3),

                'contoh_data_terakhir' => array_slice($rows, -3),

            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI IKU
        |--------------------------------------------------------------------------
        |
        | API:
        |
        | "IKU": "92.11"
        |
        |--------------------------------------------------------------------------
        */

        $nilaiIKU = null;

        if (array_key_exists('IKU', $dataMakassar)) {

            if (is_numeric($dataMakassar['IKU'])) {

                $nilaiIKU = (float) $dataMakassar['IKU'];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CEK NILAI IKU
        |--------------------------------------------------------------------------
        */

        if ($nilaiIKU === null) {

            return response()->json([
                'success' => false,

                'message' => 'Data Kota Makassar ditemukan, tetapi kolom IKU tidak memiliki nilai angka.',

                'data_kota_makassar' => $dataMakassar,

                'endpoint' => $sumber->endpoint,

                'sheet' => $sumber->sheet,

                'tahun' => $sumber->tahun,

                'total_data' => count($rows),

                'total_pages' => $totalPages,

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN / UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'IKU',

                'tahun' => $sumber->tahun,
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? '73.71',

                'indikator' => 'Indeks Kualitas Udara',

                /*
                |--------------------------------------------------------------------------
                | NILAI IKU DARI API
                |--------------------------------------------------------------------------
                */

                'nilai' => $nilaiIKU,

                'satuan' => 'indeks',

                'latitude' => null,

                'longitude' => null,

                /*
                |--------------------------------------------------------------------------
                | SIMPAN DATA ASLI API
                |--------------------------------------------------------------------------
                */

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Data IKU berhasil diambil dan disimpan.',

            'endpoint' => $sumber->endpoint,

            'sheet' => $sumber->sheet,

            'tahun' => $sumber->tahun,

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'wilayah' => 'Kota Makassar',

            'nilai_iku' => $nilaiIKU,

            'data_api' => $dataMakassar,

            'data' => $data,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA IKA KE DATABASE
    |--------------------------------------------------------------------------
    */

    public function simpanIKA()
    {
        $sumber = SumberApiLingkungan::where('kode', 'ika')
            ->where('aktif', true)
            ->firstOrFail();

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data API IKA.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        /*
        |--------------------------------------------------------------------------
        | CARI KOTA MAKASSAR
        |--------------------------------------------------------------------------
        */

        $dataMakassar = $this->cariKotaMakassar($rows);

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'total_data' => count($rows),
                'total_pages' => $totalPages,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI IKA
        |--------------------------------------------------------------------------
        */

        $nilaiIKA = isset($dataMakassar['2024'])
            ? (float) $dataMakassar['2024']
            : null;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'IKA',

                'tahun' => $sumber->tahun,
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? null,

                'indikator' => 'Indeks Kualitas Air',

                'nilai' => $nilaiIKA,

                'satuan' => 'indeks',

                'latitude' => null,

                'longitude' => null,

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        return response()->json([
            'success' => true,

            'message' => 'Data IKA berhasil diambil dan disimpan.',

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'data' => $data,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PERSAMPAHAN
    |--------------------------------------------------------------------------
    */

    public function simpanPersampahanData()
    {
        $sumber = SumberApiLingkungan::where('kode', 'persampahan_data')
            ->where('aktif', true)
            ->firstOrFail();

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data persampahan.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        $dataMakassar = $this->cariKotaMakassar($rows);

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'total_data' => count($rows),
                'total_pages' => $totalPages,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA PERSAMPAHAN
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'Persampahan',

                'tahun' => $sumber->tahun,

                'indikator' => 'Data Persampahan',
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? null,

                'nilai' => isset($dataMakassar['persen_kelola'])
                    ? (float) $dataMakassar['persen_kelola']
                    : null,

                'satuan' => '%',

                'latitude' => null,

                'longitude' => null,

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        return response()->json([
            'success' => true,

            'message' => 'Data persampahan berhasil diambil dan disimpan.',

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'data' => $data,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PERSAMPAHAN CAPAIAN
    |--------------------------------------------------------------------------
    */

    public function simpanPersampahanCapaian()
    {
        $sumber = SumberApiLingkungan::where('kode', 'persampahan_capaian')
            ->where('aktif', true)
            ->firstOrFail();

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data persampahan capaian.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        $dataMakassar = $this->cariKotaMakassar($rows);

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'total_data' => count($rows),
                'total_pages' => $totalPages,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI SAMPAH TERKELOLA
        |--------------------------------------------------------------------------
        */

        $nilaiTerkelola = isset($dataMakassar['% Sampah Terkelola'])
            ? (float) $dataMakassar['% Sampah Terkelola']
            : null;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'Persampahan',

                'tahun' => $sumber->tahun,

                'indikator' => 'Capaian Persampahan',
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? null,

                'nilai' => $nilaiTerkelola,

                'satuan' => '%',

                'latitude' => null,

                'longitude' => null,

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        return response()->json([
            'success' => true,

            'message' => 'Data persampahan capaian berhasil diambil dan disimpan.',

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'data' => $data,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PERSAMPAHAN TERKELOLA
    |--------------------------------------------------------------------------
    */

    public function simpanPersampahanTerkelola()
    {
        $sumber = SumberApiLingkungan::where('kode', 'persampahan_terkelola')
            ->where('aktif', true)
            ->firstOrFail();

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data persampahan terkelola.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        $dataMakassar = $this->cariKotaMakassar($rows);

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'total_data' => count($rows),
                'total_pages' => $totalPages,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI PERSENTASE SAMPAH TERKELOLA
        |--------------------------------------------------------------------------
        */

        $nilaiTerkelola = isset($dataMakassar['% Sampah Terkelola'])
            ? (float) $dataMakassar['% Sampah Terkelola']
            : null;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'Persampahan',

                'tahun' => $sumber->tahun,

                'indikator' => 'Persentase Sampah Terkelola',
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? null,

                'nilai' => $nilaiTerkelola,

                'satuan' => '%',

                'latitude' => null,

                'longitude' => null,

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        return response()->json([
            'success' => true,

            'message' => 'Data persampahan terkelola berhasil diambil dan disimpan.',

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'data' => $data,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PERSAMPAHAN KOMPOSISI
    |--------------------------------------------------------------------------
    */

    public function simpanPersampahanKomposisi()
    {
        $sumber = SumberApiLingkungan::where('kode', 'persampahan_komposisi')
            ->where('aktif', true)
            ->firstOrFail();

        $hasilApi = $this->ambilSemuaHalaman($sumber);

        if (!$hasilApi['success']) {

            $response = $hasilApi['response'];

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data persampahan komposisi.',
                'status' => $response->status(),
                'response' => $response->json(),
            ], 500);
        }

        $rows = $hasilApi['rows'];

        $totalPages = $hasilApi['total_pages'];

        $dataMakassar = $this->cariKotaMakassar($rows);

        if (!$dataMakassar) {

            return response()->json([
                'success' => false,
                'message' => 'Data Kota Makassar tidak ditemukan.',
                'total_data' => count($rows),
                'total_pages' => $totalPages,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | DAFTAR KOMPOSISI
        |--------------------------------------------------------------------------
        */

        $komposisi = [
            'Sisa Makanan' => 'Sisa Makanan %',
            'Plastik' => 'Plastik %',
            'Kertas/Karton' => 'Kertas/Karton %',
            'Kayu/Ranting' => 'Kayu Ranting %',
            'Karet/Kulit' => 'Karet/Kulit %',
            'Kain' => 'Kain %',
            'Logam' => 'Logam %',
            'Kaca' => 'Kaca %',
            'Lainnya' => 'Lainnya %',
        ];


        /*
        |--------------------------------------------------------------------------
        | SIMPAN SETIAP KOMPOSISI
        |--------------------------------------------------------------------------
        */

        $dataTersimpan = [];

        foreach ($komposisi as $indikator => $field) {

            $nilai = isset($dataMakassar[$field])
                ? (float) $dataMakassar[$field]
                : null;


            $data = DataLingkungan::updateOrCreate(
                [
                    'sumber_api_id' => $sumber->id,

                    'wilayah' => 'Kota Makassar',

                    'parameter' => 'Persampahan',

                    'tahun' => $sumber->tahun,

                    'indikator' => $indikator,
                ],
                [
                    'kode_wilayah' =>
                        $dataMakassar['Kode Wilayah']
                        ?? $dataMakassar['kode_wilayah']
                        ?? null,

                    'nilai' => $nilai,

                    'satuan' => '%',

                    'latitude' => null,

                    'longitude' => null,

                    'data_asli' => $dataMakassar,

                    'diambil_pada' => now(),
                ]
            );


            $dataTersimpan[] = $data;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN TIMBULAN SAMPAH
        |--------------------------------------------------------------------------
        */

        $timbulan = null;

        if (isset($dataMakassar['Timbulan Sampah'])) {

            $timbulan = (float) $dataMakassar['Timbulan Sampah'];
        }


        $dataTimbulan = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'Persampahan',

                'tahun' => $sumber->tahun,

                'indikator' => 'Timbulan Sampah',
            ],
            [
                'kode_wilayah' =>
                    $dataMakassar['Kode Wilayah']
                    ?? $dataMakassar['kode_wilayah']
                    ?? null,

                'nilai' => $timbulan,

                'satuan' => 'Ton/Tahun',

                'latitude' => null,

                'longitude' => null,

                'data_asli' => $dataMakassar,

                'diambil_pada' => now(),
            ]
        );


        $dataTersimpan[] = $dataTimbulan;


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Data persampahan komposisi berhasil diambil dan disimpan.',

            'total_data' => count($rows),

            'total_pages' => $totalPages,

            'jumlah_data_disimpan' => count($dataTersimpan),

            'data' => $dataTersimpan,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA RISIKO BANJIR
    |--------------------------------------------------------------------------
    */

    public function simpanRisikoBanjir()
    {
        $sumber = SumberApiLingkungan::where('kode', 'risiko_banjir')
            ->where('aktif', true)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | KOORDINAT REFERENSI KOTA MAKASSAR
        |--------------------------------------------------------------------------
        */

        $longitude = 119.4327;

        $latitude = -5.1477;


        /*
        |--------------------------------------------------------------------------
        | GEOMETRY
        |--------------------------------------------------------------------------
        */

        $geometry = json_encode([
            'x' => $longitude,

            'y' => $latitude,

            'spatialReference' => [
                'wkid' => 4326,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REQUEST KE BNPB
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(30)->get($sumber->endpoint, [
            'geometry' => $geometry,

            'geometryType' => 'esriGeometryPoint',

            'returnGeometry' => 'false',

            'returnCatalogItems' => 'false',

            'returnPixelValues' => 'true',

            'f' => 'json',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($response->failed()) {

            return response()->json([
                'success' => false,

                'message' => 'Gagal mengambil data risiko banjir dari BNPB.',

                'status' => $response->status(),

                'response' => $response->json(),
            ], 500);
        }


        $hasil = $response->json();


        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI PIXEL
        |--------------------------------------------------------------------------
        */

        $nilaiRaw = $hasil['value'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | CEK NODATA
        |--------------------------------------------------------------------------
        */

        if (
            $nilaiRaw === null ||
            strtolower(trim((string) $nilaiRaw)) === 'nodata'
        ) {

            return response()->json([
                'success' => false,

                'message' => 'Titik referensi Makassar tidak memiliki nilai risiko banjir pada raster BNPB.',

                'response' => $hasil,
            ], 404);
        }


        /*
        |--------------------------------------------------------------------------
        | KONVERSI
        |--------------------------------------------------------------------------
        */

        if (!is_numeric($nilaiRaw)) {

            return response()->json([
                'success' => false,

                'message' => 'Nilai risiko banjir dari BNPB bukan angka.',

                'nilai_diterima' => $nilaiRaw,

                'response' => $hasil,
            ], 422);
        }


        $nilai = (float) $nilaiRaw;


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($nilai <= 0.333) {

            $kategori = 'Rendah';

        } elseif ($nilai <= 0.666) {

            $kategori = 'Sedang';

        } else {

            $kategori = 'Tinggi';
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        $data = DataLingkungan::updateOrCreate(
            [
                'sumber_api_id' => $sumber->id,

                'wilayah' => 'Kota Makassar',

                'parameter' => 'Risiko Banjir',

                'tahun' => null,
            ],
            [
                'kode_wilayah' => '73.71',

                'indikator' => 'Indeks Risiko Banjir',

                'nilai' => $nilai,

                'satuan' => 'indeks',

                'latitude' => $latitude,

                'longitude' => $longitude,

                'data_asli' => [
                    'response_bnpb' => $hasil,

                    'kategori' => $kategori,

                    'nilai_indeks' => $nilai,
                ],

                'diambil_pada' => now(),
            ]
        );

        return response()->json([
            'success' => true,

            'message' => 'Data risiko banjir berhasil diambil dan disimpan.',

            'wilayah' => 'Kota Makassar',

            'koordinat' => [
                'latitude' => $latitude,

                'longitude' => $longitude,
            ],

            'nilai_indeks' => $nilai,

            'persentase_tampilan' => round($nilai * 100, 2),

            'kategori' => $kategori,

            'data' => $data,
        ]);
    }

    public function dataLingkungan()
    {
        $data = DataLingkungan::where('wilayah', 'Kota Makassar')
            ->orderBy('parameter')
            ->orderBy('indikator')
            ->get();

        return response()->json([
            'success' => true,
            'wilayah' => 'Kota Makassar',
            'data' => $data,
        ]);
    }

    public function index(Request $request)
    {
        $query = DataLingkungan::query();

        if ($request->filled('wilayah')) {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
        }

        if ($request->filled('parameter')) {
            $query->where('parameter', $request->parameter);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('lingkungan.index', compact('data'));
    }

    public function view($id)
    {
        $data = DataLingkungan::findOrFail($id);

        return view('lingkungan.view', compact('data'));
    }

    public function edit($id)
    {
        $data = DataLingkungan::findOrFail($id);

        return view('lingkungan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = DataLingkungan::findOrFail($id);

        $validated = $request->validate([
            'sumber_api_id' => 'required|exists:sumber_api_lingkungans,id',
            'wilayah' => 'nullable|string|max:255',
            'kode_wilayah' => 'nullable|string|max:255',
            'parameter' => 'nullable|string|max:255',
            'indikator' => 'nullable|string|max:255',
            'nilai' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'data_asli' => 'nullable|string',
            'diambil_pada' => 'nullable|date',
        ]);

        // Simpan data_asli sebelum dibandingkan
        if (!empty($validated['data_asli'])) {
            $dataAsli = json_decode($validated['data_asli'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withErrors([
                        'data_asli' => 'Format Data Asli harus berupa JSON yang valid.'
                    ])
                    ->withInput();
            }

            $validated['data_asli'] = $dataAsli;
        } else {
            $validated['data_asli'] = null;
        }

        // Isi data baru ke model tanpa langsung menyimpan
        $data->fill($validated);

        // Ambil field yang mengalami perubahan
        $perubahan = [];

        $fieldLabels = [
            'sumber_api_id' => 'Sumber API',
            'wilayah' => 'Wilayah',
            'kode_wilayah' => 'Kode Wilayah',
            'parameter' => 'Parameter',
            'indikator' => 'Indikator',
            'nilai' => 'Nilai',
            'satuan' => 'Satuan',
            'tahun' => 'Tahun',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'data_asli' => 'Data Asli',
        ];

        foreach ($data->getDirty() as $field => $newValue) {
            if (!array_key_exists($field, $fieldLabels)) {
                continue;
            }

            $oldValue = $data->getOriginal($field);

            // Untuk data_asli, ubah menjadi JSON supaya lebih mudah dibandingkan
            if ($field === 'data_asli') {
                $oldValue = is_array($oldValue)
                    ? json_encode($oldValue, JSON_UNESCAPED_UNICODE)
                    : $oldValue;

                $newValue = is_array($newValue)
                    ? json_encode($newValue, JSON_UNESCAPED_UNICODE)
                    : $newValue;
            }

            // Format nilai kosong
            $oldValue = ($oldValue === null || $oldValue === '')
                ? '-'
                : $oldValue;

            $newValue = ($newValue === null || $newValue === '')
                ? '-'
                : $newValue;

            $perubahan[] = "{$fieldLabels[$field]}: \"{$oldValue}\" → \"{$newValue}\"";
        }

        // Simpan perubahan
        $data->save();

        // Buat notifikasi hanya jika ada perubahan
        if (!empty($perubahan)) {
            Notification::create([
                'type' => 'environment',
                'title' => 'Data Lingkungan Diperbarui',
                'message' => 'Data lingkungan ' .
                    ($data->wilayah ? "\"{$data->wilayah}\"" : '') .
                    ' diperbarui. Perubahan: ' .
                    implode(', ', $perubahan) .
                    '.',
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('lingkungan.view', $data->id)
            ->with('success', 'Data lingkungan berhasil diperbarui.');
    }
}