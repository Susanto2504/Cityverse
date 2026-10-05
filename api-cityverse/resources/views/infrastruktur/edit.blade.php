<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Infrastruktur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Edit Data Infrastruktur
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Perbarui informasi data infrastruktur.
                    </p>
                </div>

                <a
                    href="{{ url('/infrastruktur') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    ← Kembali
                </a>
            </div>

            <!-- Validation Error -->
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex gap-3">
                        <div class="text-red-500">
                            ⚠
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-red-800">
                                Terdapat kesalahan pada input
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

            <!-- Form -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-200 px-6 py-5">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Infrastruktur
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Silakan ubah data yang diperlukan.
                    </p>
                </div>

                <form
                    action="{{ url('/infrastruktur/' . $infrastruktur->id) }}"
                    method="POST"
                    class="p-6"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        <!-- Kode -->
                        <div>
                            <label
                                for="kode"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Kode
                            </label>

                            <input
                                type="text"
                                id="kode"
                                name="kode"
                                value="{{ old('kode', $infrastruktur->kode) }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan kode"
                            >
                        </div>

                        <!-- Jenis -->
                        <div>
                            <label
                                for="jenis"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Jenis <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="jenis"
                                name="jenis"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                                <option value="">Pilih jenis</option>
                                <option value="Jembatan" @selected(old('jenis', $infrastruktur->jenis) === 'Jembatan')>
                                    Jembatan
                                </option>
                                <option value="Drainase" @selected(old('jenis', $infrastruktur->jenis) === 'Drainase')>
                                    Drainase
                                </option>
                                <option value="Pengelolaan Kota" @selected(old('jenis', $infrastruktur->jenis) === 'Pengelolaan Kota')>
                                    Pengelolaan Kota
                                </option>
                                <option value="Rumah" @selected(old('jenis', $infrastruktur->jenis) === 'Rumah')>
                                    Rumah
                                </option>
                            </select>
                        </div>

                        <!-- Nama -->
                        <div class="md:col-span-2">
                            <label
                                for="nama"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nama <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                value="{{ old('nama', $infrastruktur->nama) }}"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan nama infrastruktur"
                            >
                        </div>

                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label
                                for="judul"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Judul
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul', $infrastruktur->judul) }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan judul"
                            >
                        </div>

                        <!-- Lokasi -->
                        <div class="md:col-span-2">
                            <label
                                for="lokasi"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Lokasi <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="lokasi"
                                name="lokasi"
                                value="{{ old('lokasi', $infrastruktur->lokasi) }}"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan lokasi"
                            >
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label
                                for="tahun"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Tahun
                            </label>

                            <input
                                type="number"
                                id="tahun"
                                name="tahun"
                                value="{{ old('tahun', $infrastruktur->tahun) }}"
                                min="1900"
                                max="2100"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Contoh: 2026"
                            >
                        </div>

                        <!-- Nilai -->
                        <div>
                            <label
                                for="nilai"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Nilai
                            </label>

                            <input
                                type="number"
                                step="any"
                                id="nilai"
                                name="nilai"
                                value="{{ old('nilai', $infrastruktur->nilai) }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan nilai"
                            >
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label
                                for="satuan"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Satuan
                            </label>

                            <input
                                type="text"
                                id="satuan"
                                name="satuan"
                                value="{{ old('satuan', $infrastruktur->satuan) }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Contoh: Unit, Meter, Km"
                            >
                        </div>

                        <!-- Kondisi -->
                        <div>
                            <label
                                for="kondisi"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Kondisi
                            </label>

                            <select
                                id="kondisi"
                                name="kondisi"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                                <option value="">Pilih kondisi</option>
                                <option value="Baik" @selected(old('kondisi', $infrastruktur->kondisi) === 'Baik')>
                                    Baik
                                </option>
                                <option value="Perlu Pemeliharaan" @selected(old('kondisi', $infrastruktur->kondisi) === 'Perlu Pemeliharaan')>
                                    Perlu Pemeliharaan
                                </option>
                                <option value="Rusak" @selected(old('kondisi', $infrastruktur->kondisi) === 'Rusak')>
                                    Rusak
                                </option>
                            </select>
                        </div>

                        <!-- Sumber -->
                        <div>
                            <label
                                for="sumber"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Sumber
                            </label>

                            <input
                                type="text"
                                id="sumber"
                                name="sumber"
                                value="{{ old('sumber', $infrastruktur->sumber) }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan sumber data"
                            >
                        </div>

                    </div>

                    <!-- Info API -->
                    @if ($infrastruktur->api_id)
                        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <div class="flex gap-3">
                                <div class="text-blue-600">
                                    ℹ
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-blue-800">
                                        Data berasal dari API
                                    </p>

                                    <p class="mt-1 text-sm text-blue-700">
                                        Data ini memiliki ID API:
                                        <span class="font-medium">
                                            {{ $infrastruktur->api_id }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-sm text-gray-600">
                                Data ini merupakan data input manual.
                            </p>
                        </div>
                    @endif

                    <!-- Action -->
                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-200 pt-6">

                        <a
                            href="{{ url('/infrastruktur') }}"
                            class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </div>

</body>
</html>