<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tambah Infrastruktur - CityVerse</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    {{-- HEADER --}}
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900">
                    Tambah Data Infrastruktur
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Tambahkan data infrastruktur baru ke dalam sistem.
                </p>
            </div>

            <a href="{{ url('/infrastruktur') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>

                Kembali
            </a>
        </div>
    </header>


    {{-- CONTENT --}}
    <main class="mx-auto max-w-5xl px-6 py-8">

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.48 0z"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-semibold text-red-800">
                            Data belum dapat disimpan
                        </h3>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        {{-- FORM --}}
        <form action="{{ url('/infrastruktur') }}" method="POST">

            @csrf

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                {{-- FORM HEADER --}}
                <div class="border-b border-gray-200 px-6 py-5">
                    <h2 class="text-base font-semibold text-gray-900">
                        Informasi Infrastruktur
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Isi informasi utama mengenai infrastruktur yang ingin ditambahkan.
                    </p>
                </div>


                {{-- FORM BODY --}}
                <div class="space-y-8 p-6">

                    {{-- INFORMASI UTAMA --}}
                    <section>
                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-gray-900">
                                Informasi Utama
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Informasi dasar mengenai jenis dan identitas infrastruktur.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- JENIS --}}
                            <div>
                                <label for="jenis" class="mb-2 block text-sm font-medium text-gray-700">
                                    Jenis Infrastruktur
                                    <span class="text-red-500">*</span>
                                </label>

                                <select id="jenis" name="jenis" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                    <option value="">Pilih Jenis Infrastruktur</option>

                                    <option value="Jembatan" {{ old('jenis') == 'Jembatan' ? 'selected' : '' }}>
                                        Jembatan
                                    </option>

                                    <option value="Drainase" {{ old('jenis') == 'Drainase' ? 'selected' : '' }}>
                                        Drainase
                                    </option>

                                    <option value="Pengelolaan Kota" {{ old('jenis') == 'Pengelolaan Kota' ? 'selected' : '' }}>
                                        Pengelolaan Kota
                                    </option>

                                    <option value="Rumah" {{ old('jenis') == 'Rumah' ? 'selected' : '' }}>
                                        Rumah
                                    </option>

                                    <option value="Lainnya" {{ old('jenis') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                            </div>


                            {{-- KODE --}}
                            <div>
                                <label for="kode" class="mb-2 block text-sm font-medium text-gray-700">
                                    Kode Referensi
                                </label>

                                <input type="text" id="kode" name="kode" value="{{ old('kode') }}" placeholder="Contoh: JMB-001" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">

                                <p class="mt-1.5 text-xs text-gray-400">
                                    Kode dapat digunakan sebagai identitas tambahan.
                                </p>
                            </div>


                            {{-- NAMA --}}
                            <div class="md:col-span-2">
                                <label for="nama" class="mb-2 block text-sm font-medium text-gray-700">
                                    Nama Infrastruktur
                                    <span class="text-red-500">*</span>
                                </label>

                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama infrastruktur" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>


                            {{-- JUDUL --}}
                            <div class="md:col-span-2">
                                <label for="judul" class="mb-2 block text-sm font-medium text-gray-700">
                                    Judul Data
                                </label>

                                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul atau keterangan data" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>

                        </div>
                    </section>


                    {{-- LOKASI --}}
                    <section class="border-t border-gray-100 pt-8">

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-gray-900">
                                Lokasi Infrastruktur
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Masukkan lokasi atau wilayah tempat infrastruktur berada.
                            </p>
                        </div>

                        <div>
                            <label for="lokasi" class="mb-2 block text-sm font-medium text-gray-700">
                                Lokasi
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea id="lokasi" name="lokasi" rows="3" required placeholder="Contoh: Kecamatan Panakkukang, Kota Makassar" class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">{{ old('lokasi') }}</textarea>
                        </div>

                    </section>


                    {{-- NILAI DATA --}}
                    <section class="border-t border-gray-100 pt-8">

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-gray-900">
                                Nilai Infrastruktur
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Masukkan nilai, satuan, dan tahun data infrastruktur.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                            {{-- NILAI --}}
                            <div>
                                <label for="nilai" class="mb-2 block text-sm font-medium text-gray-700">
                                    Nilai
                                </label>

                                <input type="number" id="nilai" name="nilai" value="{{ old('nilai') }}" step="any" min="0" placeholder="Contoh: 1250" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>


                            {{-- SATUAN --}}
                            <div>
                                <label for="satuan" class="mb-2 block text-sm font-medium text-gray-700">
                                    Satuan
                                </label>

                                <input type="text" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: meter, unit" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>


                            {{-- TAHUN --}}
                            <div>
                                <label for="tahun" class="mb-2 block text-sm font-medium text-gray-700">
                                    Tahun
                                </label>

                                <input type="number" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" min="1900" max="2100" placeholder="Contoh: 2026" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>

                        </div>

                    </section>


                    {{-- KONDISI --}}
                    <section class="border-t border-gray-100 pt-8">

                        <div class="mb-5">
                            <h3 class="text-sm font-semibold text-gray-900">
                                Kondisi Infrastruktur
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Tentukan kondisi terkini dari infrastruktur.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- KONDISI --}}
                            <div>
                                <label for="kondisi" class="mb-2 block text-sm font-medium text-gray-700">
                                    Kondisi
                                </label>

                                <select id="kondisi" name="kondisi" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                                    <option value="">Pilih Kondisi</option>

                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>
                                        Baik
                                    </option>

                                    <option value="Perlu Pemeliharaan" {{ old('kondisi') == 'Perlu Pemeliharaan' ? 'selected' : '' }}>
                                        Perlu Pemeliharaan
                                    </option>

                                    <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>
                                        Rusak
                                    </option>
                                </select>
                            </div>


                            {{-- SUMBER --}}
                            <div>
                                <label for="sumber" class="mb-2 block text-sm font-medium text-gray-700">
                                    Sumber Data
                                </label>

                                <input type="text" id="sumber" name="sumber" value="{{ old('sumber', 'Input Manual') }}" placeholder="Contoh: Input Manual" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            </div>

                        </div>

                    </section>

                </div>


                {{-- FORM FOOTER --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-6 py-5 sm:flex-row sm:justify-end">

                    <a href="{{ url('/infrastruktur') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Batal
                    </a>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>

                        Simpan Data
                    </button>

                </div>

            </div>

        </form>

    </main>

</body>
</html>