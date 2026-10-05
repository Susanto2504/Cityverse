<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Lingkungan</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

    <div class="min-h-screen p-6">

        {{-- HEADER --}}
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Data Lingkungan
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola data lingkungan Kota Makassar
                </p>
            </div>

            {{-- TOMBOL TAMBAH --}}
            <a
                href="#"
                class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                + Tambah Data
            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR MESSAGE --}}
        @if(session('error'))

            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>

        @endif


        {{-- VALIDATION ERROR --}}
        @if($errors->any())

            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                <ul class="list-inside list-disc text-sm text-red-700">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FILTER --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <form
                action="{{ route('lingkungan.index') }}"
                method="GET"
                class="grid grid-cols-1 gap-4 md:grid-cols-4"
            >

                {{-- WILAYAH --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Wilayah
                    </label>

                    <input
                        type="text"
                        name="wilayah"
                        value="{{ request('wilayah') }}"
                        placeholder="Cari wilayah..."
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- PARAMETER --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Parameter
                    </label>

                    <select
                        name="parameter"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Semua Parameter
                        </option>

                        <option
                            value="IKU"
                            {{ request('parameter') == 'IKU' ? 'selected' : '' }}
                        >
                            IKU
                        </option>

                        <option
                            value="IKA"
                            {{ request('parameter') == 'IKA' ? 'selected' : '' }}
                        >
                            IKA
                        </option>

                        <option
                            value="Persampahan"
                            {{ request('parameter') == 'Persampahan' ? 'selected' : '' }}
                        >
                            Persampahan
                        </option>

                        <option
                            value="Risiko Banjir"
                            {{ request('parameter') == 'Risiko Banjir' ? 'selected' : '' }}
                        >
                            Risiko Banjir
                        </option>

                    </select>

                </div>


                {{-- TAHUN --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Tahun
                    </label>

                    <input
                        type="number"
                        name="tahun"
                        value="{{ request('tahun') }}"
                        placeholder="Contoh: 2024"
                        min="1900"
                        max="2100"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- BUTTON FILTER --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-900"
                    >
                        Filter
                    </button>

                    <a
                        href="{{ route('lingkungan.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- TABLE CONTAINER --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            {{-- TABLE HEADER --}}
            <div class="flex flex-col gap-2 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-base font-semibold text-gray-800">
                        Daftar Data Lingkungan
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Total {{ $data->total() }} data
                    </p>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                No
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Wilayah
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Parameter
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Indikator
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Nilai
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Satuan
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Tahun
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200 bg-white">

                        @forelse($data as $item)

                            <tr class="transition hover:bg-gray-50">

                                {{-- NO --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>


                                {{-- WILAYAH --}}
                                <td class="px-5 py-4">

                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $item->wilayah ?? '-' }}
                                    </div>

                                    @if($item->kode_wilayah)

                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $item->kode_wilayah }}
                                        </div>

                                    @endif

                                </td>


                                {{-- PARAMETER --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    @php
                                        $parameterClass = match($item->parameter) {
                                            'IKU' => 'bg-blue-50 text-blue-700',
                                            'IKA' => 'bg-cyan-50 text-cyan-700',
                                            'Persampahan' => 'bg-green-50 text-green-700',
                                            'Risiko Banjir' => 'bg-red-50 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $parameterClass }}">
                                        {{ $item->parameter ?? '-' }}
                                    </span>

                                </td>


                                {{-- INDIKATOR --}}
                                <td class="max-w-xs px-5 py-4">

                                    <div class="truncate text-sm text-gray-700">
                                        {{ $item->indikator ?? '-' }}
                                    </div>

                                </td>


                                {{-- NILAI --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $item->nilai !== null ? $item->nilai : '-' }}
                                    </span>

                                </td>


                                {{-- SATUAN --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                    {{ $item->satuan ?? '-' }}
                                </td>


                                {{-- TAHUN --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-600">
                                    {{ $item->tahun ?? '-' }}
                                </td>


                                {{-- AKSI --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- VIEW --}}
                                        <a
                                            href="{{ route('lingkungan.view', $item->id) }}"
                                            class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100"
                                        >
                                            Lihat
                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('lingkungan.edit', $item->id) }}"
                                            class="rounded-lg bg-yellow-50 px-3 py-2 text-xs font-semibold text-yellow-700 transition hover:bg-yellow-100"
                                        >
                                            Edit
                                        </a>
                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="px-5 py-12 text-center"
                                >

                                    <div class="text-sm font-medium text-gray-500">
                                        Belum ada data lingkungan.
                                    </div>

                                    <div class="mt-1 text-xs text-gray-400">
                                        Data lingkungan belum tersedia.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($data->hasPages())

                <div class="border-t border-gray-200 px-5 py-4">

                    {{ $data->links() }}

                </div>

            @endif

        </div>

    </div>

</body>
</html>
