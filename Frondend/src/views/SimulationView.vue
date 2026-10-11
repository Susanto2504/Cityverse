 <template>
      <div class="min-h-screen bg-[#F4FFFC] font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased selection:bg-[#C3E956] selection:text-[#1F4B2C]">
        <Header title="Simulasi & Analisis" @click="$emit('toggle-sidebar')" />

        <main class="mx-auto max-w-full px-4 py-8 sm:px-6 lg:px-8 space-y-8">

 
      <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1F4B2C] via-[#275836] to-[#1F4B2C] p-8 md:p-12 text-white shadow-xl shadow-[#1F4B2C]/10">
        <!-- Pattern Background -->
        <div class="absolute inset-0 bg-[radial-gradient(#C3E956_1px,transparent_1px)] [background-size:24px_24px] opacity-15 pointer-events-none"></div>

        <!-- Logo kanan -->
        <div class="absolute right-0 top-0 h-full w-[20%] flex items-center justify-center pointer-events-none">
          <img
            src="../assets/logo.png"
            alt="Logo"
            class="h-full w-auto object-contain opacity-15"
          />
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-2xl space-y-3">
          <div class="inline-flex items-center gap-2 rounded-full bg-[#C3E956]/15 px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-[#C3E956] border border-[#C3E956]/30 backdrop-blur-md">
            <span class="h-2 w-2 rounded-full bg-[#C3E956] animate-pulse"></span>
            Kota Makassar
          </div>

          <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl text-white leading-tight">
            Simulasikan kebijakan,
            <br class="hidden sm:inline">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#C3E956] to-[#91EAAF]">
              lihat dampaknya.
            </span>
          </h2>

          <p class="max-w-xl text-sm leading-relaxed text-slate-200">
            Masukkan skenario kebijakan yang ingin disimulasikan. Sistem menggunakan kondisi data saat ini sebagai dasar analisis dampak, risiko, dan rekomendasi.
          </p>
        </div>
      </section>


      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-7 h-full">
          <section class="h-full rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
              <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"><svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>Definisi Kebijakan</h3>
            </div>

            <div class="space-y-5">
              <label class="block space-y-1.5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Jenis Kebijakan</span>

                <select v-model="jenisKebijakan" class="w-full rounded-xl border border-slate-200 bg-[#EAFFE9]/20 px-4 py-3 text-sm transition focus:border-[#4D7111] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4D7111]/20">
                  <option value="pelebaran_jalan">Pelebaran Jalan</option>
                  <option value="rekayasa_lalu_lintas">Rekayasa Lalu Lintas</option>
                  <option value="normalisasi_drainase">Normalisasi Drainase</option>
                  <option value="pembangunan_infrastruktur">Pembangunan Infrastruktur</option>
                  <option value="lingkungan">Kebijakan Lingkungan</option>
                </select>
              </label>

              <label class="block space-y-1.5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Judul Kebijakan</span>
                <input v-model="judulKebijakan" type="text" class="w-full rounded-xl border border-slate-200 bg-[#EAFFE9]/20 px-4 py-3 text-sm transition focus:border-[#4D7111] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4D7111]/20 placeholder:text-slate-400" placeholder="Contoh: Rekayasa Lalu Lintas Jalan A. Pettarani">
              </label>
            </div>

            <div v-if="jenisKebijakan === 'rekayasa_lalu_lintas'" class="rounded-2xl border border-[#D5F5DD] bg-[#F4FFFC]/60 p-5">
              <div class="flex items-center gap-3 mb-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#EAFFE9] text-[#1F4B2C]">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>

                <div>
                  <p class="text-sm font-bold text-slate-800">Rute Rekayasa Lalu Lintas</p>
                  <p class="text-[10px] text-slate-400">Tentukan ruas yang terdampak dan ruas yang menjadi target pengalihan.</p>
                </div>
              </div>

              <div class="space-y-5">
                <div class="rounded-2xl border border-rose-100 bg-rose-50 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-100 text-rose-700 font-black">A</div>

                    <div>
                      <p class="text-xs font-bold text-rose-900">Lokasi Awal / Ruas Terdampak</p>
                      <p class="text-[10px] text-rose-600">Ruas jalan yang akan mengalami perubahan atau pengurangan arus.</p>
                    </div>
                  </div>

                  <div class="relative">
                    <input v-model="roadSearchQuery" type="text" class="w-full rounded-xl border border-rose-200 bg-white px-4 py-3 text-sm focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-200" placeholder="Cari ruas jalan terdampak..." @focus="showRoadDropdown = true" @input="showRoadDropdown = true">

                    <div v-if="showRoadDropdown && filteredRoads.length" class="absolute z-40 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl">
                      <button v-for="road in filteredRoads" :key="road.id_jalan" type="button" class="block w-full border-b border-slate-100 px-4 py-3 text-left transition hover:bg-[#F4FFFC]" @click="selectRoad(road)">
                        <p class="text-xs font-bold text-slate-800">{{ road.nama_ruas_jalan }}</p>
                        <p class="mt-0.5 text-[10px] text-slate-400">ID Jalan: {{ road.id_jalan }}</p>
                      </button>
                    </div>
                  </div>

                  <div v-if="selectedRuas" class="mt-4">
                    <div class="rounded-xl bg-white p-4">
                      <p class="text-[9px] font-bold uppercase tracking-wider text-rose-500">Ruas Terdampak</p>
                      <p class="mt-1 text-sm font-bold text-rose-900">{{ selectedRuas.nama_ruas_jalan }}</p>

                      <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Panjang</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalLength) }} m</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Lebar</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadAverageWidth) }} m</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kapasitas</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalCapacity) }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Volume</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalVolume) }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3 col-span-2">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kepadatan</p>
                          <p class="mt-1 text-sm font-bold text-rose-700">{{ selectedRoadDensity }}</p>
                        </div>
                        <div class="col-span-2 mt-2">
                          <div class="rounded-xl border border-rose-100 bg-rose-50/50 p-3">
                            <div class="flex items-center justify-between">
                              <p class="text-[9px] uppercase font-bold tracking-wider text-rose-500">Kondisi Jalan</p>

                              <span v-if="selectedRoadConditionSegments.length" class="rounded-full bg-rose-100 px-2 py-1 text-[9px] font-bold text-rose-600">
                                {{ selectedRoadConditionSegments.length }} kondisi
                              </span>
                            </div>

                            <div v-if="selectedRoadConditionSegments.length" class="mt-3 space-y-2">
                              <div v-for="(segment, index) in selectedRoadConditionSegments" :key="segment.id || segment.osm_id || index" class="rounded-lg bg-white p-3">
                                <div class="flex items-center justify-between gap-3">
                                  <span class="text-xs font-bold text-slate-700">
                                    Segmen {{ index + 1 }}
                                  </span>

                                  <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold uppercase text-slate-700">
                                    {{ segment.kondisi_jalan || '-' }}
                                  </span>
                                </div>

                                <div class="mt-2 grid grid-cols-2 gap-2">
                                  <div class="rounded-lg bg-slate-50 p-2">
                                    <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Panjang Kondisi</p>
                                    <p class="mt-1 text-xs font-bold text-slate-700">
                                      {{ formatNumber(Number(segment.panjang_kondisi_m || 0)) }} m
                                    </p>
                                  </div>

                                  <div v-if="String(segment.kondisi_jalan || '').toLowerCase() === 'lainnya'" class="rounded-lg bg-slate-50 p-2">
                                    <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Keterangan</p>
                                    <p class="mt-1 text-xs font-bold text-slate-700">
                                      {{ segment.kondisi_lainnya || '-' }}
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <p v-else class="mt-2 text-xs font-semibold text-emerald-600">
                              Normal
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="flex justify-center">
                  <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1F4B2C] text-white font-black shadow-md">↓</div>
                </div>

                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 font-black">B</div>

                    <div>
                      <p class="text-xs font-bold text-emerald-900">Lokasi Target Pengalihan</p>
                      <p class="text-[10px] text-emerald-600">Ruas jalan yang menjadi tujuan pemindahan arus kendaraan.</p>
                    </div>
                  </div>

                  <div class="relative">
                    <input v-model="targetRoadSearchQuery" type="text" class="w-full rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200" placeholder="Cari ruas jalan target pengalihan..." @focus="showTargetRoadDropdown = true" @input="showTargetRoadDropdown = true">

                    <div v-if="showTargetRoadDropdown && filteredTargetRoads.length" class="absolute z-40 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl">
                      <button v-for="road in filteredTargetRoads" :key="road.id_jalan" type="button" class="block w-full border-b border-slate-100 px-4 py-3 text-left transition hover:bg-[#F4FFFC]" @click="selectTargetRoad(road)">
                        <p class="text-xs font-bold text-slate-800">{{ road.nama_ruas_jalan }}</p>
                        <p class="mt-0.5 text-[10px] text-slate-400">ID Jalan: {{ road.id_jalan }}</p>
                      </button>
                    </div>
                  </div>

                  <div v-if="selectedTargetRuas" class="mt-4">
                    <div class="rounded-xl bg-white p-4">
                      <p class="text-[9px] font-bold uppercase tracking-wider text-emerald-600">Ruas Target Pengalihan</p>
                      <p class="mt-1 text-sm font-bold text-emerald-900">{{ selectedTargetRuas.nama_ruas_jalan }}</p>

                      <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Panjang</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(targetRoadTotalLength) }} m</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Lebar</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(targetRoadAverageWidth) }} m</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kapasitas</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(targetRoadTotalCapacity) }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Volume</p>
                          <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(targetRoadTotalVolume) }}</p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-3 col-span-2">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kepadatan</p>
                          <p class="mt-1 text-sm font-bold text-emerald-700">{{ targetRoadDensity }}</p>
                          <div class="col-span-2 mt-2">
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-3">
                              <div class="flex items-center justify-between">
                                <p class="text-[9px] uppercase font-bold tracking-wider text-emerald-600">Kondisi Jalan</p>

                                <span v-if="targetRoadConditionSegments.length" class="rounded-full bg-emerald-100 px-2 py-1 text-[9px] font-bold text-emerald-600">
                                  {{ targetRoadConditionSegments.length }} kondisi
                                </span>
                              </div>

                              <div v-if="targetRoadConditionSegments.length" class="mt-3 space-y-2">
                                <div v-for="(segment, index) in targetRoadConditionSegments" :key="segment.id || segment.osm_id || index" class="rounded-lg bg-white p-3">
                                  <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs font-bold text-slate-700">
                                      Segmen {{ index + 1 }}
                                    </span>

                                    <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold uppercase text-slate-700">
                                      {{ segment.kondisi_jalan || '-' }}
                                    </span>
                                  </div>

                                  <div class="mt-2 grid grid-cols-2 gap-2">
                                    <div class="rounded-lg bg-slate-50 p-2">
                                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Panjang Kondisi</p>
                                      <p class="mt-1 text-xs font-bold text-slate-700">
                                        {{ formatNumber(Number(segment.panjang_kondisi_m || 0)) }} m
                                      </p>
                                    </div>

                                    <div v-if="String(segment.kondisi_jalan || '').toLowerCase() === 'lainnya'" class="rounded-lg bg-slate-50 p-2">
                                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Keterangan</p>
                                      <p class="mt-1 text-xs font-bold text-slate-700">
                                        {{ segment.kondisi_lainnya || '-' }}
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <p v-else class="mt-2 text-xs font-semibold text-emerald-600">
                                Normal
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div v-else class="mt-4 rounded-xl bg-white p-4 text-xs text-slate-400">Pilih ruas jalan yang menjadi target pengalihan.</div>
                </div>
              </div>
            </div>

            <div class="border-t border-slate-100 pt-6 space-y-5">
              <div>
                <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"><svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>Kondisi Data Saat Ini</h3>
                <p class="mt-1 text-xs text-slate-500">Data berikut digunakan sebagai kondisi awal sebelum kebijakan disimulasikan.</p>
              </div>

              <div v-if="isLoadingData" class="rounded-xl border border-slate-200 bg-slate-50 p-6 flex items-center justify-center gap-3">
                <svg class="animate-spin h-5 w-5 text-[#4D7111]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>

                <span class="text-xs font-semibold text-slate-500">Mengambil data kondisi saat ini...</span>
              </div>

              <div v-else class="space-y-4">
                <div v-if="showRoadData && jenisKebijakan !== 'rekayasa_lalu_lintas'" class="rounded-2xl border border-[#D5F5DD] bg-[#F4FFFC]/60 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAFFE9] text-[#1F4B2C]">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5-2V6l5 2m0 12l6-2m-6 2V8m6 10l5 2V8l-5-2m0 12V6" /></svg>
                    </div>

                    <div>
                      <p class="text-sm font-bold text-slate-800">Kondisi Ruas Jalan</p>
                      <p class="text-[10px] text-slate-400">{{ ruasJalanList.length }} ruas tersedia</p>
                    </div>
                  </div>

                  <div class="relative">
                    <input v-model="roadSearchQuery" type="text" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#4D7111] focus:outline-none focus:ring-2 focus:ring-[#4D7111]/20" placeholder="Cari nama ruas jalan..." @focus="showRoadDropdown = true" @input="showRoadDropdown = true">

                    <div v-if="showRoadDropdown && filteredRoads.length" class="absolute z-30 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl">
                      <button v-for="road in filteredRoads" :key="road.id_jalan" type="button" class="block w-full border-b border-slate-100 px-4 py-3 text-left transition hover:bg-[#F4FFFC]" @click="selectRoad(road)">
                        <p class="text-xs font-bold text-slate-800">{{ road.nama_ruas_jalan }}</p>
                        <p class="mt-0.5 text-[10px] text-slate-400">ID Jalan: {{ road.id_jalan }}</p>
                      </button>
                    </div>
                  </div>

                  <div v-if="selectedRuas" class="mt-4 rounded-xl border border-slate-100 bg-white p-4">
                    <div class="mb-4">
                      <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Ruas</p>
                      <p class="mt-1 text-sm font-bold text-[#1F4B2C]">{{ selectedRuas.nama_ruas_jalan }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Jumlah Segmen</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ selectedRoadSegments.length }}</p>
                      </div>

                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Panjang</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalLength) }} m</p>
                      </div>

                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Lebar Rata-rata</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadAverageWidth) }} m</p>
                      </div>

                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kapasitas</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalCapacity) }}</p>
                      </div>

                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Volume</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ formatNumber(selectedRoadTotalVolume) }}</p>
                      </div>

                      <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kepadatan</p>
                        <p class="mt-1 text-sm font-bold text-[#1F4B2C]">{{ selectedRoadDensity }}</p>
                      </div>

                      <div v-if="selectedRoadConditionSegments.length" class="col-span-2 mt-2 space-y-3">
                        <div class="flex items-center justify-between">
                          <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">
                            Kondisi Jalan
                          </p>

                          <span class="rounded-full bg-rose-50 px-2 py-1 text-[9px] font-bold text-rose-600">
                            {{ selectedRoadConditionSegments.length }} kondisi
                          </span>
                        </div>

                        <div
                          v-for="(segment, index) in selectedRoadConditionSegments"
                          :key="segment.id || segment.osm_id || index"
                          class="rounded-xl border border-slate-100 bg-slate-50 p-3"
                        >
                          <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-bold text-slate-700">
                              Segmen {{ index + 1 }}
                            </p>

                            <span
                              class="rounded-full px-2.5 py-1 text-[9px] font-bold uppercase"
                              :class="{
                                'bg-blue-100 text-blue-700':
                                  String(segment.kondisi_jalan || '').toLowerCase() === 'banjir',

                                'bg-amber-100 text-amber-700':
                                  String(segment.kondisi_jalan || '').toLowerCase() === 'longsor',

                                'bg-slate-200 text-slate-700':
                                  String(segment.kondisi_jalan || '').toLowerCase() === 'lainnya'
                              }"
                            >
                              {{ segment.kondisi_jalan || '-' }}
                            </span>
                          </div>

                          <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <div class="rounded-lg bg-white p-2.5">
                              <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">
                                Panjang Kondisi
                              </p>

                              <p class="mt-1 text-xs font-bold text-slate-700">
                                {{ formatNumber(Number(segment.panjang_kondisi_m || 0)) }} m
                              </p>
                            </div>

                            <div
                              v-if="String(segment.kondisi_jalan || '').toLowerCase() === 'lainnya'"
                              class="rounded-lg bg-white p-2.5"
                            >
                              <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">
                                Keterangan
                              </p>

                              <p class="mt-1 text-xs font-bold text-slate-700">
                                {{ segment.kondisi_lainnya || '-' }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div v-else class="col-span-2 mt-2 rounded-xl bg-emerald-50 p-3">
                        <p class="text-[9px] uppercase font-bold tracking-wider text-emerald-600">
                          Kondisi Jalan
                        </p>

                        <p class="mt-1 text-xs font-semibold text-emerald-700">
                          Normal
                        </p>
                      </div>
                    </div>
                  </div>

                  <div v-else class="mt-4 rounded-xl bg-slate-50 p-4 text-xs text-slate-400">Data ruas jalan belum tersedia.</div>
                </div>

                <div v-if="showEnvironmentData" class="rounded-2xl border border-[#D5F5DD] bg-[#F4FFFC]/60 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAFFE9] text-[#1F4B2C]">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3C7 8 5 11 5 14a7 7 0 0014 0c0-3-2-6-7-11z" /></svg>
                    </div>

                    <div>
                      <p class="text-sm font-bold text-slate-800">Data Lingkungan</p>
                      <p class="text-[10px] text-slate-400">{{ dataLingkungan.length }} data tersedia</p>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                      Pilih Data Lingkungan
                    </label>

                    <select v-model="selectedEnvironmentId" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-medium text-slate-700 outline-none focus:border-[#1F4B2C]">
                      <option :value="null">-- Pilih Data Lingkungan --</option>

                      <option v-for="item in dataLingkungan" :key="item.id" :value="item.id">
                        {{ item.wilayah || '-' }} — {{ item.parameter || '-' }} — {{ item.nilai ?? '-' }} {{ item.satuan || '' }}
                      </option>
                    </select>
                  </div>

                  <div v-if="selectedEnvironment" class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Wilayah</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedEnvironment.wilayah || '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Parameter</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedEnvironment.parameter || '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Nilai</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedEnvironment.nilai ?? '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Satuan</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedEnvironment.satuan || '-' }}</p>
                    </div>
                  </div>

                  <div v-else class="rounded-xl bg-slate-50 p-4 text-xs text-slate-400">
                    Silakan pilih data lingkungan.
                  </div>
                </div>

                <div v-if="showInfrastructureData" class="rounded-2xl border border-[#D5F5DD] bg-[#F4FFFC]/60 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAFFE9] text-[#1F4B2C]">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6" /></svg>
                    </div>

                    <div>
                      <p class="text-sm font-bold text-slate-800">Data Infrastruktur</p>
                      <p class="text-[10px] text-slate-400">{{ infrastrukturs.length }} data tersedia</p>
                    </div>
                  </div>

                  <div class="mb-4">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                      Pilih Data Infrastruktur
                    </label>

                    <select v-model="selectedInfrastructureId" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-medium text-slate-700 outline-none focus:border-[#1F4B2C]">
                      <option :value="null">-- Pilih Data Infrastruktur --</option>

                      <option v-for="item in infrastrukturs" :key="item.id" :value="item.id">
                        {{ item.jenis || '-' }} — {{ item.nama || item.judul || '-' }} — {{ item.lokasi || '-' }}
                      </option>
                    </select>
                  </div>

                  <div v-if="selectedInfrastructure" class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Jenis</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedInfrastructure.jenis || '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Nama</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">
                        {{ selectedInfrastructure.nama || selectedInfrastructure.judul || '-' }}
                      </p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Lokasi</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedInfrastructure.lokasi || '-' }}</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kondisi</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ selectedInfrastructure.kondisi || '-' }}</p>
                    </div>
                  </div>

                  <div v-else class="rounded-xl bg-slate-50 p-4 text-xs text-slate-400">
                    Silakan pilih data infrastruktur.
                  </div>
                </div>

                <div v-if="showWeatherData" class="rounded-2xl border border-[#D5F5DD] bg-[#F4FFFC]/60 p-4">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#EAFFE9] text-[#1F4B2C]">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 000-10 7 7 0 00-13 2" /></svg>
                    </div>

                    <div>
                      <p class="text-sm font-bold text-slate-800">Prakiraan Cuaca</p>
                      <p class="text-[10px] text-slate-400">{{ prakiraanCuaca.length }} data tersedia</p>
                    </div>
                  </div>

                  <div v-if="latestWeather" class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Suhu</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ latestWeather.suhu ?? '-' }} °C</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kelembapan</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ latestWeather.kelembapan ?? '-' }}%</p>
                    </div>

                    <div class="rounded-xl bg-white p-3 border border-slate-100 col-span-2">
                      <p class="text-[9px] uppercase font-bold tracking-wider text-slate-400">Kondisi</p>
                      <p class="mt-1 text-xs font-bold text-slate-700">{{ latestWeather.keterangan_cuaca || '-' }}</p>
                    </div>
                  </div>
                  <div v-else class="rounded-xl bg-slate-50 p-4 text-xs text-slate-400">Data cuaca belum tersedia.</div>
                </div>
              </div>
            </div>

          <div class="border-t border-slate-100 pt-6 space-y-5">
            <div>
              <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"><svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" /></svg>Parameter Skenario Kebijakan</h3>
              <p class="mt-1 text-xs text-slate-500">Tentukan intervensi atau kondisi kebijakan yang ingin disimulasikan.</p>
            </div>

            <label class="block space-y-1.5">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Parameter Skenario Kebijakan</span>
                <span class="text-[10px] font-medium text-slate-400">Isi bagian setelah tanda :</span>
              </div>

              <textarea v-model="promptKebijakan" @input="protectPromptTemplate" rows="9" class="w-full resize-y rounded-xl border border-slate-200 bg-[#EAFFE9]/20 px-4 py-3 text-sm leading-relaxed font-medium transition focus:border-[#4D7111] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4D7111]/20" spellcheck="false"></textarea>
              <p class="text-[11px] text-slate-400 leading-relaxed">Parameter di atas merupakan kondisi atau intervensi yang ingin disimulasikan. Data kondisi aktual digunakan sebagai dasar analisis.</p>
            </label>
          </div>

          <button type="button" class="w-full rounded-xl bg-[#1F4B2C] py-4 text-sm font-bold text-white transition hover:bg-[#275836] active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-60 shadow-lg shadow-[#1F4B2C]/20" :disabled="isAnalyzing || isLoadingData" @click="analyzeWithAI">
            <span v-if="isAnalyzing" class="flex items-center justify-center gap-2"><svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>Menganalisis Dampak Kebijakan...</span>
            <span v-else>Analisis Dampak Kebijakan</span>
          </button>
          </section>
        </div>

        <div class="lg:col-span-5 h-full">
          <section class="h-full space-y-6">
            <div class="rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm">
              <div class="border-b border-slate-100 pb-4">
                <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"><svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Hasil Simulasi</h3>
                <p class="mt-1 text-xs text-slate-500">Hasil analisis dampak kebijakan berdasarkan kondisi data saat ini.</p>
              </div>

              <div class="mt-5 max-h-[480px] overflow-y-auto pr-2 custom-scrollbar">
                <div v-if="isAnalyzing" class="rounded-xl border border-[#D5F5DD] bg-[#F4FFFC] p-10 text-center">
                  <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#EAFFE9]">
                    <svg class="h-7 w-7 animate-spin text-[#4D7111]" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                  </div>

                  <p class="mt-4 text-sm font-bold text-[#1F4B2C]">
                    Sedang menganalisis hasil simulasi
                  </p>

                  <p class="mt-1 text-xs leading-relaxed text-slate-400">
                    Sistem sedang memproses dampak, risiko, dan rekomendasi kebijakan.
                  </p>
                </div>

                <div v-else-if="!result" class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                  <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-300 shadow-sm">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                  </div>

                  <p class="mt-4 text-sm font-bold text-slate-500">
                    Belum ada hasil simulasi
                  </p>

                  <p class="mt-1 text-xs leading-relaxed text-slate-400">
                    Jalankan analisis untuk melihat dampak kebijakan berdasarkan kondisi data saat ini.
                  </p>
                </div>

                <div v-else class="space-y-5">
                  <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                    <div class="flex items-center gap-2">
                      <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">✓</span>

                      <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Analisis Berhasil</p>
                        <p class="text-sm font-bold text-emerald-900">Hasil simulasi tersedia</p>
                      </div>
                    </div>
                  </div>

                  <div v-if="jenisKebijakan === 'rekayasa_lalu_lintas'" class="rounded-xl border border-[#D5F5DD] bg-[#F4FFFC] p-4">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Jalur Rekayasa</p>

                    <div class="mt-3 flex items-center gap-3">
                      <div class="flex-1 rounded-xl border border-rose-100 bg-rose-50 p-3">
                        <p class="text-[9px] font-bold uppercase text-rose-500">Terdampak</p>
                        <p class="mt-1 text-xs font-bold text-rose-900">{{ selectedRuas?.nama_ruas_jalan || '-' }}</p>
                      </div>

                      <div class="font-black text-[#1F4B2C]">→</div>
                        <div class="flex-1 rounded-xl border border-emerald-100 bg-emerald-50 p-3">
                          <p class="text-[9px] font-bold uppercase text-emerald-600">Target</p>
                          <p class="mt-1 text-xs font-bold text-emerald-900">{{ selectedTargetRuas?.nama_ruas_jalan || '-' }}</p>
                        </div>
                      </div>
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-[#F4FFFC]/60 p-4">
                      <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ringkasan Analisis</p>
                      <p class="mt-2 text-sm leading-relaxed font-semibold text-slate-700">{{ result.ringkasan || '-' }}</p>
                    </div>

                    <div v-if="result.kondisi_awal?.length" class="space-y-3">
                      <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-[#1F4B2C]">Kondisi Awal</h4>

                        <span class="rounded-full bg-[#EAFFE9] px-2.5 py-1 text-[10px] font-bold text-[#1F4B2C]">{{ result.kondisi_awal.length }} parameter</span>
                      </div>

                      <div v-for="(item, index) in result.kondisi_awal" :key="index" class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                          <div>
                            <p class="text-xs font-bold text-slate-800">{{ item.parameter || '-' }}</p>
                            <p class="mt-1 text-[10px] text-slate-400">{{ item.satuan || '-' }}</p>
                          </div>

                          <span class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-black text-[#1F4B2C]">{{ item.nilai ?? '-' }}</span>
                        </div>

                        <p v-if="item.analisis" class="mt-3 border-t border-slate-100 pt-3 text-xs leading-relaxed text-slate-500">{{ item.analisis }}</p>
                      </div>
                    </div>

                    <div v-if="result.dampak?.length" class="space-y-3">
                      <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-[#1F4B2C]">Dampak Kebijakan</h4>
                        <span class="rounded-full bg-[#EAFFE9] px-2.5 py-1 text-[10px] font-bold text-[#1F4B2C]">{{ result.dampak.length }} dampak</span>
                      </div>

                      <div v-for="(item, index) in result.dampak" :key="index" class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                        <span class="inline-flex rounded-full bg-[#EAFFE9] px-2.5 py-1 text-[9px] font-bold uppercase tracking-wide text-[#1F4B2C]">{{ item.domain || 'Dampak' }}</span>
                        <p class="mt-2 text-sm font-bold text-slate-800">{{ item.parameter || '-' }}</p>
                        <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2">
                          <div class="rounded-lg bg-slate-50 p-3">
                            <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Nilai Awal</p>
                            <p class="mt-1 text-xs font-bold text-slate-700">{{ item.nilai_awal ?? '-' }}</p>
                          </div>

                          <div class="rounded-lg bg-slate-50 p-3">
                            <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Nilai Simulasi</p>
                            <p class="mt-1 text-xs font-bold text-[#1F4B2C]">{{ item.nilai_simulasi ?? '-' }}</p>
                          </div>
                        </div>

                        <div v-if="item.perubahan" class="mt-2 rounded-lg bg-amber-50 p-3">
                          <p class="text-[9px] font-bold uppercase tracking-wider text-amber-600">Perubahan</p>
                          <p class="mt-1 text-xs font-bold text-amber-800">{{ item.perubahan }}</p>
                        </div>
                        <p v-if="item.analisis" class="mt-3 text-xs leading-relaxed text-slate-500">{{ item.analisis }}</p>
                      </div>
                    </div>

                    <div v-if="result.dampak_positif?.length" class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                      <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">+</span>
                        <p class="text-sm font-bold text-emerald-900">Dampak Positif</p>
                      </div>

                      <ul class="mt-3 space-y-2">
                        <li v-for="(item, index) in result.dampak_positif" :key="index" class="flex gap-2 text-xs leading-relaxed text-emerald-800">
                          <span class="mt-1">•</span>
                          <span>{{ item }}</span>
                        </li>
                      </ul>
                    </div>

                    <div v-if="result.dampak_negatif?.length" class="rounded-xl border border-rose-100 bg-rose-50 p-4">
                      <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100 text-rose-700">−</span>
                        <p class="text-sm font-bold text-rose-900">Dampak Negatif</p>
                      </div>

                      <ul class="mt-3 space-y-2">
                        <li v-for="(item, index) in result.dampak_negatif" :key="index" class="flex gap-2 text-xs leading-relaxed text-rose-800">
                          <span class="mt-1">•</span>
                          <span>{{ item }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="p-6 md:p-8 rounded-2xl border border-[#D5F5DD] bg-white  ">
                <div class="max-h-[360px] pr-2 space-y-5 overflow-y-auto custom-scrollbar">
                  <div v-if="result?.hasil_penerapan" class="rounded-2xl border border-blue-100 bg-blue-50 p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 border-b border-blue-100 pb-4">
                      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">✓</div>

                      <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-blue-600">Hasil Penerapan</p>
                        <h3 class="text-xl font-bold text-blue-900">Proyeksi Penerapan Kebijakan</h3>
                      </div>
                    </div>

                    <div class="mt-5 rounded-xl bg-white p-4 text-xs leading-relaxed text-slate-700">
                      <template v-if="typeof result.hasil_penerapan === 'string'">{{ result.hasil_penerapan }}</template>
                      <div v-else class="space-y-3">
                        <div v-if="result.hasil_penerapan.ringkasan">
                          <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ringkasan</p>
                          <p class="mt-1">{{ result.hasil_penerapan.ringkasan }}</p>
                        </div>

                        <div v-if="result.hasil_penerapan.status">
                          <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</p>
                          <p class="mt-1 font-semibold">{{ result.hasil_penerapan.status }}</p>
                        </div>

                        <div v-if="result.hasil_penerapan.detail">
                          <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Detail</p>
                          <p class="mt-1">{{ result.hasil_penerapan.detail }}</p>
                        </div>

                        <pre v-if="!result.hasil_penerapan.ringkasan && !result.hasil_penerapan.status && !result.hasil_penerapan.detail" class="whitespace-pre-wrap font-sans">{{ JSON.stringify(result.hasil_penerapan, null, 2) }}</pre>
                      </div>
                    </div>
                  </div>

                  <div class="rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                      <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#1F4B2C] text-white">✦</div>

                      <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#4D7111]">Rekomendasi</p>
                        <h3 class="text-xl font-bold text-[#1F4B2C]">Rekomendasi Kebijakan</h3>
                      </div>
                    </div>

                    <div v-if="result?.rekomendasi?.length" class="mt-5 space-y-3">
                      <div v-for="(item, index) in result.rekomendasi" :key="index" class="rounded-xl border border-[#D5F5DD] bg-[#F4FFFC] p-4">
                        <div class="flex gap-3">
                          <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-[#EAFFE9] text-xs font-black text-[#1F4B2C]">{{ index + 1 }}</span>
                          <p class="text-xs font-semibold leading-relaxed text-slate-700">{{ item }}</p>
                        </div>
                      </div>
                    </div>

                    <div v-else class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-4 text-xs text-slate-400">Rekomendasi akan muncul setelah analisis kebijakan selesai.</div>
                  </div>

                  <div v-if="result?.risiko?.length" class="rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm">
                    <div class="border-b border-slate-100 pb-4">
                      <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"><svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.07 19h13.86a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z" /></svg>Risiko</h3>
                      <p class="mt-1 text-xs text-slate-500">Risiko yang teridentifikasi dari skenario kebijakan.</p>
                    </div>

                    <div class="mt-5 space-y-3">
                      <div v-for="(item, index) in result.risiko" :key="index" class="rounded-xl border border-slate-100 bg-[#F4FFFC]/60 p-4">
                        <div class="flex items-start justify-between gap-3">
                          <p class="text-sm font-bold text-slate-800">{{ item.risiko || '-' }}</p>
                          <span class="shrink-0 rounded-full px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-wide" :class="riskClass(item.tingkat)">{{ item.tingkat || 'Tidak diketahui' }}</span>
                        </div>
                        <p v-if="item.penjelasan" class="mt-3 text-xs leading-relaxed text-slate-500">{{ item.penjelasan }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <button v-if="result" type="button" class="mt-5 w-full rounded-xl py-3.5 text-xs font-bold text-white transition disabled:cursor-not-allowed disabled:opacity-50" :class="isSaved ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-[#1F4B2C] hover:bg-[#275836]'" :disabled="isSaved" @click="saveToHistory">
                  {{ isSaved ? 'Data Sudah Disimpan' : 'Simpan Simulasi' }}
                </button>
              </div>
              
          </section>
        </div>
        <section class="lg:col-span-12">
          <div v-if="result?.kesimpulan" class="rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-wider text-[#4D7111]">Kesimpulan</p>
            <p class="mt-3 text-sm font-semibold leading-relaxed text-[#1F4B2C]">{{ result.kesimpulan }}</p>
          </div>
        </section>
      </div>

      <section class="rounded-2xl border border-[#D5F5DD] bg-white p-6 md:p-8 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4">
          <h3 class="text-xl font-bold text-[#1F4B2C] flex items-center gap-2"> <svg class="w-5 h-5 text-[#4D7111]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Riwayat Simulasi </h3>
          <p class="mt-1 text-xs text-slate-500">Daftar simulasi kebijakan yang telah disimpan ke database.</p>
        </div>

        <div v-if="history.length" class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead>
              <tr class="border-b border-slate-200 text-slate-600 uppercase font-bold tracking-wider">
                <th class="pb-3 px-3">Judul</th>
                <th class="pb-3 px-3">Jenis Kebijakan</th>
                <th class="pb-3 px-3">Target</th>
                <th class="pb-3 px-3">Dampak</th>
                <th class="pb-3 px-3 text-right">Status</th>
                <th class="pb-3 px-3 text-right">Aksi</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 font-medium">
              <tr v-for="item in history" :key="item.id" class="hover:bg-[#F4FFFC]/80 transition cursor-pointer" @click="loadHistoryItem(item)">
                <td class="py-3.5 px-3 font-bold text-slate-800">{{ item.judul }}</td>
                <td class="py-3.5 px-3 text-slate-600">{{ labelForJenis(item.jenisKebijakan) }}</td>
                <td class="py-3.5 px-3 text-slate-600">
                  <template v-if="item.jenisKebijakan === 'rekayasa_lalu_lintas'">
                    <div class="space-y-1">
                      <p><span class="font-bold text-rose-600">A:</span> {{ item.lokasiAwal || '-' }}</p>
                      <p><span class="font-bold text-emerald-600">B:</span> {{ item.lokasiTarget || '-' }}</p>
                    </div>
                  </template>
                  <template v-else>{{ typeof item.target === 'object' ? (item.target?.lokasi_awal || item.target?.lokasi_target || '-') : (item.target || '-') }}</template>
                </td>
                <td class="py-3.5 px-3 text-slate-600">{{ item.jumlahDampak }} dampak</td>
                <td class="py-3.5 px-3 text-right">
                  <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide" :class="`status-badge--${item.status}`">{{ statusLabel(item.status) }}</span>
                </td>

                <td class="py-3.5 px-3 text-right">
                  <button type="button" class="inline-flex items-center justify-center rounded-lg bg-rose-50 px-3 py-2 text-[10px] font-bold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700 disabled:cursor-not-allowed disabled:opacity-50" :disabled="item.isDeleting" @click.stop="deleteHistoryItem(item)">
                    <svg v-if="!item.isDeleting" class="mr-1.5 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12" />
                    </svg>

                    <svg v-else class="mr-1.5 h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div v-else class="rounded-xl border border-dashed border-slate-200 bg-slate-50 py-12 text-center">
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white text-slate-300 shadow-sm">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <p class="mt-4 text-sm font-bold text-slate-500">Belum ada riwayat simulasi</p>
          <p class="mt-1 text-xs text-slate-400">Hasil simulasi yang disimpan akan muncul di tabel ini.</p>
        </div>
      </section>

      <div v-if="showSaveSuccessModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
          <div class="p-6 md:p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
              <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <h3 class="mt-5 text-lg font-bold text-[#1F4B2C]">
              Simulasi Berhasil Disimpan
            </h3>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
              Hasil simulasi kebijakan berhasil disimpan ke riwayat simulasi.
            </p>

            <button type="button" class="mt-6 w-full rounded-xl bg-[#1F4B2C] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#275836] active:scale-[0.99]" @click="showSaveSuccessModal = false">
              Mengerti
            </button>
          </div>
        </div>
      </div>

      <div v-if="showDeleteConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
          <div class="p-6 md:p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 text-rose-600">
              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-8.1 14a2 2 0 001.73 3h16.16a2 2 0 001.73-3l-8.1-14a2 2 0 00-3.42 0z" />
              </svg>
            </div>

            <h3 class="mt-5 text-lg font-bold text-[#1F4B2C]">
              Hapus Riwayat Simulasi?
            </h3>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
              Apakah kamu yakin ingin menghapus riwayat
              <span class="font-bold text-slate-700">
                "{{ deleteTarget?.judul }}"
              </span>?
            </p>

            <p class="mt-2 text-xs text-rose-500">
              Data yang sudah dihapus tidak dapat dikembalikan.
            </p>

            <div class="mt-6 grid grid-cols-2 gap-3">
              <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50" @click="showDeleteConfirmModal = false; deleteTarget = null">
                Batal
              </button>

              <button type="button" class="rounded-xl bg-rose-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-rose-700 active:scale-[0.99]" @click="confirmDeleteHistory">
                Ya, Hapus
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="showDeleteSuccessModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
          <div class="p-6 md:p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
              <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <h3 class="mt-5 text-lg font-bold text-[#1F4B2C]">
              Riwayat Berhasil Dihapus
            </h3>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
              Riwayat simulasi berhasil dihapus dari database.
            </p>

            <button type="button" class="mt-6 w-full rounded-xl bg-[#1F4B2C] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#275836] active:scale-[0.99]" @click="showDeleteSuccessModal = false">
              Mengerti
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

  <script setup>
    import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue'
    import Header from '../components/layout/Header2.vue'
    import { useJalanStore } from '../scriptViews/jalan/store.js'
    import { useInfrastruktur } from '../scriptViews/infrastruktur/main.js'
    import { useLingkungan } from '../scriptViews/lingkungan/main.js'

    const { loadJalan } = useJalanStore()
    const API_BASE = import.meta.env.VITE_API_URL;
    const API_ENDPOINTS = {
      wilayah: `${API_BASE}/api/wilayah`,
      cuaca: `${API_BASE}/api/cuaca`,
      gemini: `${API_BASE}/api/gemini/generate`,
      simulasi: `${API_BASE}/api/simulasi-kebijakan`,
    }

    function getCookie(name) {
      const row = document.cookie
        .split("; ")
        .find((item) => item.startsWith(`${name}=`));

      return row ? decodeURIComponent(row.substring(name.length + 1)) : null;
    }

    async function getCsrfToken() {
      const response = await fetch(`${API_BASE}/sanctum/csrf-cookie`, {
        method: "GET",
        credentials: "include",
        headers: {
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        throw new Error(`Gagal mengambil CSRF cookie. HTTP ${response.status}`);
      }

      const token = getCookie("XSRF-TOKEN");

      if (!token) {
        throw new Error("Cookie XSRF-TOKEN tidak ditemukan.");
      }

      return token;
    }


    const ruasJalanList = ref([])
    const {
      environmentRows: dataLingkungan,
      loadEnvironmentalData,
    } = useLingkungan()

    const {
        infrastructureData: infrastrukturs,
        loadInfrastructureData,
    } = useInfrastruktur({
        autoLoad: false,
    })
    const wilayahList = ref([])
    const prakiraanCuaca = ref([])

    const judulKebijakan = ref('')
    const jenisKebijakan = ref('pelebaran_jalan')
    const promptKebijakan = ref('')

    const isSaved = ref(false)
    const showSaveSuccessModal = ref(false)
    const showDeleteConfirmModal = ref(false)
    const showDeleteSuccessModal = ref(false)
    const deleteTarget = ref(null)
    const deleteErrorMessage = ref('')

    const selectedRuasId = ref(null)
    const selectedTargetRuasId = ref(null)
    const selectedEnvironmentId = ref(null)
    const selectedInfrastructureId = ref(null)
    const selectedKodeWilayah = ref(null)

    const roadSearchQuery = ref('')
    const targetRoadSearchQuery = ref('')

    const showRoadDropdown = ref(false)
    const showTargetRoadDropdown = ref(false)

    const isLoadingData = ref(false)
    const isAnalyzing = ref(false)

    const result = ref(null)
    const history = ref([])

    const jenisKebijakanLabels = {
      pelebaran_jalan: 'Pelebaran Jalan',
      rekayasa_lalu_lintas: 'Rekayasa Lalu Lintas',
      normalisasi_drainase: 'Normalisasi Drainase',
      pembangunan_infrastruktur: 'Pembangunan Infrastruktur',
      lingkungan: 'Kebijakan Lingkungan'
    }

    const promptTemplates = {
pelebaran_jalan:`Ruas Jalan:
Panjang Pelebaran:
Lebar Tambahan:
Lama Pengerjaan:
Deskripsi:`,

rekayasa_lalu_lintas: `Lokasi Awal/Terdampak:
Lokasi Target Pengalihan:
Jenis Rekayasa:
Durasi Penerapan:
Target Perubahan:
Deskripsi:`,

normalisasi_drainase: `Daerah Normalisasi:
Lama Pengerjaan:
Target Penanganan:
Deskripsi:`,

pembangunan_infrastruktur: `Lokasi Pembangunan:
Jenis Infrastruktur:
Lama Pembangunan:
Kapasitas/Rencana:
Deskripsi:`,

lingkungan: `Wilayah:
Jenis Intervensi Lingkungan:
Target Penanganan:
Lama Penerapan:
Deskripsi:`
    }

    const selectedRuas = computed(() => {
      if (!ruasJalanList.value.length) {
        return null
      }

      if (selectedRuasId.value === null || selectedRuasId.value === undefined || selectedRuasId.value === '') {
        return null
      }

      return ruasJalanList.value.find(
        road => String(road.id_jalan) === String(selectedRuasId.value)
      ) || null
    })

    const selectedTargetRuas = computed(() => {
      if (!ruasJalanList.value.length || selectedTargetRuasId.value === null || selectedTargetRuasId.value === undefined || selectedTargetRuasId.value === '') {
        return null
      }

      return ruasJalanList.value.find(
        road => String(road.id_jalan) === String(selectedTargetRuasId.value)
      ) || null
    })

    const selectedRoadSegments = computed(() => {
      if (!Array.isArray(selectedRuas.value?.segmen_jalans)) {
        return []
      }

      return selectedRuas.value.segmen_jalans
    })

    const targetRoadSegments = computed(() => {
      if (!Array.isArray(selectedTargetRuas.value?.segmen_jalans)) {
        return []
      }

      return selectedTargetRuas.value.segmen_jalans
    })

    const selectedRoadTotalLength = computed(() => {
      const directLength = Number(selectedRuas.value?.panjang_m)

      if (Number.isFinite(directLength) && directLength > 0) {
        return directLength
      }

      return selectedRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.panjang_m || 0),
        0
      )
    })

    const targetRoadTotalLength = computed(() => {
      const directLength = Number(selectedTargetRuas.value?.panjang_m)

      if (Number.isFinite(directLength) && directLength > 0) {
        return directLength
      }

      return targetRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.panjang_m || 0),
        0
      )
    })

    const selectedRoadAverageWidth = computed(() => {
      const widths = selectedRoadSegments.value
        .map(segment => Number(segment.lebar_m))
        .filter(value => Number.isFinite(value) && value > 0)

      if (widths.length) {
        return widths.reduce((total, value) => total + value, 0) / widths.length
      }

      const directWidth = Number(selectedRuas.value?.lebar_m)

      if (Number.isFinite(directWidth) && directWidth > 0) {
        return directWidth
      }

      return 0
    })

    const targetRoadAverageWidth = computed(() => {
      const widths = targetRoadSegments.value
        .map(segment => Number(segment.lebar_m))
        .filter(value => Number.isFinite(value) && value > 0)

      if (widths.length) {
        return widths.reduce((total, value) => total + value, 0) / widths.length
      }

      const directWidth = Number(selectedTargetRuas.value?.lebar_m)

      if (Number.isFinite(directWidth) && directWidth > 0) {
        return directWidth
      }

      return 0
    })

    const selectedRoadTotalCapacity = computed(() => {
      const directCapacity = Number(selectedRuas.value?.kapasitas_jalan)

      if (Number.isFinite(directCapacity) && directCapacity > 0) {
        return directCapacity
      }

      return selectedRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.kapasitas_jalan || 0),
        0
      )
    })

    const targetRoadTotalCapacity = computed(() => {
      const directCapacity = Number(selectedTargetRuas.value?.kapasitas_jalan)

      if (Number.isFinite(directCapacity) && directCapacity > 0) {
        return directCapacity
      }

      return targetRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.kapasitas_jalan || 0),
        0
      )
    })

    const selectedRoadTotalVolume = computed(() => {
      const directVolume = Number(selectedRuas.value?.volume_kendaraan)

      if (Number.isFinite(directVolume) && directVolume > 0) {
        return directVolume
      }

      return selectedRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.volume_kendaraan || 0),
        0
      )
    })

    const targetRoadTotalVolume = computed(() => {
      const directVolume = Number(selectedTargetRuas.value?.volume_kendaraan)

      if (Number.isFinite(directVolume) && directVolume > 0) {
        return directVolume
      }

      return targetRoadSegments.value.reduce(
        (total, segment) => total + Number(segment.volume_kendaraan || 0),
        0
      )
    })

  const selectedRoadDensity = computed(() => {
    const segments = selectedRoadSegments.value
    const totalVolume = segments.reduce((total, segment) => total + Number(segment.volume_kendaraan || 0), 0)
    const totalCapacity = segments.reduce((total, segment) => total + Number(segment.kapasitas_jalan || 0), 0)
    if (totalCapacity <= 0) {
      return 'Tidak Diketahui'
    }
    const persentase = (totalVolume / totalCapacity) * 100
    if (persentase > 80) {
      return 'Macet'
    }
    if (persentase >= 50) {
      return 'Sedang'
    }
    return 'Lancar'
  })

    const selectedRoadConditionSegments = computed(() => {
      return selectedRoadSegments.value.filter(segment => {
        const kondisi = String(segment.kondisi_jalan || '')
          .trim()
          .toLowerCase()

        return ['banjir', 'longsor', 'lainnya'].includes(kondisi)
      })
    })

    const targetRoadConditionSegments = computed(() => {
      return targetRoadSegments.value.filter(segment => {
        const kondisi = String(segment.kondisi_jalan || '')
          .trim()
          .toLowerCase()

        return ['banjir', 'longsor', 'lainnya'].includes(kondisi)
      })
    })

    const targetRoadDensity = computed(() => {
      const segments = targetRoadSegments.value
      const totalVolume = segments.reduce((total, segment) => total + Number(segment.volume_kendaraan || 0), 0)
      const totalCapacity = segments.reduce((total, segment) => total + Number(segment.kapasitas_jalan || 0), 0)
      if (totalCapacity <= 0) {
        return 'Tidak Diketahui'
      }
      const persentase = (totalVolume / totalCapacity) * 100
      if (persentase > 80) {
        return 'Macet'
      }
      if (persentase >= 50) {
        return 'Sedang'
      }
      return 'Lancar'
    })
    
    const filteredRoads = computed(() => {
      const query = roadSearchQuery.value.trim().toLowerCase()
      const roads = ruasJalanList.value.filter(road => String(road.id_jalan) !== String(selectedTargetRuasId.value))
      if (!query) {
        return roads.slice(0, 50)
      }
      return roads.filter(road => {
        const nama = String(road.nama_ruas_jalan || '').toLowerCase()
        const id = String(road.id_jalan || '').toLowerCase()
        const osmId = String(road.osm_id || '').toLowerCase()

        return nama.includes(query) || id.includes(query) || osmId.includes(query)
      }).slice(0, 50)
    })

    const filteredTargetRoads = computed(() => {
      const query = targetRoadSearchQuery.value.trim().toLowerCase()
      const roads = ruasJalanList.value.filter(road => String(road.id_jalan) !== String(selectedRuasId.value))
      if (!query) {
        return roads.slice(0, 50)
      }
      return roads.filter(road => {
        const nama = String(road.nama_ruas_jalan || '').toLowerCase()
        const id = String(road.id_jalan || '').toLowerCase()
        const osmId = String(road.osm_id || '').toLowerCase()

        return nama.includes(query) || id.includes(query) || osmId.includes(query)
      }).slice(0, 50)
    })

    const selectedEnvironment = computed(() => {
      if (!selectedEnvironmentId.value) {
        return null
      }

      return dataLingkungan.value.find(
        item => String(item.id) === String(selectedEnvironmentId.value)
      ) || null
    })

    const selectedInfrastructure = computed(() => {
      if (!selectedInfrastructureId.value) {
        return null
      }

      return infrastrukturs.value.find(
        item => String(item.id) === String(selectedInfrastructureId.value)
      ) || null
    })

    const latestWeather = computed(() => {
      if (!prakiraanCuaca.value.length) {
        return null
      }

      return prakiraanCuaca.value[0]
    })

    const showRoadData = computed(() => {
      return [
        'pelebaran_jalan',
        'rekayasa_lalu_lintas',
        'normalisasi_drainase',
        'pembangunan_infrastruktur'
      ].includes(jenisKebijakan.value)
    })

    const showEnvironmentData = computed(() => {
      return [
        'normalisasi_drainase',
        'pembangunan_infrastruktur',
        'lingkungan'
      ].includes(jenisKebijakan.value)
    })

    const showInfrastructureData = computed(() => {
      return [
        'normalisasi_drainase',
        'pembangunan_infrastruktur',
        'lingkungan'
      ].includes(jenisKebijakan.value)
    })

    const showWeatherData = computed(() => {
      return [
        'normalisasi_drainase',
        'lingkungan'
      ].includes(jenisKebijakan.value)
    })

    watch(jenisKebijakan, newType => {
  promptKebijakan.value = promptTemplates[newType] || ''
  result.value = null

  showRoadDropdown.value = false
  showTargetRoadDropdown.value = false

  if (newType !== 'rekayasa_lalu_lintas') {
    selectedTargetRuasId.value = null
    targetRoadSearchQuery.value = ''
  }

  nextTick(() => {
    syncSelectedRoadToPrompt()

    if (newType === 'rekayasa_lalu_lintas') {
      syncTargetRoadToPrompt()
    }
  })
})

  watch(selectedRuasId, newId => {
  if (!newId) {
    return
  }

  const road = ruasJalanList.value.find(
    item => String(item.id_jalan) === String(newId)
  )

  if (road) {
    roadSearchQuery.value = road.nama_ruas_jalan || ''

    syncSelectedRoadToPrompt()
  }

  if (String(selectedTargetRuasId.value) === String(newId)) {
    selectedTargetRuasId.value = null
    targetRoadSearchQuery.value = ''
  }
})

  watch(selectedTargetRuasId, newId => {
  if (!newId) {
    return
  }

  const road = ruasJalanList.value.find(
    item => String(item.id_jalan) === String(newId)
  )

  if (road) {
    targetRoadSearchQuery.value = road.nama_ruas_jalan || ''

    syncTargetRoadToPrompt()
  }
})

    watch(selectedKodeWilayah, async newCode => {
      if (!newCode) {
        prakiraanCuaca.value = []
        return
      }

      await loadWeatherData(newCode)
    })

    onMounted(async () => {
      promptKebijakan.value = promptTemplates[jenisKebijakan.value] || ''

      await Promise.all([
        loadDatabaseData(),
        loadSimulationHistory()
      ])
    })

    onUnmounted(() => {
      showRoadDropdown.value = false
      showTargetRoadDropdown.value = false
    })

    async function fetchJson(url) {
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          Accept: 'application/json',
          'Cache-Control': 'no-cache'
        },
        cache: 'no-store'
      })

      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`)
      }

      const data = await response.json()

      return unwrapArray(data)
    }

    function unwrapArray(data) {
      if (Array.isArray(data)) {
        return data
      }

      if (Array.isArray(data.data)) {
        return data.data
      }

      if (Array.isArray(data.results)) {
        return data.results
      }

      if (data.data && typeof data.data === 'object') {
        if (Array.isArray(data.data.data)) {
          return data.data.data
        }

        if (Array.isArray(data.data.results)) {
          return data.data.results
        }
      }

      return []
    }

    async function loadRoadData() {
        try {
            const data = await loadJalan()

            ruasJalanList.value = data.map(normalizeRoad)

            console.log('Data ruas jalan:', ruasJalanList.value.length)
            console.log('Contoh data jalan:', ruasJalanList.value[0])
        } catch (error) {
            console.error('Gagal mengambil data jalan:', error)
            ruasJalanList.value = []
        }
    }

    async function loadDatabaseData() {
      isLoadingData.value = true

      try {
          const requests = await Promise.allSettled([
              loadRoadData(),
              loadEnvironmentalData(),
              loadInfrastructureData(),
              loadWilayahData(),
          ])

          requests.forEach((request, index) => {
              if (request.status === 'rejected') {
                  console.error(
                      `Gagal memuat data ke-${index + 1}:`,
                      request.reason
                  )
              }
          })

          if (selectedKodeWilayah.value) {
              await loadWeatherData(selectedKodeWilayah.value)
          }
      } finally {
          isLoadingData.value = false
      }
  }

    async function loadWilayahData() {
      try {
        wilayahList.value = await fetchJson(`${API_ENDPOINTS.wilayah}?_=${Date.now()}`)

        const first = wilayahList.value[0]

        if (first) {
          selectedKodeWilayah.value =
            first.kode_wilayah ||
            first.kode ||
            first.id_wilayah ||
            first.id ||
            null
        }
      } catch (error) {
        console.error('Gagal mengambil data wilayah:', error)
        wilayahList.value = []
        selectedKodeWilayah.value = null
      }
    }

    async function loadWeatherData(kodeWilayah) {
      if (!kodeWilayah) {
        prakiraanCuaca.value = []
        return
      }

      try {
        const url = `${API_ENDPOINTS.cuaca}/${encodeURIComponent(kodeWilayah)}?_=${Date.now()}`
        const data = await fetchJson(url)

        prakiraanCuaca.value = data.map(item => ({
          ...item,
          kode_wilayah: item.kode_wilayah || kodeWilayah,
          suhu: item.suhu ?? item.temperature ?? item.temp,
          kelembapan: item.kelembapan ?? item.humidity,
          keterangan_cuaca: item.keterangan_cuaca || item.keterangan || item.deskripsi || item.weather_description || '-'
        }))

        console.log('Data cuaca:', prakiraanCuaca.value)
      } catch (error) {
        console.error('Gagal mengambil data cuaca:', error)
        prakiraanCuaca.value = []
      }
    }

    function normalizeRoad(item) {
      return {
        id_jalan: item.id_jalan ?? item.id,
        osm_id: item.osm_id ?? null,
        nama_ruas_jalan: item.nama_ruas_jalan || item.nama || 'Ruas Jalan Tanpa Nama',
        panjang_m: item.panjang_m ?? null,
        lebar_m: item.lebar_m ?? null,
        kapasitas_jalan: item.kapasitas_jalan ?? null,
        volume_kendaraan: item.volume_kendaraan ?? null,
        tingkat_kepadatan: item.tingkat_kepadatan ?? null,
        tipe_jalan_detail: item.tipe_jalan_detail ?? null,
        koordinat_geometri: item.koordinat_geometri ?? null,
        segmen_jalans: Array.isArray(item.segmen_jalans) ? item.segmen_jalans : []
      }
    }

    function setPromptField(label, value) {
  const lines = promptKebijakan.value.split('\n')

  const index = lines.findIndex(line => {
    return line.toLowerCase().startsWith(`${label.toLowerCase()}:`)
  })

  if (index === -1) {
    return
  }

  lines[index] = `${label}: ${value || ''}`

  promptKebijakan.value = lines.join('\n')
}

function syncSelectedRoadToPrompt() {
  const roadName = selectedRuas.value?.nama_ruas_jalan || ''

  if (!roadName) {
    return
  }

  if (jenisKebijakan.value === 'pelebaran_jalan') {
    setPromptField('Ruas Jalan', roadName)
  }

  if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
    setPromptField('Lokasi Awal/Terdampak', roadName)
  }

  if (jenisKebijakan.value === 'normalisasi_drainase') {
    setPromptField('Daerah Normalisasi', roadName)
  }

  if (jenisKebijakan.value === 'pembangunan_infrastruktur') {
    setPromptField('Lokasi Pembangunan', roadName)
  }
}

function syncTargetRoadToPrompt() {
  const roadName = selectedTargetRuas.value?.nama_ruas_jalan || ''

  if (!roadName) {
    return
  }

  if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
    setPromptField('Lokasi Target Pengalihan', roadName)
  }
}

function selectRoad(road) {
  if (String(road.id_jalan) === String(selectedTargetRuasId.value)) {
    alert('Ruas terdampak tidak boleh sama dengan ruas target pengalihan.')
    return
  }

  selectedRuasId.value = road.id_jalan
  roadSearchQuery.value = road.nama_ruas_jalan || ''
  showRoadDropdown.value = false

  syncSelectedRoadToPrompt()
}

function selectTargetRoad(road) {
  if (String(road.id_jalan) === String(selectedRuasId.value)) {
    alert('Ruas target pengalihan tidak boleh sama dengan ruas terdampak.')
    return
  }

  selectedTargetRuasId.value = road.id_jalan
  targetRoadSearchQuery.value = road.nama_ruas_jalan || ''
  showTargetRoadDropdown.value = false

  syncTargetRoadToPrompt()
}

    function protectPromptTemplate(event) {
      const textarea = event.target
      const template = promptTemplates[jenisKebijakan.value] || ''
      const templateLines = template.split('\n')
      const currentLines = textarea.value.split('\n')

      const cursorStart = textarea.selectionStart
      const cursorEnd = textarea.selectionEnd

      const rebuiltLines = templateLines.map((templateLine, index) => {
        const colonIndex = templateLine.indexOf(':')

        if (colonIndex === -1) {
          return templateLine
        }

        const label = templateLine.substring(0, colonIndex + 1)
        const currentLine = currentLines[index] || ''
        const currentColonIndex = currentLine.indexOf(':')

        if (currentColonIndex !== -1) {
          return `${label}${currentLine.substring(currentColonIndex + 1)}`
        }

        return label
      })

      const newValue = rebuiltLines.join('\n')

      promptKebijakan.value = newValue

      nextTick(() => {
        textarea.setSelectionRange(cursorStart, cursorEnd)
      })
    }

    function getPromptValue(label) {
      const lines = promptKebijakan.value.split('\n')

      const line = lines.find(item => {
        return item.toLowerCase().startsWith(`${label.toLowerCase()}:`)
      })

      if (!line) {
        return ''
      }

      return line.substring(line.indexOf(':') + 1).trim()
    }

    function getScenarioTarget() {
      if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
        return {
          lokasi_awal: getPromptValue('Lokasi Awal/Terdampak') || selectedRuas.value?.nama_ruas_jalan || 'Tidak ditentukan',
          lokasi_target: getPromptValue('Lokasi Target Pengalihan') || selectedTargetRuas.value?.nama_ruas_jalan || 'Tidak ditentukan',
          ruas_awal: selectedRuas.value
            ? {
                id_jalan: selectedRuas.value.id_jalan,
                nama_ruas_jalan: selectedRuas.value.nama_ruas_jalan
              }
            : null,
          ruas_target: selectedTargetRuas.value
            ? {
                id_jalan: selectedTargetRuas.value.id_jalan,
                nama_ruas_jalan: selectedTargetRuas.value.nama_ruas_jalan
              }
            : null
        }
      }

      const lines = promptKebijakan.value.split('\n')

      const targetLine = lines.find(line => {
        const lower = line.toLowerCase()

        return (
          lower.startsWith('ruas jalan:') ||
          lower.startsWith('lokasi/ruas jalan:') ||
          lower.startsWith('daerah normalisasi:') ||
          lower.startsWith('lokasi pembangunan:') ||
          lower.startsWith('wilayah:')
        )
      })

      if (!targetLine) {
        return selectedRuas.value?.nama_ruas_jalan || 'Tidak ditentukan'
      }

      return targetLine.substring(targetLine.indexOf(':') + 1).trim() || 'Belum ditentukan'
    }

    function getRoadBaseline(road, segments, totalLength, averageWidth, totalCapacity, totalVolume, density) {
      if (!road) {
        return null
      }

      return {
        id_jalan: road.id_jalan,
        osm_id: road.osm_id,
        nama_ruas_jalan: road.nama_ruas_jalan,
        panjang_m: totalLength,
        lebar_m: averageWidth,
        jumlah_segmen: segments.length,
        kapasitas_jalan: totalCapacity,
        volume_kendaraan: totalVolume,
        tingkat_kepadatan: density,
        tipe_jalan_detail: road.tipe_jalan_detail,
        koordinat_geometri: road.koordinat_geometri,
        segmen_jalans: segments.map(segment => ({
          id_segmen: segment.id_segmen,
          panjang_m: segment.panjang_m,
          lebar_m: segment.lebar_m,
          tipe_jalan_detail: segment.tipe_jalan_detail,
          kapasitas_jalan: segment.kapasitas_jalan,
          volume_kendaraan: segment.volume_kendaraan,
          tingkat_kepadatan: segment.tingkat_kepadatan
        }))
      }
    }

    function getRelevantBaseline() {
      const baseline = {
        jalan: {
          jumlah_ruas: ruasJalanList.value.length,
          ruas_terpilih: getRoadBaseline(
            selectedRuas.value,
            selectedRoadSegments.value,
            selectedRoadTotalLength.value,
            selectedRoadAverageWidth.value,
            selectedRoadTotalCapacity.value,
            selectedRoadTotalVolume.value,
            selectedRoadDensity.value
          )
        }
      }

      if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
        baseline.jalan.ruas_terdampak = getRoadBaseline(
          selectedRuas.value,
          selectedRoadSegments.value,
          selectedRoadTotalLength.value,
          selectedRoadAverageWidth.value,
          selectedRoadTotalCapacity.value,
          selectedRoadTotalVolume.value,
          selectedRoadDensity.value
        )

        baseline.jalan.ruas_target_pengalihan = getRoadBaseline(
          selectedTargetRuas.value,
          targetRoadSegments.value,
          targetRoadTotalLength.value,
          targetRoadAverageWidth.value,
          targetRoadTotalCapacity.value,
          targetRoadTotalVolume.value,
          targetRoadDensity.value
        )
      }

      if (showEnvironmentData.value) {
        baseline.lingkungan = selectedEnvironment.value
          ? {
              wilayah: selectedEnvironment.value.wilayah,
              kode_wilayah: selectedEnvironment.value.kode_wilayah,
              parameter: selectedEnvironment.value.parameter,
              indikator: selectedEnvironment.value.indikator,
              nilai: selectedEnvironment.value.nilai,
              satuan: selectedEnvironment.value.satuan,
              tahun: selectedEnvironment.value.tahun
            }
          : null
      }

      if (showInfrastructureData.value) {
        baseline.infrastruktur = selectedInfrastructure.value
          ? {
              api_id: selectedInfrastructure.value.api_id,
              kode: selectedInfrastructure.value.kode,
              jenis: selectedInfrastructure.value.jenis,
              nama: selectedInfrastructure.value.nama,
              judul: selectedInfrastructure.value.judul,
              lokasi: selectedInfrastructure.value.lokasi,
              tahun: selectedInfrastructure.value.tahun,
              nilai: selectedInfrastructure.value.nilai,
              satuan: selectedInfrastructure.value.satuan,
              kondisi: selectedInfrastructure.value.kondisi,
              sumber: selectedInfrastructure.value.sumber
            }
          : null
      }

      if (showWeatherData.value) {
        baseline.cuaca = prakiraanCuaca.value.slice(0, 20).map(item => ({
          kode_wilayah: item.kode_wilayah,
          waktu_prakiraan: item.waktu_prakiraan,
          suhu: item.suhu,
          kelembapan: item.kelembapan,
          kode_cuaca: item.kode_cuaca,
          keterangan_cuaca: item.keterangan_cuaca,
          kecepatan_angin: item.kecepatan_angin,
          arah_angin: item.arah_angin,
          tutupan_awan: item.tutupan_awan,
          jarak_pandang: item.jarak_pandang
        }))
      }

      return baseline
    }

    function buildAnalysisInstruction() {
      const domainsByPolicy = {
        pelebaran_jalan: [
          {
            key: 'lalu_lintas',
            icon: '🚦',
            title: 'Lalu Lintas'
          },
          {
            key: 'infrastruktur',
            icon: '🏗️',
            title: 'Infrastruktur'
          },
          {
            key: 'lingkungan',
            icon: '🌿',
            title: 'Lingkungan'
          }
        ],

        rekayasa_lalu_lintas: [
          {
            key: 'lalu_lintas',
            icon: '🚦',
            title: 'Lalu Lintas'
          },
          {
            key: 'infrastruktur',
            icon: '🏗️',
            title: 'Infrastruktur'
          },
          {
            key: 'lingkungan',
            icon: '🌿',
            title: 'Lingkungan'
          }
        ],

        normalisasi_drainase: [
          {
            key: 'banjir',
            icon: '🌧️',
            title: 'Banjir & Drainase'
          },
          {
            key: 'lingkungan',
            icon: '🌿',
            title: 'Lingkungan'
          },
          {
            key: 'infrastruktur',
            icon: '🏗️',
            title: 'Infrastruktur'
          }
        ],

        pembangunan_infrastruktur: [
          {
            key: 'infrastruktur',
            icon: '🏗️',
            title: 'Infrastruktur'
          },
          {
            key: 'lalu_lintas',
            icon: '🚦',
            title: 'Lalu Lintas'
          },
          {
            key: 'lingkungan',
            icon: '🌿',
            title: 'Lingkungan'
          }
        ],

        lingkungan: [
          {
            key: 'lingkungan',
            icon: '🌿',
            title: 'Lingkungan'
          },
          {
            key: 'infrastruktur',
            icon: '🏗️',
            title: 'Infrastruktur'
          },
          {
            key: 'cuaca',
            icon: '🌦️',
            title: 'Cuaca'
          }
        ]
      }

      return domainsByPolicy[jenisKebijakan.value] || domainsByPolicy.lingkungan
    }

    async function analyzeWithAI() {
      isSaved.value = false

      if (!promptKebijakan.value.trim()) {
        alert('Parameter skenario kebijakan belum diisi.')
        return
      }

      if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
        if (!selectedRuas.value) {
          alert('Pilih lokasi awal atau ruas jalan yang terdampak.')
          return
        }

        if (!selectedTargetRuas.value) {
          alert('Pilih lokasi target pengalihan.')
          return
        }

        if (
          String(selectedRuasId.value) ===
          String(selectedTargetRuasId.value)
        ) {
          alert(
            'Lokasi awal dan lokasi target pengalihan tidak boleh sama.'
          )
          return
        }
      }

      isAnalyzing.value = true
      result.value = null

      const relevantBaseline = getRelevantBaseline()
      const analysisDomains = buildAnalysisInstruction()

      const rekayasaLaluLintas =
        jenisKebijakan.value === 'rekayasa_lalu_lintas'
          ? {
              lokasi_awal: selectedRuas.value
                ? {
                    id_jalan: selectedRuas.value.id_jalan,
                    nama_ruas_jalan: selectedRuas.value.nama_ruas_jalan,
                    panjang_m: selectedRoadTotalLength.value,
                    lebar_m: selectedRoadAverageWidth.value,
                    kapasitas_jalan: selectedRoadTotalCapacity.value,
                    volume_kendaraan: selectedRoadTotalVolume.value,
                    tingkat_kepadatan: selectedRoadDensity.value,

                    kondisi_jalan: selectedRoadConditionSegments.value.map(
                      (segment) => ({
                        kondisi_jalan: segment.kondisi_jalan,
                        panjang_kondisi_m: Number(
                          segment.panjang_kondisi_m || 0
                        ),
                        kondisi_lainnya:
                          String(segment.kondisi_jalan || '').toLowerCase() ===
                          'lainnya'
                            ? segment.kondisi_lainnya || null
                            : null
                      })
                    )
                  }
                : null,

              lokasi_target: selectedTargetRuas.value
                ? {
                    id_jalan: selectedTargetRuas.value.id_jalan,
                    nama_ruas_jalan:
                      selectedTargetRuas.value.nama_ruas_jalan,
                    panjang_m: targetRoadTotalLength.value,
                    lebar_m: targetRoadAverageWidth.value,
                    kapasitas_jalan: targetRoadTotalCapacity.value,
                    volume_kendaraan: targetRoadTotalVolume.value,
                    tingkat_kepadatan: targetRoadDensity.value,

                    kondisi_jalan: targetRoadConditionSegments.value.map(
                      (segment) => ({
                        kondisi_jalan: segment.kondisi_jalan,
                        panjang_kondisi_m: Number(
                          segment.panjang_kondisi_m || 0
                        ),
                        kondisi_lainnya:
                          String(segment.kondisi_jalan || '').toLowerCase() ===
                          'lainnya'
                            ? segment.kondisi_lainnya || null
                            : null
                      })
                    )
                  }
                : null
            }
          : null

      const controller = new AbortController()

      const timeoutId = setTimeout(() => {
        controller.abort()
      }, 90000)

      try {
        // Ambil CSRF token sebelum mengirim request POST.
        const xsrfToken = await getCsrfToken()

        const response = await fetch(API_ENDPOINTS.gemini, {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-XSRF-TOKEN': xsrfToken
          },
          signal: controller.signal,
          body: JSON.stringify({
            judul: judulKebijakan.value || 'Tanpa Judul',
            jenis: jenisKebijakan.value,
            jenis_label: labelForJenis(jenisKebijakan.value),
            skenario: promptKebijakan.value,
            target: getScenarioTarget(),
            rekayasa_lalu_lintas: rekayasaLaluLintas,
            baseline: relevantBaseline,
            domains: analysisDomains
          })
        })

        const data = await response.json()

        console.log('Response Gemini:', data)

        if (!response.ok) {
          throw new Error(
            data.message || `HTTP ${response.status}`
          )
        }

        if (data.status !== 'success') {
          throw new Error(
            data.message || 'Respons AI tidak berhasil.'
          )
        }

        let parsedResult = data.reply

        if (typeof parsedResult === 'string') {
          const cleanedReply = parsedResult
            .replace(/```json/gi, '')
            .replace(/```/g, '')
            .trim()

          try {
            parsedResult = JSON.parse(cleanedReply)
          } catch (error) {
            console.error(
              'JSON hasil Gemini tidak valid:',
              cleanedReply
            )

            throw new Error('Respons AI bukan JSON yang valid.')
          }
        }

        if (!parsedResult || typeof parsedResult !== 'object') {
          throw new Error('Format hasil AI tidak valid.')
        }

        result.value = {
          ringkasan: parsedResult.ringkasan || '',
          kondisi_awal: Array.isArray(parsedResult.kondisi_awal)
            ? parsedResult.kondisi_awal
            : [],
          dampak: Array.isArray(parsedResult.dampak)
            ? parsedResult.dampak
            : [],
          dampak_positif: Array.isArray(parsedResult.dampak_positif)
            ? parsedResult.dampak_positif
            : [],
          dampak_negatif: Array.isArray(parsedResult.dampak_negatif)
            ? parsedResult.dampak_negatif
            : [],
          risiko: Array.isArray(parsedResult.risiko)
            ? parsedResult.risiko
            : [],
          rekomendasi: Array.isArray(parsedResult.rekomendasi)
            ? parsedResult.rekomendasi
            : [],
          hasil_penerapan:
            parsedResult.hasil_penerapan ||
            parsedResult.penerapan ||
            null,
          kesimpulan: parsedResult.kesimpulan || ''
        }

        console.log('JSON hasil AI:', parsedResult)
        console.log('RESULT FINAL:', result.value)
      } catch (error) {
        console.error('Analisis AI gagal:', error)

        if (error.name === 'AbortError') {
          alert(
            'Request ke AI membutuhkan waktu terlalu lama. Coba lagi.'
          )
        } else {
          alert(
            error.message ||
            'Terjadi kesalahan saat melakukan analisis.'
          )
        }
      } finally {
        clearTimeout(timeoutId)
        isAnalyzing.value = false
      }
    }

    async function loadSimulationHistory() {
      try {
        const response = await fetch(`${API_ENDPOINTS.simulasi}?_=${Date.now()}`, {
          method: 'GET',
          headers: {
            Accept: 'application/json',
            'Cache-Control': 'no-cache'
          },
          cache: 'no-store'
        })

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`)
        }

        const data = await response.json()

        console.log('Response API simulasi:', data)

        if (data.status !== 'success') {
          throw new Error(data.message || 'Gagal mengambil riwayat simulasi')
        }

        let rows = []

        if (Array.isArray(data.data)) {
          rows = data.data
        } else if (data.data && Array.isArray(data.data.data)) {
          rows = data.data.data
        }

        history.value = rows.map(mapSimulationHistoryItem)

        console.log('Jumlah riwayat:', history.value.length)
        console.log('Data riwayat:', history.value)
      } catch (error) {
        console.error('Gagal mengambil riwayat simulasi:', error)
        history.value = []
      }
    }

    function safeParse(value, fallback = {}) {
      if (value === null || value === undefined || value === '') {
        return fallback
      }

      if (typeof value !== 'string') {
        return value
      }

      try {
        return JSON.parse(value)
      } catch {
        return value
      }
    }

    function mapSimulationHistoryItem(item) {
      const target = safeParse(item.target, {})
      const traffic = safeParse(item.rekayasa_lalu_lintas, {})
      const resultData = safeParse(item.hasil_ai, {})
      const baseline = safeParse(item.baseline, {})
      const domains = safeParse(item.domains, [])

      return {
        id: item.id,
        isDeleting: false,
        judul: item.judul || `Simulasi ${labelForJenis(item.jenis_kebijakan)}`,
        jenisKebijakan: item.jenis_kebijakan || '',
        jenisLabel: item.jenis_label || labelForJenis(item.jenis_kebijakan),

        target,

        lokasiAwal:
          traffic?.lokasi_awal?.nama_ruas_jalan ||
          (typeof target === 'object' ? target?.ruas_awal?.nama_ruas_jalan : null) ||
          (typeof target === 'object' ? target?.lokasi_awal : null) ||
          null,

        lokasiTarget:
          traffic?.lokasi_target?.nama_ruas_jalan ||
          (typeof target === 'object' ? target?.ruas_target?.nama_ruas_jalan : null) ||
          (typeof target === 'object' ? target?.lokasi_target : null) ||
          null,

        jumlahDampak:
          Array.isArray(resultData?.dampak)
            ? resultData.dampak.length
            : 0,

        status: item.status || 'draft',

        result: resultData,

        prompt: item.skenario || '',

        baseline,

        domains,

        kesimpulan:
          item.kesimpulan ||
          resultData?.kesimpulan ||
          '',

        createdAt: item.created_at || null,

        updatedAt: item.updated_at || null,

        selectedRuasId:
          item.ruas_awal_id ??
          (typeof target === 'object'
            ? target?.ruas_awal?.id_jalan
            : null) ??
          null,

        selectedTargetRuasId:
          item.ruas_target_id ??
          (typeof target === 'object'
            ? target?.ruas_target?.id_jalan
            : null) ??
          null
      }
    }

    async function saveToHistory() {
      if (!result.value) {
        alert('Belum ada hasil simulasi yang dapat disimpan.')
        return
      }

      if (jenisKebijakan.value === 'rekayasa_lalu_lintas') {
        if (!selectedRuas.value) {
          alert('Ruas awal belum dipilih.')
          return
        }

        if (!selectedTargetRuas.value) {
          alert('Ruas target pengalihan belum dipilih.')
          return
        }

        if (
          String(selectedRuasId.value) ===
          String(selectedTargetRuasId.value)
        ) {
          alert('Ruas awal dan ruas target tidak boleh sama.')
          return
        }
      }

      const relevantBaseline = getRelevantBaseline()
      const analysisDomains = buildAnalysisInstruction()

      const payload = {
        judul: judulKebijakan.value || 'Tanpa Judul',
        jenis_kebijakan: jenisKebijakan.value,
        jenis_label: labelForJenis(jenisKebijakan.value),
        skenario: promptKebijakan.value,
        target: getScenarioTarget(),
        baseline: relevantBaseline,
        domains: analysisDomains,
        hasil_ai: result.value,

        rekayasa_lalu_lintas:
          jenisKebijakan.value === 'rekayasa_lalu_lintas'
            ? {
                lokasi_awal: selectedRuas.value
                  ? {
                      id_jalan: selectedRuas.value.id_jalan,
                      nama_ruas_jalan: selectedRuas.value.nama_ruas_jalan,
                      panjang_m: selectedRoadTotalLength.value,
                      lebar_m: selectedRoadAverageWidth.value,
                      kapasitas_jalan: selectedRoadTotalCapacity.value,
                      volume_kendaraan: selectedRoadTotalVolume.value,
                      tingkat_kepadatan: selectedRoadDensity.value
                    }
                  : null,

                lokasi_target: selectedTargetRuas.value
                  ? {
                      id_jalan: selectedTargetRuas.value.id_jalan,
                      nama_ruas_jalan:
                        selectedTargetRuas.value.nama_ruas_jalan,
                      panjang_m: targetRoadTotalLength.value,
                      lebar_m: targetRoadAverageWidth.value,
                      kapasitas_jalan: targetRoadTotalCapacity.value,
                      volume_kendaraan: targetRoadTotalVolume.value,
                      tingkat_kepadatan: targetRoadDensity.value
                    }
                  : null
              }
            : null
      }

      try {
        // Ambil CSRF token dari Laravel Sanctum.
        const xsrfToken = await getCsrfToken()

        const response = await fetch(API_ENDPOINTS.simulasi, {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-XSRF-TOKEN': xsrfToken
          },
          body: JSON.stringify(payload)
        })

        const data = await response.json()

        console.log('Status simpan simulasi:', response.status)
        console.log('Response simpan simulasi:', data)

        if (!response.ok || data.status !== 'success') {
          throw new Error(
            data.message || `Gagal menyimpan simulasi. HTTP ${response.status}`
          )
        }

        const saved = data.data

        history.value.unshift(mapSimulationHistoryItem(saved))
        isSaved.value = true
        showSaveSuccessModal.value = true

        // Perbarui daftar riwayat dari server.
        await loadSimulationHistory()
      } catch (error) {
        console.error('Gagal menyimpan simulasi:', error)
        alert(
          error.message ||
          'Terjadi kesalahan saat menyimpan simulasi.'
        )
      }
    }

    function deleteHistoryItem(item) {
      if (!item?.id) {
        deleteErrorMessage.value = 'ID simulasi tidak ditemukan.'
        showDeleteSuccessModal.value = false
        showDeleteConfirmModal.value = true
        return
      }

      deleteTarget.value = item
      showDeleteConfirmModal.value = true
    }

    
    async function confirmDeleteHistory() {
        const item = deleteTarget.value

        if (!item?.id) {
            showDeleteConfirmModal.value = false
            return
        }

        showDeleteConfirmModal.value = false
        item.isDeleting = true

        try {
            // Ambil CSRF token menggunakan helper yang sudah tersedia.
            const xsrfToken = await getCsrfToken()

            const response = await fetch(
                `${API_BASE}/api/simulasi-kebijakan/${encodeURIComponent(item.id)}`,
                {
                    method: 'DELETE',
                    credentials: 'include',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                }
            )

            const data = await response.json()

            if (!response.ok || data.status !== 'success') {
                throw new Error(
                    data.message ||
                    `Gagal menghapus simulasi. HTTP ${response.status}`
                )
            }

            history.value = history.value.filter(
                historyItem => String(historyItem.id) !== String(item.id)
            )

            item.isDeleting = false
            deleteTarget.value = null
            showDeleteSuccessModal.value = true

        } catch (error) {
            console.error('Gagal menghapus simulasi:', error)

            item.isDeleting = false

            deleteErrorMessage.value =
                error.message ||
                'Terjadi kesalahan saat menghapus riwayat simulasi.'

            showDeleteConfirmModal.value = true
        }
    }


    function loadHistoryItem(item) {
      isSaved.value = true

      judulKebijakan.value = item.judul || ''
      jenisKebijakan.value = item.jenisKebijakan || 'normalisasi_drainase'
      promptKebijakan.value = item.prompt || promptTemplates[jenisKebijakan.value] || ''

      selectedRuasId.value = item.selectedRuasId ?? null
      selectedTargetRuasId.value = item.selectedTargetRuasId ?? null

      if (selectedRuasId.value !== null && selectedRuasId.value !== undefined) {
        const road = ruasJalanList.value.find(
          road => String(road.id_jalan) === String(selectedRuasId.value)
        )

        if (road) {
          roadSearchQuery.value = road.nama_ruas_jalan || ''
        }
      } else {
        roadSearchQuery.value = ''
      }

      if (selectedTargetRuasId.value !== null && selectedTargetRuasId.value !== undefined) {
        const targetRoad = ruasJalanList.value.find(
          road => String(road.id_jalan) === String(selectedTargetRuasId.value)
        )

        if (targetRoad) {
          targetRoadSearchQuery.value = targetRoad.nama_ruas_jalan || ''
        }
      } else {
        targetRoadSearchQuery.value = ''
      }

      if (item.result) {
        result.value = JSON.parse(JSON.stringify(item.result))
      } else {
        result.value = null
      }

      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      })
    }

    function labelForJenis(key) {
      return jenisKebijakanLabels[key] || key
    }

    function statusLabel(status) {
      return {
        draft: 'Draf',
        diajukan: 'Diajukan',
        diterapkan: 'Diterapkan'
      }[status] || status
    }

    function riskClass(level) {
      const value = String(level || '').toLowerCase()

      if (value.includes('tinggi')) {
        return 'bg-rose-100 text-rose-800'
      }

      if (value.includes('sedang')) {
        return 'bg-amber-100 text-amber-800'
      }

      if (value.includes('rendah')) {
        return 'bg-emerald-100 text-emerald-800'
      }

      return 'bg-slate-100 text-slate-600'
    }

    function formatNumber(value) {
      if (value === null || value === undefined || value === '') {
        return '-'
      }

      const number = Number(value)

      if (Number.isNaN(number)) {
        return value
      }

      return new Intl.NumberFormat('id-ID', {
        maximumFractionDigits: 2
      }).format(number)
    }
    </script>

    <style scoped>
    .status-badge--draft {
      background: #fef3c7;
      color: #92400e;
    }

    .status-badge--diajukan {
      background: #dbeafe;
      color: #1e40af;
    }

    .status-badge--diterapkan {
      background: #dcfce7;
      color: #166534;
    }

    .custom-scrollbar {
      scrollbar-width: thin;
      scrollbar-color: #a7c7af transparent;
    }

    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #a7c7af;
      border-radius: 999px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: #7da889;
    }
    </style>
