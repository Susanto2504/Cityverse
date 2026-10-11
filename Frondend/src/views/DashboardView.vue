<template>
    <div class="min-h-screen bg-[#F4FFFC] font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased selection:bg-[#C3E956] selection:text-[#1F4B2C]">
        <Header title="Dashboard" @toggle-sidebar="$emit('toggle-sidebar')" />

        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
            <div class="tab-panel space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                    <div class="bg-white rounded-2xl p-5 border border-emerald-900/5 shadow-sm flex items-center justify-between hover:shadow-md transition" data-purpose="stat-card">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 mb-1">Resiko Perkotaan</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-4xl font-extrabold text-slate-900">{{ risikoPerkotaan }}%</h3>
                                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md" :class="{ 'text-emerald-600 bg-emerald-50': risikoPerkotaan < 30,
                                'text-amber-600 bg-amber-50': risikoPerkotaan >= 30 && risikoPerkotaan < 60,
                                'text-red-600 bg-red-50': risikoPerkotaan >= 60}">
                                    {{ statusRisikoPerkotaan }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-2 font-medium">
                                Berdasarkan kalkulasi 4 sektor kota
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-800 text-3xl">
                            <i class="fa-solid fa-city text-emerald-800"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-emerald-900/5 shadow-sm flex items-center justify-between hover:shadow-md transition" data-purpose="stat-card">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 mb-1">Populasi Kota</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-4xl font-extrabold text-slate-900">
                                    {{ formatPopulasi(populasiKota) }}
                                </h3>
                                <span v-if="populasiLoading" class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">
                                    Memuat
                                </span>
                                <span v-else-if="populasiError" class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-md">
                                    Gagal
                                </span>
                                <span v-else class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                                    Tahun 2025
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-2 font-medium">
                                Data diambil dari <span class="font-bold">Satu Data Makassar (BPS) 2025</span>
                            </p>
                        </div>
                        <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-500 text-3xl">
                            <i class="fa-solid fa-circle-user text-sky-500"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-emerald-900/10 p-4 md:p-6 shadow-sm w-full" data-purpose="map-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-map-location-dot text-emerald-700"></i>
                            <h3 class="text-sm md:text-base font-bold text-slate-800">
                                Peta Kota - Zona Makassar Metro Live Grid
                            </h3>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-3 text-[10px] font-semibold">
                                <div class="flex items-center gap-1">
                                    <span class="w-3 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span class="text-slate-500">Lancar</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="w-3 h-1.5 rounded-full bg-amber-500"></span>
                                    <span class="text-slate-500">Sedang</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="w-3 h-1.5 rounded-full bg-rose-500"></span>
                                    <span class="text-slate-500">Macet</span>
                                </div>
                            </div>

                            <button @click="resetMapView" class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-md transition">
                                <i class="fa-solid fa-arrows-rotate mr-1"></i>
                                Reset View
                            </button>
                        </div>
                    </div>

                    <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] rounded-xl overflow-hidden border border-slate-200 z-0">
                        <div ref="mapContainer" class="w-full h-full"></div>

                        <div class="absolute bottom-2 left-2 bg-white/80 backdrop-blur-sm px-2 py-0.5 rounded text-[10px] text-slate-600 font-medium z-[1000] border border-slate-200 pointer-events-none">
                            Makassar GIS Live Engine © 2026 CityVerse
                        </div>

                        <div v-if="jalanLoading" class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md border border-slate-200 z-[1000] text-xs font-semibold text-slate-600">
                            <i class="fa-solid fa-circle-notch animate-spin text-emerald-600 mr-1"></i>
                            Memuat data jalan...
                        </div>

                        <div v-else-if="jalanError" class="absolute top-3 right-3 bg-red-50/95 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md border border-red-200 z-[1000] text-xs font-semibold text-red-600">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                            Gagal memuat data jalan
                        </div>

                        <div v-else class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md border border-slate-200 z-[1000] text-xs font-semibold text-slate-600">
                            <i class="fa-solid fa-road text-emerald-600 mr-1"></i>
                            {{ jalanData.length }} Ruas Jalan
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-7 xl:col-span-7" data-purpose="risk-overview-section">
                        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-3 tracking-tight">
                            Risk Overview
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white rounded-2xl p-4 border border-emerald-900/5 shadow-sm flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                        <span class="text-xs font-bold text-slate-600">Banjir</span>
                                    </div>

                                    <div class="text-3xl font-extrabold text-slate-900 mt-1">
                                        {{ persentaseBanjir }}%
                                    </div>

                                    <div class="w-28 bg-slate-100 rounded-full h-1.5 mt-2">
                                        <div class="bg-blue-600 h-1.5 rounded-full" :style="{ width: persentaseBanjir + '%' }"></div>
                                    </div>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                                    <i class="fa-solid fa-house-flood-water"></i>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-4 border border-emerald-900/5 shadow-sm flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                        <span class="text-xs font-bold text-slate-600">Infrastruktur</span>
                                    </div>

                                    <div class="text-3xl font-extrabold text-slate-900 mt-1">
                                        {{ persentaseInfrastruktur }}%
                                    </div>

                                    <div class="w-28 bg-slate-100 rounded-full h-1.5 mt-2">
                                        <div class="bg-amber-500 h-1.5 rounded-full" :style="{ width: `${persentaseInfrastruktur}%` }"></div>
                                    </div>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl">
                                    <i class="fa-solid fa-building-circle-check"></i>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-4 border border-emerald-900/5 shadow-sm flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                                        <span class="text-xs font-bold text-slate-600">Lingkungan</span>
                                    </div>

                                    <div class="text-3xl font-extrabold text-slate-900 mt-1">
                                        {{ environmentalRiskDisplay }}
                                    </div>

                                    <div class="w-28 bg-slate-100 rounded-full h-1.5 mt-2">
                                        <div class="bg-emerald-600 h-1.5 rounded-full" :style="{ width: `${environmentalRisk ?? 0}%` }"></div>
                                    </div>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl">
                                    <i class="fa-solid fa-tree"></i>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl p-4 border border-emerald-900/5 shadow-sm flex items-center justify-between">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                        <span class="text-xs font-bold text-slate-600">Macet</span>

                                    </div>

                                    <div class="text-3xl font-extrabold text-slate-900 mt-1">
                                        {{ persentaseMacet }}%
                                    </div>

                                    <div class="w-28 bg-slate-100 rounded-full h-1.5 mt-2">
                                        <div class="bg-rose-500 h-1.5 rounded-full transition-all duration-500" :style="{ width: `${persentaseMacet}%` }"></div>
                                    </div>
                                </div>

                                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl">
                                    <i class="fa-solid fa-car-side"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 xl:col-span-5 flex flex-col">
                        <div class="bg-white rounded-2xl p-5 border border-emerald-900/5 shadow-sm h-full">

                            <!-- HEADER -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-base font-bold text-slate-800 tracking-tight">
                                        Kondisi Jalan
                                    </h3>

                                    <p class="text-[11px] text-slate-400 font-medium mt-1">
                                        Persentase kondisi seluruh segmen jalan
                                    </p>
                                </div>

                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                            </div>

                            <!-- PIE CHART -->
                            <div class="flex justify-center py-4">

                                <div
                                    class="w-52 h-52 rounded-full"
                                    :style="{
                                        background: roadConditionGradient
                                    }"
                                ></div>

                            </div>

                            <!-- LEGEND -->
                            <div class="grid grid-cols-2 gap-x-5 gap-y-3 mt-2">

                                <!-- NORMAL -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>

                                        <span class="text-[11px] font-semibold text-slate-600">
                                            Normal
                                        </span>
                                    </div>

                                    <span class="text-[11px] font-bold text-slate-800">
                                        {{ roadConditionPercentages.normal }}%
                                    </span>
                                </div>

                                <!-- LONGSOR -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-700"></span>

                                        <span class="text-[11px] font-semibold text-slate-600">
                                            Longsor
                                        </span>
                                    </div>

                                    <span class="text-[11px] font-bold text-slate-800">
                                        {{ roadConditionPercentages.longsor }}%
                                    </span>
                                </div>

                                <!-- BANJIR -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>

                                        <span class="text-[11px] font-semibold text-slate-600">
                                            Banjir
                                        </span>
                                    </div>

                                    <span class="text-[11px] font-bold text-slate-800">
                                        {{ roadConditionPercentages.banjir }}%
                                    </span>
                                </div>

                                <!-- MACET -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>

                                        <span class="text-[11px] font-semibold text-slate-600">
                                            Macet
                                        </span>
                                    </div>

                                    <span class="text-[11px] font-bold text-slate-800">
                                        {{ roadConditionPercentages.macet }}%
                                    </span>
                                </div>

                                <!-- LAINNYA -->
                                <div class="flex items-center justify-between col-span-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>

                                        <span class="text-[11px] font-semibold text-slate-600">
                                            Lainnya
                                        </span>
                                    </div>

                                    <span class="text-[11px] font-bold text-slate-800">
                                        {{ roadConditionPercentages.lainnya }}%
                                    </span>
                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">

                                <span class="text-[11px] text-slate-400 font-medium">
                                    Total segmen jalan
                                </span>

                                <span class="text-[11px] font-bold text-emerald-700">
                                    {{ totalRoadSegments }} Segmen
                                </span>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4" id="modal-edit-data">
            <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-100">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">
                        Perbarui Parameter Kota Makassar
                    </h3>

                    <button class="text-slate-400 hover:text-slate-600" onclick="closeModalEditData()">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="space-y-3.5 my-4 text-xs">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">
                            Populasi Saat Ini
                        </label>

                        <input class="w-full text-xs rounded-xl border-slate-200 p-2.5" id="input-populasi" type="text" :value="formatPopulasi(populasiKota)" readonly />
                    </div>

                    <div>
                        <label class="font-bold text-slate-700 block mb-1">
                            Tingkat Resiko Perkotaan (%)
                        </label>

                        <input class="w-full text-xs rounded-xl border-slate-200 p-2.5" id="input-resiko" type="number" value="62" />
                    </div>

                    <div>
                        <label class="font-bold text-slate-700 block mb-1">
                            Catatan Operasional Wilayah
                        </label>

                        <textarea class="w-full text-xs rounded-xl border-slate-200 p-2.5" rows="2">Status darurat genangan air wilayah Panakkukang dan Toddopuli dalam penanganan.</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl" onclick="closeModalEditData()">
                        Batal
                    </button>

                    <button class="px-5 py-2 bg-brand-deep text-white text-xs font-bold rounded-xl hover:bg-emerald-900" onclick="saveDataKota()">
                        Simpan Pembaruan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import Header from '@/components/layout/Header1.vue'
