<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Jalan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 min-h-screen bg-[#f5f7fb] font-sans text-slate-800">
    <div class="mx-auto w-full max-w-[1200px] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <div class="mb-6 flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-center">
            <div>
                <h1 class="m-0 mb-2 text-2xl font-bold text-slate-900 sm:text-[28px]">Detail Data Jalan</h1>
                <p class="m-0 text-sm text-slate-500">Informasi lengkap ruas jalan dan segmen jalan.</p>
            </div>

            <div class="flex w-full gap-2.5 sm:w-auto">
                <a href="{{ route('jalan.index') }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-300 sm:flex-none">
                    ← Kembali
                </a>

                <a href="{{ route('jalan.edit', $jalan->id_jalan) }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:flex-none">
                    ✎ Edit
                </a>
            </div>
        </div>

        <div class="mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
            <div class="mb-[22px] border-b border-slate-200 pb-[15px]">
                <h2 class="m-0 text-[19px] font-bold text-slate-900">Informasi Jalan</h2>
                <p class="mt-1 text-[13px] text-slate-500">Informasi utama mengenai ruas jalan.</p>
            </div>

            <div class="grid grid-cols-1 gap-[15px] sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px] sm:col-span-2 lg:col-span-2">
                    <div class="mb-1.5 text-xs text-slate-500">Nama Ruas Jalan</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        {{ $jalan->nama_ruas_jalan ?? '-' }}
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Panjang</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        @if($jalan->panjang_m !== null)
                            {{ number_format($jalan->panjang_m, 2, ',', '.') }} meter
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Lebar</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        @if($jalan->lebar_m !== null)
                            {{ number_format($jalan->lebar_m, 2, ',', '.') }} meter
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Tipe Jalan</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        @if($jalan->tipe_jalan_detail)
                            <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700">
                                {{ $jalan->tipe_jalan_detail }}
                            </span>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Jumlah Segmen</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        {{ $jalan->segmenJalans->count() }} segmen
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">ID Jalan</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        #{{ $jalan->id_jalan }}
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Dibuat</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        {{ $jalan->created_at ? $jalan->created_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>

                <div class="rounded-[10px] border border-slate-200 bg-slate-50 p-[18px]">
                    <div class="mb-1.5 text-xs text-slate-500">Diperbarui</div>
                    <div class="break-words text-base font-bold text-slate-900">
                        {{ $jalan->updated_at ? $jalan->updated_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-[14px] border border-slate-200 bg-white p-5 shadow-[0_4px_15px_rgba(15,23,42,0.06)] sm:p-6">
            <div class="mb-[22px] border-b border-slate-200 pb-[15px]">
                <h2 class="m-0 text-[19px] font-bold text-slate-900">Segmen Jalan</h2>
                <p class="mt-1 text-[13px] text-slate-500">Detail setiap segmen yang terdapat pada ruas jalan ini.</p>
            </div>

            @forelse($jalan->segmenJalans as $index => $segmen)
                @php
                    $densityClass = match($segmen->tingkat_kepadatan) {
                        'Lancar' => 'bg-green-100 text-green-700',
                        'Sedang' => 'bg-orange-100 text-orange-700',
                        'Macet' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-500',
                    };

                    $kondisi = $segmen->kondisi_jalan ?? 'Normal';
                @endphp

                <div class="mb-[18px] overflow-hidden rounded-xl border border-slate-200">
                    <div class="flex flex-col items-start justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-2.5 text-base font-bold text-slate-900">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-[13px] text-white">
                                {{ $index + 1 }}
                            </span>
                            <span>Segmen {{ $index + 1 }}</span>
                        </div>

                        <span class="inline-flex items-center justify-center rounded-full px-3 py-1.5 text-xs font-bold {{ $densityClass }}">
                            {{ $segmen->tingkat_kepadatan ?? 'Belum dihitung' }}
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="grid grid-cols-1 gap-[15px] sm:grid-cols-2 lg:grid-cols-3">
                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">OSM ID</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    {{ $segmen->osm_id ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Panjang Segmen</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->panjang_m !== null)
                                        {{ number_format($segmen->panjang_m, 2, ',', '.') }} meter
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Lebar Segmen</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->lebar_m !== null)
                                        {{ number_format($segmen->lebar_m, 2, ',', '.') }} meter
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Tipe Jalan</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->tipe_jalan_detail)
                                        <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700">
                                            {{ $segmen->tipe_jalan_detail }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Kapasitas Jalan</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->kapasitas_jalan !== null)
                                        {{ number_format($segmen->kapasitas_jalan, 0, ',', '.') }} kendaraan
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Volume Kendaraan</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->volume_kendaraan !== null)
                                        {{ number_format($segmen->volume_kendaraan, 0, ',', '.') }} kendaraan
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Kondisi Jalan</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($kondisi === 'Normal')
                                        <span class="inline-flex items-center justify-center rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700">
                                            Normal
                                        </span>
                                    @elseif($kondisi === 'Longsor')
                                        <span class="inline-flex items-center justify-center rounded-full bg-orange-100 px-3 py-1.5 text-xs font-bold text-orange-700">
                                            Longsor
                                        </span>
                                    @elseif($kondisi === 'Banjir')
                                        <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700">
                                            Banjir
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                            {{ $kondisi }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($kondisi === 'Longsor' || $kondisi === 'Banjir' || $kondisi === 'Lainnya')
                                <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                    <div class="mb-1.5 text-xs text-slate-500">Panjang Kondisi</div>
                                    <div class="text-sm font-semibold text-slate-900">
                                        @if($segmen->panjang_kondisi_m !== null)
                                            {{ number_format($segmen->panjang_kondisi_m, 2, ',', '.') }} meter
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($kondisi === 'Lainnya')
                                <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                    <div class="mb-1.5 text-xs text-slate-500">Keterangan Kondisi</div>
                                    <div class="break-words text-sm font-semibold text-slate-900">
                                        {{ $segmen->kondisi_lainnya ?? '-' }}
                                    </div>
                                </div>
                            @endif

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Rasio Kepadatan</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    @if($segmen->kapasitas_jalan && $segmen->kapasitas_jalan > 0 && $segmen->volume_kendaraan !== null)
                                        {{ number_format(($segmen->volume_kendaraan / $segmen->kapasitas_jalan) * 100, 2, ',', '.') }}%
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5">
                                <div class="mb-1.5 text-xs text-slate-500">Dibuat</div>
                                <div class="text-sm font-semibold text-slate-900">
                                    {{ $segmen->created_at ? $segmen->created_at->format('d M Y H:i') : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-[18px]">
                            <div class="mb-1.5 text-xs text-slate-500">Koordinat Geometri</div>

                            @if($segmen->koordinat_geometri)
                                <div class="overflow-x-auto whitespace-pre-wrap break-words rounded-[9px] bg-slate-900 p-[15px] font-mono text-xs text-slate-200">
                                    @if(is_array($segmen->koordinat_geometri))
                                        {{ json_encode($segmen->koordinat_geometri, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                                    @else
                                        {{ $segmen->koordinat_geometri }}
                                    @endif
                                </div>
                            @else
                                <div class="rounded-[9px] border border-slate-200 bg-slate-50 p-3.5 text-sm font-semibold text-slate-900">
                                    Tidak ada data koordinat.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-[10px] border-2 border-dashed border-slate-300 px-5 py-10 text-center text-slate-500">
                    <strong>Belum ada segmen jalan.</strong>
                    <br>
                    Data segmen belum tersedia untuk ruas jalan ini.
                </div>
            @endforelse

            <div class="mt-5 flex flex-col justify-end gap-2.5 sm:flex-row">
                <a href="{{ route('jalan.index') }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-300">
                    ← Kembali ke Data Jalan
                </a>

                <a href="{{ route('jalan.edit', $jalan->id_jalan) }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                    ✎ Edit Jalan
                </a>
            </div>
        </div>
    </div>
</body>

</html>