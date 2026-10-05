<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Notification;
use App\Models\SegmenJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JalanController extends Controller
{
    private function createSegmentNotification($jalan, $segmen, $kondisiLama = null, $kepadatanLama = null)
    {
        $kondisiBaru = $segmen->kondisi_jalan;
        $kepadatanBaru = $segmen->tingkat_kepadatan;

        $idSegmen = $segmen->id_segmen ?? $segmen->id;
        $panjangSegmen = $segmen->panjang_m ?? 0;

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI KONDISI JALAN
        |--------------------------------------------------------------------------
        */

        // Hanya membuat notifikasi jika kondisi jalan berubah
        if ($kondisiLama !== $kondisiBaru) {

            if (in_array($kondisiBaru, ['Banjir', 'Longsor'])) {

                Notification::create([
                    'type' => 'road',
                    'title' => 'Kondisi Jalan Berubah',
                    'message' => 'Terjadi ' .
                        $kondisiBaru .
                        ' sebesar ' .
                        ($segmen->panjang_kondisi_m ?? 0) .
                        ' m di ruas jalan ' .
                        $jalan->nama_ruas_jalan .
                        '.',
                    'is_read' => false,
                ]);

            } elseif ($kondisiBaru === 'Lainnya') {

                Notification::create([
                    'type' => 'road',
                    'title' => 'Kondisi Jalan Berubah',
                    'message' => 'Terjadi ' .
                        ($segmen->kondisi_lainnya ?? 'gangguan') .
                        ' sebesar ' .
                        ($segmen->panjang_kondisi_m ?? 0) .
                        ' m di ruas jalan ' .
                        $jalan->nama_ruas_jalan .
                        '.',
                    'is_read' => false,
                ]);

            } elseif ($kondisiBaru === 'Normal' && $kondisiLama !== null) {

                Notification::create([
                    'type' => 'road',
                    'title' => 'Kondisi Jalan Kembali Normal',
                    'message' => 'Jalan ' .
                        $jalan->nama_ruas_jalan .
                        ', pada segmen ' .
                        $idSegmen .
                        ' sepanjang ' .
                        $panjangSegmen .
                        ' m sudah kembali normal.',
                    'is_read' => false,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI KEMACETAN
        |--------------------------------------------------------------------------
        */

        // Kondisi berubah menjadi Macet
        if (
            $kepadatanLama !== 'Macet' &&
            $kepadatanBaru === 'Macet'
        ) {

            Notification::create([
                'type' => 'road',
                'title' => 'Kemacetan Terdeteksi',
                'message' => 'Terjadi kemacetan di ' .
                    $jalan->nama_ruas_jalan .
                    ' pada segmen ' .
                    $idSegmen .
                    ' sepanjang: ' .
                    $panjangSegmen .
                    ' m.',
                'is_read' => false,
            ]);
        }

        // Macet berubah menjadi normal
        if (
            $kepadatanLama === 'Macet' &&
            $kepadatanBaru !== 'Macet'
        ) {

            Notification::create([
                'type' => 'road',
                'title' => 'Kemacetan Berakhir',
                'message' => 'Jalan ' .
                    $jalan->nama_ruas_jalan .
                    ', pada segmen ' .
                    $idSegmen .
                    ' sepanjang ' .
                    $panjangSegmen .
                    ' m sudah kembali normal.',
                'is_read' => false,
            ]);
        }
    }

    public function index()
    {
        $jalan = Jalan::with('segmenJalans')
            ->orderBy('nama_ruas_jalan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jalan,
        ]);
    }

    public function syncOSM()
    {
        set_time_limit(300);
        
        try {
            $overpassQuery = <<<'QUERY'
[out:json][timeout:120];

area["name"="Makassar"]->.searchArea;

(
    way["highway"]["name"](area.searchArea);
);

out body geom;
QUERY;

            $response = Http::timeout(240)
                ->withHeaders([
                    'User-Agent' => 'API-CityVerse/1.0 (Laravel OpenStreetMap Integration)',
                    'Accept' => 'application/json',
                ])
                ->asForm()
                ->post('https://overpass-api.de/api/interpreter', [
                    'data' => $overpassQuery,
                ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data dari Overpass API.',
                    'status' => $response->status(),
                ], 500);
            }

            $data = $response->json();

            if (!isset($data['elements'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Response Overpass API tidak memiliki data jalan.',
                ], 500);
            }

            $jumlahSegmen = 0;
            $jumlahRuas = 0;
            $jumlahDilewati = 0;

            $jalanIds = [];

            foreach ($data['elements'] as $item) {
                if (!isset($item['id'])) {
                    $jumlahDilewati++;
                    continue;
                }

                $tags = $item['tags'] ?? [];

                if (empty($tags['name'])) {
                    $jumlahDilewati++;
                    continue;
                }

                $namaJalan = trim($tags['name']);

                $coords = [];

                if (!empty($item['geometry'])) {
                    foreach ($item['geometry'] as $point) {
                        if (
                            isset($point['lat']) &&
                            isset($point['lon'])
                        ) {
                            $coords[] = [
                                $point['lat'],
                                $point['lon'],
                            ];
                        }
                    }
                }

                if (count($coords) < 2) {
                    $jumlahDilewati++;
                    continue;
                }

                $totalDistance = 0;

                for ($i = 0; $i < count($coords) - 1; $i++) {
                    $totalDistance += $this->calculateDistance(
                        $coords[$i][0],
                        $coords[$i][1],
                        $coords[$i + 1][0],
                        $coords[$i + 1][1]
                    );
                }

                $tipeJalan = match ($tags['highway'] ?? null) {
                    'motorway' => 'Jalan Tol',
                    'trunk' => 'Jalan Nasional / Trunk',
                    'primary' => 'Jalan Utama / Primary',
                    'secondary' => 'Jalan Sekunder',
                    'tertiary' => 'Jalan Tersier',
                    'residential' => 'Jalan Permukiman',
                    'unclassified' => 'Jalan Umum',
                    'service' => 'Jalan Layanan',
                    'living_street' => 'Jalan Lingkungan',
                    'pedestrian' => 'Jalan Pedestrian',
                    'motorway_link' => 'Jalan Penghubung Tol',
                    'trunk_link' => 'Jalan Penghubung Trunk',
                    'primary_link' => 'Jalan Penghubung Utama',
                    'secondary_link' => 'Jalan Penghubung Sekunder',
                    'tertiary_link' => 'Jalan Penghubung Tersier',
                    default => 'Jalan Umum',
                };

                $lebar = null;

                if (!empty($tags['width'])) {
                    $width = preg_replace('/[^0-9.]/', '', $tags['width']);

                    if (is_numeric($width)) {
                        $lebar = (float) $width;
                    }
                } elseif (!empty($tags['lanes'])) {
                    $lanes = (float) $tags['lanes'];

                    if ($lanes > 0) {
                        $lebar = $lanes * 3.5;
                    }
                }

                $jalan = Jalan::firstOrCreate(
                    [
                        'nama_ruas_jalan' => $namaJalan,
                    ],
                    [
                        'panjang_m' => 0,
                        'lebar_m' => $lebar,
                        'tipe_jalan_detail' => $tipeJalan,
                    ]
                );

                $jalanIds[$jalan->id_jalan] = true;

                SegmenJalan::updateOrCreate(
                    [
                        'osm_id' => $item['id'],],
                    [
                        'jalan_id' => $jalan->id_jalan,
                        'koordinat_geometri' => $coords,
                        'panjang_m' => $totalDistance,
                        'lebar_m' => $lebar,
                        'tipe_jalan_detail' => $tipeJalan,]
                );
                $jumlahSegmen++;
            }

            foreach (array_keys($jalanIds) as $jalanId) {
                $jalan = Jalan::find($jalanId);
                if (!$jalan) {
                    continue;
                }

                $segmen = SegmenJalan::where( 'jalan_id', $jalanId)->get();

                $totalPanjang = $segmen->sum(fn ($item) => (float) $item->panjang_m);
                $lebarRataRata = $segmen->whereNotNull('lebar_m')->avg('lebar_m');
                $tipeUtama = $segmen->groupBy('tipe_jalan_detail')->sortByDesc(fn ($group) => $group->count())->keys()->first();

                $jalan->update(['panjang_m' => $totalPanjang,'lebar_m' => $lebarRataRata,'tipe_jalan_detail' => $tipeUtama,]);
                $jumlahRuas++;
            }

            return response()->json(['success' => true,'message' => 'Data jalan Makassar berhasil disinkronisasi.','jumlah_ruas' => $jumlahRuas,'jumlah_segmen' => $jumlahSegmen,'jumlah_dilewati' => $jumlahDilewati,]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false,'message' => 'Terjadi kesalahan saat sinkronisasi data jalan.','error' => $e->getMessage(),], 500);
        }
    }

    private function calculateDistance( float $lat1, float $lon1, float $lat2, float $lon2): float {
        $earthRadius = 6371000;
        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);
        $a = sin($deltaLat / 2) ** 2 + cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a),sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function generateTraffic()
    {
        $jumlah = 0;
        SegmenJalan::query()->chunkById(500, function ($segmenJalans) use (&$jumlah) {
                foreach ($segmenJalans as $segmen) {
                    $kapasitas = random_int(1000, 5000);
                    $persentase = random_int(20, 95) / 100;
                    $volume = (int) round($kapasitas * $persentase);

                    $rasio = $volume / $kapasitas;
                    if ($rasio < 0.60) {
                        $kepadatan = 'Lancar';
                    } elseif ($rasio < 0.80) {
                        $kepadatan = 'Sedang';
                    } else {
                        $kepadatan = 'Macet';
                    }

                    $segmen->update(['kapasitas_jalan' => $kapasitas,'volume_kendaraan' => $volume,'tingkat_kepadatan' => $kepadatan,]);
                    $jumlah++;
                }
            });

        return response()->json(['success' => true,'message' => 'Data traffic setiap segmen berhasil dibuat.','jumlah_data' => $jumlah,]);
    }

    // Blade
    public function indexBlade(Request $request)
    {
        $search = $request->input('search');
        $jalan = Jalan::with('segmenJalans')->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_ruas_jalan', 'like', "%{$search}%")->orWhere('tipe_jalan_detail', 'like', "%{$search}%");
                });
            })->orderBy('nama_ruas_jalan')->paginate(10)->withQueryString();

        return view('jalan.index', compact('jalan', 'search'));
    }

    public function create()
    {
        return view('jalan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruas_jalan' => [
                'required',
                'string',
                'max:255',
                'unique:jalans,nama_ruas_jalan',
            ],

            'panjang_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'lebar_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tipe_jalan_detail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'segmen' => [
                'nullable',
                'array',
            ],

            'segmen.*.osm_id' => [
                'required',
                'integer',
                'distinct',
                'unique:segmen_jalans,osm_id',
            ],

            'segmen.*.koordinat_geometri' => [
                'nullable',
                'json',
            ],

            'segmen.*.panjang_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.lebar_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.tipe_jalan_detail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'segmen.*.kapasitas_jalan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'segmen.*.volume_kendaraan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'segmen.*.kondisi_jalan' => [
                'nullable',
                'in:Normal,Longsor,Banjir,Lainnya',
            ],

            'segmen.*.panjang_kondisi_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.kondisi_lainnya' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $jalan = Jalan::create([
            'nama_ruas_jalan' => $validated['nama_ruas_jalan'],
            'panjang_m' => $validated['panjang_m'] ?? null,
            'lebar_m' => $validated['lebar_m'] ?? null,
            'tipe_jalan_detail' => $validated['tipe_jalan_detail'] ?? null,
        ]);

        if (!empty($validated['segmen'])) {

            foreach ($validated['segmen'] as $dataSegmen) {

                $koordinat = null;

                if (!empty($dataSegmen['koordinat_geometri'])) {
                    $koordinat = json_decode(
                        $dataSegmen['koordinat_geometri'],
                        true
                    );
                }

                $kapasitas = $dataSegmen['kapasitas_jalan'] ?? null;
                $volume = $dataSegmen['volume_kendaraan'] ?? null;

                $tingkatKepadatan = null;

                if (
                    $kapasitas !== null &&
                    $volume !== null &&
                    $kapasitas > 0
                ) {

                    $rasio = $volume / $kapasitas;

                    if ($rasio < 0.60) {
                        $tingkatKepadatan = 'Lancar';
                    } elseif ($rasio < 0.80) {
                        $tingkatKepadatan = 'Sedang';
                    } else {
                        $tingkatKepadatan = 'Macet';
                    }
                }

                $segmen = $jalan->segmenJalans()->create([
                    'osm_id' => $dataSegmen['osm_id'],

                    'koordinat_geometri' => $koordinat,

                    'panjang_m' =>
                        $dataSegmen['panjang_m'] ?? null,

                    'lebar_m' =>
                        $dataSegmen['lebar_m'] ?? null,

                    'tipe_jalan_detail' =>
                        $dataSegmen['tipe_jalan_detail'] ?? null,

                    'kapasitas_jalan' =>
                        $kapasitas,

                    'volume_kendaraan' =>
                        $volume,

                    'tingkat_kepadatan' =>
                        $tingkatKepadatan,

                    'kondisi_jalan' =>
                        $dataSegmen['kondisi_jalan'] ?? 'Normal',

                    'panjang_kondisi_m' =>
                        $dataSegmen['panjang_kondisi_m'] ?? null,

                    'kondisi_lainnya' =>
                        $dataSegmen['kondisi_lainnya'] ?? null,
                ]);

                /*
                * Karena ini data baru, kondisi awal seperti
                * Banjir, Longsor, Lainnya, atau Macet
                * tetap akan menghasilkan notifikasi.
                *
                * Normal tidak membuat notifikasi.
                */
                $this->createSegmentNotification(
                    $jalan,
                    $segmen
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI DATA JALAN DITAMBAHKAN
        |--------------------------------------------------------------------------
        */

        Notification::create([
            'type' => 'road',
            'title' => 'Data Jalan Ditambahkan',
            'message' => 'Data jalan "' .
                $jalan->nama_ruas_jalan .
                '" berhasil ditambahkan.',
            'is_read' => false,
        ]);

        return redirect()
            ->route('jalan.index')
            ->with(
                'success',
                'Data jalan dan segmen berhasil ditambahkan.'
            );
    }

    public function show($id)
    {
        $jalan = Jalan::with('segmenJalans')->findOrFail($id);
        return view('jalan.show', compact('jalan'));
    }

    public function edit($id)
    {
        $jalan = Jalan::findOrFail($id);
        return view('jalan.edit', compact('jalan'));
    }

    public function update(Request $request, $id)
    {
        $jalan = Jalan::with('segmenJalans')->findOrFail($id);

        $validated = $request->validate([
            'nama_ruas_jalan' => [
                'required',
                'string',
                'max:255',
                'unique:jalans,nama_ruas_jalan,' .
                    $jalan->id_jalan .
                    ',id_jalan',
            ],

            'panjang_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'lebar_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tipe_jalan_detail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'segmen' => [
                'nullable',
                'array',
            ],

            'segmen.*.osm_id' => [
                'required',
                'integer',
                'distinct',
            ],

            'segmen.*.koordinat_geometri' => [
                'nullable',
                'json',
            ],

            'segmen.*.panjang_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.lebar_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.tipe_jalan_detail' => [
                'nullable',
                'string',
                'max:255',
            ],

            'segmen.*.kapasitas_jalan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'segmen.*.volume_kendaraan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'segmen.*.kondisi_jalan' => [
                'nullable',
                'in:Normal,Longsor,Banjir,Lainnya',
            ],

            'segmen.*.panjang_kondisi_m' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'segmen.*.kondisi_lainnya' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KONDISI LAMA SETIAP SEGMEN
        |--------------------------------------------------------------------------
        */

        $kondisiLama = [];

        foreach ($jalan->segmenJalans as $segmenLama) {

            $kondisiLama[$segmenLama->osm_id] = [
                'kondisi_jalan' =>
                    $segmenLama->kondisi_jalan,

                'tingkat_kepadatan' =>
                    $segmenLama->tingkat_kepadatan,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA JALAN
        |--------------------------------------------------------------------------
        */

        $jalan->update([
            'nama_ruas_jalan' =>
                $validated['nama_ruas_jalan'],

            'panjang_m' =>
                $validated['panjang_m'] ?? null,

            'lebar_m' =>
                $validated['lebar_m'] ?? null,

            'tipe_jalan_detail' =>
                $validated['tipe_jalan_detail'] ?? null,
        ]);

        $osmIds = [];

        /*
        |--------------------------------------------------------------------------
        | UPDATE / CREATE SEGMEN
        |--------------------------------------------------------------------------
        */

        foreach ($validated['segmen'] ?? [] as $dataSegmen) {

            $osmId = $dataSegmen['osm_id'];

            $osmIds[] = $osmId;

            $koordinat = null;

            if (!empty($dataSegmen['koordinat_geometri'])) {

                $koordinat = json_decode(
                    $dataSegmen['koordinat_geometri'],
                    true
                );
            }

            $kapasitas =
                $dataSegmen['kapasitas_jalan'] ?? null;

            $volume =
                $dataSegmen['volume_kendaraan'] ?? null;

            $tingkatKepadatan = null;

            if (
                $kapasitas !== null &&
                $volume !== null &&
                $kapasitas > 0
            ) {

                $rasio = $volume / $kapasitas;

                if ($rasio < 0.60) {

                    $tingkatKepadatan = 'Lancar';

                } elseif ($rasio < 0.80) {

                    $tingkatKepadatan = 'Sedang';

                } else {

                    $tingkatKepadatan = 'Macet';
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CARI SEGMEN LAMA
            |--------------------------------------------------------------------------
            */

            $segmen = $jalan->segmenJalans()
                ->where('osm_id', $osmId)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | UPDATE SEGMEN LAMA
            |--------------------------------------------------------------------------
            */

            if ($segmen) {

                $kondisiSebelumnya =
                    $kondisiLama[$osmId]['kondisi_jalan']
                    ?? null;

                $kepadatanSebelumnya =
                    $kondisiLama[$osmId]['tingkat_kepadatan']
                    ?? null;

                $segmen->update([
                    'koordinat_geometri' =>
                        $koordinat,

                    'panjang_m' =>
                        $dataSegmen['panjang_m'] ?? null,

                    'lebar_m' =>
                        $dataSegmen['lebar_m'] ?? null,

                    'tipe_jalan_detail' =>
                        $dataSegmen['tipe_jalan_detail'] ?? null,

                    'kapasitas_jalan' =>
                        $kapasitas,

                    'volume_kendaraan' =>
                        $volume,

                    'tingkat_kepadatan' =>
                        $tingkatKepadatan,

                    'kondisi_jalan' =>
                        $dataSegmen['kondisi_jalan'] ?? 'Normal',

                    'panjang_kondisi_m' =>
                        $dataSegmen['panjang_kondisi_m'] ?? null,

                    'kondisi_lainnya' =>
                        $dataSegmen['kondisi_lainnya'] ?? null,
                ]);

                $segmen->refresh();

                $this->createSegmentNotification(
                    $jalan,
                    $segmen,
                    $kondisiSebelumnya,
                    $kepadatanSebelumnya
                );

            } else {
                $segmen = $jalan->segmenJalans()->create([
                    'osm_id' =>
                        $osmId,

                    'koordinat_geometri' =>
                        $koordinat,

                    'panjang_m' =>
                        $dataSegmen['panjang_m'] ?? null,

                    'lebar_m' =>
                        $dataSegmen['lebar_m'] ?? null,

                    'tipe_jalan_detail' =>
                        $dataSegmen['tipe_jalan_detail'] ?? null,

                    'kapasitas_jalan' =>
                        $kapasitas,

                    'volume_kendaraan' =>
                        $volume,

                    'tingkat_kepadatan' =>
                        $tingkatKepadatan,

                    'kondisi_jalan' =>
                        $dataSegmen['kondisi_jalan'] ?? 'Normal',

                    'panjang_kondisi_m' =>
                        $dataSegmen['panjang_kondisi_m'] ?? null,

                    'kondisi_lainnya' =>
                        $dataSegmen['kondisi_lainnya'] ?? null,
                ]);

                /*
                * Segmen baru:
                * Banjir / Longsor / Lainnya / Macet
                * akan menghasilkan notifikasi.
                */
                $this->createSegmentNotification(
                    $jalan,
                    $segmen
                );
            }
        }
        
        $jalan->segmenJalans()
            ->when(
                count($osmIds) > 0,
                function ($query) use ($osmIds) {
                    $query->whereNotIn('osm_id', $osmIds);
                }
            )
            ->when(
                count($osmIds) === 0,
                function ($query) {}
            )
            ->delete();

        return redirect()
            ->route('jalan.index')
            ->with(
                'success',
                'Data jalan berhasil diperbarui.'
            );
    }

    public function destroy($id)
    {
        $jalan = Jalan::findOrFail($id);
        $jalan->segmenJalans()->delete();
        $jalan->delete();

        return redirect()->route('jalan.index')->with('success', 'Data jalan berhasil dihapus.');
    }
}
