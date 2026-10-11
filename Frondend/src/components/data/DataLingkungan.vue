<template>
    <div>
        <Header title="Data Lingkungan" />

        <main class="min-h-screen w-full space-y-6 bg-[var(--color-mint-50)] p-4 font-[var(--font-sans)] text-[var(--color-brand-deep)] sm:p-6 lg:p-8">
            <header class="flex w-full flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">   
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="flex items-center justify-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-medium text-[var(--color-brand-deep)] shadow-sm ring-1 ring-[var(--color-mint-200)]" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        Kota Makassar
                    </div>

                    <button @click="loadEnvironmentalData" :disabled="loading" class="flex items-center justify-center gap-2 rounded-2xl bg-[var(--color-brand-active)] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="{ 'animate-spin': loading }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-2.64-6.36" />
                            <polyline points="21 3 21 9 15 9"/>
                        </svg>

                        {{ loading ? "Mengambil..." : "Refresh" }}
                    </button>
                </div>
            </header>

            <div v-if="loading" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                <div class="flex items-center gap-3">
                    <div class="h-5 w-5 animate-spin rounded-full border-2 border-[var(--color-brand-active)] border-t-transparent"></div>

                    <div>
                        <p class="text-sm font-semibold"> Mengambil data lingkungan... </p>

                        <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Mengambil data lingkungan dari server Laravel dan database.</p>
                    </div>
                </div>
            </div>

            <div v-if="errorMessage" class="rounded-3xl border border-red-200 bg-red-50 p-5">
                <div class="flex gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-red-700">Gagal mengambil data</p>

                        <p class="mt-1 text-xs leading-5 text-red-600/80">{{ errorMessage }}</p>
                    </div>
                </div>
            </div>

            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[var(--color-brand-deep)] via-[var(--color-brand-sidebar)] to-[var(--color-brand-active)] p-6 text-white shadow-lg sm:p-8">
                <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[var(--color-brand-bright)]/15 blur-3xl"></div>

                <div class="pointer-events-none absolute -bottom-24 left-1/3 h-64 w-64 rounded-full bg-[var(--color-brand-accent)]/10 blur-3xl"></div>

                <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <div class="flex items-center gap-2 text-sm font-medium text-[var(--color-mint-200)]">
                            <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2a10 10 0 1 0 10 10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </span>
                            Menampilkan Data Rekapan 
                        </div>

                        <div class="mt-5">
                            <p class="text-4xl font-bold sm:text-5xl">Kondisi Lingkungan</p>

                        </div>

                        <p class="mt-2 max-w-xl text-[12px] leading-6 text-yellow-500 font-bold italic"> <span class="font-bold text-white">*</span> Data yang ditampilkan berasal dari berberapa sumber terkait kondisi lingkungan yang ada di Kota Makassar.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-2">
                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-xs text-[var(--color-mint-200)]/65">Tingkat Risiko Lingkungan</p>

                            <p class="mt-1 text-2xl font-bold">{{ environmentalRiskDisplay }}</p>

                            <p class="mt-1 text-[11px] text-[var(--color-mint-200)]/55">berdasarkan IKU, IKA & Persampahan</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-xs text-[var(--color-mint-200)]/65">IKU</p>

                            <p class="mt-1 text-lg font-bold">{{ ikuDisplay }}</p>

                            <p class="mt-1 text-[11px] text-[var(--color-mint-200)]/55">dari endpoint IKU</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-xs text-[var(--color-mint-200)]/65">IKA</p>

                            <p class="mt-1 text-lg font-bold">{{ ikaDisplay }}</p>

                            <p class="mt-1 text-[11px] text-[var(--color-mint-200)]/55">tahun 2024</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-sm">
                            <p class="text-xs text-[var(--color-mint-200)]/65">Wilayah</p>

                            <p class="mt-1 text-lg font-bold">Makassar</p>

                            <p class="mt-1 text-[11px] text-[var(--color-mint-200)]/55">Kota</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-[var(--color-brand-deep)]">Parameter Lingkungan</h2>
                    </div>

                    <span class="text-xs text-[var(--color-brand-deep)]/45">Kota Makassar</span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12h14a4 4 0 1 0-4-4" />
                                    <path d="M3 17h9a3 3 0 1 1-3 3" />
                                </svg>
                            </div>

                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold" :class="ikuValue !== null ? 'bg-sky-500/10 text-sky-600' : 'bg-slate-500/10 text-slate-600'">{{ikuValue !== null ? "DATA API" : "BELUM ADA"}}</span>
                        </div>

                        <p class="mt-5 text-sm font-semibold text-[var(--color-brand-deep)]">Kualitas Udara</p>

                        <div class="mt-2">
                            <span class="text-2xl font-bold text-[var(--color-brand-deep)]">
                                {{ ikuDisplay }}
                            </span>
                        </div>

                        <p class="mt-1 text-xs leading-5 text-[var(--color-brand-deep)]/50"> Nilai IKU diambil dari <span class="font-bold text-[var(--color-brand-deep)]/70">Kementerian Lingkungan Hidup / Badan Pengendalian Lingkungan Hidup</span> </p>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-sky-500 transition-all duration-500" :style="{width: `${Math.min(Math.max(ikuValue ?? 0, 0),100)}%`,}"></div>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-500/10 text-cyan-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2.69s-5 6.5-5 10.31a5 5 0 0 0 10 0c0-3.81-5-10.31-5-10.31Z"/>
                                </svg>
                            </div>

                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold" :class="ikaValue !== null ? 'bg-cyan-500/10 text-cyan-600' : 'bg-slate-500/10 text-slate-600'">{{ikaValue !== null ? "DATA API" : "BELUM ADA"}}</span>
                        </div>

                        <p class="mt-5 text-sm font-semibold text-[var(--color-brand-deep)]">Kualitas Air</p>

                        <div class="mt-2">
                            <span class="text-2xl font-bold text-[var(--color-brand-deep)]">{{ ikaDisplay }}</span>
                        </div>

                        <p class="mt-1 text-xs leading-5 text-[var(--color-brand-deep)]/50">Data IKA diambil dari <span class="font-bold text-[var(--color-brand-deep)]/70">Kementerian Lingkungan Hidup / Badan Pengendalian Lingkungan Hidup</span></p>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-cyan-500 transition-all duration-500" :style="{width: `${Math.min(Math.max(ikaValue ?? 0, 0),100)}%`,}"></div>
                        </div>
                    </div>

                    <div
                        class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/10 text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17"/>
                                    <line x1="14" x2="14" y1="11" y2="17"/>
                                </svg>
                            </div>

                            <span class="rounded-full bg-orange-500/10 px-2.5 py-1 text-[10px] font-bold text-orange-600"> DATA API</span>
                        </div>

                        <p class="mt-5 text-sm font-semibold text-[var(--color-brand-deep)]">Persampahan</p>

                        <div class="mt-2 flex items-end gap-2">
                            <span class="text-3xl font-bold text-[var(--color-brand-deep)]">{{ wastePercentageDisplay }}</span>

                            <span class="mb-1 text-xs text-[var(--color-brand-deep)]/45">terkelola</span>
                        </div>

                        <p class="mt-1 text-xs text-[var(--color-brand-deep)]/50">Data sampah diambil dari <span class="font-bold text-[var(--color-brand-deep)]/70">Kementerian Lingkungan Hidup / Badan Pengendalian Lingkungan Hidup</span></p>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-orange-500 transition-all duration-500" :style="{width: `${Math.min(Math.max(wastePercentage, 0), 100)}%`,}"></div>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                        <div class="flex items-start justify-between">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-500/10 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 16c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2" />
                                    <path d="M3 20c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2" />
                                    <path d="M12 3v7" />
                                    <path d="m9 7 3 3 3-3" />
                                </svg>
                            </div>

                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold" :class="floodRiskValue !== null ? floodRiskCategory === 'TINGGI' ? 'bg-red-500/10 text-red-600' : floodRiskCategory === 'SEDANG' ? 'bg-amber-500/10 text-amber-600' : 'bg-emerald-500/10 text-emerald-600' : 'bg-slate-500/10 text-slate-600'">{{floodRiskValue !== null ? floodRiskCategory : floodRiskLoading ? 'MENGAMBIL' : 'BELUM ADA'}}</span>
                        </div>

                        <p class="mt-5 text-sm font-semibold text-[var(--color-brand-deep)]">Risiko Banjir</p>

                        <div class="mt-2">
                            <span class="text-2xl font-bold text-[var(--color-brand-deep)]">{{ floodRiskDisplay }}</span>
                        </div>

                        <p class="mt-4 text-xs leading-5 text-[var(--color-brand-deep)]/50">
                            <template v-if="floodRiskValue !== null"> Data risiko banjir diambil dari <span class="font-bold text-[var(--color-brand-deep)]/70">InaRISK BNPB.</span></template>

                            <template v-else-if="floodRiskLoading"> Mengambil data risiko banjir dari InaRISK BNPB...</template>
                            <template v-else> {{ floodRiskError || 'Data risiko banjir belum tersedia.' }}</template>
                        </p>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full transition-all duration-500" :class="floodRiskCategory === 'TINGGI' ? 'bg-red-500' : floodRiskCategory === 'SEDANG' ? 'bg-amber-500' : 'bg-emerald-500'" :style="{width: `${floodRiskProgress}%`, }"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[var(--color-mint-200)]">
                <div class="border-b border-[var(--color-mint-200)] p-5 sm:p-6">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="font-bold text-[var(--color-brand-deep)]">Data Persampahan Kota Makassar</h2>

                            <p class="mt-1 text-xs text-[var(--color-brand-deep)]/45">Data diambil dari <span class="font-bold text-[var(--color-brand-deep)]/70">Kementerian Lingkungan Hidup / Badan Pengendalian Lingkungan Hidup</span></p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 border-b border-[var(--color-mint-200)] p-5 sm:grid-cols-2 lg:grid-cols-4 sm:p-6">
                    <div class="rounded-2xl bg-[var(--color-mint-50)] p-4">
                        <p class="text-xs text-[var(--color-brand-deep)]/50">Timbulan Sampah</p>

                        <p class="mt-2 text-xl font-bold text-[var(--color-brand-deep)]">{{ wasteTotalDisplay }}</p>

                        <p class="mt-1 text-[11px] text-[var(--color-brand-deep)]/45">ton/tahun</p>
                    </div>

                    <div class="rounded-2xl bg-[var(--color-mint-50)] p-4">
                        <p class="text-xs text-[var(--color-brand-deep)]/50">Sampah Terkelola</p>

                        <p class="mt-2 text-xl font-bold text-[var(--color-brand-deep)]">{{ wasteManagedDisplay }}</p>

                        <p class="mt-1 text-[11px] text-[var(--color-brand-deep)]/45">ton/tahun</p>
                    </div>

                    <div class="rounded-2xl bg-[var(--color-mint-50)] p-4">
                        <p class="text-xs text-[var(--color-brand-deep)]/50">Penanganan</p>

                        <p class="mt-2 text-xl font-bold text-[var(--color-brand-deep)]">{{ wasteHandlingDisplay }}</p>

                        <p class="mt-1 text-[11px] text-[var(--color-brand-deep)]/45">ton/tahun</p>
                    </div>

                    <div class="rounded-2xl bg-[var(--color-mint-50)] p-4">
                        <p class="text-xs text-[var(--color-brand-deep)]/50">Pengurangan</p>

                        <p class="mt-2 text-xl font-bold text-[var(--color-brand-deep)]">{{ wasteReductionDisplay }}</p>

                        <p class="mt-1 text-[11px] text-[var(--color-brand-deep)]/45">ton/tahun</p>
                    </div>
                </div>

                <div class="grid gap-4 border-b border-[var(--color-mint-200)] p-5 sm:grid-cols-2 lg:grid-cols-3 sm:p-6">
                    <div class="rounded-2xl border border-[var(--color-mint-200)] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs text-[var(--color-brand-deep)]/55">Sampah Terkelola</span>

                            <span class="text-sm font-bold text-orange-600">{{ wastePercentageDisplay }}</span>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-orange-500" :style="{width: `${Math.min(Math.max(wastePercentage, 0),100)}%`,}"></div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-mint-200)] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs text-[var(--color-brand-deep)]/55">Penanganan</span>

                            <span class="text-sm font-bold text-blue-600">{{ wasteHandlingPercentageDisplay }}</span>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-blue-500" :style="{width: `${Math.min(Math.max(wasteHandlingPercentage, 0),100)}%`,}"></div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[var(--color-mint-200)] p-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-xs text-[var(--color-brand-deep)]/55">Pengurangan</span>

                            <span class="text-sm font-bold text-violet-600">{{ wasteReductionPercentageDisplay }}</span>
                        </div>

                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-[var(--color-mint-100)]">
                            <div class="h-full rounded-full bg-violet-500" :style="{width: `${Math.min(Math.max(wasteReductionPercentage, 0),100)}%`,}"></div>
                        </div>
                    </div>
                </div>

            </section>

            <section class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-2">
                    <button v-for="filter in filters" :key="filter" @click="activeFilter = filter" :class="activeFilter === filter ? 'bg-[var(--color-brand-active)] text-white shadow-sm' : 'bg-white text-[var(--color-brand-deep)]/70 ring-1 ring-[var(--color-mint-200)] hover:bg-[var(--color-mint-50)]'" class="rounded-full px-4 py-2 text-xs font-semibold transition">{{ filter }}</button>
                </div>
            </section>

            <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-[var(--color-mint-200)]">
                <div class="flex flex-col gap-3 border-b border-[var(--color-mint-200)] p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="font-bold text-[var(--color-brand-deep)]">Detail Data Lingkungan</h2>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 shadow-sm ring-1 ring-[var(--color-mint-200)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[var(--color-brand-deep)]/45" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>

                            <input v-model="search" type="text" placeholder="Cari data..." class="w-full bg-transparent text-sm outline-none placeholder:text-[var(--color-brand-deep)]/40 sm:w-52"/>
                        </div>

                        <span class="w-fit rounded-full bg-[var(--color-mint-50)] px-3 py-1.5 text-xs  font-medium text-[var(--color-brand-deep)]/60">{{ filteredData.length }} data</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-[var(--color-mint-200)] bg-[var(--color-mint-50)] text-[11px] uppercase tracking-wide text-[var(--color-brand-deep)]/55">
                                <th class="px-6 py-3.5 font-semibold">Wilayah</th>

                                <th class="px-6 py-3.5 font-semibold">Parameter</th>

                                <th class="px-6 py-3.5 font-semibold">Indikator</th>

                                <th class="px-6 py-3.5 font-semibold">Nilai</th>

                                <th class="px-6 py-3.5 font-semibold">Tahun</th>

                                <th class="px-6 py-3.5 font-semibold">Sumber</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[var(--color-mint-100)]">
                            <tr v-for="item in filteredData" :key="item.id" class="transition hover:bg-[var(--color-mint-50)]">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-[var(--color-brand-deep)]">{{ item.wilayah }}</p>

                                    <p class="mt-0.5 text-[11px] text-[var(--color-brand-deep)]/45">{{ item.kode }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-lg bg-orange-50 px-2.5 py-1 text-xs font-semibold text-orange-600">{{ item.parameter }}</span>
                                </td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/65">{{ item.indikator }}</td>

                                <td class="px-6 py-4 font-semibold text-[var(--color-brand-deep)]"
                                >{{ item.nilai }}</td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/55"
                                >{{ item.tahun }}</td>

                                <td class="px-6 py-4 text-[var(--color-brand-deep)]/55">{{ item.sumber }}</td>
                            </tr>

                            <tr v-if="filteredData.length === 0">
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <p class="text-sm font-medium text-[var(--color-brand-deep)]/60"
                                    >Data belum ditemukan.</p>

                                    <p class="mt-1 text-xs text-[var(--color-brand-deep)]/40">Pastikan endpoint API Laravel dapat diakses dan data sudah tersimpan di database.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[var(--color-mint-200)] sm:p-6 mb-9">
                <div class="flex gap-4">
                    <div class="w-full">
                        <h3 class="text-sm font-bold text-[var(--color-brand-deep)] border-b border-[var(--color-mint-200)] pb-2">Status Sumber Data</h3>

                        <div class="mt-4  grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="rounded-xl bg-[var(--color-mint-50)] p-3">
                                <p class="text-[10px] font-bold uppercase text-[var(--color-brand-deep)]/40">IKU</p>

                                <p class="mt-1 text-xs font-semibold text-[var(--color-brand-deep)]">{{ ikuStatus }}</p>
                            </div>

                            <div class="rounded-xl bg-[var(--color-mint-50)] p-3">
                                <p class="text-[10px] font-bold uppercase text-[var(--color-brand-deep)]/40"
                                >IKA</p>

                                <p class="mt-1 text-xs font-semibold text-[var(--color-brand-deep)]"
                                >{{ ikaStatus }}</p>
                            </div>

                            <div class="rounded-xl bg-[var(--color-mint-50)] p-3">
                                <p class="text-[10px] font-bold uppercase text-[var(--color-brand-deep)]/40"
                                >Risiko Banjir</p>

                                <p class="mt-1 text-xs font-semibold text-[var(--color-brand-deep)]"
                                >{{ floodRiskStatus }}</p>
                            </div>

                            <div class="rounded-xl bg-[var(--color-mint-50)] p-3">
                                <p class="text-[10px] font-bold uppercase text-[var(--color-brand-deep)]/40"
                                >Persampahan</p>

                                <p class="mt-1 text-xs font-semibold text-[var(--color-brand-deep)]">{{ wasteStatus }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
        <footer class="fixed bottom-0 left-0 right-0 z-40 flex h-12 items-center justify-center border-t border-[var(--color-mint-200)] bg-white/95 px-4 backdrop-blur-md lg:left-64">
            <div class="flex items-center justify-center">
                <p class="text-xs text-[var(--color-brand-deep)]/50">Sumber data berasal dari
                    <a href="https://satudata.kemenlh.go.id/dataset" target="_blank" rel="noopener noreferrer" class="font-semibold text-[var(--color-brand-active)] transition hover:underline">Kementerian Lingkungan Hidup / Badan Pengendalian Lingkungan Hidup</a> dan
                    <a href="https://inarisk.bnpb.go.id/" target="_blank" rel="noopener noreferrer" class="font-semibold text-[var(--color-brand-active)] transition hover:underline">InaRISK BNPB</a> 
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import Header from "../configViews/Header.vue";
import { useLingkungan } from "../../scriptViews/lingkungan/main.js";

const {
  loading,
  errorMessage,

  // IKU
  ikuValue,
  ikuDisplay,
  ikuStatus,

  // IKA
  ikaValue,
  ikaDisplay,
  ikaStatus,

  // Persampahan
  wastePercentage,
  wastePercentageDisplay,
  wasteTotalDisplay,
  wasteManagedDisplay,
  wasteHandlingDisplay,
  wasteReductionDisplay,
  wasteHandlingPercentage,
  wasteHandlingPercentageDisplay,
  wasteReductionPercentage,
  wasteReductionPercentageDisplay,
  wasteStatus,

  // Risiko banjir
  floodRiskValue,
  floodRiskCategory,
  floodRiskDisplay,
  floodRiskProgress,
  floodRiskLoading,
  floodRiskError,
  floodRiskStatus,

  // Risiko lingkungan
  environmentalRiskDisplay,

  // Tabel & filter
  filteredData,
  filters,
  activeFilter,
  search,

  // Action
  loadEnvironmentalData,
  refreshData,
} = useLingkungan();
</script>