import { useLingkungan } from '../scriptViews/lingkungan/main.js'
import { useInfrastruktur } from '../scriptViews/infrastruktur/main.js'
import { useNotifications } from '../composables/useNotifications.js'
import { useJalan } from '../scriptViews/jalan/main.js'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png'
import markerIcon from 'leaflet/dist/images/marker-icon.png'
import markerShadow from 'leaflet/dist/images/marker-shadow.png'

const API_BASE = import.meta.env.VITE_API_URL;

defineEmits(['toggle-sidebar'])

delete L.Icon.Default.prototype._getIconUrl

L.Icon.Default.mergeOptions({
    iconUrl: markerIcon,
    iconRetinaUrl: markerIcon2x,
    shadowUrl: markerShadow
})

const mapContainer = ref(null)
let map = null
let polylineGroup = null
let markerGroup = null
let mapRenderer = null
let searchMarker = null
let debounceTimer = null

const searchQuery = ref('')
const searchResults = ref([])
const isSearching = ref(false)
const showDropdown = ref(false)

const populasiKota = ref(0)
const populasiLoading = ref(true)
const populasiError = ref(false)

const jalanLoading = ref(false)
const jalanError = ref(false)

const {
    listJalan,
    getDataJalan,
} = useJalan({
    autoInit: false,
})

