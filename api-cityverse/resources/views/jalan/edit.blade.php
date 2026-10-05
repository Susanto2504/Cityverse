<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Data Jalan</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="m-0 min-h-screen bg-[#f5f7fb] font-sans text-slate-800">
        <div class="mx-auto w-full max-w-[1200px] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            <div class="mb-6">
                <h1 class="m-0 mb-2 text-2xl font-bold text-slate-900 sm:text-[28px]">Edit Data Jalan</h1>
                <p class="m-0 text-sm text-slate-500">Perbarui informasi ruas jalan dan segmen jalan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-[9px] border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 ml-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jalan.update', $jalan->id_jalan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
                    <div class="mb-5 border-b border-slate-200 pb-4">
                        <h2 class="m-0 text-[19px] font-bold text-slate-900">Informasi Jalan</h2>
                        <p class="mt-1 text-[13px] text-slate-500">Perbarui informasi utama mengenai ruas jalan.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2">
                        <div class="flex flex-col md:col-span-2">
                            <label for="nama_ruas_jalan" class="mb-1.5 text-sm font-semibold text-slate-700">
                                Nama Ruas Jalan
                                <span class="text-red-600">*</span>
                            </label>

                            <input type="text" id="nama_ruas_jalan" name="nama_ruas_jalan" value="{{ old('nama_ruas_jalan', $jalan->nama_ruas_jalan) }}" placeholder="Contoh: Jalan A. P. Pettarani" required class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">

                            @error('nama_ruas_jalan')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label for="panjang_m" class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Jalan (meter)</label>

                            <input type="number" id="panjang_m" name="panjang_m" value="{{ old('panjang_m', $jalan->panjang_m) }}" step="0.01" min="0" placeholder="Contoh: 2500" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">

                            @error('panjang_m')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label for="lebar_m" class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Jalan (meter)</label>

                            <input type="number" id="lebar_m" name="lebar_m" value="{{ old('lebar_m', $jalan->lebar_m) }}" step="0.01" min="0" placeholder="Contoh: 7.50" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">

                            @error('lebar_m')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex flex-col md:col-span-2">
                            <label for="tipe_jalan_detail" class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                            @php
                                $tipeJalan = old('tipe_jalan_detail', $jalan->tipe_jalan_detail);
                            @endphp

                            <select id="tipe_jalan_detail" name="tipe_jalan_detail" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                <option value="">-- Pilih Tipe Jalan --</option>
                                <option value="Jalan Arteri" {{ $tipeJalan == 'Jalan Arteri' ? 'selected' : '' }}>Jalan Arteri</option>
                                <option value="Jalan Kolektor" {{ $tipeJalan == 'Jalan Kolektor' ? 'selected' : '' }}>Jalan Kolektor</option>
                                <option value="Jalan Lokal" {{ $tipeJalan == 'Jalan Lokal' ? 'selected' : '' }}>Jalan Lokal</option>
                                <option value="Jalan Tol" {{ $tipeJalan == 'Jalan Tol' ? 'selected' : '' }}>Jalan Tol</option>
                                <option value="Jalan Permukiman" {{ $tipeJalan == 'Jalan Permukiman' ? 'selected' : '' }}>Jalan Permukiman</option>
                                <option value="Jalan Servis" {{ $tipeJalan == 'Jalan Servis' ? 'selected' : '' }}>Jalan Servis</option>
                            </select>

                            @error('tipe_jalan_detail')
                                <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
                    <div class="mb-5 flex flex-col items-start justify-between gap-4 border-b border-slate-200 pb-4 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="m-0 text-[19px] font-bold text-slate-900">Segmen Jalan</h2>
                            <p class="mt-1 text-[13px] text-slate-500">Perbarui atau tambahkan segmen jalan.</p>
                        </div>

                        <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700" onclick="tambahSegmen()">
                            + Tambah Segmen
                        </button>
                    </div>

                    <div id="segments-container">
                        @forelse($jalan->segmenJalans as $index => $segmen)
                            @php
                                $kondisiSegmen = old('segmen.' . $index . '.kondisi_jalan', $segmen->kondisi_jalan);
                                $panjangKondisi = old('segmen.' . $index . '.panjang_kondisi_m', $segmen->panjang_kondisi_m);
                                $keteranganKondisi = old('segmen.' . $index . '.kondisi_lainnya', $segmen->kondisi_lainnya);
                            @endphp

                            <div class="mb-[18px] rounded-xl border border-slate-200 bg-slate-50 p-5" data-segment>
                                <div class="mb-[18px] flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                                    <div class="flex items-center text-base font-bold text-slate-900">
                                        <span class="mr-2 inline-flex h-[30px] w-[30px] items-center justify-center rounded-full bg-blue-600 text-[13px] text-white segment-number">{{ $index + 1 }}</span>
                                        <span>Segmen {{ $index + 1 }}</span>
                                    </div>

                                    <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100" onclick="hapusSegmen(this)">
                                        Hapus
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2 lg:grid-cols-3">
                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">
                                            OSM ID
                                            <span class="text-red-600">*</span>
                                        </label>

                                        <input type="number" name="segmen[{{ $index }}][osm_id]" value="{{ old('segmen.' . $index . '.osm_id', $segmen->osm_id) }}" min="1" required class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Segmen (m)</label>

                                        <input type="number" name="segmen[{{ $index }}][panjang_m]" value="{{ old('segmen.' . $index . '.panjang_m', $segmen->panjang_m) }}" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Segmen (m)</label>

                                        <input type="number" name="segmen[{{ $index }}][lebar_m]" value="{{ old('segmen.' . $index . '.lebar_m', $segmen->lebar_m) }}" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                                        @php
                                            $tipeSegmen = old('segmen.' . $index . '.tipe_jalan_detail', $segmen->tipe_jalan_detail);
                                        @endphp

                                        <select name="segmen[{{ $index }}][tipe_jalan_detail]" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                            <option value="">-- Pilih Tipe Jalan --</option>
                                            <option value="Jalan Arteri" {{ $tipeSegmen == 'Jalan Arteri' ? 'selected' : '' }}>Jalan Arteri</option>
                                            <option value="Jalan Kolektor" {{ $tipeSegmen == 'Jalan Kolektor' ? 'selected' : '' }}>Jalan Kolektor</option>
                                            <option value="Jalan Lokal" {{ $tipeSegmen == 'Jalan Lokal' ? 'selected' : '' }}>Jalan Lokal</option>
                                            <option value="Jalan Tol" {{ $tipeSegmen == 'Jalan Tol' ? 'selected' : '' }}>Jalan Tol</option>
                                            <option value="Jalan Permukiman" {{ $tipeSegmen == 'Jalan Permukiman' ? 'selected' : '' }}>Jalan Permukiman</option>
                                            <option value="Jalan Servis" {{ $tipeSegmen == 'Jalan Servis' ? 'selected' : '' }}>Jalan Servis</option>
                                        </select>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kapasitas Jalan</label>

                                        <input type="number" class="capacity-input w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100" name="segmen[{{ $index }}][kapasitas_jalan]" value="{{ old('segmen.' . $index . '.kapasitas_jalan', $segmen->kapasitas_jalan) }}" min="0" oninput="hitungKepadatan(this)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Volume Kendaraan</label>

                                        <input type="number" class="volume-input w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100" name="segmen[{{ $index }}][volume_kendaraan]" value="{{ old('segmen.' . $index . '.volume_kendaraan', $segmen->volume_kendaraan) }}" min="0" oninput="hitungKepadatan(this)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Kondisi Jalan</label>

                                        <select name="segmen[{{ $index }}][kondisi_jalan]" onchange="toggleKondisi(this)" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                            <option value="Normal" {{ $kondisiSegmen == 'Normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="Longsor" {{ $kondisiSegmen == 'Longsor' ? 'selected' : '' }}>Longsor</option>
                                            <option value="Banjir" {{ $kondisiSegmen == 'Banjir' ? 'selected' : '' }}>Banjir</option>
                                            <option value="Lainnya" {{ $kondisiSegmen == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="hidden flex-col" data-panjang-kondisi>
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Kondisi (m)</label>

                                        <input type="number" name="segmen[{{ $index }}][panjang_kondisi_m]" value="{{ $panjangKondisi }}" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="hidden flex-col" data-kondisi-lainnya>
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Keterangan Kondisi</label>

                                        <input type="text" name="segmen[{{ $index }}][kondisi_lainnya]" value="{{ $keteranganKondisi }}" placeholder="Masukkan keterangan kondisi" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                    </div>

                                    <div class="flex flex-col md:col-span-2 lg:col-span-3">
                                        <label class="mb-1.5 text-sm font-semibold text-slate-700">Koordinat Geometri</label>

                                        <textarea name="segmen[{{ $index }}][koordinat_geometri]" placeholder="Contoh: [[119.412, -5.135], [119.413, -5.136]]" class="min-h-[100px] w-full resize-y rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">{{ old('segmen.' . $index . '.koordinat_geometri', is_array($segmen->koordinat_geometri) ? json_encode($segmen->koordinat_geometri) : $segmen->koordinat_geometri) }}</textarea>

                                        <div class="mt-1 text-xs text-slate-500">Format JSON.</div>
                                    </div>
                                </div>

                                <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[13px] font-semibold text-slate-500">Tingkat Kepadatan</span>
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500" data-density>{{ $segmen->tingkat_kepadatan ?? 'Belum dihitung' }}</span>
                                    </div>

                                    <div class="mt-2.5 text-xs text-slate-500" data-density-info>Tingkat kepadatan dihitung otomatis berdasarkan volume dan kapasitas.</div>
                                </div>
                            </div>
                        @empty
                            <div id="empty-segment" class="mb-[18px] rounded-[10px] border-2 border-dashed border-slate-300 px-5 py-[35px] text-center text-slate-500">
                                Belum ada segmen. Klik <strong>Tambah Segmen</strong>.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-6 flex flex-col-reverse justify-end gap-2.5 sm:flex-row">
                    <a href="{{ route('jalan.index') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-300">
                        Batal
                    </a>

                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <script>
            let segmentIndex = document.querySelectorAll('[data-segment]').length;

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

            function kondisiJalanOptions() {
                return `
                    <option value="Normal">Normal</option>
                    <option value="Longsor">Longsor</option>
                    <option value="Banjir">Banjir</option>
                    <option value="Lainnya">Lainnya</option>
                `;
            }

            function tambahSegmen() {
                const container = document.getElementById('segments-container');
                const index = segmentIndex;
                const segment = document.createElement('div');

                segment.className = 'mb-[18px] rounded-xl border border-slate-200 bg-slate-50 p-5';
                segment.setAttribute('data-segment', '');

                segment.innerHTML = `
                    <div class="mb-[18px] flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                        <div class="flex items-center text-base font-bold text-slate-900">
                            <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">${index + 1}</span>
                            <span>Segmen ${index + 1}</span>
                        </div>

                        <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100" onclick="hapusSegmen(this)">
                            Hapus
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-[18px] md:grid-cols-2 lg:grid-cols-3">
                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">
                                OSM ID
                                <span class="text-red-600">*</span>
                            </label>

                            <input type="number" name="segmen[${index}][osm_id]" min="1" placeholder="Contoh: 123456789" required class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Segmen (m)</label>

                            <input type="number" name="segmen[${index}][panjang_m]" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Lebar Segmen (m)</label>

                            <input type="number" name="segmen[${index}][lebar_m]" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Tipe Jalan</label>

                            <select name="segmen[${index}][tipe_jalan_detail]" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                ${tipeJalanOptions()}
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Kapasitas Jalan</label>

                            <input type="number" class="capacity-input w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100" name="segmen[${index}][kapasitas_jalan]" min="0" oninput="hitungKepadatan(this)">
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Volume Kendaraan</label>

                            <input type="number" class="volume-input w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100" name="segmen[${index}][volume_kendaraan]" min="0" oninput="hitungKepadatan(this)">
                        </div>

                        <div class="flex flex-col">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Kondisi Jalan</label>

                            <select name="segmen[${index}][kondisi_jalan]" onchange="toggleKondisi(this)" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                                ${kondisiJalanOptions()}
                            </select>
                        </div>

                        <div class="hidden flex-col" data-panjang-kondisi>
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Panjang Kondisi (m)</label>

                            <input type="number" name="segmen[${index}][panjang_kondisi_m]" step="0.01" min="0" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div class="hidden flex-col" data-kondisi-lainnya>
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Keterangan Kondisi</label>

                            <input type="text" name="segmen[${index}][kondisi_lainnya]" placeholder="Masukkan keterangan kondisi" class="w-full rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div class="flex flex-col md:col-span-2 lg:col-span-3">
                            <label class="mb-1.5 text-sm font-semibold text-slate-700">Koordinat Geometri</label>

                            <textarea name="segmen[${index}][koordinat_geometri]" placeholder="Contoh: [[119.412, -5.135], [119.413, -5.136]]" class="min-h-[100px] w-full resize-y rounded-lg border border-slate-300 bg-white px-[13px] py-[11px] text-sm text-slate-900 outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100"></textarea>

                            <div class="mt-1 text-xs text-slate-500">Format JSON.</div>
                        </div>
                    </div>

                    <div class="mt-[18px] rounded-[10px] border border-slate-200 bg-white p-[15px]">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[13px] font-semibold text-slate-500">Tingkat Kepadatan</span>
                            <span class="density-status inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500" data-density>Belum dihitung</span>
                        </div>

                        <div class="mt-2.5 text-xs text-slate-500" data-density-info>Masukkan kapasitas dan volume kendaraan untuk menghitung kepadatan.</div>
                    </div>
                `;

                container.appendChild(segment);
                segmentIndex++;

                updateSegmentNumbers();
                cekSegmentKosong();

                const kondisi = segment.querySelector('[name$="[kondisi_jalan]"]');

                if (kondisi) {
                    toggleKondisi(kondisi);
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
                            <span class="segment-number mr-2 inline-flex h-[30px] w-[30px] items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">${index + 1}</span>
                            <span>Segmen ${index + 1}</span>
                        `;
                    }
                });
            }

            function cekSegmentKosong() {
                const segments = document.querySelectorAll('[data-segment]');
                let empty = document.getElementById('empty-segment');

                if (segments.length === 0) {
                    if (!empty) {
                        empty = document.createElement('div');
                        empty.id = 'empty-segment';
                        empty.className = 'mb-[18px] rounded-[10px] border-2 border-dashed border-slate-300 px-5 py-[35px] text-center text-slate-500';
                        empty.innerHTML = 'Belum ada segmen. Klik <strong>Tambah Segmen</strong>.';
                        document.getElementById('segments-container').appendChild(empty);
                    }

                    empty.classList.remove('hidden');
                } else {
                    if (empty) {
                        empty.classList.add('hidden');
                    }
                }
            }

            function toggleKondisi(select) {
                const segment = select.closest('[data-segment]');

                if (!segment) {
                    return;
                }

                const panjangBox = segment.querySelector('[data-panjang-kondisi]');
                const lainnyaBox = segment.querySelector('[data-kondisi-lainnya]');
                const panjangInput = panjangBox ? panjangBox.querySelector('input') : null;
                const lainnyaInput = lainnyaBox ? lainnyaBox.querySelector('input') : null;

                if (!panjangBox || !lainnyaBox) {
                    return;
                }

                panjangBox.classList.add('hidden');
                panjangBox.classList.remove('flex');

                lainnyaBox.classList.add('hidden');
                lainnyaBox.classList.remove('flex');

                if (select.value === 'Longsor' || select.value === 'Banjir') {
                    panjangBox.classList.remove('hidden');
                    panjangBox.classList.add('flex');

                    if (lainnyaInput) {
                        lainnyaInput.value = '';
                    }
                } else if (select.value === 'Lainnya') {
                    panjangBox.classList.remove('hidden');
                    panjangBox.classList.add('flex');

                    lainnyaBox.classList.remove('hidden');
                    lainnyaBox.classList.add('flex');
                } else {
                    if (panjangInput) {
                        panjangInput.value = '';
                    }

                    if (lainnyaInput) {
                        lainnyaInput.value = '';
                    }
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
                    density.className = 'density-status inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700';
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