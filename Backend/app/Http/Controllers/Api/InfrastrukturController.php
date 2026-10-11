<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Infrastruktur;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class InfrastrukturController extends Controller
{
    private array $sumberApi = [
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/8/91/2024',
            'jenis' => 'Jembatan',
        ],
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/7/364/2024',
            'jenis' => 'Drainase',
        ],
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/7/365/2024',
            'jenis' => 'Drainase',
        ],
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/7/313/2024',
            'jenis' => 'Drainase',
        ],
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/7/398/2025',
            'jenis' => 'Pengelolaan Kota',
        ],
        [
            'url' => 'https://data.makassarkota.go.id/datasektorals/18/385/2024',
            'jenis' => 'Rumah',
        ],
    ];

    public function index(): JsonResponse
    {
        $data = Infrastruktur::orderBy('jenis')
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'total' => $data->count(),
            'data' => $data,
        ]);
    }

    public function sync(): JsonResponse
    {
        $totalDisimpan = 0;
        $totalNotifikasi = 0;
        $gagal = [];

        DB::beginTransaction();

        try {
            foreach ($this->sumberApi as $sumber) {
                try {
                    $response = Http::timeout(30)
                        ->acceptJson()
                        ->get($sumber['url']);

                    if ($response->failed()) {
                        $gagal[] = [
                            'jenis' => $sumber['jenis'],
                            'url' => $sumber['url'],
                            'status' => $response->status(),
                        ];

                        continue;
                    }

                    $data = $this->ambilArrayData($response->json());

                    foreach ($data as $item) {
                        $elemenData = data_get($item, 'elemen_data_r.elemen_data');
                        $judul = data_get($item, 'elemen_data_r.judul');
                        $noRef = data_get($item, 'elemen_data_r.no_ref');
                        $satuan = data_get($item, 'satuan_r.nama_satuan');
                        $apiId = data_get($item, 'id');
                        $fkElemen = data_get($item, 'fk_mst_elemen_data');
                        $jumlah = data_get($item, 'jumlah');
                        $tahun = data_get($item, 'tahun');

                        if (!$apiId || !$elemenData) {
                            continue;
                        }

                        $infrastruktur = Infrastruktur::updateOrCreate(
                            [
                                'jenis' => $sumber['jenis'],
                                'api_id' => $apiId,
                            ],
                            [
                                'kode' => $noRef ?: $fkElemen,
                                'nama' => $elemenData,
                                'judul' => $judul,
                                'lokasi' => $this->ambilLokasi($item, $elemenData),
                                'tahun' => $tahun,
                                'nilai' => is_numeric($jumlah) ? $jumlah : null,
                                'satuan' => $satuan,
                                'kondisi' => $this->ambilKondisi($item),
                                'sumber' => 'Satu Data Makassar',
                            ]
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | NOTIFIKASI JIKA DATA INFRASTRUKTUR BERUBAH
                        |--------------------------------------------------------------------------
                        */

                        if ($infrastruktur->wasChanged()) {
                            Notification::create([
                                'type' => 'infrastructure',
                                'title' => 'Data Infrastruktur Diperbarui',
                                'message' => "Data {$infrastruktur->jenis} \"{$infrastruktur->nama}\" telah diperbarui.",
                                'is_read' => false,
                            ]);

                            $totalNotifikasi++;
                        }

                        $totalDisimpan++;
                    }
                } catch (\Throwable $e) {
                    $gagal[] = [
                        'jenis' => $sumber['jenis'],
                        'url' => $sumber['url'],
                        'error' => $e->getMessage(),
                    ];
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sinkronisasi data infrastruktur selesai.',
                'total_diproses' => $totalDisimpan,
                'total_notifikasi' => $totalNotifikasi,
                'gagal' => $gagal,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Sinkronisasi data gagal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function ambilArrayData(array $response): array
    {
        if (array_is_list($response)) {
            return $response;
        }

        foreach (['data', 'result', 'results', 'rows', 'items', 'records'] as $key) {
            if (isset($response[$key]) && is_array($response[$key])) {
                return $response[$key];
            }
        }

        foreach ($response as $value) {
            if (is_array($value) && array_is_list($value)) {
                return $value;
            }
        }

        return [];
    }

    private function ambilLokasi(array $item, string $nama): string
    {
        $lokasi = $item['kecamatan']
            ?? $item['nama_kecamatan']
            ?? $item['wilayah']
            ?? $item['kelurahan']
            ?? $item['lokasi']
            ?? $item['nama_wilayah']
            ?? null;

        if ($lokasi) {
            return $lokasi;
        }

        if (preg_match('/Kecamatan\s+(.+)$/i', $nama, $matches)) {
            return trim($matches[1]);
        }

        return 'Kota Makassar';
    }

    private function ambilKondisi(array $item): ?string
    {
        $text = strtolower(implode(' ', array_filter([
            $item['kondisi'] ?? null,
            $item['status'] ?? null,
            $item['keadaan'] ?? null,
            data_get($item, 'elemen_data_r.judul'),
            data_get($item, 'elemen_data_r.elemen_data'),
        ])));

        if (str_contains($text, 'rusak')) {
            return 'Rusak';
        }

        if (
            str_contains($text, 'pemeliharaan') ||
            str_contains($text, 'perlu perbaikan')
        ) {
            return 'Perlu Pemeliharaan';
        }

        if (
            str_contains($text, 'baik') ||
            str_contains($text, 'layak')
        ) {
            return 'Baik';
        }

        return null;
    }


    // Blade
    public function view(Request $request)
    {
        $query = Infrastruktur::orderBy('jenis')
        ->orderBy('nama');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query->paginate(8)->withQueryString();

        return view('infrastruktur.index', [
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $infrastruktur = Infrastruktur::findOrFail($id);

        return view('infrastruktur.show', [
            'infrastruktur' => $infrastruktur,
        ]);
    }

    public function create()
    {
        return view('infrastruktur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'nullable|string|max:255',
            'jenis' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'judul' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'nilai' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'sumber' => 'nullable|string|max:255',
        ]);

        $validated['api_id'] = null;

        // Simpan data infrastruktur
        $infrastruktur = Infrastruktur::create($validated);

        // Buat notifikasi
        Notification::create([
            'type' => 'infrastructure',
            'title' => 'Data Infrastruktur Ditambahkan',
            'message' => "Data {$infrastruktur->jenis} \"{$infrastruktur->nama}\" berhasil ditambahkan.",
            'is_read' => false,
        ]);

        return redirect('/infrastruktur')
            ->with('success', 'Data infrastruktur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $infrastruktur = Infrastruktur::findOrFail($id);

        return view('infrastruktur.edit', [
            'infrastruktur' => $infrastruktur,
        ]);
    }

    public function update(Request $request, $id)
    {
        $infrastruktur = Infrastruktur::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'nullable|string|max:255',
            'jenis' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'judul' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'nilai' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'sumber' => 'nullable|string|max:255',
        ]);

        $dataLama = $infrastruktur->getOriginal();

        $namaField = [
            'kode' => 'Kode',
            'jenis' => 'Jenis',
            'nama' => 'Nama',
            'judul' => 'Judul',
            'lokasi' => 'Lokasi',
            'tahun' => 'Tahun',
            'nilai' => 'Nilai',
            'satuan' => 'Satuan',
            'kondisi' => 'Kondisi',
            'sumber' => 'Sumber',
        ];

        $perubahan = [];

        foreach ($namaField as $field => $label) {
            $nilaiLama = $dataLama[$field] ?? null;
            $nilaiBaru = $validated[$field] ?? null;

            if ((string) $nilaiLama !== (string) $nilaiBaru) {
                $nilaiLama = $nilaiLama !== null && $nilaiLama !== ''
                    ? $nilaiLama
                    : '-';

                $nilaiBaru = $nilaiBaru !== null && $nilaiBaru !== ''
                    ? $nilaiBaru
                    : '-';

                $perubahan[] = "{$label}: {$nilaiLama} → {$nilaiBaru}";
            }
        }

        $infrastruktur->update($validated);

        if (!empty($perubahan)) {
            Notification::create([
                'type' => 'infrastructure',
                'title' => 'Data Infrastruktur Diperbarui',
                'message' => "Data {$infrastruktur->jenis} \"{$infrastruktur->nama}\" diperbarui. Perubahan: " . implode(', ', $perubahan) . '.',
                'is_read' => false,
            ]);
        }

        return redirect('/infrastruktur')
            ->with('success', 'Data infrastruktur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $infrastruktur = Infrastruktur::findOrFail($id);

        $nama = $infrastruktur->nama;
        $jenis = $infrastruktur->jenis;

        $infrastruktur->delete();

        return redirect('/infrastruktur')
            ->with('success', 'Data infrastruktur berhasil dihapus.');
    }
}