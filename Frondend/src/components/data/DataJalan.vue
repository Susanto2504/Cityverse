<template>
    <div>
        <Header title="Data Jalan" />

        <main
            class="min-h-screen w-full space-y-6 bg-[var(--color-mint-50)] p-4 font-[var(--font-sans)] text-[var(--color-brand-deep)] sm:p-6 lg:p-8"
        >
            <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <div
                    class="rounded-3xl bg-gradient-to-br from-slate-900 to-slate-800 p-5 text-white shadow-md"
                >
                    <p class="text-xs font-medium text-slate-300">
                        Total Ruas Jalan
                    </p>

                    <p class="mt-2 text-3xl font-bold">
                        {{ stats.totalRuas.toLocaleString() }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Total Panjang: {{ stats.totalPanjangKm }} km
                    </p>
                </div>

                <div
                    class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200"
                >
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-slate-500">
                            Lancar
                        </p>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-emerald-500"
                        ></span>
                    </div>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ stats.lancar.toLocaleString() }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Segmen jalan
                    </p>
                </div>

                <div
                    class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200"
                >
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-slate-500">
                            Sedang / Padat
                        </p>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-amber-500"
                        ></span>
                    </div>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ stats.sedang.toLocaleString() }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Segmen jalan
                    </p>
                </div>

                <div
                    class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200"
                >
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-slate-500">
                            Macet Total
                        </p>

                        <span
                            class="h-2.5 w-2.5 rounded-full bg-rose-500"
                        ></span>
                    </div>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ stats.macet.toLocaleString() }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Segmen jalan
                    </p>
                </div>
            </section>

            <section
                class="overflow-hidden rounded-3xl bg-white p-4 shadow-sm ring-1 ring-slate-200"
            >
                <div
                    class="mb-3 flex items-center justify-between px-2"
                >
                    <div>
                        <h2 class="text-sm font-semibold text-slate-800">
                            Peta Spasial Geometri Jalan (Leaflet GIS)
                        </h2>

                        <p class="mt-1 text-xs text-slate-400">
                            Warna garis menunjukkan kondisi traffic setiap
                            segmen jalan
                        </p>
                    </div>

                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <span
                                class="h-2.5 w-2.5 rounded-full bg-emerald-500"
                            ></span>
                            Lancar
                        </span>

                        <span class="flex items-center gap-1.5">
                            <span
                                class="h-2.5 w-2.5 rounded-full bg-amber-500"
                            ></span>
                            Sedang
                        </span>

                        <span class="flex items-center gap-1.5">
                            <span
                                class="h-2.5 w-2.5 rounded-full bg-rose-500"
                            ></span>
                            Macet
                        </span>
                    </div>
                </div>

                <div
                    id="map"
                    class="z-0 h-[450px] w-full rounded-2xl border border-slate-100"
                ></div>
            </section>

            <section
                class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 mb-12"
            >
                <div
                    class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">
                            Data Ruas Jalan
                        </h2>

                        <p class="mt-1 text-xs text-slate-400">
                            Cari berdasarkan nama ruas atau ID jalan
                        </p>
                    </div>

                    <div
                        class="flex w-full items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 transition focus-within:border-emerald-400 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-500/10 sm:w-[320px]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 shrink-0 text-slate-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>

                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari ruas jalan..."
                            class="min-w-0 flex-1 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                        />

                        <button
                            v-if="searchQuery"
                            @click="searchQuery = ''"
                            type="button"
                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-200 hover:text-slate-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="w-full min-w-[1150px] table-auto text-left text-sm"
                    >
                        <thead>
                            <tr
                                class="border-b border-slate-200 bg-slate-50/50 text-xs uppercase tracking-wider text-slate-500"
                            >
                                <th
                                    class="whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Ruas Jalan
                                </th>

                                <th
                                    class="whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Tipe & Fisik Jalan
                                </th>

                                <th
                                    class="whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Segmen
                                </th>

                                <th
                                    class="whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Kapasitas
                                </th>

                                <th
                                    class="whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Volume
                                </th>

                                <th
                                    class="w-[190px] whitespace-nowrap px-6 py-3.5 font-semibold"
                                >
                                    Kondisi Traffic
                                </th>

                                <th
                                    class="whitespace-nowrap px-6 py-3.5 text-right font-semibold"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <tr v-if="loading">
                                <td
                                    colspan="7"
                                    class="px-6 py-8 text-center text-slate-400"
                                >
                                    Sedang mengambil data jalan...
                                </td>
                            </tr>

                            <tr
                                v-else-if="filteredList.length === 0"
                            >
                                <td
                                    colspan="7"
                                    class="px-6 py-8 text-center text-slate-400"
                                >
                                    Tidak ada data ruas jalan yang ditemukan.
                                </td>
                            </tr>
                            <template
                                v-else
                                v-for="jalan in paginatedList"
                                :key="jalan.id_jalan"
                            >
                                <tr
                                    class="transition hover:bg-slate-50/80"
                                >
                                    <td class="px-6 py-4">
                                        <p
                                            class="font-semibold text-slate-900"
                                        >
                                            {{
                                                jalan.nama_ruas_jalan ||
                                                "Tidak bernama"
                                            }}
                                        </p>

                                        <div
                                            class="mt-0.5 flex items-center gap-2 text-xs text-slate-400"
                                        >
                                            <span>
                                                ID: #{{ jalan.id_jalan }}
                                            </span>

                                            <span>•</span>

                                            <span>
                                                {{
                                                    jalan.segmen_jalans?.length ||
                                                    0
                                                }}
                                                segmen
                                            </span>
                                        </div>
                                    </td>

                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-slate-600"
                                    >
                                        <div
                                            class="flex items-center gap-2"
                                        >
                                            <span
                                                class="font-medium text-slate-800"
                                            >
                                                {{
                                                    Number(
                                                        jalan.panjang_m || 0,
                                                    ).toFixed(2)
                                                }}
                                                m
                                            </span>

                                            <span class="text-slate-300">
                                                •
                                            </span>

                                            <span
                                                class="text-xs text-slate-400"
                                            >
                                                Lebar
                                                {{
                                                    jalan.lebar_m != null
                                                        ? Number(
                                                            jalan.lebar_m,
                                                        ).toFixed(2)
                                                        : "-"
                                                }}
                                                m
                                            </span>
                                        </div>

                                        <p
                                            class="mt-1 font-medium text-emerald-600"
                                        >
                                            {{
                                                jalan.tipe_jalan_detail || "-"
                                            }}
                                        </p>
                                    </td>

                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-slate-600"
                                    >
                                        <span
                                            class="font-semibold text-slate-800"
                                        >
                                            {{
                                                jalan.segmen_jalans?.length || 0
                                            }}
                                        </span>

                                        <span
                                            class="ml-1 text-xs text-slate-400"
                                        >
                                            segmen OSM
                                        </span>
                                    </td>

                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-slate-600"
                                    >
                                        <span
                                            class="font-semibold text-slate-800"
                                        >
                                            {{
                                                getTotalCapacity(
                                                    jalan,
                                                ).toLocaleString()
                                            }}
                                        </span>

                                        <span
                                            class="ml-1 text-xs text-slate-400"
                                        >
                                            smp/jam
                                        </span>
                                    </td>

                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-slate-600"
                                    >
                                        <span
                                            class="font-semibold text-slate-800"
                                        >
                                            {{
                                                getTotalVolume(
                                                    jalan,
                                                ).toLocaleString()
                                            }}
                                        </span>

                                        <span
                                            class="ml-1 text-xs text-slate-400"
                                        >
                                            kend/jam
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div
                                            v-if="
                                                getTrafficSummary(jalan).kapasitas > 0
                                            "
                                            class="flex flex-col gap-1.5"
                                        >
                                            <span
                                                v-if="
                                                    getTrafficSummary(jalan).kondisi === 'Lancar'
                                                "
                                                class="inline-flex w-fit items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200"
                                            >
                                                <span
                                                    class="h-1.5 w-1.5 rounded-full bg-emerald-500"
                                                ></span>

                                                Lancar
                                            </span>

                                            <span
                                                v-else-if="
                                                    getTrafficSummary(jalan).kondisi === 'Sedang'
                                                "
                                                class="inline-flex w-fit items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-200"
                                            >
                                                <span
                                                    class="h-1.5 w-1.5 rounded-full bg-amber-500"
                                                ></span>

                                                Sedang
                                            </span>

                                            <span
                                                v-else-if="
                                                    getTrafficSummary(jalan).kondisi === 'Macet'
                                                "
                                                class="inline-flex w-fit items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200"
                                            >
                                                <span
                                                    class="h-1.5 w-1.5 rounded-full bg-rose-500"
                                                ></span>

                                                Macet
                                            </span>

                                            <span
                                                class="text-xs text-slate-400"
                                            >
                                                {{ getTrafficSummary(jalan).persentase }}%
                                            </span>
                                        </div>

                                        <div
                                            v-if="getConditionSegments(jalan).length > 0"
                                            class="mt-2"
                                        >
                                            <button
                                                type="button"
                                                @click="toggleConditionDetails(jalan.id_jalan)"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 transition hover:text-slate-800"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-3.5 w-3.5 transition-transform"
                                                    :class="{
                                                        'rotate-180': isConditionExpanded(jalan.id_jalan),
                                                    }"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 9l-7 7-7-7"
                                                    />
                                                </svg>

                                                Kondisi Jalan
                                                ({{ getConditionSegments(jalan).length }})
                                            </button>
                                        </div>

                                        <span
                                            v-else
                                            class="whitespace-nowrap text-xs text-slate-400"
                                        >
                                            Belum tersedia
                                        </span>
                                        
                                    </td>

                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-right"
                                    >
                                        <button
                                            @click="
                                                focusToMap(
                                                    getRoadGeometry(jalan),
                                                )
                                            "
                                            class="text-xs font-semibold text-emerald-600 transition hover:text-emerald-700 hover:underline"
                                        >
                                            Fokus Peta
                                        </button>
                                    </td>
                                </tr>

                                <tr
                                    v-if="
                                        isConditionExpanded(jalan.id_jalan) &&
                                        getConditionSegments(jalan).length > 0
                                    "
                                    class="bg-slate-50"
                                >
                                    <td
                                        colspan="7"
                                        class="px-6 py-4"
                                    >
                                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                            <div class="mb-3">
                                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                                    Kondisi Jalan
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-slate-800">
                                                    {{ jalan.nama_ruas_jalan || "Tidak bernama" }}
                                                </p>
                                            </div>

                                            <div class="overflow-hidden rounded-xl border border-slate-200">
                                                <table class="w-full text-left text-xs">
                                                    <thead class="bg-slate-50">
                                                        <tr>
                                                            <th class="px-4 py-3 font-semibold text-slate-500">
                                                                ID Segmen
                                                            </th>

                                                            <th class="px-4 py-3 font-semibold text-slate-500">
                                                                Kondisi
                                                            </th>

                                                            <th class="px-4 py-3 font-semibold text-slate-500">
                                                                Keterangan
                                                            </th>

                                                            <th class="px-4 py-3 text-right font-semibold text-slate-500">
                                                                Panjang Kondisi
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="divide-y divide-slate-100">
                                                        <tr
                                                            v-for="segmen in getConditionSegments(jalan)"
                                                            :key="segmen.id"
                                                            class="hover:bg-slate-50"
                                                        >
                                                            <td class="px-4 py-3 font-semibold text-slate-700">
                                                                #{{ segmen.id }}
                                                            </td>

                                                            <td class="px-4 py-3">
                                                                <span
                                                                    v-if="segmen.kondisi_jalan === 'Banjir'"
                                                                    class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 font-semibold text-blue-700"
                                                                >
                                                                    Banjir
                                                                </span>

                                                                <span
                                                                    v-else-if="segmen.kondisi_jalan === 'Longsor'"
                                                                    class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 font-semibold text-amber-700"
                                                                >
                                                                    Longsor
                                                                </span>

                                                                <span
                                                                    v-else
                                                                    class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 font-semibold text-slate-700"
                                                                >
                                                                    Lainnya
                                                                </span>
                                                            </td>

                                                            <td class="px-4 py-3 text-slate-600">
                                                                {{
                                                                    segmen.kondisi_jalan === "Lainnya"
                                                                        ? segmen.kondisi_lainnya || "-"
                                                                        : "-"
                                                                }}
                                                            </td>

                                                            <td class="px-4 py-3 text-right font-semibold text-slate-700">
                                                                {{
                                                                    segmen.panjang_kondisi_m != null
                                                                        ? Number(
                                                                            segmen.panjang_kondisi_m,
                                                                        ).toFixed(2)
                                                                        : "-"
                                                                }}
                                                                m
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div
                    v-if="filteredList.length > 0"
                    class="flex flex-col gap-3 border-t border-slate-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-xs text-slate-500">
                        Menampilkan

                        <span class="font-semibold">
                            {{ paginationStart }}
                        </span>

                        -

                        <span class="font-semibold">
                            {{ paginationEnd }}
                        </span>

                        dari

                        <span class="font-semibold">
                            {{ filteredList.length.toLocaleString() }}
                        </span>

                        ruas jalan
                    </p>

                    <div class="flex items-center gap-2">
                        <button
                            @click="previousPage"
                            :disabled="currentPage === 1"
                            class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            Sebelumnya
                        </button>

                        <span
                            class="rounded-xl bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white"
                        >
                            {{ currentPage }} / {{ totalPages }}
                        </span>

                        <button
                            @click="nextPage"
                            :disabled="currentPage === totalPages"
                            class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            Berikutnya
                        </button>
                    </div>
                </div>
            </section>
        </main>

        <footer class="fixed bottom-0 left-0 right-0 z-40 flex h-15 items-center justify-center border-t border-[var(--color-mint-200)] bg-white/95 px-4 backdrop-blur-md lg:left-64">
            <div class="flex items-center justify-center">
                <p class="text-xs text-[var(--color-brand-deep)]/80">
                    Semua data ruas jalan, trafic, dan kondisi adalah data dummy dari OpenStreetMap
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import Header from "../configViews/Header.vue";
import { useJalan } from "../../scriptViews/jalan/main.js";

const {
    searchQuery,
    loading,
    syncing,
    listJalan,
    currentPage,
    perPage,
    totalPages,
    paginationStart,
    paginationEnd,
    stats,
    filteredList,
    paginatedList,
    resetPagination,
    previousPage,
    nextPage,
    initMap,
    getRoadColor,
    renderGeometriesOnMap,
    focusToMap,
    getRoadGeometry,
    getTotalCapacity,
    getTotalVolume,
    getTrafficSummary,
    getDataJalan,
    fetchDataJalan,
    toggleConditionDetails,
    isConditionExpanded,
    getConditionSegments,
} = useJalan();
</script>