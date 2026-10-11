<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Lingkungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

    <div class="mx-auto max-w-5xl px-6 py-8">

        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Edit Data Lingkungan
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Perbarui informasi data lingkungan
                    </p>
                </div>

                <a
                    href="{{ route('lingkungan.view', $data->id) }}"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Kembali
                </a>
            </div>
        </div>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <div class="mb-2 font-semibold text-red-700">
                    Terdapat kesalahan:
                </div>

                <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form
            action="{{ route('lingkungan.update', $data->id) }}"
            method="POST"
            class="rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            @csrf
            @method('PUT')

            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Informasi Data
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                <!-- Sumber API -->
                <div>
                    <label
                        for="sumber_api_id"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Sumber API ID
                    </label>

                    <input
                        type="number"
                        id="sumber_api_id"
                        name="sumber_api_id"
                        value="{{ old('sumber_api_id', $data->sumber_api_id) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Wilayah -->
                <div>
                    <label
                        for="wilayah"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Wilayah
                    </label>

                    <input
                        type="text"
                        id="wilayah"
                        name="wilayah"
                        value="{{ old('wilayah', $data->wilayah) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Kode Wilayah -->
                <div>
                    <label
                        for="kode_wilayah"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Kode Wilayah
                    </label>

                    <input
                        type="text"
                        id="kode_wilayah"
                        name="kode_wilayah"
                        value="{{ old('kode_wilayah', $data->kode_wilayah) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Parameter -->
                <div>
                    <label
                        for="parameter"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Parameter
                    </label>

                    <input
                        type="text"
                        id="parameter"
                        name="parameter"
                        value="{{ old('parameter', $data->parameter) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Indikator -->
                <div>
                    <label
                        for="indikator"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Indikator
                    </label>

                    <input
                        type="text"
                        id="indikator"
                        name="indikator"
                        value="{{ old('indikator', $data->indikator) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
                        value="{{ old('nilai', $data->nilai) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
                        value="{{ old('satuan', $data->satuan) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
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
                        value="{{ old('tahun', $data->tahun) }}"
                        min="1900"
                        max="2100"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Latitude -->
                <div>
                    <label
                        for="latitude"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Latitude
                    </label>

                    <input
                        type="number"
                        step="any"
                        id="latitude"
                        name="latitude"
                        value="{{ old('latitude', $data->latitude) }}"
                        min="-90"
                        max="90"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Longitude -->
                <div>
                    <label
                        for="longitude"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Longitude
                    </label>

                    <input
                        type="number"
                        step="any"
                        id="longitude"
                        name="longitude"
                        value="{{ old('longitude', $data->longitude) }}"
                        min="-180"
                        max="180"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Diambil Pada -->
                <div class="md:col-span-2">
                    <label
                        for="diambil_pada"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Diambil Pada
                    </label>

                    <input
                        type="datetime-local"
                        id="diambil_pada"
                        name="diambil_pada"
                        value="{{ old('diambil_pada', $data->diambil_pada ? $data->diambil_pada->format('Y-m-d\TH:i') : '') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <!-- Data Asli -->
                <div class="md:col-span-2">
                    <label
                        for="data_asli"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Data Asli
                    </label>

                    <textarea
                        id="data_asli"
                        name="data_asli"
                        rows="10"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 font-mono text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >{{ old('data_asli', $data->data_asli ? json_encode($data->data_asli, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '') }}</textarea>

                    <p class="mt-1 text-xs text-gray-500">
                        Isi dengan format JSON yang valid.
                    </p>
                </div>

            </div>

            <!-- Footer Form -->
            <div class="flex items-center justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">

                <a
                    href="{{ route('lingkungan.view', $data->id) }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</body>
</html>