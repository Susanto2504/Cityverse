<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Infrastruktur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="min-h-screen px-4 py-8 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-5xl">

            <!-- Header -->
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Detail Infrastruktur
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Informasi lengkap data infrastruktur.
                    </p>
                </div>

                <div class="flex items-center gap-2">

                    <a
                        href="{{ url('/infrastruktur') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        ← Kembali
                    </a>

                    <a
                        href="{{ url('/infrastruktur/' . $infrastruktur->id . '/edit') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                    >
                        Edit Data
                    </a>

                </div>

            </div>

            <!-- Main Card -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <!-- Title -->
                <div class="border-b border-gray-200 px-6 py-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                {{ $infrastruktur->jenis ?: 'Infrastruktur' }}
                            </p>

                            <h2 class="mt-1 text-xl font-bold text-gray-900">
                                {{ $infrastruktur->nama }}
                            </h2>

                            @if ($infrastruktur->judul)
                                <p class="mt-2 text-sm text-gray-500">
                                    {{ $infrastruktur->judul }}
                                </p>
                            @endif
                        </div>

                        <!-- Kondisi -->
                        <div>
                            @if ($infrastruktur->kondisi === 'Baik')

                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700">
                                    Baik
                                </span>

                            @elseif ($infrastruktur->kondisi === 'Perlu Pemeliharaan')

                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-semibold text-yellow-700">
                                    Perlu Pemeliharaan
                                </span>

                            @elseif ($infrastruktur->kondisi === 'Rusak')

                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700">
                                    Rusak
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600">
                                    Tidak Diketahui
                                </span>

                            @endif
                        </div>

                    </div>

                </div>

                <!-- Informasi -->
                <div class="px-6 py-6">

                    <h3 class="mb-5 text-lg font-semibold text-gray-900">
                        Informasi Data
                    </h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        <!-- Kode -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Kode
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->kode ?: '-' }}
                            </p>
                        </div>

                        <!-- Jenis -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Jenis
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->jenis ?: '-' }}
                            </p>
                        </div>

                        <!-- Nama -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Nama Infrastruktur
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->nama ?: '-' }}
                            </p>
                        </div>

                        <!-- Judul -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Judul
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->judul ?: '-' }}
                            </p>
                        </div>

                        <!-- Lokasi -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Lokasi
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->lokasi ?: '-' }}
                            </p>
                        </div>

                        <!-- Tahun -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Tahun
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->tahun ?: '-' }}
                            </p>
                        </div>

                        <!-- Nilai -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Nilai
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                @if ($infrastruktur->nilai !== null)
                                    {{ $infrastruktur->nilai }}
                                    {{ $infrastruktur->satuan ? ' ' . $infrastruktur->satuan : '' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        <!-- Satuan -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Satuan
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->satuan ?: '-' }}
                            </p>
                        </div>

                        <!-- Kondisi -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Kondisi
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->kondisi ?: '-' }}
                            </p>
                        </div>

                        <!-- Sumber -->
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Sumber Data
                            </p>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $infrastruktur->sumber ?: '-' }}
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Status Sumber Data -->
                <div class="border-t border-gray-200 px-6 py-6">

                    <h3 class="mb-4 text-lg font-semibold text-gray-900">
                        Informasi Sumber Data
                    </h3>

                    @if ($infrastruktur->api_id)

                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">

                            <div class="flex gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                    ℹ
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-blue-800">
                                        Data dari Satu Data Makassar
                                    </p>

                                    <p class="mt-1 text-sm text-blue-700">
                                        Data ini berasal dari proses sinkronisasi API.
                                    </p>

                                    <div class="mt-3">
                                        <p class="text-xs font-medium uppercase tracking-wide text-blue-600">
                                            API ID
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-blue-900">
                                            {{ $infrastruktur->api_id }}
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                    @else

                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">

                            <div class="flex gap-3">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-200 text-gray-600">
                                    ℹ
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        Data Input Manual
                                    </p>

                                    <p class="mt-1 text-sm text-gray-600">
                                        Data ini ditambahkan secara manual melalui halaman administrasi.
                                    </p>
                                </div>

                            </div>

                        </div>

                    @endif

                </div>

                <!-- Timestamp -->
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-5">

                    <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Dibuat
                            </p>

                            <p class="mt-1 font-medium text-gray-700">
                                {{ $infrastruktur->created_at ? $infrastruktur->created_at->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Terakhir Diperbarui
                            </p>

                            <p class="mt-1 font-medium text-gray-700">
                                {{ $infrastruktur->updated_at ? $infrastruktur->updated_at->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Bottom Action -->
            <div class="mt-6 flex justify-end gap-3">

                <a
                    href="{{ url('/infrastruktur') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Kembali
                </a>

                <a
                    href="{{ url('/infrastruktur/' . $infrastruktur->id . '/edit') }}"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Edit Data
                </a>

            </div>

        </div>

    </div>

</body>
</html>