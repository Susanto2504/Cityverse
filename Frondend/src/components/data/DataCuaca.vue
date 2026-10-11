<template>
  <!-- Wrapper luar: w-full + h-dvh -->
  <div class="flex h-dvh w-full flex-col overflow-hidden bg-[var(--color-mint-50)]">
    
    <!-- Header -->
    <Header title="Data Cuaca" data="Kota Makassar" />

    <!-- Main Content -->
    <main class="flex-1 min-h-0 overflow-y-auto space-y-6 px-4 py-6 font-[var(--font-sans)] text-[var(--color-brand-deep)] sm:px-6 lg:px-8">
      
      <!-- State Loading -->
      <div v-if="loading" class="flex min-h-[400px] flex-col items-center justify-center gap-3">
        <div class="h-10 w-10 animate-spin rounded-full border-4 border-[var(--color-brand-sidebar)] border-t-[var(--color-brand-bright)]"></div>
        <p class="text-sm font-medium text-[var(--color-brand-sidebar)]">Memuat data cuaca dari database...</p>
      </div>

      <!-- State Error -->
      <div v-else-if="error" class="rounded-3xl bg-red-50 p-6 text-center text-red-700 ring-1 ring-red-200">
        <p class="font-semibold">{{ error }}</p>
        <button @click="initData" class="mt-4 rounded-xl bg-[var(--color-brand-deep)] px-4 py-2 text-xs font-semibold text-white hover:opacity-90">
          Coba Lagi
        </button>
      </div>

      <template v-else>
        <!-- Banner Utama -->
        <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[var(--color-brand-deep)] via-[var(--color-brand-sidebar)] to-[var(--color-brand-active)] p-6 text-white shadow-xl sm:p-8">
          <div class="pointer-events-none absolute -right-12 -top-12 h-72 w-72 rounded-full bg-[var(--color-brand-bright)]/20 blur-3xl" />
          
          <div class="relative flex flex-col justify-between gap-8 md:flex-row md:items-center">
            <div>
              <!-- Dropdown Select Lokasi dari WilayahController -->
              <div class="relative w-full">
                <select
                  id="kelurahan-select"
                  v-model="selectedAdm4"
                  @change="fetchWeatherData"
                  class="w-full cursor-pointer appearance-none rounded-xl bg-white px-3.5 py-2.5 pr-8 text-xs font-semibold text-[var(--color-brand-deep)] shadow-sm ring-1 ring-[var(--color-mint-200)] transition-all focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-bright)]"
                >
                  <option 
                    v-for="item in filteredMakassarList" 
                    :key="item.code" 
                    :value="item.code"
                    class="text-gray-900 bg-white py-1"
                  >
                    {{ item.name }} {{ item.kecamatan ? `(${item.kecamatan})` : '' }}
                  </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-[var(--color-brand-deep)]">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>

              <div class="mt-3 text-xs text-[var(--color-mint-200)]/90 space-y-0.5">
                <p class="font-semibold">Tanggal: <span class="text-white">{{ formatDateOnly(currentWeather?.waktu_prakiraan) }}</span></p>
              </div>
              
              <!-- Suhu & Deskripsi -->
              <div class="mt-4 flex items-baseline gap-3">
                <span class="text-7xl font-extrabold tracking-tight leading-none">{{ currentWeather?.suhu ?? '--' }}°C</span>
                <div>
                  <p class="text-lg font-bold text-[var(--color-brand-accent)]">{{ currentWeather?.keterangan_cuaca ?? '-' }}</p>
                </div>
              </div>

              <!-- Jam Realtime -->
              <div class="mt-3 text-lg text-[var(--color-mint-200)]/90 space-y-0.5">
                <p class="font-semibold">
                  <span class="font-mono text-white font-bold">{{ currentTime }} WITA</span>
                </p>
              </div>
            </div>

            <!-- Visual & Stats -->
            <div class="flex flex-col items-center gap-4">
              <img 
                v-if="currentWeather?.gambar_cuaca"
                :src="currentWeather?.gambar_cuaca" 
                :alt="currentWeather?.keterangan_cuaca" 
                class="h-28 w-28 drop-shadow-lg transition-transform duration-500 hover:scale-105"
              />
              
              <div class="flex gap-4 rounded-2xl bg-white/10 p-3.5 text-xs font-medium backdrop-blur-md ring-1 ring-white/15">
                <div class="flex items-center gap-1.5">
                  <span class="text-[var(--color-mint-200)]">Kelembapan:</span>
                  <span class="font-bold">{{ currentWeather?.kelembapan ?? '--' }}%</span>
                </div>
                <div class="h-4 w-[1px] bg-white/20"></div>
                <div class="flex items-center gap-1.5">
                  <span class="text-[var(--color-mint-200)]">Angin:</span>
                  <span class="font-bold">{{ currentWeather?.kecepatan_angin ?? '--' }} km/jam</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Detail Grid -->
        <section class="grid grid-cols-2 gap-4 md:grid-cols-4">
          <div class="rounded-2xl bg-white p-4 ring-1 ring-[var(--color-mint-200)] shadow-sm">
            <p class="text-xs text-[var(--color-brand-deep)]/60 font-medium">Kecepatan Angin</p>
            <p class="mt-1 text-lg font-bold text-[var(--color-brand-deep)]">{{ currentWeather?.kecepatan_angin ?? '--' }} <span class="text-xs font-normal">km/jam</span></p>
          </div>

          <div class="rounded-2xl bg-white p-4 ring-1 ring-[var(--color-mint-200)] shadow-sm">
            <p class="text-xs text-[var(--color-brand-deep)]/60 font-medium">Arah Angin</p>
            <p class="mt-1 text-lg font-bold text-[var(--color-brand-deep)]">Dari {{ currentWeather?.arah_angin ?? '-' }}</p>
          </div>

          <div class="rounded-2xl bg-white p-4 ring-1 ring-[var(--color-mint-200)] shadow-sm">
            <p class="text-xs text-[var(--color-brand-deep)]/60 font-medium">Tutupan Awan</p>
            <p class="mt-1 text-lg font-bold text-[var(--color-brand-deep)]">{{ currentWeather?.tutupan_awan ?? '--' }}%</p>
          </div>

          <div class="rounded-2xl bg-white p-4 ring-1 ring-[var(--color-mint-200)] shadow-sm">
            <p class="text-xs text-[var(--color-brand-deep)]/60 font-medium">Jarak Pandang</p>
            <p class="mt-1 text-lg font-bold text-[var(--color-brand-deep)]">
              {{ getVisibilityText(currentWeather) }}
            </p>
          </div>
        </section>

        <!-- Prakiraan Per Jam -->
        <section class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-[var(--color-mint-200)]">
          <h2 class="mb-4 text-base font-bold text-[var(--color-brand-deep)]">Prakiraan Waktu Jam-jaman</h2>

          <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-none">
            <div 
              v-for="(item, idx) in hourlyForecast" 
              :key="idx"
              class="flex min-w-[130px] flex-col items-center gap-2 rounded-2xl bg-[var(--color-mint-50)] p-3 text-center transition-all hover:bg-[var(--color-mint-100)]"
            >
              <span class="text-[11px] font-bold text-[var(--color-brand-deep)]">{{ formatTime(item.waktu_prakiraan) }} WITA</span>
              <img v-if="item.gambar_cuaca" :src="item.gambar_cuaca" :alt="item.keterangan_cuaca" class="h-8 w-8 object-contain my-1" />
              <span class="text-sm font-extrabold text-[var(--color-brand-deep)]">{{ item.suhu }}°C</span>
              <span class="text-[11px] font-medium text-[var(--color-brand-sidebar)] truncate w-full">{{ item.keterangan_cuaca }}</span>
            </div>
          </div>
        </section>
      </template>

    </main>
    <footer class="fixed bottom-0 left-0 right-0 z-40 flex h-12 items-center justify-center border-t border-[var(--color-mint-200)] bg-white/95 px-4 backdrop-blur-md lg:left-64">
      <div class="flex items-center justify-center">
          <p class="text-xs text-[var(--color-brand-deep)]/50">Sumber data berasal dari
              <a href="https://data.bmkg.go.id/" target="_blank" rel="noopener noreferrer" class="font-semibold text-[var(--color-brand-active)] transition hover:underline">Data Cuaca BMKG ( Badan Meteorologi, Klimatologi, dan Geofisika)</a>
          </p>
      </div>
  </footer>

  </div>
</template>

<script setup>
import Header from "@/components/configViews/Header.vue";
import { useCuaca } from "@/scriptViews/cuaca/main.js";

const {
  loading,
  error,

  makassarList,
  currentWeather,
  hourlyForecast,

  searchQuery,
  selectedAdm4,
  currentTime,

  filteredMakassarList,

  updateMakassarTime,
  fetchWilayahList,
  fetchWeatherData,
  initData,
  refreshData,

  getVisibilityText,
  formatDateOnly,
  formatTime,
} = useCuaca();
</script>

