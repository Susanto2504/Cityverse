<template>
    <div class="h-screen  bg-[#F4FFFC] font-['Plus_Jakarta_Sans',sans-serif] text-[#3F4743] antialiased selection:bg-[#C3E956] selection:text-[#1F4B2C]">
        <router-view v-if="$route.path !== '/config'" />

        <template v-else>
            <div class="flex h-screen flex-col">
                <Header title="Data & Konfigurasi Kota" @click="$emit('toggle-sidebar')" class="shrink-0" />

                <div class="flex min-h-0 flex-1 flex-col">
                    <main class="min-h-0 flex-1 overflow-y-auto">
                        <div class="mx-auto max-w-full px-4 py-8 sm:px-6 lg:px-8">
                            <section class="relative mb-8 overflow-hidden rounded-[2rem] border border-[#275836] bg-[#1F4B2C] p-8 text-white shadow-2xl shadow-[#1F4B2C]/20 sm:p-10">
                                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(#91EAAF_1px,transparent_1px)] opacity-10 [background-size:24px_24px]" aria-hidden="true"></div>
                                <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-[#C3E956]/20 blur-3xl" aria-hidden="true"></div>
                                <div class="pointer-events-none absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-[#91EAAF]/15 blur-3xl" aria-hidden="true"></div>

                                <div class="relative z-10 flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                                    <div class="max-w-xl">
                                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#91EAAF]/30 bg-[#275836]/60 px-4 py-1.5 text-xs font-semibold tracking-wide text-[#91EAAF] backdrop-blur-md">
                                            <span class="relative flex h-2 w-2">
                                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#C3E956] opacity-75"></span>
                                                <span class="relative inline-flex h-2 w-2 rounded-full bg-[#C3E956]"></span>
                                            </span>
                                            Kota Makassar
                                        </div>

                                        <h2 class="font-sans text-3xl font-extrabold tracking-tight text-white sm:text-4xl sm:leading-tight">
                                            Semua data operasional kota,
                                            <span class="text-[#C3E956]">satu tampilan terpadu.</span>
                                        </h2>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 sm:flex sm:gap-6">
                                        <div class="flex flex-col rounded-2xl border border-[#91EAAF]/10 bg-[#275836]/40 p-4 backdrop-blur-sm sm:min-w-[130px]">
                                            <span class="font-sans text-2xl font-black text-[#C3E956] sm:text-3xl">{{ totalJalan }}</span>
                                            <span class="mt-1 text-xs font-medium text-[#91EAAF]">Ruas Jalan</span>
                                        </div>

                                        <div class="flex flex-col rounded-2xl border border-[#91EAAF]/10 bg-[#275836]/40 p-4 backdrop-blur-sm sm:min-w-[130px]">
                                            <span class="font-sans text-2xl font-black text-[#C3E956] sm:text-3xl">{{ temperature }}</span>
                                            <span class="mt-1 truncate text-xs font-medium text-[#91EAAF]">{{ condition }}</span>
                                        </div>

                                        <div class="flex flex-col rounded-2xl border border-[#91EAAF]/10 bg-[#275836]/40 p-4 backdrop-blur-sm sm:min-w-[130px]">
                                            <span class="font-sans text-2xl font-black text-[#C3E956] sm:text-3xl">{{ totalParameterLingkungan }}</span>
                                            <span class="mt-1 text-xs font-medium text-[#91EAAF]">Lingkungan</span>
                                        </div>

                                        <div class="flex flex-col rounded-2xl border border-[#91EAAF]/10 bg-[#275836]/40 p-4 backdrop-blur-sm sm:min-w-[130px]">
                                            <span class="font-sans text-2xl font-black text-[#C3E956] sm:text-3xl">{{ totalInfrastruktur }}%</span>
                                            <span class="mt-1 text-xs font-medium text-[#91EAAF]">aset dalam kondisi baik</span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                                <article class="group relative flex flex-col justify-between overflow-hidden rounded-[2rem] border border-[#D5F5DD] bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-[#1F4B2C]/5 md:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#EAFFE9] text-[#1F4B2C] transition-transform duration-300 group-hover:scale-110">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M4 19L9 3h6l5 16" />
                                                <line x1="12" y1="6" x2="12" y2="8" />
                                                <line x1="12" y1="12" x2="12" y2="14" />
                                            </svg>
                                        </div>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFFE9] px-3 py-1 text-xs font-bold text-[#1F4B2C]">
                                            <span class="h-2 w-2 rounded-full bg-[#4D7111]"></span>
                                            Data aktif
                                        </span>
                                    </div>

                                    <div class="my-6">
                                        <h3 class="font-sans text-xl font-bold tracking-tight text-[#1F4B2C]">Ruas Jalan</h3>
                                        <p class="mt-2 text-sm leading-relaxed text-[#3F4743]/80">Menampilkan jumlah ruas jalan beserta informasi panjang jalan, lebar jalan, tipe jalan, kapasitas jalan, volume kendaraan, dan tingkat kepadatan.</p>
                                    </div>

                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <span class="block font-sans text-3xl font-black leading-none text-[#1F4B2C]">{{ totalJalan }}</span>
                                            <span class="mt-1.5 block text-xs font-semibold text-[#3F4743]/60">ruas jalan terpantau</span>
                                        </div>

                                        <router-link :to="{ name: 'data-jalan' }" class="inline-flex items-center gap-2 rounded-xl bg-[#3F4743] px-4 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-[#1F4B2C] hover:shadow-md active:scale-95">
                                            <span>Lihat data</span>
                                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7-7" />
                                            </svg>
                                        </router-link>
                                    </div>
                                </article>

                                <article class="group relative flex flex-col justify-between overflow-hidden rounded-[2rem] border border-[#D5F5DD] bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-[#1F4B2C]/5 md:col-span-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#EAFFE9] text-[#4D7111] transition-transform duration-300 group-hover:scale-110">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z" />
                                                <path d="M22 10a3 3 0 0 0-3-3h-2.25" />
                                            </svg>
                                        </div>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFFE9] px-3 py-1 text-xs font-bold text-[#1F4B2C]">
                                            <span class="h-2 w-2 rounded-full bg-[#4D7111]"></span>
                                            Data aktif
                                        </span>
                                    </div>

                                    <div class="my-6">
                                        <h3 class="font-sans text-xl font-bold tracking-tight text-[#1F4B2C]">Cuaca Kota</h3>
                                        <p class="mt-2 text-sm leading-relaxed text-[#3F4743]/80">Suhu, curah hujan, dan indikator mikro cuaca terkini.</p>
                                    </div>

                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <span class="block font-sans text-3xl font-black leading-none text-[#1F4B2C]">{{ temperature }}</span>
                                            <span class="mt-1.5 block max-w-[100px] truncate text-xs font-semibold text-[#3F4743]/60">{{ condition }}</span>
                                        </div>

                                        <router-link :to="{ name: 'data-cuaca' }" class="inline-flex items-center gap-2 rounded-xl bg-[#3F4743] px-4 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-[#1F4B2C] hover:shadow-md active:scale-95">
                                            <span>Lihat data</span>
                                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7-7" />
                                            </svg>
                                        </router-link>
                                    </div>
                                </article>

                                <article class="group relative flex flex-col justify-between overflow-hidden rounded-[2rem] border border-[#D5F5DD] bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-[#1F4B2C]/5 md:col-span-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F4FFFC] text-[#3F4743] transition-transform duration-300 group-hover:scale-110">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                            </svg>
                                        </div>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAFFE9] px-3 py-1 text-xs font-bold text-[#1F4B2C]">
                                            <span class="h-2 w-2 rounded-full bg-[#4D7111]"></span>
                                            Data aktif
                                        </span>
                                    </div>

                                    <div class="my-6">
                                        <h3 class="font-sans text-xl font-bold tracking-tight text-[#1F4B2C]">Lingkungan</h3>
                                        <p class="mt-2 text-sm leading-relaxed text-[#3F4743]/80">Menampilkan jumlah parameter lingkungan beserta nilai indikator, satuan, wilayah, dan tahun pengukuran.</p>
                                    </div>

                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <span class="block font-sans text-3xl font-black leading-none text-[#1F4B2C]">{{ totalParameterLingkungan }}</span>
                                            <span class="mt-1.5 block text-xs font-semibold text-[#3F4743]/60">parameter lingkungan</span>
                                        </div>

                                        <router-link :to="{ name: 'data-lingkungan' }" class="inline-flex items-center gap-2 rounded-xl bg-[#3F4743] px-4 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-[#1F4B2C] hover:shadow-md active:scale-95">
                                            <span>Lihat data</span>
                                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7-7" />
                                            </svg>
                                        </router-link>
                                    </div>
                                </article>

                                <article class="group relative flex flex-col justify-between overflow-hidden rounded-[2rem] border border-[#91EAAF]/20 bg-[#275836] p-7 text-white shadow-xl shadow-[#275836]/10 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl md:col-span-2 lg:col-span-4 lg:flex-row lg:items-center lg:gap-8">
                                    <div class="pointer-events-none absolute -bottom-10 -right-10 h-48 w-48 rounded-full bg-[#C3E956]/10 blur-2xl" aria-hidden="true"></div>

                                    <div class="flex items-center justify-between lg:flex-col lg:items-start lg:gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-[#91EAAF]/20 bg-[#1F4B2C] text-[#C3E956] transition-transform duration-300 group-hover:scale-110">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="6" width="20" height="8" rx="1" />
                                                <path d="M17 14v7" />
                                                <path d="M7 14v7" />
                                                <path d="M12 14v7" />
                                            </svg>
                                        </div>

                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#91EAAF]/20 bg-[#1F4B2C] px-3 py-1 text-xs font-bold text-[#91EAAF]">
                                            <span class="h-2 w-2 rounded-full bg-[#C3E956]"></span>
                                            Data aktif
                                        </span>
                                    </div>

                                    <div class="my-6 lg:my-0 lg:flex-1">
                                        <h3 class="font-sans text-xl font-bold tracking-tight text-white">Infrastruktur Kota</h3>
                                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-[#91EAAF]/90">Menampilkan data aset infrastruktur berdasarkan jenis, nama aset, lokasi, tahun, nilai data, satuan, dan kondisi aset.</p>
                                    </div>

                                    <div class="flex items-end justify-between gap-6 lg:items-center">
                                        <div>
                                            <span class="block font-sans text-3xl font-black leading-none text-[#C3E956]">{{ totalInfrastruktur }}%</span>
                                            <span class="mt-1.5 block text-xs font-medium text-[#91EAAF]">aset kondisi baik</span>
                                        </div>

                                        <router-link :to="{ name: 'data-infrastruktur' }" class="inline-flex items-center gap-2 rounded-xl bg-[#C3E956] px-5 py-3 text-xs font-black text-[#1F4B2C] transition-all duration-200 hover:bg-[#91EAAF] hover:shadow-lg hover:shadow-[#C3E956]/20 active:scale-95">
                                            <span>Lihat data</span>
                                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <path d="M5 12h14M12 5l7 7-7-7" />
                                            </svg>
                                        </router-link>
                                    </div>
                                </article>
                            </section>
                        </div>
                    </main>

                    <footer class="fixed bottom-0 left-0 right-0 z-40 flex h-15 items-center justify-center border-t border-[var(--color-mint-200)] bg-white/95 px-4 backdrop-blur-md lg:left-64">
                        <div class="flex items-center justify-center">
                            <p class="text-xs text-[var(--color-brand-deep)]/80">
                                © Semua nama sumber telah dicantumkan pada detail card dan diambil pada tahun <span class="font-bold text-[var(--color-brand-active)] transition">{{ new Date().getFullYear() }}</span>
                            </p>
                        </div>
                    </footer>

                    
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import Header from '../components/layout/Header2.vue'
import { ref, computed, onMounted } from 'vue'

import { useJalan } from '../scriptViews/jalan/main.js'
import { useCuaca } from '../scriptViews/cuaca/main.js'
import { useLingkungan } from '../scriptViews/lingkungan/main.js'
import { useInfrastruktur } from '../scriptViews/infrastruktur/main.js'

const {
    stats: jalanStats,
    getDataJalan,
} = useJalan({
    autoInit: false,
})


// Cuaca
const {
    currentWeather,
    fetchWeatherData,
} = useCuaca({
    autoInit: false,
})


// Lingkungan
const {
    environmentalRiskDisplay,
    loadEnvironmentalData,
} = useLingkungan({
    autoLoad: false,
})


// Infrastruktur
const {
    totalData: infrastructureTotalData,
    conditionCounts: infrastructureConditionCounts,
    loadInfrastructureData,
} = useInfrastruktur({
    autoLoad: false,
})

const totalJalan = computed(() => {
    return jalanStats.value?.totalRuas ?? 0
})


const temperature = computed(() => {
    const weather = currentWeather.value

    if (!weather) {
        return '—'
    }

    const temp =
        weather.t ??
        weather.temperature ??
        weather.suhu

    if (
        temp === null ||
        temp === undefined ||
        temp === ''
    ) {
        return '—'
    }

    return `${temp}°C`
})


const condition = computed(() => {
    const weather = currentWeather.value

    if (!weather) {
        return 'Memuat cuaca...'
    }

    return (
        weather.weather_desc ??
        weather.weatherDesc ??
        weather.condition ??
        'Data cuaca tersedia'
    )
})


const totalParameterLingkungan = computed(() => {
    return environmentalRiskDisplay.value ?? '—'
})


const totalInfrastruktur = computed(() => {
    const total = infrastructureTotalData.value ?? 0
    const baik = infrastructureConditionCounts.value?.Baik ?? 0

    if (total === 0) {
        return 0
    }

    return Math.round((baik / total) * 100)
})

const dataSource = ref({
    name: 'BMKG',
    fullName:
        'Badan Meteorologi, Klimatologi, dan Geofisika',
    url:
        'https://data.bmkg.go.id/prakiraan-cuaca/',
})

async function loadDashboardData() {
    await Promise.all([
        getDataJalan(),
        fetchWeatherData(),
        loadEnvironmentalData(),
        loadInfrastructureData(),
    ])
}

onMounted(() => {
    loadDashboardData()
})
</script>