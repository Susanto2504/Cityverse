<template>
    <div>
        <Header title="Data Infrastruktur" />

        <main class="min-h-screen w-full space-y-6 bg-[var(--color-mint-50)] p-4 pb-20 font-[var(--font-sans)] text-[var(--color-brand-deep)] sm:p-6 sm:pb-20 lg:p-8 lg:pb-20">
            <div v-if="loading" class="flex items-center gap-3 rounded-2xl bg-white p-4 text-sm shadow-sm ring-1 ring-[var(--color-mint-200)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-spin text-[var(--color-brand-active)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3a9 9 0 1 0 9 9" />
                </svg>
                Memuat data infrastruktur...
            </div>

            <div v-if="errorMessage" class="rounded-2xl bg-red-50 p-4 text-sm text-red-600 ring-1 ring-red-200">
                {{ errorMessage }}
            </div>

            <section class="grid grid-cols-2 gap-4 lg:grid-cols-5">
                <div class="rounded-3xl bg-gradient-to-br from-[var(--color-brand-deep)] to-[var(--color-brand-sidebar)] p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-brand-bright)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18" />
                            <path d="M5 21V7l8-4v18" />
                            <path d="M19 21V11l-6-4" />
                            <path d="M9 9v.01" />
                            <path d="M9 12v.01" />
                            <path d="M9 15v.01" />
                            <path d="M9 18v.01" />
                        </svg>
                        <span class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] font-semibold text-[var(--color-mint-200)]">Infrastruktur</span>
                    </div>
                    <p class="mt-3 text-3xl font-bold">{{ totalData }}</p>
                    <p class="mt-1 text-xs text-[var(--color-mint-200)]/80">Total Data Infrastruktur Terpantau</p>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-brand-active)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 3v18" />
                            <path d="M18 3v18" />
                            <path d="M6 12h12" />
                            <path d="M6 6h12" />
                            <path d="M6 18h12" />
                        </svg>
                        <span class="rounded-full bg-[var(--color-mint-100)] px-2 py-0.5 text-[10px] font-semibold text-[var(--color-brand-active)]">Jembatan</span>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-[var(--color-brand-deep)]">{{ categoryCounts.Jembatan }}</p>
                    <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Data jembatan per kecamatan</p>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-brand-active)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12h18" />
                            <path d="M6 8h12" />
                            <path d="M6 16h12" />
                            <path d="M9 4v16" />
                            <path d="M15 4v16" />
                        </svg>
                        <span class="rounded-full bg-[var(--color-mint-100)] px-2 py-0.5 text-[10px] font-semibold text-[var(--color-brand-active)]">Drainase</span>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-[var(--color-brand-deep)]">{{ categoryCounts.Drainase }}</p>
                    <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Data drainase wilayah</p>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-brand-active)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19h16" />
                            <path d="M6 17V7" />
                            <path d="M10 17V4" />
                            <path d="M14 17v-6" />
                            <path d="M18 17V9" />
                        </svg>
                        <span class="rounded-full bg-[var(--color-mint-100)] px-2 py-0.5 text-[10px] font-semibold text-[var(--color-brand-active)]">Pengelolaan Kota</span>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-[var(--color-brand-deep)]">{{ categoryCounts['Pengelolaan Kota'] }}</p>
                    <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Data pengelolaan kota</p>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex items-center justify-between">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-brand-active)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21h18" />
                            <path d="M5 21V7l7-4 7 4v14" />
                            <path d="M9 21v-5h6v5" />
                            <path d="M9 10h.01" />
                            <path d="M15 10h.01" />
                        </svg>
                        <span class="rounded-full bg-[var(--color-mint-100)] px-2 py-0.5 text-[10px] font-semibold text-[var(--color-brand-active)]">Rumah</span>
                    </div>
                    <p class="mt-3 text-3xl font-bold text-[var(--color-brand-deep)]">{{ categoryCounts.Rumah }}</p>
                    <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Data rumah per kecamatan</p>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="flex items-center gap-4 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-brand-active)]/15">
                        <span class="h-3 w-3 rounded-full bg-[var(--color-brand-active)]" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-[var(--color-brand-deep)]/60">Kondisi Baik</p>
                        <p class="text-xl font-bold text-[var(--color-brand-deep)]">{{ conditionCounts.Baik }} aset</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-yellow-500/15">
                        <span class="h-3 w-3 rounded-full bg-yellow-500" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-[var(--color-brand-deep)]/60">Perlu Pemeliharaan</p>
                        <p class="text-xl font-bold text-[var(--color-brand-deep)]">{{ conditionCounts['Perlu Pemeliharaan'] }} aset</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-red-500/15">
                        <span class="h-3 w-3 rounded-full bg-red-500" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-[var(--color-brand-deep)]/60">Rusak / Tidak Layak</p>
                        <p class="text-xl font-bold text-[var(--color-brand-deep)]">{{ conditionCounts.Rusak }} aset</p>
                    </div>
                </div>
            </section>

            <section class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-2">
                    <button v-for="category in categories" :key="category" @click="activeCategory = category" :class="activeCategory === category ? 'bg-[var(--color-brand-active)] text-white shadow-sm' : 'bg-white text-[var(--color-brand-deep)]/70 ring-1 ring-[var(--color-mint-200)] hover:bg-[var(--color-mint-100)]'" class="rounded-full px-4 py-2 text-xs font-semibold transition-all duration-200">
                        {{ category }}
                    </button>
                </div>

                <div class="flex w-full items-center lg:w-auto">
                    <div class="flex w-full items-center gap-3 rounded-2xl bg-white px-4 py-2.5 shadow-sm ring-1 ring-[var(--color-mint-200)] transition focus-within:ring-2 focus-within:ring-[var(--color-brand-active)]/30 lg:w-72">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[var(--color-brand-deep)]/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input v-model="search" type="text" placeholder="Cari nama aset..." class="w-full bg-transparent text-sm text-[var(--color-brand-deep)] outline-none placeholder:text-[var(--color-brand-deep)]/40" />
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[var(--color-mint-200)]">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[var(--color-mint-200)] bg-[var(--color-mint-50)] text-xs uppercase tracking-wide text-[var(--color-brand-deep)]/60">
                                <th class="px-6 py-3 font-semibold">Nama Aset</th>
                                <th class="px-6 py-3 font-semibold">Jenis</th>
                                <th class="px-6 py-3 font-semibold">Lokasi</th>
                                <th class="px-6 py-3 font-semibold">Tahun</th>
                                <th class="px-6 py-3 font-semibold">Kondisi</th>
                                <th class="px-6 py-3 font-semibold">Detail</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[var(--color-mint-100)]">
                            <tr v-for="item in paginatedData" :key="item.id" class="transition hover:bg-[var(--color-mint-50)]">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-[var(--color-brand-deep)]">{{ item.nama }}</p>
                                    <p class="text-xs text-[var(--color-brand-deep)]/50">Kode: {{ item.kode }}</p>
                                </td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/70">
                                    {{ item.jenis }}
                                </td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/70">
                                    {{ item.lokasi }}
                                </td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/70">
                                    {{ item.tahun || '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span v-if="item.kondisi === 'Baik'" class="inline-flex items-center gap-1.5 rounded-full bg-[var(--color-brand-active)]/15 px-3 py-1 text-xs font-semibold text-[var(--color-brand-active)]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[var(--color-brand-active)]" />
                                        Baik
                                    </span>

                                    <span v-else-if="item.kondisi === 'Perlu Pemeliharaan'" class="inline-flex items-center gap-1.5 rounded-full bg-yellow-500/15 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-yellow-500" />
                                        Perlu Pemeliharaan
                                    </span>

                                    <span v-else-if="item.kondisi === 'Rusak'" class="inline-flex items-center gap-1.5 rounded-full bg-red-500/15 px-3 py-1 text-xs font-semibold text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500" />
                                        Rusak
                                    </span>

                                    <span v-else class="text-xs text-[var(--color-brand-deep)]/40">
                                        -
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div v-if="item.jenis === 'Drainase'" class="space-y-1 text-xs text-[var(--color-brand-deep)]/60">
                                        <p v-if="item.nilai !== null && item.nilai !== undefined">
                                            Nilai:
                                            <span class="font-semibold text-[var(--color-brand-deep)]">
                                                {{ item.nilai }} {{ item.satuan }}
                                            </span>
                                        </p>

                                        <p v-if="item.judul">
                                            Keterangan:
                                            <span class="font-semibold text-[var(--color-brand-deep)]">
                                                {{ item.judul }}
                                            </span>
                                        </p>
                                    </div>

                                    <div v-else class="space-y-1 text-xs text-[var(--color-brand-deep)]/60">
                                        <p v-if="item.nilai !== null && item.nilai !== undefined">
                                            Nilai:
                                            <span class="font-semibold text-[var(--color-brand-deep)]">
                                                {{ item.nilai }} {{ item.satuan }}
                                            </span>
                                        </p>

                                        <p v-if="item.judul">
                                            {{ item.judul }}
                                        </p>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="paginatedData.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-[var(--color-brand-deep)]/50">
                                    Data aset tidak ditemukan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col items-center justify-between gap-3 border-t border-[var(--color-mint-200)] px-6 py-4 sm:flex-row">
                    <p class="text-xs text-[var(--color-brand-deep)]/50">
                        Menampilkan
                        {{ filteredData.length === 0 ? 0 : (currentPage - 1) * perPage + 1 }}
                        –
                        {{ Math.min(currentPage * perPage, filteredData.length) }}
                        dari
                        {{ filteredData.length }}
                        aset
                    </p>

                    <div class="flex items-center gap-1">
                        <button @click="previousPage" :disabled="currentPage === 1" class="flex h-8 w-8 items-center justify-center rounded-lg text-[var(--color-brand-deep)]/40 hover:bg-[var(--color-mint-100)] disabled:cursor-not-allowed disabled:opacity-30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>

                        <button v-for="page in visiblePages" :key="page" @click="page !== '...' && goToPage(page)" :disabled="page === '...'" :class="page === currentPage ? 'bg-[var(--color-brand-active)] text-white' : 'text-[var(--color-brand-deep)]/70 hover:bg-[var(--color-mint-100)]'" class="flex h-8 w-8 items-center justify-center rounded-lg text-xs font-medium">
                            {{ page }}
                        </button>

                        <button @click="nextPage" :disabled="currentPage === totalPages" class="flex h-8 w-8 items-center justify-center rounded-lg text-[var(--color-brand-deep)]/40 hover:bg-[var(--color-mint-100)] disabled:cursor-not-allowed disabled:opacity-30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>
        </main>
        <!-- FOOTER -->
        <footer class="fixed bottom-0 left-64 right-0 z-40 flex h-12 items-center justify-center border-t border-[var(--color-mint-200)] bg-white/95 px-4 backdrop-blur-sm">
            <p class="text-xs text-[var(--color-brand-deep)]/50">Sumber data berasal dari
                <a href="https://data.makassarkota.go.id/" target="_blank" rel="noopener noreferrer" class="font-semibold text-[var(--color-brand-active)] transition hover:underline">Portal Satu Data Makassar</a>
            </p>
        </footer>
    </div>
</template>

<script setup>
import Header from '../configViews/Header.vue'
import { useInfrastruktur } from '../../scriptViews/infrastruktur/main.js'

const {
    search,
    activeCategory,
    currentPage,
    perPage,

    loading,
    errorMessage,
    infrastructureData,

    categories,

    loadInfrastructureData,
    filteredData,
    categoryCounts,
    totalData,
    conditionCounts,

    totalPages,
    paginatedData,
    visiblePages,
    goToPage,
    previousPage,
    nextPage,
} = useInfrastruktur()
</script>