const jalanData = listJalan

const {
    environmentalRisk,
    environmentalRiskDisplay,
    loading: lingkunganLoading,
    errorMessage: lingkunganError
} = useLingkungan()

const {
    percentageGood: persentaseInfrastruktur,
    conditionCounts: infrastructureConditionCounts,
    loadInfrastructureData
} = useInfrastruktur({
    autoLoad: false
})


const INITIAL_COORDS = [-5.14, 119.4]
const INITIAL_ZOOM = 13

const formatPopulasi = (value) => {
    if (value === null || value === undefined || value === '') {
        return '0'
    }

    const number = Number(value)

    if (!Number.isFinite(number)) {
        return '0'
    }

    return new Intl.NumberFormat('id-ID').format(number)
}

const persentaseMacet = computed(() => {
    const allSegments = jalanData.value.flatMap((jalan) =>
        Array.isArray(jalan.segmen_jalans)
            ? jalan.segmen_jalans
            : []
    )

    const total = allSegments.length

    if (total === 0) {
        return 0
    }

    const jumlahMacet = allSegments.filter(
        (segmen) => segmen.tingkat_kepadatan === 'Macet'
    ).length

    return Math.round((jumlahMacet / total) * 100)
})

const totalRoadSegments = computed(() => {
    return jalanData.value.flatMap((jalan) =>
        Array.isArray(jalan.segmen_jalans)
            ? jalan.segmen_jalans
            : []
    ).length
})

