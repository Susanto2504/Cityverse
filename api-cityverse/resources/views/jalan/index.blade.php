<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Jalan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen bg-slate-100 text-slate-800">
        <div class="mx-auto max-w-7xl px-6 py-8">
            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Data Jalan</h1>

                <p class="mt-2 text-sm text-slate-500">Kelola data ruas jalan dan segmen jalan.</p>
            </div>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">{{ session('success') }}</div>
            @endif

            {{-- STATISTIK --}}
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total Ruas Jalan</p>
                    <h2 class="mt-2 text-3xl font-bold">{{ $jalan->total() }}</h2>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Data Per Halaman</p>
                    <h2 class="mt-2 text-3xl font-bold">{{ $jalan->count() }}</h2>
                </div>

                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Halaman</p>

                    <h2 class="mt-2 text-3xl font-bold">{{ $jalan->currentPage() }}<span class="text-base text-slate-400"> / {{ $jalan->lastPage() }}</span></h2>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                {{-- TOOLBAR --}}
                <div class="border-b border-slate-200 p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Daftar Ruas Jalan</h2>
                            <p class="mt-1 text-sm text-slate-500">Data jalan yang tersimpan di database.</p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            {{-- SEARCH --}}
                            <form action="{{ route('jalan.index') }}" method="GET" class="flex gap-2">
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0z"/>
                                    </svg>

                                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari jalan..." class="w-64 rounded-lg border border-slate-300 py-2.5 pl-10 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                </div>

                                <button type="submit" class="rounded-lg bg-slate-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-slate-900">Cari</button>
                            </form>

                            {{-- TAMBAH --}}
                            <a href="{{ route('jalan.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Jalan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1050px] text-left">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama Jalan</th>
                                <th class="px-6 py-4">Panjang</th>
                                <th class="px-6 py-4">Lebar</th>
                                <th class="px-6 py-4">Tipe Jalan</th>
                                <th class="px-6 py-4 text-center">Segmen</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($jalan as $index => $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ $jalan->firstItem() + $index }}</td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900">{{ $item->nama_ruas_jalan }}</div>

                                        <div class="mt-1 text-xs text-slate-400">ID: {{ $item->id_jalan }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        @if($item->panjang_m !== null)
                                            {{ number_format($item->panjang_m, 2, ',', '.') }} m
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        @if($item->lebar_m !== null)
                                            {{ number_format($item->lebar_m, 2, ',', '.') }} m
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($item->tipe_jalan_detail)
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">{{ $item->tipe_jalan_detail }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-lg bg-slate-100 px-3 py-1 text-sm font-semibold">{{ $item->segmenJalans->count() }}</span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            {{-- LIHAT --}}
                                            <a href="{{ route('jalan.show', $item->id_jalan) }}" title="Lihat" class="rounded-lg bg-slate-100 p-2 text-slate-600 hover:bg-slate-200">👁️</a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('jalan.edit', $item->id_jalan) }}" title="Edit" class="rounded-lg bg-blue-50 p-2 text-blue-600 hover:bg-blue-100">✏️</a>

                                            {{-- HAPUS --}}
                                            <form action="{{ route('jalan.destroy', $item->id_jalan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jalan ini? Semua segmennya juga akan dihapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus" class="rounded-lg bg-red-50 p-2 text-red-600 hover:bg-red-100">🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="text-4xl">🛣️</div>

                                        <h3 class="mt-4 font-semibold">Data jalan tidak ditemukan</h3>
                                        <p class="mt-1 text-sm text-slate-500">Tidak ada data yang sesuai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($jalan->hasPages())
                    <div class="border-t border-slate-200 px-6 py-5">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-slate-500"> Menampilkan <strong> {{ $jalan->firstItem() }} </strong> sampai <strong>{{ $jalan->lastItem() }}</strong> dari <strong>{{ $jalan->total() }}</strong> data</p>
                            <div>{{ $jalan->onEachSide(1)->links() }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>