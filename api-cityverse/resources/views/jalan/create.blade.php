<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Jalan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 min-h-screen bg-[#f5f7fb] font-sans text-slate-800">
    <div class="container mx-auto w-full max-w-[1200px] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <div class="header mb-6">
            <h1 class="m-0 mb-2 text-2xl font-bold text-slate-900">Tambah Data Jalan</h1>
            <p class="m-0 text-sm text-slate-500">Tambahkan data ruas jalan beserta segmen jalan yang dimilikinya.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-5 rounded-[9px] border border-red-200 bg-red-100 px-4 py-3.5 text-sm text-red-800">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 ml-5 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jalan.store') }}" method="POST">
            @csrf

            <div class="card mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
                <div class="card-header mb-5 flex items-center justify-between gap-4 border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="card-title m-0 text-lg font-bold text-slate-900">Informasi Jalan</h2>
                        <p class="card-description mt-1 text-[13px] text-slate-500">Masukkan informasi utama mengenai ruas jalan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2">
                    <div class="form-group col-span-full flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700" for="nama_ruas_jalan">
                            Nama Ruas Jalan
                            <span class="text-red-600">*</span>
                        </label>

                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="text" id="nama_ruas_jalan" name="nama_ruas_jalan" value="{{ old('nama_ruas_jalan') }}" placeholder="Contoh: Jalan A. P. Pettarani" required>

                        @error('nama_ruas_jalan')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700" for="panjang_m">Panjang Jalan (meter)</label>

                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" id="panjang_m" name="panjang_m" value="{{ old('panjang_m') }}" step="0.01" min="0" placeholder="Contoh: 2500">

                        <div class="mt-1 text-xs text-slate-500">Panjang total ruas jalan dalam meter.</div>

                        @error('panjang_m')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700" for="lebar_m">Lebar Jalan (meter)</label>

                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" id="lebar_m" name="lebar_m" value="{{ old('lebar_m') }}" step="0.01" min="0" placeholder="Contoh: 7.50">

                        <div class="mt-1 text-xs text-slate-500">Lebar rata-rata ruas jalan dalam meter.</div>

                        @error('lebar_m')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-span-full flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700" for="tipe_jalan_detail">Tipe Jalan</label>

                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" id="tipe_jalan_detail" name="tipe_jalan_detail">
                            <option value="">-- Pilih Tipe Jalan --</option>
                            <option value="Jalan Arteri" {{ old('tipe_jalan_detail') == 'Jalan Arteri' ? 'selected' : '' }}>Jalan Arteri</option>
                            <option value="Jalan Kolektor" {{ old('tipe_jalan_detail') == 'Jalan Kolektor' ? 'selected' : '' }}>Jalan Kolektor</option>
                            <option value="Jalan Lokal" {{ old('tipe_jalan_detail') == 'Jalan Lokal' ? 'selected' : '' }}>Jalan Lokal</option>
                            <option value="Jalan Tol" {{ old('tipe_jalan_detail') == 'Jalan Tol' ? 'selected' : '' }}>Jalan Tol</option>
                            <option value="Jalan Permukiman" {{ old('tipe_jalan_detail') == 'Jalan Permukiman' ? 'selected' : '' }}>Jalan Permukiman</option>
                            <option value="Jalan Servis" {{ old('tipe_jalan_detail') == 'Jalan Servis' ? 'selected' : '' }}>Jalan Servis</option>
                        </select>

                        @error('tipe_jalan_detail')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
                <div class="card-header mb-5 flex items-center justify-between gap-4 border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="card-title m-0 text-lg font-bold text-slate-900">Segmen Jalan</h2>
                        <p class="card-description mt-1 text-[13px] text-slate-500">Tambahkan satu atau beberapa segmen untuk ruas jalan ini.</p>
                    </div>

                    <button type="button" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white no-underline transition duration-200 hover:bg-blue-700" onclick="tambahSegmen()">
                        + Tambah Segmen
                    </button>
                </div>

                <div id="segments-container">
                    @if(old('segmen'))
                        @foreach(old('segmen') as $index => $segment)
                            <div class="segment-card mb-[18px] rounded-xl border border-slate-200 bg-slate-50 p-5" data-segment>
                                <div class="segment-header mb-[18px] flex items-center justify-between gap-4">
                                    <div class="segment-title flex items-center text-base font-bold text-slate-900">
                                        <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">{{ $index + 1 }}</span>
                                        Segmen {{ $index + 1 }}
                                    </div>

                                    <button type="button" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-red-100 px-4 py-2.5 text-sm font-semibold text-red-600 no-underline transition duration-200 hover:bg-red-200" onclick="hapusSegmen(this)">
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2 lg:grid-cols-3">
                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">
                                            OSM ID
                                            <span class="text-red-600">*</span>
                                        </label>

                                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[{{ $index }}][osm_id]" value="{{ $segment['osm_id'] ?? '' }}" min="1" placeholder="Contoh: 123456789" required>
                                    </div>

                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Segmen (m)</label>

                                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[{{ $index }}][panjang_m]" value="{{ $segment['panjang_m'] ?? '' }}" step="0.01" min="0" placeholder="Contoh: 250.50">
                                    </div>

                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Segmen (m)</label>

                                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[{{ $index }}][lebar_m]" value="{{ $segment['lebar_m'] ?? '' }}" step="0.01" min="0" placeholder="Contoh: 7.50">
                                    </div>

                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[{{ $index }}][tipe_jalan_detail]">
                                            <option value="">-- Pilih Tipe Jalan --</option>
                                            <option value="Jalan Arteri" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Arteri' ? 'selected' : '' }}>Jalan Arteri</option>
                                            <option value="Jalan Kolektor" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Kolektor' ? 'selected' : '' }}>Jalan Kolektor</option>
                                            <option value="Jalan Lokal" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Lokal' ? 'selected' : '' }}>Jalan Lokal</option>
                                            <option value="Jalan Tol" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Tol' ? 'selected' : '' }}>Jalan Tol</option>
                                            <option value="Jalan Permukiman" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Permukiman' ? 'selected' : '' }}>Jalan Permukiman</option>
                                            <option value="Jalan Servis" {{ ($segment['tipe_jalan_detail'] ?? '') == 'Jalan Servis' ? 'selected' : '' }}>Jalan Servis</option>
                                        </select>
                                    </div>

                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kapasitas Jalan</label>

                                        <input type="number" class="capacity-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[{{ $index }}][kapasitas_jalan]" value="{{ $segment['kapasitas_jalan'] ?? '' }}" min="0" placeholder="Contoh: 3000" oninput="hitungKepadatan(this)">

                                        <div class="mt-1 text-xs text-slate-500">Kendaraan per satuan waktu.</div>
                                    </div>

                                    <div class="form-group flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Volume Kendaraan</label>

                                        <input type="number" class="volume-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[{{ $index }}][volume_kendaraan]" value="{{ $segment['volume_kendaraan'] ?? '' }}" min="0" placeholder="Contoh: 1500" oninput="hitungKepadatan(this)">
                                    </div>

                                    <div class="form-group col-span-full flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kondisi Jalan</label>

                                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[{{ $index }}][kondisi_jalan]" onchange="toggleKondisi(this)">
                                            <option value="Normal" {{ ($segment['kondisi_jalan'] ?? 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="Longsor" {{ ($segment['kondisi_jalan'] ?? '') == 'Longsor' ? 'selected' : '' }}>Longsor</option>
                                            <option value="Banjir" {{ ($segment['kondisi_jalan'] ?? '') == 'Banjir' ? 'selected' : '' }}>Banjir</option>
                                            <option value="Lainnya" {{ ($segment['kondisi_jalan'] ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mt-[15px] grid grid-cols-1 gap-[18px] md:grid-cols-2">
                                        <div class="form-group hidden flex-col" data-panjang-kondisi>
                                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Kondisi (meter)</label>

                                            <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" step="0.01" min="0" name="segmen[{{ $index }}][panjang_kondisi_m]" value="{{ $segment['panjang_kondisi_m'] ?? '' }}" placeholder="Contoh: 15.50">

                                            <div class="mt-1 text-xs text-slate-500">Panjang bagian jalan yang terdampak.</div>
                                        </div>

                                        <div class="form-group hidden flex-col" data-kondisi-lainnya>
                                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Keterangan Kondisi</label>

                                            <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="text" name="segmen[{{ $index }}][kondisi_lainnya]" value="{{ $segment['kondisi_lainnya'] ?? '' }}" placeholder="Contoh: Jalan tertutup material">
                                        </div>
                                    </div>

                                    <div class="form-group col-span-full flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Koordinat Geometri</label>

                                        <textarea class="min-h-[100px] w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[{{ $index }}][koordinat_geometri]" placeholder='Contoh: [[119.412, -5.135], [119.413, -5.136]]'>{{ $segment['koordinat_geometri'] ?? '' }}</textarea>

                                        <div class="mt-1 text-xs text-slate-500">Masukkan koordinat dalam format JSON.</div>
                                    </div>
                                </div>

                                <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[13px] font-semibold text-slate-500">Tingkat Kepadatan</span>

                                        <span class="density-status inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500" data-density>Belum dihitung</span>
                                    </div>

                                    <div class="mt-2.5 text-xs text-slate-500" data-density-info>Masukkan kapasitas dan volume kendaraan untuk menghitung kepadatan.</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="segment-card mb-[18px] rounded-xl border border-slate-200 bg-slate-50 p-5" data-segment>
                            <div class="segment-header mb-[18px] flex items-center justify-between gap-4">
                                <div class="segment-title flex items-center text-base font-bold text-slate-900">
                                    <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">1</span>
                                    Segmen 1
                                </div>

                                <button type="button" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-red-100 px-4 py-2.5 text-sm font-semibold text-red-600 no-underline transition duration-200 hover:bg-red-200" onclick="hapusSegmen(this)">
                                    Hapus
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2 lg:grid-cols-3">
                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">
                                        OSM ID
                                        <span class="text-red-600">*</span>
                                    </label>

                                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[0][osm_id]" min="1" placeholder="Contoh: 123456789" required>
                                </div>

                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Segmen (m)</label>

                                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[0][panjang_m]" step="0.01" min="0" placeholder="Contoh: 250.50">
                                </div>

                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Segmen (m)</label>

                                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" name="segmen[0][lebar_m]" step="0.01" min="0" placeholder="Contoh: 7.50">
                                </div>

                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                                    <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[0][tipe_jalan_detail]">
                                        <option value="">-- Pilih Tipe Jalan --</option>
                                        <option value="Jalan Arteri">Jalan Arteri</option>
                                        <option value="Jalan Kolektor">Jalan Kolektor</option>
                                        <option value="Jalan Lokal">Jalan Lokal</option>
                                        <option value="Jalan Tol">Jalan Tol</option>
                                        <option value="Jalan Permukiman">Jalan Permukiman</option>
                                        <option value="Jalan Servis">Jalan Servis</option>
                                    </select>
                                </div>

                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Kapasitas Jalan</label>

                                    <input type="number" class="capacity-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[0][kapasitas_jalan]" min="0" placeholder="Contoh: 3000" oninput="hitungKepadatan(this)">

                                    <div class="mt-1 text-xs text-slate-500">Kapasitas maksimum kendaraan.</div>
                                </div>

                                <div class="form-group flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Volume Kendaraan</label>

                                    <input type="number" class="volume-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[0][volume_kendaraan]" min="0" placeholder="Contoh: 1500" oninput="hitungKepadatan(this)">
                                </div>

                                <div class="form-group col-span-full flex flex-col">
                                    <label class="mb-1.5 text-sm font-semibold text-slate-700">Koordinat Geometri</label>

                                    <textarea class="min-h-[100px] w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[0][koordinat_geometri]" placeholder='Contoh: [[119.412, -5.135], [119.413, -5.136]]'></textarea>

                                    <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kondisi Jalan</label>

                                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[0][kondisi_jalan]" onchange="toggleKondisi(this)">
                                            <option value="Normal" selected>Normal</option>
                                            <option value="Longsor">Longsor</option>
                                            <option value="Banjir">Banjir</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>

                                        <div class="mt-[15px] grid grid-cols-1 gap-[18px] md:grid-cols-2">
                                            <div class="form-group hidden flex-col" data-panjang-kondisi>
                                                <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Kondisi (meter)</label>

                                                <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="number" step="0.01" min="0" name="segmen[0][panjang_kondisi_m]" placeholder="Contoh: 15.50">

                                                <div class="mt-1 text-xs text-slate-500">Panjang bagian jalan yang terdampak.</div>
                                            </div>

                                            <div class="form-group flex flex-col hidden" data-kondisi-lainnya>
                                                <label class="mb-1.5 text-sm font-semibold text-slate-700">Keterangan Kondisi</label>

                                                <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" type="text" name="segmen[0][kondisi_lainnya]" placeholder="Contoh: Jalan tertutup material">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">Masukkan koordinat dalam format JSON.</div>
                                </div>
                            </div>

                            <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[13px] font-semibold text-slate-500">Tingkat Kepadatan</span>
                                    <span class="density-status inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500" data-density>Belum dihitung</span>
                                </div>

                                <div class="mt-2.5 text-xs text-slate-500" data-density-info>Masukkan kapasitas dan volume kendaraan untuk menghitung kepadatan.</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div id="empty-segment" class="mb-[18px] hidden rounded-[10px] border-2 border-dashed border-slate-300 p-5 text-center text-slate-500">
                    Belum ada segmen. Klik tombol <strong>Tambah Segmen</strong>.
                </div>
            </div>

            <div class="mt-6 flex flex-col-reverse justify-end gap-2.5 md:flex-row">
                <a href="{{ route('jalan.index') }}" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 no-underline transition duration-200 hover:bg-slate-300">
                    Batal
                </a>

                <button type="submit" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-green-600 px-4 py-2.5 text-sm font-semibold text-white no-underline transition duration-200 hover:bg-green-700">
                    Simpan Data Jalan
                </button>
            </div>
        </form>
    </div>

    <script>
        let segmentIndex = {{ old('segmen') ? count(old('segmen')) : 1 }};

        function tipeJalanOptions() {
            return `
                <option value="">-- Pilih Tipe Jalan --</option>
                <option value="Jalan Arteri">Jalan Arteri</option>
                <option value="Jalan Kolektor">Jalan Kolektor</option>
                <option value="Jalan Lokal">Jalan Lokal</option>
                <option value="Jalan Tol">Jalan Tol</option>
                <option value="Jalan Permukiman">Jalan Permukiman</option>
                <option value="Jalan Servis">Jalan Servis</option>
            `;
        }

        function tambahSegmen() {
            const container = document.getElementById('segments-container');
            const index = segmentIndex;
            const segment = document.createElement('div');

            segment.className = 'segment-card mb-[18px] rounded-xl border border-slate-200 bg-slate-50 p-5';
            segment.setAttribute('data-segment', '');

            segment.innerHTML = `
                <div class="segment-header mb-[18px] flex items-center justify-between gap-4">
                    <div class="segment-title flex items-center text-base font-bold text-slate-900">
                        <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">${index + 1}</span>
                        Segmen ${index + 1}
                    </div>

                    <button type="button" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border-0 bg-red-100 px-4 py-2.5 text-sm font-semibold text-red-600 no-underline transition duration-200 hover:bg-red-200" onclick="hapusSegmen(this)">
                        Hapus
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">
                            OSM ID
                            <span class="text-red-600">*</span>
                        </label>

                        <input type="number" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][osm_id]" min="1" placeholder="Contoh: 123456789" required>
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Segmen (m)</label>

                        <input type="number" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][panjang_m]" step="0.01" min="0" placeholder="Contoh: 250.50">
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Segmen (m)</label>

                        <input type="number" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][lebar_m]" step="0.01" min="0" placeholder="Contoh: 7.50">
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][tipe_jalan_detail]">
                            ${tipeJalanOptions()}
                        </select>
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kapasitas Jalan</label>

                        <input type="number" class="capacity-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][kapasitas_jalan]" min="0" placeholder="Contoh: 3000" oninput="hitungKepadatan(this)">

                        <div class="mt-1 text-xs text-slate-500">Kapasitas maksimum kendaraan.</div>
                    </div>

                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Volume Kendaraan</label>

                        <input type="number" class="volume-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][volume_kendaraan]" min="0" placeholder="Contoh: 1500" oninput="hitungKepadatan(this)">
                    </div>

                    <div class="form-group col-span-full flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Koordinat Geometri</label>

                        <textarea class="min-h-[100px] w-full resize-y rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][koordinat_geometri]" placeholder='Contoh: [[119.412, -5.135], [119.413, -5.136]]'></textarea>

                        <div class="mt-1 text-xs text-slate-500">Masukkan koordinat dalam format JSON.</div>
                    </div>
                </div>

                <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                    <div class="form-group flex flex-col">
                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kondisi Jalan</label>

                        <select class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][kondisi_jalan]" onchange="toggleKondisi(this)">
                            <option value="Normal" selected>Normal</option>
                            <option value="Longsor">Longsor</option>
                            <option value="Banjir">Banjir</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mt-[15px] grid grid-cols-1 gap-[18px] md:grid-cols-2">
                        <div class="form-group hidden flex-col" data-panjang-kondisi>
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Kondisi (meter)</label>

                            <input type="number" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][panjang_kondisi_m]" placeholder="Contoh: 15.50">

                            <div class="mt-1 text-xs text-slate-500">Panjang bagian jalan yang terdampak.</div>
                        </div>

                        <div class="form-group flex flex-col hidden" data-kondisi-lainnya>
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Keterangan Kondisi</label>

                            <input type="text" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" name="segmen[${index}][kondisi_lainnya]" placeholder="Contoh: Jalan tertutup material">
                        </div>
                    </div>
                </div>

                <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-[13px] font-semibold text-slate-500">Tingkat Kepadatan</span>

                        <span class="density-status inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500" data-density>
                            Belum dihitung
                        </span>
                    </div>

                    <div class="mt-2.5 text-xs text-slate-500" data-density-info>
                        Masukkan kapasitas dan volume kendaraan untuk menghitung kepadatan.
                    </div>
                </div>
            `;

            container.appendChild(segment);
            segmentIndex++;

            updateSegmentNumbers();
            cekSegmentKosong();
        }

        function toggleKondisi(select) {
            const segment = select.closest('[data-segment]');

            if (!segment) {
                return;
            }

            const panjangBox = segment.querySelector('[data-panjang-kondisi]');
            const lainnyaBox = segment.querySelector('[data-kondisi-lainnya]');

            if (!panjangBox || !lainnyaBox) {
                return;
            }

            const inputLainnya = lainnyaBox.querySelector('input');

            if (select.value === 'Normal') {
                panjangBox.classList.add('hidden');
                lainnyaBox.classList.add('hidden');

                const panjangInput = panjangBox.querySelector('input');

                if (panjangInput) {
                    panjangInput.value = '';
                }

                if (inputLainnya) {
                    inputLainnya.value = '';
                }
            } else if (select.value === 'Lainnya') {
                panjangBox.classList.remove('hidden');
                lainnyaBox.classList.remove('hidden');
            } else {
                panjangBox.classList.remove('hidden');
                lainnyaBox.classList.add('hidden');

                if (inputLainnya) {
                    inputLainnya.value = '';
                }
            }
}

        function hapusSegmen(button) {
            const segment = button.closest('[data-segment]');

            if (!segment) {
                return;
            }

            segment.remove();

            updateSegmentNumbers();
            cekSegmentKosong();
        }

        function updateSegmentNumbers() {
            const segments = document.querySelectorAll('[data-segment]');

            segments.forEach((segment, index) => {
                const number = segment.querySelector('.segment-number');
                const title = segment.querySelector('.segment-title');

                if (number) {
                    number.textContent = index + 1;
                }

                if (title) {
                    title.innerHTML = `
                        <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] shrink-0 items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">${index + 1}</span>
                        Segmen ${index + 1}
                    `;
                }
            });
        }

        function cekSegmentKosong() {
            const segments = document.querySelectorAll('[data-segment]');
            const empty = document.getElementById('empty-segment');

            if (segments.length === 0) {
                empty.classList.remove('hidden');
            } else {
                empty.classList.add('hidden');
            }
        }

        function hitungKepadatan(input) {
            const segment = input.closest('[data-segment]');

            if (!segment) {
                return;
            }

            const capacityInput = segment.querySelector('.capacity-input');
            const volumeInput = segment.querySelector('.volume-input');
            const density = segment.querySelector('[data-density]');
            const densityInfo = segment.querySelector('[data-density-info]');

            const kapasitas = parseFloat(capacityInput.value);
            const volume = parseFloat(volumeInput.value);

            if (!kapasitas || kapasitas <= 0 || isNaN(volume)) {
                density.textContent = 'Belum dihitung';
                density.className = 'density-status inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500';
                densityInfo.textContent = 'Masukkan kapasitas dan volume kendaraan untuk menghitung kepadatan.';
                return;
            }

            const rasio = volume / kapasitas;
            const persentase = rasio * 100;

            if (rasio < 0.60) {
                density.textContent = 'Lancar';
                density.className = 'density-status inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-800';
            } else if (rasio < 0.80) {
                density.textContent = 'Sedang';
                density.className = 'density-status inline-flex rounded-full bg-orange-100 px-3 py-1.5 text-xs font-bold text-orange-700';
            } else {
                density.textContent = 'Macet';
                density.className = 'density-status inline-flex rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700';
            }

            densityInfo.textContent = `Rasio volume terhadap kapasitas: ${persentase.toFixed(2)}%`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const segments = document.querySelectorAll('[data-segment]');
            segments.forEach(segment => {
                const capacity = segment.querySelector('.capacity-input');
                const kondisi = segment.querySelector('[name$="[kondisi_jalan]"]');
                if (capacity) {
                    hitungKepadatan(capacity);
                }
                if (kondisi) {
                    toggleKondisi(kondisi);
                }
            });
            cekSegmentKosong();
        });
    </script>
</body>
</html>