const roadConditionCounts = computed(() => {
    const allSegments = jalanData.value.flatMap((jalan) =>
        Array.isArray(jalan.segmen_jalans)
            ? jalan.segmen_jalans
            : []
    )

    const counts = {
        normal: 0,
        longsor: 0,
        banjir: 0,
        lainnya: 0,
        macet: 0
    }

    allSegments.forEach((segmen) => {
        const kondisiJalan = String(segmen.kondisi_jalan ?? '')
            .trim()
            .toLowerCase()

        const tingkatKepadatan = String(segmen.tingkat_kepadatan ?? '')
            .trim()
            .toLowerCase()

        // 1. KONDISI JALAN: BANJIR
        if (kondisiJalan === 'banjir') {
            counts.banjir++
        }

        // 2. KONDISI JALAN: LONGSOR
        else if (kondisiJalan === 'longsor') {
            counts.longsor++
        }

        // 3. KONDISI JALAN: LAINNYA
        else if (kondisiJalan === 'lainnya') {
            counts.lainnya++
        }

        // 4. KONDISI NORMAL TAPI KEPADATAN MACET
        else if (
            kondisiJalan === 'normal' &&
            tingkatKepadatan === 'macet'
        ) {
            counts.macet++
        }

        // 5. NORMAL
        else {
            counts.normal++
        }
    })

    return counts
})

const roadConditionPercentages = computed(() => {
    const counts = roadConditionCounts.value

    const total = Object.values(counts).reduce(
        (sum, value) => sum + value,
        0
    )

    if (total === 0) {
        return {
            normal: 0,
            longsor: 0,
            banjir: 0,
            lainnya: 0,
            macet: 0
        }
    }

    return {
        normal: Number(((counts.normal / total) * 100).toFixed(2)),
        longsor: Number(((counts.longsor / total) * 100).toFixed(2)),
        banjir: Number(((counts.banjir / total) * 100).toFixed(2)),
        lainnya: Number(((counts.lainnya / total) * 100).toFixed(2)),
        macet: Number(((counts.macet / total) * 100).toFixed(2))
    }
})

const roadConditionGradient = computed(() => {
    const percentages = roadConditionPercentages.value

    const normal = percentages.normal
    const longsor = percentages.longsor
    const banjir = percentages.banjir
    const macet = percentages.macet
    const lainnya = percentages.lainnya

    const longsorStart = normal
    const banjirStart = normal + longsor
    const macetStart = normal + longsor + banjir
    const lainnyaStart = normal + longsor + banjir + macet

    return `
        conic-gradient(
            #10b981 0% ${normal}%,
            #b45309 ${longsorStart}% ${banjirStart}%,
            #3b82f6 ${banjirStart}% ${macetStart}%,
            #f43f5e ${macetStart}% ${lainnyaStart}%,
            #94a3b8 ${lainnyaStart}% 100%
        )
    `
})

const totalMacet = computed(() => {
    const allSegments = jalanData.value.flatMap((jalan) =>
        Array.isArray(jalan.segmen_jalans)
            ? jalan.segmen_jalans
            : []
    )

    return allSegments.filter(
        (segmen) => segmen.tingkat_kepadatan === 'Macet'
    ).length
})



const totalBanjir = computed(() => {
    const allSegments = jalanData.value.flatMap((jalan) =>
        Array.isArray(jalan.segmen_jalans)
            ? jalan.segmen_jalans
            : []
    )

    return allSegments.filter(
        (segmen) =>
            String(segmen.kondisi_jalan || '')
                .trim()
                .toLowerCase() === 'banjir'
    ).length
})

const totalAsetBaik = computed(() => {
    return Number(infrastructureConditionCounts.value?.Baik ?? 0)
})

const totalLingkungan = computed(() => {
    return Number(environmentalRisk.value ?? 0)
})

const totalRisikoPerkotaan = computed(() => {
    return (
        Number(totalMacet.value ?? 0) +
        Number(totalBanjir.value ?? 0) +
        Number(totalLingkungan.value ?? 0)
    )
})

