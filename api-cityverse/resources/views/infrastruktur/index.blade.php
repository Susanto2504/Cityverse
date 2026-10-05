<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Data Infrastruktur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">
    @php
        $semuaData = \App\Models\Infrastruktur::orderBy('jenis')
            ->orderBy('nama')
            ->get();
    @endphp

    <div class="min-h-screen p-6">
        {{-- HEADER --}}
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Infrastruktur</h1>

                <p class="mt-1 text-sm text-gray-500">Data infrastruktur Kota Makassar dari Satu Data Makassar.</p>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {{-- TOTAL INFRASTRUKTUR --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Infrastruktur</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $semuaData->count() }}</p>
                    </div>

                    <div class="rounded-lg bg-blue-100 p-3 text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 10h.01M15 10h.01"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- JEMBATAN --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jembatan</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $semuaData->where('jenis', 'Jembatan')->count() }}</p>
                    </div>
                    <div class="rounded-lg bg-green-100 p-3 text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19h16M5 17l4-8 4 5 3-6 3 9"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- DRAINASE --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Drainase</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $semuaData->where('jenis', 'Drainase')->count() }}</p>
                    </div>

                    <div class="rounded-lg bg-cyan-100 p-3 text-cyan-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- PERLU PERHATIAN --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Perlu Perhatian</p>

                        <p class="mt-2 text-3xl font-bold text-red-600">{{ $semuaData->whereIn('kondisi', ['Rusak', 'Perlu Pemeliharaan'])->count() }}</p>
                    </div>

                    <div class="rounded-lg bg-red-100 p-3 text-red-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.48 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ url('/infrastruktur') }}">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="filterJenis" class="mb-2 block text-sm font-medium text-gray-700">Jenis Infrastruktur</label>

                        <select id="filterJenis" name="jenis" onchange="this.form.submit()" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            <option value="">Semua Jenis</option>

                            @php
                                $jenisList = \App\Models\Infrastruktur::whereNotNull('jenis')
                                    ->where('jenis', '!=', '')
                                    ->select('jenis')
                                    ->distinct()
                                    ->orderBy('jenis')
                                    ->pluck('jenis');
                            @endphp

                            @foreach ($jenisList as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filterKondisi" class="mb-2 block text-sm font-medium text-gray-700">Kondisi</label>

                        <select id="filterKondisi" name="kondisi" onchange="this.form.submit()" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Perlu Pemeliharaan" {{ request('kondisi') == 'Perlu Pemeliharaan' ? 'selected' : '' }}>Perlu Pemeliharaan</option>
                            <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterTahun" class="mb-2 block text-sm font-medium text-gray-700">Tahun</label>

                        <select id="filterTahun" name="tahun" onchange="this.form.submit()" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                            <option value="">Semua Tahun</option>

                            @php
                                $tahunList = \App\Models\Infrastruktur::whereNotNull('tahun')
                                    ->where('tahun', '!=', '')
                                    ->select('tahun')
                                    ->distinct()
                                    ->orderByDesc('tahun')
                                    ->pluck('tahun');
                            @endphp

                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            {{-- TABLE HEADER --}}
            <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900">Daftar Infrastruktur</h2>
                    <p class="mt-1 text-xs text-gray-500">Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data</p>
                </div>

                {{-- TAMBAH DATA --}}
                <a href="/infrastruktur/tambah" class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Data
                </a>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4">No</th>
                            <th class="whitespace-nowrap px-5 py-4">Jenis</th>
                            <th class="min-w-[250px] px-5 py-4">Nama</th>
                            <th class="whitespace-nowrap px-5 py-4">Lokasi</th>
                            <th class="whitespace-nowrap px-5 py-4 text-right">Nilai</th>
                            <th class="whitespace-nowrap px-5 py-4">Satuan</th>
                            <th class="whitespace-nowrap px-5 py-4">Kondisi</th>
                            <th class="whitespace-nowrap px-5 py-4">Tahun</th>
                            <th class="whitespace-nowrap px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($data as $index => $item)
                            <tr class="transition hover:bg-gray-50">
                                {{-- NOMOR --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-500">{{ $data->firstItem() + $index }}</td>

                                {{-- JENIS --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">{{ $item->jenis ?? '-' }}</span>
                                </td>

                                {{-- NAMA --}}
                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-900">{{ $item->nama ?? '-' }}</div>

                                    @if ($item->judul)
                                        <div class="mt-1 text-xs text-gray-400">{{ $item->judul }}</div>
                                    @endif
                                </td>

                                {{-- LOKASI --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">{{ $item->lokasi ?? '-' }}</td>

                                {{-- NILAI --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right font-medium text-gray-900">{{ $item->nilai !== null ? number_format($item->nilai, 2, ',', '.') : '-' }}</td>

                                {{-- SATUAN --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-500">{{ $item->satuan ?? '-' }}</td>

                                {{-- KONDISI --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($item->kondisi === 'Baik')
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">Baik</span>
                                    @elseif ($item->kondisi === 'Perlu Pemeliharaan')
                                        <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">Perlu Pemeliharaan</span>
                                    @elseif ($item->kondisi === 'Rusak')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Rusak</span>
                                    @elseif ($item->kondisi)
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $item->kondisi }}</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Tidak diketahui</span>
                                    @endif
                                </td>

                                {{-- TAHUN --}}
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">{{ $item->tahun ?? '-' }}</td>

                                {{-- AKSI --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- LIHAT --}}
                                        <a href="/infrastruktur/{{ $item->id }}" title="Lihat" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 100-6 3 3 0 000 6z"/>
                                            </svg>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="/infrastruktur/{{ $item->id }}/edit" title="Edit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 transition hover:bg-yellow-100">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ url('/infrastruktur/' . $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100"
                                            >
                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                                                    />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="9" class="px-5 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4m4-4h8"/>
                                    </svg>

                                    <p class="mt-3 font-medium text-gray-600">Tidak ada data</p>

                                    <p class="mt-1 text-sm text-gray-400">Belum ada data infrastruktur.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($data->hasPages())
                <div class="border-t border-gray-200 px-5 py-4">{{ $data->links() }}</div>
            @endif
        </div>
    </div>

</body>
</html>