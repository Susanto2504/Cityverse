<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Data Lingkungan</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

    <div class="min-h-screen p-6">

        {{-- HEADER --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Detail Data Lingkungan
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Informasi lengkap data lingkungan
                </p>
            </div>

            <a
                href="{{ route('lingkungan.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
            >
                ← Kembali
            </a>

        </div>


        {{-- DATA UTAMA --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-base font-semibold text-gray-800">
                    Informasi Data
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Detail informasi lingkungan yang tersimpan di database.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-6 md:grid-cols-2">

                {{-- ID --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        ID
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->id }}
                    </p>
                </div>


                {{-- SUMBER API --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Sumber API ID
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->sumber_api_id ?? '-' }}
                    </p>
                </div>


                {{-- WILAYAH --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Wilayah
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->wilayah ?? '-' }}
                    </p>
                </div>


                {{-- KODE WILAYAH --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Kode Wilayah
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->kode_wilayah ?? '-' }}
                    </p>
                </div>


                {{-- PARAMETER --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Parameter
                    </p>

                    <div>

                        @php
                            $parameterClass = match($data->parameter) {
                                'IKU' => 'bg-blue-50 text-blue-700',
                                'IKA' => 'bg-cyan-50 text-cyan-700',
                                'Persampahan' => 'bg-green-50 text-green-700',
                                'Risiko Banjir' => 'bg-red-50 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $parameterClass }}">
                            {{ $data->parameter ?? '-' }}
                        </span>

                    </div>
                </div>


                {{-- INDIKATOR --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Indikator
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->indikator ?? '-' }}
                    </p>
                </div>


                {{-- NILAI --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Nilai
                    </p>

                    <p class="text-xl font-bold text-gray-800">
                        {{ $data->nilai !== null ? $data->nilai : '-' }}
                    </p>
                </div>


                {{-- SATUAN --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Satuan
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->satuan ?? '-' }}
                    </p>
                </div>


                {{-- TAHUN --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Tahun
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->tahun ?? '-' }}
                    </p>
                </div>


                {{-- LATITUDE --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Latitude
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->latitude ?? '-' }}
                    </p>
                </div>


                {{-- LONGITUDE --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Longitude
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->longitude ?? '-' }}
                    </p>
                </div>


                {{-- DIAMBIL PADA --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Diambil Pada
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->diambil_pada ? $data->diambil_pada->format('d F Y H:i:s') : '-' }}
                    </p>
                </div>


                {{-- CREATED AT --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Dibuat Pada
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->created_at ? $data->created_at->format('d F Y H:i:s') : '-' }}
                    </p>
                </div>


                {{-- UPDATED AT --}}
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Diperbarui Pada
                    </p>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $data->updated_at ? $data->updated_at->format('d F Y H:i:s') : '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- KOORDINAT --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-base font-semibold text-gray-800">
                    Koordinat
                </h2>

            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                <div class="rounded-lg bg-gray-50 p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Latitude
                    </p>

                    <p class="mt-2 text-lg font-semibold text-gray-800">
                        {{ $data->latitude ?? '-' }}
                    </p>

                </div>

                <div class="rounded-lg bg-gray-50 p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Longitude
                    </p>

                    <p class="mt-2 text-lg font-semibold text-gray-800">
                        {{ $data->longitude ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- DATA ASLI --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="text-base font-semibold text-gray-800">
                    Data Asli
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Data asli yang tersimpan dari sumber API.
                </p>

            </div>

            <div class="p-6">

                @if($data->data_asli)

                    <pre class="max-h-[500px] overflow-auto rounded-lg bg-gray-900 p-5 text-sm leading-6 text-gray-100">{{ json_encode($data->data_asli, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>

                @else

                    <div class="rounded-lg bg-gray-50 px-4 py-8 text-center">

                        <p class="text-sm text-gray-500">
                            Tidak ada data asli yang tersimpan.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</body>
</html>