const risikoPerkotaan = computed(() => {
    const macet = Number(persentaseMacet.value ?? 0)
    const banjir = Number(persentaseBanjir.value ?? 0)
    const lingkungan = Number(environmentalRisk.value ?? 0)

    // Infrastruktur yang baik dibalik menjadi risiko
    const risikoInfrastruktur =
        100 - Number(persentaseInfrastruktur.value ?? 0)

    const total =
        macet +
        banjir +
        lingkungan +
        risikoInfrastruktur

    return Math.round(total / 4)
})

const statusRisikoPerkotaan = computed(() => {
    const risiko = risikoPerkotaan.value

    if (risiko < 30) {
        return 'Aman'
    }

    if (risiko < 60) {
        return 'Waspada'
    }

    return 'Tinggi'
})

const getPopulasiKota = async () => {
    populasiLoading.value = true
    populasiError.value = false

    try {
        const response = await fetch(`${API_BASE}/api/satu-data/2025`, {
            method: 'GET',
            credentials: 'include',
            headers: {
                Accept: 'application/json'
            }
        })

        if (!response.ok) {
            throw new Error(`HTTP Error ${response.status}`)
        }

        const data = await response.json()

        const rows = Array.isArray(data.data)
            ? data.data
            : Array.isArray(data)
                ? data
                : [];

        console.log('[POPULASI] Respons API:', data);

        const populasiData = rows.find((item) => {
            const noRef = String(
                item?.elemen_data_r?.no_ref ??
                item?.elemen_data?.no_ref ??
                ''
            ).trim();

            return noRef === 'K01153';
        });

        if (!populasiData) {
            throw new Error('Data K01153 tidak ditemukan')
        }

        populasiKota.value = Number(populasiData.jumlah)
    } catch (error) {
        console.error('Gagal mengambil data populasi:', error)
        populasiError.value = true
        populasiKota.value = 0
    } finally {
        populasiLoading.value = false
    }
}

const initMap = () => {
    map = L.map(mapContainer.value, {
        zoomControl: true
    }).setView(INITIAL_COORDS, INITIAL_ZOOM)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map)

    polylineGroup = L.featureGroup().addTo(map)
    markerGroup = L.featureGroup().addTo(map)

    mapRenderer = L.canvas({
        padding: 0.5
    })
}

const getRoadColor = (segmen) => {
    const kondisi = String(segmen?.kondisi_jalan || '')
        .trim()
        .toLowerCase()

    // BANJIR
    if (kondisi === 'banjir') {
        return '#2563eb'
    }

    // LONGSOR
    if (kondisi === 'longsor') {
        return '#92400e'
    }

    // LANCAR
    if (segmen?.tingkat_kepadatan === 'Lancar') {
        return '#10b981'
    }

    // SEDANG
    if (segmen?.tingkat_kepadatan === 'Sedang') {
        return '#f59e0b'
    }

    // MACET
    if (segmen?.tingkat_kepadatan === 'Macet') {
        return '#ef4444'
    }

    return '#64748b'
}

const normalizeGeometry = (item) => {
    let coords = item?.koordinat_geometri

    if (typeof coords === 'string') {
        try {
            coords = JSON.parse(coords)
        } catch (error) {
            console.error('Geometry tidak valid:', error)
            return []
        }
    }

    if (!Array.isArray(coords)) {
        return []
    }

    return coords
        .filter((point) => {
            return (
                Array.isArray(point) &&
                point.length >= 2 &&
                Number.isFinite(Number(point[0])) &&
                Number.isFinite(Number(point[1]))
            )
        })
        .map((point) => [
            Number(point[0]),
            Number(point[1])
        ])
}

const getRoadSegments = (jalan) => {
    if (!Array.isArray(jalan?.segmen_jalans)) {
        return []
    }

    return jalan.segmen_jalans
}

const getConditionMarkerColor = (kondisi) => {
  const value = String(kondisi || '').trim().toLowerCase()

  if (value === 'banjir') return '#2563eb'
  if (value === 'longsor') return '#92400e'

  return '#ef4444'
}

