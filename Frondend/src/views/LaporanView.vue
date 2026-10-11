<template>
  <div class="min-h-screen bg-[#F4FFFC] font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased selection:bg-[#C3E956] selection:text-[#1F4B2C]">
    <Header title="Laporan Data" @click="$emit('toggle-sidebar')" />
    <main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-8">
      <section class="relative overflow-hidden rounded-3xl bg-[#1F4B2C] text-white p-6 md:p-8 shadow-xl shadow-[#1F4B2C]/10">
        <div class="absolute inset-0 bg-[radial-gradient(#C3E956_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>
        <div class="relative z-10 space-y-6">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#4D7111] text-[#EAFFE9]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#C3E956] animate-pulse"></span>
                Kota Makassar
              </span>
              <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-white mt-2">
                Laporan data kota periode terpilih
              </h2>
              <p class="text-sm text-[#91EAAF] mt-2">
                Evaluasi penerapan kebijakan dan dampaknya terhadap kondisi kota.
              </p>
            </div>
            <div class="flex items-center gap-3">
              <button @click="exportAs('excel')" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-bold text-[#1F4B2C] bg-[#C3E956] hover:bg-[#91EAAF] transition-all duration-200 shadow-md shadow-[#C3E956]/20 active:scale-95">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v11m0 0 4-4m-4 4-4-4M5 20h14a1 1 0 0 0 1-1v-2"/>
                </svg>
                Export Excel
              </button>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-[#91EAAF] uppercase tracking-wider">
                Dari tanggal
              </label>
              <input v-model="filters.start" type="date" class="w-full px-3.5 py-2.5 rounded-xl bg-[#275836] border border-[#4D7111] text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#C3E956] transition-all">
            </div>
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-[#91EAAF] uppercase tracking-wider">
                Sampai tanggal
              </label>
              <input v-model="filters.end" type="date" class="w-full px-3.5 py-2.5 rounded-xl bg-[#275836] border border-[#4D7111] text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#C3E956] transition-all">
            </div>
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-[#91EAAF] uppercase tracking-wider">
                Kota
              </label>
              <select v-model="filters.kota" class="w-full px-3.5 py-2.5 rounded-xl bg-[#275836] border border-[#4D7111] text-white text-sm focus:outline-none focus:ring-2 focus:ring-[#C3E956] transition-all">
                <option value="makassar" class="bg-[#1F4B2C]">
                  Makassar
                </option>
              </select>
            </div>
          </div>
        </div>
      </section>
      <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
          <div>
            <p class="text-xs font-bold uppercase tracking-wider text-[#4D7111]">
              Simulasi Kebijakan
            </p>
            <h3 class="text-xl font-bold text-[#1F4B2C] mt-1">
              Draf Kebijakan
            </h3>
            <p class="text-sm text-[#275836]/60 mt-1">
              Kebijakan yang masih berada dalam tahap draf.
            </p>
          </div>
          <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-[#FFF8E1] text-[#8A6500] border border-[#F5E3A5]">
            {{ kebijakanDraft.length }} Draf
          </span>
        </div>
        <div v-if="loading" class="p-10 rounded-2xl bg-white border border-[#D5F5DD] text-center">
          <div class="flex justify-center">
            <div class="w-8 h-8 border-4 border-[#D5F5DD] border-t-[#4D7111] rounded-full animate-spin"></div>
          </div>
          <p class="text-sm font-semibold text-[#1F4B2C] mt-3">
            Mengambil data kebijakan...
          </p>
        </div>
        <div v-else-if="error" class="p-10 rounded-2xl bg-red-50 border border-red-200 text-center">
          <p class="text-sm font-semibold text-red-700">
            Gagal mengambil data kebijakan.
          </p>
          <p class="text-xs text-red-500 mt-1">
            {{ error }}
          </p>
          <button @click="fetchRiwayatKebijakan" class="mt-4 px-4 py-2 rounded-xl bg-[#1F4B2C] text-white text-sm font-bold">
            Coba Lagi
          </button>
        </div>
        <div v-else-if="kebijakanDraft.length" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
          <button v-for="k in kebijakanDraft" :key="k.id" type="button" @click="selectedKebijakan = k" class="group text-left p-5 rounded-2xl bg-white border border-[#D5F5DD] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#C3E956]">
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-[#FFF8E1] text-[#8A6500] shrink-0 group-hover:bg-[#F5E3A5] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z" />
                </svg>
              </div>
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#FFF8E1] text-[#8A6500] border border-[#F5E3A5]">
                Draf
              </span>
            </div>
            <div class="mt-5">
              <p class="text-xs font-semibold text-[#4D7111] uppercase tracking-wider">
                {{ k.jenis_label || k.jenis_kebijakan || 'Kebijakan' }}
              </p>
              <h4 class="text-base font-bold text-[#1F4B2C] mt-1.5 leading-snug line-clamp-2">
                {{ k.judul || 'Tanpa Judul' }}
              </h4>
            </div>
            <p class="text-xs text-[#275836]/60 line-clamp-3 mt-4">
              {{ k.skenario || k.kesimpulan || 'Belum ada deskripsi kebijakan.' }}
            </p>
            <div class="mt-4 pt-4 border-t border-[#EAFFE9] flex items-center justify-between">
              <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-[#275836]/50">
                  Dibuat
                </p>
                <p class="text-sm font-extrabold text-[#1F4B2C] mt-0.5">
                  {{ formatTanggal(k.created_at) }}
                </p>
              </div>
              <div class="flex items-center gap-1.5 text-xs font-bold text-[#4D7111]">
                Detail
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
          </button>
        </div>
        <div v-else class="p-10 rounded-2xl bg-white border border-[#D5F5DD] text-center">
          <p class="text-sm font-semibold text-[#1F4B2C]">
            Belum ada draf kebijakan.
          </p>
          <p class="text-xs text-[#275836]/60 mt-1">
            Kebijakan dengan status draf akan muncul di sini.
          </p>
        </div>
      </section>
      <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
          <div>
            <p class="text-xs font-bold uppercase tracking-wider text-[#4D7111]">
              Evaluasi Kebijakan
            </p>
            <h3 class="text-xl font-bold text-[#1F4B2C] mt-1">
              Kebijakan yang Sudah Diterapkan
            </h3>
            <p class="text-sm text-[#275836]/60 mt-1">
              Pilih kebijakan untuk melihat detail hasil penerapan.
            </p>
          </div>
          <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-[#EAFFE9] text-[#275836] border border-[#D5F5DD]">
            {{ kebijakanDiterapkan.length }} Kebijakan
          </span>
        </div>
        <div v-if="loading" class="p-10 rounded-2xl bg-white border border-[#D5F5DD] text-center">
          <div class="flex justify-center">
            <div class="w-8 h-8 border-4 border-[#D5F5DD] border-t-[#4D7111] rounded-full animate-spin"></div>
          </div>
          <p class="text-sm font-semibold text-[#1F4B2C] mt-3">
            Mengambil data kebijakan...
          </p>
        </div>
        <div v-else-if="kebijakanDiterapkan.length" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
          <button v-for="k in kebijakanDiterapkan" :key="k.id" type="button" @click="selectedKebijakan = k" class="group text-left p-5 rounded-2xl bg-white border border-[#D5F5DD] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#C3E956]">
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-[#EAFFE9] text-[#1F4B2C] shrink-0 group-hover:bg-[#C3E956] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#EAFFE9] text-[#1F4B2C] border border-[#91EAAF]">
                Diterapkan
              </span>
            </div>
            <div class="mt-5">
              <p class="text-xs font-semibold text-[#4D7111] uppercase tracking-wider">
                {{ k.jenis_label || k.jenis_kebijakan || 'Kebijakan' }}
              </p>
              <h4 class="text-base font-bold text-[#1F4B2C] mt-1.5 leading-snug line-clamp-2">
                {{ k.judul || 'Tanpa Judul' }}
              </h4>
            </div>
            <p class="text-xs text-[#275836]/60 line-clamp-3 mt-4">
              {{ k.skenario || k.kesimpulan || 'Tidak ada deskripsi kebijakan.' }}
            </p>
            <div class="mt-4 pt-4 border-t border-[#EAFFE9] flex items-center justify-between">
              <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-[#275836]/50">
                  Diterapkan
                </p>
                <p class="text-sm font-extrabold text-[#1F4B2C] mt-0.5">
                  {{ formatTanggal(k.updated_at || k.created_at) }}
                </p>
              </div>
              <div class="flex items-center gap-1.5 text-xs font-bold text-[#4D7111]">
                Detail
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
          </button>
        </div>
        <div v-else class="p-10 rounded-2xl bg-white border border-[#D5F5DD] text-center">
          <p class="text-sm font-semibold text-[#1F4B2C]">
            Belum ada kebijakan yang diterapkan.
          </p>
          <p class="text-xs text-[#275836]/60 mt-1">
            Kebijakan yang sudah diterapkan akan muncul di sini.
          </p>
        </div>
      </section>
      <Transition name="modal">
        <div v-if="selectedKebijakan" class="fixed inset-0 z-[100] flex items-center justify-center p-3 sm:p-5 bg-[#10291A]/75 backdrop-blur-sm" @click.self="selectedKebijakan = null">
          <div class="relative w-full max-w-6xl h-[94vh] bg-[#F4FFFC] rounded-[30px] overflow-hidden shadow-[0_30px_100px_rgba(16,41,26,0.35)] flex flex-col">
            <div class="relative shrink-0 bg-[#1F4B2C] text-white overflow-hidden">
              <div class="absolute inset-0 opacity-[0.07] bg-[radial-gradient(#C3E956_1px,transparent_1px)] [background-size:18px_18px]"></div>
              <div class="relative px-5 sm:px-7 lg:px-8 pt-5 pb-6">
                <div class="flex items-start justify-between gap-4">
                  <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                      <span :class="selectedKebijakan.status === 'diterapkan' ? 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#C3E956] text-[#1F4B2C] text-[11px] font-extrabold' : 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#FFF8E1] text-[#8A6500] text-[11px] font-extrabold'">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ labelStatus(selectedKebijakan.status) }}
                      </span>
                      <span class="text-xs text-[#B8EBC6]">
                        {{ formatTanggal(selectedKebijakan.updated_at || selectedKebijakan.created_at) }}
                      </span>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-[#91EAAF]">
                      {{ selectedKebijakan.jenis_label || selectedKebijakan.jenis_kebijakan || 'Kebijakan' }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight leading-tight mt-1 break-words">
                      {{ selectedKebijakan.judul || 'Tanpa Judul' }}
                    </h2>
                  </div>
                  <button type="button" @click="selectedKebijakan = null" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 flex items-center justify-center transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <div class="flex-1 overflow-y-auto">
              <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="max-w-5xl mx-auto">
                  <section class="mb-6">
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                        Detail Kebijakan
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Informasi Simulasi
                      </h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                      <div class="rounded-2xl bg-white border border-[#D5F5DD] p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                          <div class="w-10 h-10 rounded-xl bg-[#EAFFE9] text-[#1F4B2C] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a2 2 0 011.414.586L21 8v11a2 2 0 01-2 2H7z" />
                            </svg>
                          </div>
                          <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-wider font-bold text-[#6F8D78]">
                              Jenis Kebijakan
                            </p>
                            <p class="text-sm font-extrabold text-[#1F4B2C] mt-1 break-words">
                              {{ selectedKebijakan.jenis_label || selectedKebijakan.jenis_kebijakan || '-' }}
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="rounded-2xl bg-white border border-[#D5F5DD] p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                          <div class="w-10 h-10 rounded-xl bg-[#FFF8E1] text-[#8A6500] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                          </div>
                          <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-[#6F8D78]">
                              Tanggal
                            </p>
                            <p class="text-sm font-extrabold text-[#1F4B2C] mt-1">
                              {{ formatTanggal(selectedKebijakan.created_at) }}
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="rounded-2xl bg-white border border-[#D5F5DD] p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                          <div class="w-10 h-10 rounded-xl bg-[#EAF7FF] text-[#39709A] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0-1.042.133-2.052.382-3.016z" />
                            </svg>
                          </div>
                          <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-[#6F8D78]">
                              Status
                            </p>
                            <p class="text-sm font-extrabold text-[#1F4B2C] mt-1">
                              {{ labelStatus(selectedKebijakan.status) }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                  <section class="mb-6">
                    <div class="rounded-2xl bg-white border border-[#D5F5DD] shadow-sm overflow-hidden">
                      <div class="px-5 py-4 border-b border-[#EDF6F0]">
                        <div class="flex items-center gap-3">
                          <div class="w-9 h-9 rounded-xl bg-[#FFF8E1] text-[#8A6500] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293L21 8v11a2 2 0 01-2 2H7z" />
                            </svg>
                          </div>
                          <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-[#4D7111]">
                              Perencanaan
                            </p>
                            <h4 class="text-base font-extrabold text-[#1F4B2C]">
                              Skenario Kebijakan
                            </h4>
                          </div>
                        </div>
                      </div>
                      <div class="p-5">
                        <div class="rounded-xl bg-[#F7FCF8] border border-[#E3F1E7] p-5">
                          <p class="text-sm text-[#315C3D] leading-7 whitespace-pre-line break-words">
                            {{ selectedKebijakan.skenario || 'Tidak ada skenario kebijakan.' }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </section>
                  <section v-if="selectedKebijakan.status !== 'diterapkan' && hasValue(selectedKebijakan.baseline)" class="mb-6">
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                        Kondisi Awal
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Baseline Data
                      </h3>
                      <p class="text-xs text-[#6F8475] mt-1">
                        Data kondisi jalan sebelum kebijakan diterapkan.
                      </p>
                    </div>
                    <JsonTree :value="selectedKebijakan.baseline" />
                  </section>
                  <section
                    v-if="selectedKebijakan.status === 'diterapkan' && hasValue(hasilAiDiterapkan)"
                    class="mb-6"
                  >
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                        Evaluasi Penerapan
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Hasil Penerapan Kebijakan
                      </h3>
                      <p class="text-xs text-[#6F8475] mt-1">
                        Ringkasan hasil analisis AI yang hanya menampilkan kondisi awal, hasil penerapan, dan kesimpulan.
                      </p>
                    </div>
                    <div class="space-y-5">
                      <div
                        v-if="hasValue(hasilAiDiterapkan.kondisi_awal)"
                        class="rounded-2xl bg-white border border-[#D5F5DD] shadow-sm overflow-hidden"
                      >
                        <div class="px-5 py-4 border-b border-[#EDF6F0] bg-[#F7FCF8]">
                          <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                            Sebelum Penerapan
                          </p>
                          <h4 class="text-base font-extrabold text-[#1F4B2C] mt-1">
                            Kondisi Awal
                          </h4>
                        </div>
                        <div class="p-5">
                          <JsonTree :value="hasilAiDiterapkan.kondisi_awal" />
                        </div>
                      </div>
                      <div
                        v-if="hasValue(hasilAiDiterapkan.hasil_penerapan)"
                        class="rounded-2xl bg-white border border-[#BEE8C8] shadow-sm overflow-hidden"
                      >
                        <div class="px-5 py-4 border-b border-[#D5F5DD] bg-[#EAFFE9]">
                          <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#275836]">
                            Setelah Penerapan
                          </p>
                          <h4 class="text-base font-extrabold text-[#1F4B2C] mt-1">
                            Hasil Penerapan
                          </h4>
                        </div>
                        <div class="p-5">
                          <JsonTree :value="hasilAiDiterapkan.hasil_penerapan" />
                        </div>
                      </div>
                      <div
                        v-if="hasValue(hasilAiDiterapkan.kesimpulan)"
                        class="rounded-2xl bg-gradient-to-br from-[#1F4B2C] to-[#275836] p-5 sm:p-6 text-white shadow-lg shadow-[#1F4B2C]/10"
                      >
                        <div class="flex items-center gap-3 mb-4">
                          <div class="w-10 h-10 rounded-xl bg-[#C3E956] text-[#1F4B2C] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 00-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                          </div>
                          <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-[#91EAAF]">
                              Ringkasan
                            </p>
                            <h4 class="text-lg font-extrabold">
                              Kesimpulan
                            </h4>
                          </div>
                        </div>
                        <p class="text-sm text-white/90 leading-7 whitespace-pre-line break-words">
                          {{ formatPrimitive(hasilAiDiterapkan.kesimpulan) }}
                        </p>
                      </div>
                    </div>
                  </section>
                  <section v-if="selectedKebijakan.status !== 'diterapkan' && hasValue(selectedKebijakan.target)" class="mb-6">
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#8A6500]">
                        Sasaran
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Target Kebijakan
                      </h3>
                      <p class="text-xs text-[#6F8475] mt-1">
                        Kondisi yang ingin dicapai melalui kebijakan.
                      </p>
                    </div>
                    <JsonTree :value="selectedKebijakan.target" />
                  </section>
                  <section v-if="selectedKebijakan.status !== 'diterapkan' && hasValue(selectedKebijakan.rekayasa_lalu_lintas)" class="mb-6">
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                        Rekayasa
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Rekayasa Lalu Lintas
                      </h3>
                      <p class="text-xs text-[#6F8475] mt-1">
                        Parameter dan perubahan yang digunakan dalam simulasi.
                      </p>
                    </div>
                    <JsonTree :value="selectedKebijakan.rekayasa_lalu_lintas" />
                  </section>
                  <section v-if="selectedKebijakan.status !== 'diterapkan' && hasValue(selectedKebijakan.hasil_ai)" class="mb-6">
                    <div class="mb-4">
                      <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-[#4D7111]">
                        Analisis
                      </p>
                      <h3 class="text-xl font-extrabold text-[#1F4B2C] mt-1">
                        Hasil Analisis AI
                      </h3>
                      <p class="text-xs text-[#6F8475] mt-1">
                        Analisis berdasarkan data dan skenario simulasi kebijakan.
                      </p>
                    </div>
                    <div class="rounded-2xl bg-[#1F4B2C] p-5 shadow-lg shadow-[#1F4B2C]/10">
                      <JsonTree :value="selectedKebijakan.hasil_ai" theme="dark" />
                    </div>
                  </section>
                  <section v-if="selectedKebijakan.status !== 'diterapkan'" class="mb-2">
                    <div class="rounded-2xl bg-gradient-to-br from-[#1F4B2C] to-[#275836] p-5 sm:p-6 text-white shadow-lg shadow-[#1F4B2C]/10">
                      <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-[#C3E956] text-[#1F4B2C] flex items-center justify-center shrink-0">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 00-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z" />
                          </svg>
                        </div>
                        <div>
                          <p class="text-[10px] uppercase tracking-wider font-bold text-[#91EAAF]">
                            Ringkasan
                          </p>
                          <h4 class="text-lg font-extrabold">
                            Kesimpulan Simulasi
                          </h4>
                        </div>
                      </div>
                      <p class="text-sm text-white/90 leading-7 whitespace-pre-line break-words">
                        {{ selectedKebijakan.kesimpulan || 'Belum ada kesimpulan simulasi.' }}
                      </p>
                    </div>
                  </section>
                </div>
              </div>
            </div>
            <div class="shrink-0 px-5 sm:px-7 py-4 bg-white border-t border-[#D5F5DD] flex items-center justify-between gap-3">
              <div class="hidden sm:flex items-center gap-2 text-xs text-[#6F8475]">
                <span class="w-2 h-2 rounded-full bg-[#91EAAF]"></span>
                Detail simulasi kebijakan
              </div>
              <div class="ml-auto flex items-center gap-2">
                <button
                  v-if="selectedKebijakan.status === 'draft'"
                  type="button"
                  @click="showApplyModal = true"
                  :disabled="applying"
                  class="px-5 py-2.5 rounded-xl bg-[#C3E956] text-[#1F4B2C] text-sm font-extrabold hover:bg-[#91EAAF] active:scale-95 transition-all disabled:opacity-60 disabled:cursor-not-allowed"
                >
                  <span class="flex items-center gap-2">
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>

                    Terapkan
                  </span>
                </button>
                <button v-else-if="selectedKebijakan.status === 'diterapkan'" type="button" disabled class="px-5 py-2.5 rounded-xl bg-[#EAFFE9] text-[#1F6A36] border border-[#BEE8C8] text-sm font-extrabold cursor-default">
                  <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Sudah Diterapkan
                  </span>
                </button>
                <button type="button" @click="selectedKebijakan = null" class="px-6 py-2.5 rounded-xl bg-[#1F4B2C] text-white text-sm font-bold hover:bg-[#275836] active:scale-95 transition-all">
                  Tutup
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>

      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="showApplyModal"
          class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-[#10291A]/70 backdrop-blur-sm"
          @click.self="showApplyModal = false"
        >
          <div
            class="w-full max-w-md rounded-3xl bg-white shadow-[0_30px_100px_rgba(16,41,26,0.3)] overflow-hidden"
          >
            <!-- Icon -->
            <div class="px-6 pt-7 text-center">
              <div
                class="mx-auto w-16 h-16 rounded-2xl bg-[#FFF8E1] text-[#8A6500] flex items-center justify-center"
              >
                <svg
                  class="w-8 h-8"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M12 9v4m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 19.7h14.74a2 2 0 001.74-3.02l-7.4-12.82a2 2 0 00-3.42 0z"
                  />
                </svg>
              </div>

              <p class="mt-2 text-sm leading-6 text-[#6F8475]">
                Apakah kamu yakin ingin menerapkan kebijakan
                <span class="font-bold text-[#1F4B2C]">
                  "{{ selectedKebijakan?.judul || 'Tanpa Judul' }}"
                </span>
                ?
              </p>

              <div
                class="mt-4 rounded-2xl bg-[#F7FCF8] border border-[#D5F5DD] p-4 text-left"
              >
                <div class="flex items-start gap-3">
                  <div
                    class="w-9 h-9 rounded-xl bg-[#EAFFE9] text-[#1F4B2C] flex items-center justify-center shrink-0"
                  >
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.052-.382-3.016z"
                      />
                    </svg>
                  </div>

                  <div>
                    <p class="text-xs font-bold text-[#1F4B2C]">
                      Konfirmasi penerapan
                    </p>

                    <p class="text-xs text-[#6F8475] mt-1 leading-5">
                      Status kebijakan akan berubah dari
                      <span class="font-semibold text-[#8A6500]">Draf</span>
                      menjadi
                      <span class="font-semibold text-[#1F6A36]">Diterapkan</span>.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Error -->
            <div
              v-if="applyError"
              class="mx-6 mt-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3"
            >
              <p class="text-xs font-semibold text-red-700">
                {{ applyError }}
              </p>
            </div>

            <!-- Action -->
            <div class="flex items-center justify-end gap-3 px-6 py-6">
              <button
                type="button"
                @click="showApplyModal = false"
                :disabled="applying"
                class="px-5 py-2.5 rounded-xl border border-[#D5F5DD] bg-white text-[#275836] text-sm font-bold hover:bg-[#F7FCF8] transition-all disabled:opacity-50"
              >
                Batal
              </button>

              <button
                type="button"
                @click="terapkanKebijakan"
                :disabled="applying"
                class="px-5 py-2.5 rounded-xl bg-[#1F4B2C] text-white text-sm font-extrabold hover:bg-[#275836] active:scale-95 transition-all disabled:opacity-60 disabled:cursor-not-allowed"
              >
                <span
                  v-if="applying"
                  class="flex items-center gap-2"
                >
                  <span
                    class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"
                  ></span>
                  Menerapkan...
                </span>

                <span
                  v-else
                  class="flex items-center gap-2"
                >
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>

                  Ya, Terapkan
                </span>
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, watch, defineComponent, h } from 'vue'
import * as XLSX from 'xlsx'
import Header from '../components/layout/Header2.vue'

const API_BASE = import.meta.env.VITE_API_URL;
function getCookie(name) {
    const row = document.cookie
        .split('; ')
        .find(item => item.startsWith(`${name}=`))

    return row
        ? decodeURIComponent(row.substring(name.length + 1))
        : null
}

async function getCsrfToken() {
    const response = await fetch(`${API_BASE}/sanctum/csrf-cookie`, {
        method: 'GET',
        credentials: 'include',
        headers: {
            Accept: 'application/json'
        }
    })

    if (!response.ok) {
        throw new Error(
            `Gagal mengambil CSRF cookie. HTTP ${response.status}`
        )
    }

    const token = getCookie('XSRF-TOKEN')

    if (!token) {
        throw new Error('Cookie XSRF-TOKEN tidak ditemukan.')
    }

    return token
}
const API_URL = `${API_BASE}/api/simulasi-kebijakan`
const filters = reactive({
  start: '',
  end: '',
  kota: 'makassar'
})
const selectedKebijakan = ref(null)
const riwayatKebijakan = ref([])
const loading = ref(false)
const error = ref(null)
const applying = ref(false)
const showApplyModal = ref(false)
const applyError = ref('')
function parseJsonValue(value) {
  if (typeof value !== 'string') {
    return value
  }
  const trimmed = value.trim()
  if (!trimmed) {
    return value
  }
  if (
    (trimmed.startsWith('{') && trimmed.endsWith('}')) ||
    (trimmed.startsWith('[') && trimmed.endsWith(']'))
  ) {
    try {
      return JSON.parse(trimmed)
    } catch {
      return value
    }
  }
  return value
}
function normalizeDeep(value) {
  const parsed = parseJsonValue(value)
  if (parsed === null || parsed === undefined) {
    return parsed
  }
  if (Array.isArray(parsed)) {
    return parsed.map(item => normalizeDeep(item))
  }
  if (typeof parsed === 'object') {
    const result = {}
    Object.entries(parsed).forEach(([key, item]) => {
      result[key] = normalizeDeep(item)
    })
    return result
  }
  return parsed
}
function normalizeKebijakan(item) {
  if (!item || typeof item !== 'object') {
    return item
  }
  return {
    ...item,
    baseline: normalizeDeep(item.baseline),
    target: normalizeDeep(item.target),
    rekayasa_lalu_lintas: normalizeDeep(item.rekayasa_lalu_lintas),
    hasil_ai: normalizeDeep(item.hasil_ai),
    hasil_penerapan: normalizeDeep(item.hasil_penerapan)
  }
}
const hasilAiDiterapkan = computed(() => {
  const hasilAi = normalizeDeep(selectedKebijakan.value?.hasil_ai)
  if (!hasilAi || typeof hasilAi !== 'object' || Array.isArray(hasilAi)) {
    return {}
  }
  const getAiValue = (...keys) => {
    for (const key of keys) {
      if (Object.prototype.hasOwnProperty.call(hasilAi, key) && hasValue(hasilAi[key])) {
        return hasilAi[key]
      }
    }
    return null
  }
  const kondisiAwal = getAiValue(
    'kondisi_awal',
    'kondisiAwal',
    'Kondisi Awal',
    'kondisi awal'
  )
  const hasilPenerapan = getAiValue(
    'hasil_penerapan',
    'hasilPenerapan',
    'Hasil Penerapan',
    'hasil penerapan'
  )
  const kesimpulan = getAiValue(
    'kesimpulan',
    'Kesimpulan'
  )
  return {
    kondisi_awal: kondisiAwal,
    hasil_penerapan: hasilPenerapan,
    kesimpulan
  }
})

async function fetchRiwayatKebijakan() {
  loading.value = true
  error.value = null
  try {
    const params = new URLSearchParams()
    if (filters.start) {
      params.append('start', filters.start)
    }
    if (filters.end) {
      params.append('end', filters.end)
    }
    const query = params.toString()
    const url = query ? `${API_URL}?${query}` : API_URL
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`)
    }
    const result = await response.json()
    console.log('Response API:', result)
    const data = Array.isArray(result.data?.data)
      ? result.data.data
      : Array.isArray(result.data)
        ? result.data
        : Array.isArray(result)
          ? result
          : []
    riwayatKebijakan.value = data.map(normalizeKebijakan)
    console.log('Data setelah normalisasi:', riwayatKebijakan.value)
  } catch (err) {
    console.error('Gagal mengambil data:', err)
    error.value = err.message || 'Terjadi kesalahan saat mengambil data.'
    riwayatKebijakan.value = []
  } finally {
    loading.value = false
  }
}
async function terapkanKebijakan() {
  if (!selectedKebijakan.value?.id) {
    applyError.value = 'ID kebijakan tidak ditemukan.'
    return
  }

  if (selectedKebijakan.value.status !== 'draft') {
    return
  }

  const id = selectedKebijakan.value.id

  applyError.value = ''
  applying.value = true

  try {
    const xsrfToken = await getCsrfToken()
    const response = await fetch(`${API_URL}/${id}`, {
      method: 'PUT',
      credentials: 'include',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': xsrfToken
      },
      body: JSON.stringify({
        status: 'diterapkan'
      })
    })
    const result = await response.json()
    console.log('Response penerapan kebijakan:', result)
    if (!response.ok) {
      throw new Error(
        result.message || `Gagal menerapkan kebijakan. HTTP ${response.status}`
      )
    }
    if (result.status !== 'success') {
      throw new Error(
        result.message || 'Gagal mengubah status kebijakan.'
      )
    }
    const responseData =
      result.data ||
      result.simulasi_kebijakan ||
      result.item ||
      {}
    const updatedData = normalizeKebijakan(responseData)
    const index = riwayatKebijakan.value.findIndex(
      item => Number(item.id) === Number(id)
    )
    if (index !== -1) {
      riwayatKebijakan.value[index] = {
        ...riwayatKebijakan.value[index],
        ...updatedData,
        status: 'diterapkan'
      }
    }
    selectedKebijakan.value = {
      ...selectedKebijakan.value,
      ...updatedData,
      status: 'diterapkan'
    }
    showApplyModal.value = false
  } catch (err) {
    console.error('Gagal menerapkan kebijakan:', err)
    applyError.value =
      err.message ||
      'Terjadi kesalahan saat menerapkan kebijakan.'
  } finally {
    applying.value = false
  }
}
const kebijakanDraft = computed(() => {
  return riwayatKebijakan.value.filter(
    item => item.status === 'draft'
  )
})
const kebijakanDiterapkan = computed(() => {
  return riwayatKebijakan.value.filter(
    item => item.status === 'diterapkan'
  )
})
function formatTanggal(tanggal) {
  if (!tanggal) {
    return '-'
  }
  const date = new Date(tanggal)
  if (Number.isNaN(date.getTime())) {
    return tanggal
  }
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}
function labelStatus(status) {
  const labels = {
    draft: 'Draf',
    diajukan: 'Diajukan',
    diterapkan: 'Diterapkan'
  }
  return labels[status] || status || '-'
}
function formatLabel(key) {
  if (!key) {
    return '-'
  }
  const labels = {
    osm_id: 'OSM ID',
    id_jalan: 'ID Jalan',
    id_segmen: 'ID Segmen',
    panjang_m: 'Panjang',
    lebar_m: 'Lebar',
    jumlah_ruas: 'Jumlah Ruas',
    jumlah_segmen: 'Jumlah Segmen',
    segmen_jalans: 'Segmen Jalan',
    kapasitas_jalan: 'Kapasitas Jalan',
    volume_kendaraan: 'Volume Kendaraan',
    tingkat_kepadatan: 'Tingkat Kepadatan',
    tipe_jalan_detail: 'Tipe Jalan',
    nama_ruas_jalan: 'Nama Ruas Jalan',
    koordinat_geometri: 'Koordinat Geometri',
    volume_lalu_lintas: 'Volume Lalu Lintas',
    kecepatan_rata_rata: 'Kecepatan Rata-rata',
    lebar_tambahan: 'Lebar Tambahan',
    panjang_pekerjaan: 'Panjang Pekerjaan',
    lama_pengerjaan: 'Lama Pengerjaan',
    ruas_terpilih: 'Ruas Jalan Terpilih'
  }
  if (labels[key]) {
    return labels[key]
  }
  return String(key)
    .replace(/_/g, ' ')
    .replace(/([a-z])([A-Z])/g, '$1 $2')
    .replace(/\b\w/g, char => char.toUpperCase())
}
function isPlainObject(value) {
  return value !== null &&
    typeof value === 'object' &&
    !Array.isArray(value)
}
function hasValue(value) {
  if (
    value === null ||
    value === undefined ||
    value === ''
  ) {
    return false
  }
  if (
    Array.isArray(value) &&
    value.length === 0
  ) {
    return false
  }
  if (
    isPlainObject(value) &&
    Object.keys(value).length === 0
  ) {
    return false
  }
  return true
}

function formatPrimitive(value) {
  if (
    value === null ||
    value === undefined ||
    value === ''
  ) {
    return '-'
  }
  if (typeof value === 'boolean') {
    return value ? 'Ya' : 'Tidak'
  }
  if (typeof value === 'number') {
    return Number.isInteger(value)
      ? value.toLocaleString('id-ID')
      : value.toLocaleString('id-ID', {
          maximumFractionDigits: 2
        })
  }
  return String(value)
}
const JsonTree = defineComponent({
  name: 'JsonTree',
  props: {
    value: {
      type: null,
      default: null
    },
    theme: {
      type: String,
      default: 'light'
    }
  },
  setup(props) {
    return () => {
      const value = normalizeDeep(props.value)
      const dark = props.theme === 'dark'
      if (!hasValue(value)) {
        return h(
          'div',
          {
            class: dark
              ? 'rounded-xl bg-white/10 border border-white/10 px-4 py-3 text-sm text-white/50'
              : 'rounded-xl bg-[#F7FCF8] border border-[#E4F1E7] px-4 py-3 text-sm text-[#82958A]'
          },
          '-'
        )
      }
      if (Array.isArray(value)) {
        return h(
          'div',
          {
            class: 'grid grid-cols-1 md:grid-cols-2 gap-3'
          },
          value.map((item, index) =>
            h(
              'div',
              {
                key: index,
                class: dark
                  ? 'rounded-2xl bg-white/[0.07] border border-white/10 p-4'
                  : 'rounded-2xl bg-white border border-[#DCEFE1] p-4 shadow-sm'
              },
              [
                h(
                  'div',
                  {
                    class: 'flex items-center gap-2 mb-3'
                  },
                  [
                    h(
                      'span',
                      {
                        class: dark
                          ? 'w-7 h-7 rounded-lg bg-[#C3E956] text-[#1F4B2C] flex items-center justify-center text-[10px] font-extrabold'
                          : 'w-7 h-7 rounded-lg bg-[#1F4B2C] text-white flex items-center justify-center text-[10px] font-extrabold'
                      },
                      String(index + 1)
                    ),
                    h(
                      'span',
                      {
                        class: dark
                          ? 'text-[10px] uppercase tracking-wider font-bold text-[#91EAAF]'
                          : 'text-[10px] uppercase tracking-wider font-bold text-[#6F8D78]'
                      },
                      `Data ${index + 1}`
                    )
                  ]
                ),
                h(JsonTree, {
                  value: item,
                  theme: props.theme
                })
              ]
            )
          )
        )
      }
      if (isPlainObject(value)) {
        return h(
          'div',
          {
            class: 'grid grid-cols-1 md:grid-cols-2 gap-3'
          },
          Object.entries(value).map(([key, childValue]) => {
            const nested =
              isPlainObject(childValue) ||
              Array.isArray(childValue)
            if (nested) {
              return h(
                'div',
                {
                  key,
                  class: dark
                    ? 'md:col-span-2 rounded-2xl bg-white/[0.07] border border-white/10 p-4 sm:p-5'
                    : 'md:col-span-2 rounded-2xl bg-white border border-[#DCEFE1] p-4 sm:p-5 shadow-sm'
                },
                [
                  h(
                    'div',
                    {
                      class: 'flex items-center justify-between gap-3 mb-4'
                    },
                    [
                      h(
                        'div',
                        {
                          class: 'flex items-center gap-2.5'
                        },
                        [
                          h(
                            'span',
                            {
                              class: dark
                                ? 'w-2 h-2 rounded-full bg-[#C3E956]'
                                : 'w-2 h-2 rounded-full bg-[#4D7111]'
                            }
                          ),
                          h(
                            'span',
                            {
                              class: dark
                                ? 'text-xs font-extrabold text-white'
                                : 'text-xs font-extrabold text-[#1F4B2C]'
                            },
                            formatLabel(key)
                          )
                        ]
                      ),
                      h(
                        'span',
                        {
                          class: dark
                            ? 'text-[9px] uppercase tracking-wider font-bold text-white/40'
                            : 'text-[9px] uppercase tracking-wider font-bold text-[#8A9E90]'
                        },
                        Array.isArray(childValue)
                          ? `${childValue.length} data`
                          : 'Detail'
                      )
                    ]
                  ),
                  h(JsonTree, {
                    value: childValue,
                    theme: props.theme
                  })
                ]
              )
            }
            return h(
              'div',
              {
                key,
                class: dark
                  ? 'rounded-2xl bg-white/[0.07] border border-white/10 px-4 py-4'
                  : 'rounded-2xl bg-white border border-[#DCEFE1] px-4 py-4 shadow-sm'
              },
              [
                h(
                  'p',
                  {
                    class: dark
                      ? 'text-[9px] uppercase tracking-wider font-bold text-[#91EAAF]'
                      : 'text-[9px] uppercase tracking-wider font-bold text-[#718A79]'
                  },
                  formatLabel(key)
                ),
                h(
                  'p',
                  {
                    class: dark
                      ? 'text-sm font-extrabold text-white mt-1.5 break-words'
                      : 'text-sm font-extrabold text-[#1F4B2C] mt-1.5 break-words'
                  },
                  formatPrimitive(childValue)
                )
              ]
            )
          })
        )
      }
      return h(
        'p',
        {
          class: dark
            ? 'text-sm text-white leading-7 whitespace-pre-line break-words'
            : 'text-sm text-[#315C3D] leading-7 whitespace-pre-line break-words'
        },
        formatPrimitive(value)
      )
    }
  }
})


function formatExcelValue(value) {
  if (
    value === null ||
    value === undefined ||
    value === ''
  ) {
    return '-'
  }

  if (typeof value === 'object') {
    return JSON.stringify(value, null, 2)
  }

  if (typeof value === 'boolean') {
    return value ? 'Ya' : 'Tidak'
  }

  return String(value)
}

function exportAs(type) {
  if (type !== 'excel') {
    return
  }

  if (!riwayatKebijakan.value.length) {
    alert('Tidak ada data kebijakan yang dapat diekspor.')
    return
  }

  const dataExport = riwayatKebijakan.value.map((item, index) => ({
    No: index + 1,

    'Judul Kebijakan':
      item.judul || '-',

    'Jenis Kebijakan':
      item.jenis_label ||
      item.jenis_kebijakan ||
      '-',

    'Tanggal Dibuat':
      formatTanggal(item.created_at),

    'Tanggal Diterapkan':
      item.status === 'diterapkan'
        ? formatTanggal(
            item.tanggal_diterapkan ||
            item.updated_at ||
            item.created_at
          )
        : '-',

    Status:
      labelStatus(item.status),

    'Hasil Penilaian AI':
      formatExcelValue(item.hasil_ai)
  }))

  const worksheet = XLSX.utils.json_to_sheet(dataExport)

  worksheet['!cols'] = [
    { wch: 7 },
    { wch: 32 },
    { wch: 22 },
    { wch: 20 },
    { wch: 22 },
    { wch: 18 },
    { wch: 70 }
  ]

  const workbook = XLSX.utils.book_new()

  XLSX.utils.book_append_sheet(
    workbook,
    worksheet,
    'Laporan Kebijakan'
  )

  const tanggalSekarang = new Date()
    .toISOString()
    .slice(0, 10)

  XLSX.writeFile(
    workbook,
    `laporan-kebijakan-${tanggalSekarang}.xlsx`
  )
}

onMounted(() => {
  fetchRiwayatKebijakan()
})
watch(
  () => [
    filters.start,
    filters.end
  ],
  () => {
    fetchRiwayatKebijakan()
  }
)
</script>
<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.25s ease;
}
.modal-enter-active > div,
.modal-leave-active > div {
  transition:
    transform 0.25s ease,
    opacity 0.25s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
.modal-enter-from > div,
.modal-leave-to > div {
  opacity: 0;
  transform: translateY(15px) scale(0.985);
}
::-webkit-scrollbar {
  width: 7px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background: #B9D9C2;
  border-radius: 999px;
}
::-webkit-scrollbar-thumb:hover {
  background: #7EAD89;
}
</style>