const createConditionMarker = (segmen, coords, namaJalan) => {
  const kondisi = String(segmen?.kondisi_jalan || '')
    .trim()
    .toLowerCase()

  // Tidak membuat marker kalau kosong atau NORMAL
  if (!kondisi || kondisi === 'normal' || coords.length < 2) {
    return null
  }

  const middleIndex = Math.floor(coords.length / 2)
  const middlePoint = coords[middleIndex]

  const color = getConditionMarkerColor(kondisi)

  const markerIcon = L.divIcon({
    className: 'condition-marker-wrapper',
    html: `
      <div
        style="
          width: 22px;
          height: 22px;
          background: ${color};
          border: 3px solid white;
          border-radius: 50%;
          box-shadow: 0 2px 6px rgba(0,0,0,0.35);
          display: flex;
          align-items: center;
          justify-content: center;
        "
      >
        <i
          class="fa-solid fa-triangle-exclamation"
          style="
            color: white;
            font-size: 10px;
          "
        ></i>
      </div>
    `,
    iconSize: [22, 22],
    iconAnchor: [11, 11],
    popupAnchor: [0, -12]
  })

  return L.marker(middlePoint, {
    icon: markerIcon,
    zIndexOffset: 1000
  }).bindPopup(`
    <div style="min-width:220px">
      <strong>${namaJalan ?? 'Tidak bernama'}</strong>

      <br><br>

      <span style="color:${color}; font-weight:700; text-transform:uppercase">
        ${kondisi}
      </span>

      <br><br>

      Panjang kondisi:
      ${Number(segmen.panjang_kondisi_m || 0).toFixed(2)} m

      <br>

      Segmen OSM:
      ${segmen.osm_id ?? '-'}
    </div>
  `)
}

const renderGeometriesOnMap = () => {
    if (!polylineGroup || !mapRenderer || !markerGroup) {
        return
    }

    polylineGroup.clearLayers()
    markerGroup.clearLayers()

    for (const jalan of jalanData.value) {
        const segments = getRoadSegments(jalan)

        for (const segmen of segments) {
            const coords = normalizeGeometry(segmen)

            if (coords.length < 2) {
                continue
            }

            const polyline = L.polyline(coords, {
                renderer: mapRenderer,
                color: getRoadColor(segmen),
                weight: 5,
                opacity: 0.8,
                lineCap: 'round',
                lineJoin: 'round'
            })

            const kapasitas =
                segmen.kapasitas_jalan != null
                    ? Number(segmen.kapasitas_jalan).toLocaleString()
                    : '-'

            const volume =
                segmen.volume_kendaraan != null
                    ? Number(segmen.volume_kendaraan).toLocaleString()
                    : '-'

            polyline.bindPopup(`
                <div style="min-width:220px">
                    <strong>
                        ${jalan.nama_ruas_jalan ?? 'Tidak bernama'}
                    </strong>

                    <br><br>

                    <span style="color:#64748b">
                        Segmen OSM:
                        ${segmen.osm_id ?? '-'}
                    </span>

                    <br><br>

                    Panjang:
                    ${Number(segmen.panjang_m || 0).toFixed(2)} m

                    <br>

                    Tipe:
                    ${segmen.tipe_jalan_detail ?? '-'}

                    <br>

                    Kapasitas:
                    ${kapasitas} smp/jam

                    <br>

                    Volume:
                    ${volume} kend/jam

                    <br>

                    Kepadatan:
                    <strong style="color:${getRoadColor(segmen)}">
                        ${segmen.tingkat_kepadatan ?? '-'}
                    </strong>
                </div>
            `)

            polyline.on('mouseover', function () {
                this.setStyle({
                    weight: 7,
                    opacity: 1
                })
            })

            polyline.on('mouseout', function () {
                this.setStyle({
                    weight: 5,
                    opacity: 0.9
                })
            })

            polylineGroup.addLayer(polyline)
            const conditionMarker = createConditionMarker(
                segmen,
                coords,
                jalan.nama_ruas_jalan
            )

            if (conditionMarker) {
            markerGroup.addLayer(conditionMarker)
            }
        }
    }
}

const getJalan = async () => {
    try {
        jalanLoading.value = true
        jalanError.value = false

        await getDataJalan()

        console.log('=== DISTRIBUSI KONDISI JALAN ===')
        console.table(
            jalanData.value
                .flatMap((jalan) => Array.isArray(jalan.segmen_jalans) ? jalan.segmen_jalans : [])
                .reduce((acc, segmen) => {
                    const kondisi = String(segmen.kondisi_jalan ?? '').trim()
                    const key = kondisi || '(KOSONG)'

                    acc[key] = (acc[key] || 0) + 1

                    return acc
                }, {})
        )

        console.log(
            'TOTAL BANJIR:',
            jalanData.value
                .flatMap((jalan) =>
                    Array.isArray(jalan.segmen_jalans)
                        ? jalan.segmen_jalans
                        : []
                )
                .filter((segmen) =>
                    String(segmen.kondisi_jalan ?? '')
                        .trim()
                        .toLowerCase() === 'banjir'
                ).length
        )

        console.log('Data jalan dari Store:', jalanData.value.length)

        const allSegments = jalanData.value.flatMap((jalan) =>
            Array.isArray(jalan.segmen_jalans)
                ? jalan.segmen_jalans
                : []
        )

        console.log(
            'Jumlah segmen macet:',
            allSegments.filter(
                (segmen) => segmen.tingkat_kepadatan === 'Macet'
            ).length
        )

        console.log(
            'Persentase macet:',
            persentaseMacet.value
        )

        renderGeometriesOnMap()

    } catch (error) {
        console.error('Gagal mengambil data jalan:', error)
        jalanError.value = true
    } finally {
        jalanLoading.value = false
    }
}

const onSearchInput = () => {
    clearTimeout(debounceTimer)

    if (!searchQuery.value.trim() || searchQuery.value.length < 3) {
        searchResults.value = []
        showDropdown.value = false
        isSearching.value = false
        return
    }

    isSearching.value = true
    showDropdown.value = true

    debounceTimer = setTimeout(async () => {
        try {
            const endpoint = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery.value)}&viewbox=119.3000,-5.2500,119.5000,-5.0500&limit=5`

            const response = await fetch(endpoint, {
                headers: {
                    Accept: 'application/json'
                }
            })

            if (!response.ok) {
                throw new Error(`HTTP Error ${response.status}`)
            }

            const data = await response.json()

            searchResults.value = data || []
        } catch (error) {
            console.error('Error fetching search results:', error)
            searchResults.value = []
        } finally {
            isSearching.value = false
        }
    }, 300)
}

const selectLocation = (item) => {
    showDropdown.value = false

    searchQuery.value = item.name || item.display_name.split(',')[0]

    const lat = parseFloat(item.lat)
    const lon = parseFloat(item.lon)
    const targetCoords = [lat, lon]

    map.setView(targetCoords, 17)

    if (searchMarker) {
        map.removeLayer(searchMarker)
    }

    searchMarker = L.marker(targetCoords)
        .addTo(map)
        .bindPopup(`
            <div style="font-family: sans-serif; max-width: 220px;">
                <b style="color: #065f46; font-size: 12px;">Lokasi Dipilih</b>
                <br>
                <span style="font-size: 11px; color: #334155;">${item.display_name}</span>
            </div>
        `)
        .openPopup()
}

const clearSearch = () => {
    searchQuery.value = ''
    searchResults.value = []
    showDropdown.value = false

    if (searchMarker) {
        map.removeLayer(searchMarker)
        searchMarker = null
    }
}

const resetMapView = () => {
    clearSearch()

    if (map) {
        map.setView(INITIAL_COORDS, INITIAL_ZOOM)
    }
}

const handleOutsideClick = (event) => {
    if (!event.target.closest('.relative')) {
        showDropdown.value = false
    }
}

onMounted(async () => {
    getPopulasiKota()
    loadInfrastructureData()

    await new Promise((resolve) => setTimeout(resolve, 100))

    if (mapContainer.value) {
        initMap()
        await getJalan()
    }

    document.addEventListener('click', handleOutsideClick)
})

onUnmounted(() => {
    clearTimeout(debounceTimer)
    document.removeEventListener('click', handleOutsideClick)

    if (map) {
        map.remove()
        map = null
    }

    polylineGroup = null
    mapRenderer = null
    markerGroup = null
})

const persentaseBanjir = computed(() => {
    const allSegments = jalanData.value.flatMap((jalan) => Array.isArray(jalan.segmen_jalans) ? jalan.segmen_jalans : [])

    const totalTinggiBanjir = allSegments
        .filter((segmen) => String(segmen.kondisi_jalan || '').trim().toLowerCase() === 'banjir')
        .reduce((total, segmen) => total + Number(segmen.panjang_kondisi_m || 0), 0)
    return Math.min(totalTinggiBanjir, 100)
})
</script>

<style scoped>
</style>