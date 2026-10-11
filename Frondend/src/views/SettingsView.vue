<template>
  <div class="min-h-screen bg-[var(--color-mint-50)] font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased selection:bg-[var(--color-brand-bright)] selection:text-[var(--color-brand-deep)] pb-12">
    <!-- Header -->
    <Header title="Pengaturan" @click="$emit('toggle-sidebar')" />

    <!-- Main Wrapper -->
    <main class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 pt-8">
      
      <div class="space-y-6">
        <!-- CATEGORY BUTTONS -->
        <div class="w-full rounded-2xl p-2">
            <div class="flex items-center gap-5 overflow-x-auto justify-center">

                <!-- Profil -->
                <button
                    type="button"
                    @click="activeTab = 'profil'"
                    class="group flex items-center gap-2.5 px-5 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200"
                    :class="activeTab === 'profil'
                        ? 'bg-[var(--color-brand-deep)] text-white shadow-md'
                        : 'text-[#3F4743] bg-white hover:bg-[var(--color-mint-100)] hover:text-[var(--color-brand-deep)]'"
                >
                    <svg
                        class="w-5 h-5 transition-transform duration-200 group-hover:scale-105"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                        />
                    </svg>

                    <span>Profil</span>
                </button>

                <!-- Manajemen Pengguna -->
                <button
                    type="button"
                    @click="activeTab = 'pengguna'"
                    class="group flex items-center gap-2.5 px-5 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200"
                    :class="activeTab === 'pengguna'
                        ? 'bg-[var(--color-brand-deep)] text-white shadow-md'
                        : 'text-[#3F4743] bg-white hover:bg-[var(--color-mint-100)] hover:text-[var(--color-brand-deep)]'"
                >
                    <svg
                        class="w-5 h-5 transition-transform duration-200 group-hover:scale-105"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                        />
                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                        />
                    </svg>

                    <span>Manajemen Pengguna</span>
                </button>

                <!-- Tampilan -->
                <button
                    type="button"
                    @click="activeTab = 'tampilan'"
                    class="group flex items-center gap-2.5 px-5 py-3 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200"
                    :class="activeTab === 'tampilan'
                        ? 'bg-[var(--color-brand-deep)] text-white shadow-md'
                        : 'text-[#3F4743] bg-white hover:bg-[var(--color-mint-100)] hover:text-[var(--color-brand-deep)]'"
                >
                    <svg
                        class="w-5 h-5 transition-transform duration-200 group-hover:scale-105"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M18.19 18.19l1.59 1.59M3 12h2.25M18.75 12H21M4.22 19.78l1.59-1.59M18.19 5.81l1.59-1.59"
                        />
                        <circle
                            cx="12"
                            cy="12"
                            r="4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        />
                    </svg>

                    <span>Tampilan</span>
                </button>

            </div>
        </div>

        <!-- Main Content Area -->
        <div class="w-full space-y-6">
          
          <!-- 1. Profil Pengguna -->
          <section v-if="activeTab === 'profil'" class="bg-white rounded-2xl border border-[var(--color-mint-200)]/60 p-6 md:p-8 shadow-sm transition-all">
            <div class="border-b border-slate-100 pb-5 mb-6">
              <h3 class="text-lg font-bold text-[var(--color-brand-deep)]">Profil Pengguna</h3>
              <p class="text-xs md:text-sm text-slate-500 mt-0.5">Kelola informasi identitas publik dan alamat email Anda.</p>
            </div>

            <!-- Avatar & Info -->
            <div class="flex items-center gap-5 p-4 rounded-xl bg-[var(--color-mint-50)] border border-[var(--color-mint-200)]/50 mb-6">
              <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-[var(--color-brand-accent)] text-[var(--color-brand-deep)] flex items-center justify-center font-bold text-xl shadow-inner">
                  {{ initials }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-[var(--color-brand-bright)] border-2 border-white rounded-full"></div>
              </div>
              <div>
                <h4 class="font-bold text-slate-800 text-base">{{ profil.nama }}</h4>
                <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-semibold rounded-md bg-white border border-[var(--color-mint-200)] text-[var(--color-brand-sidebar)]">
                  {{ profil.role }}
                </span>
              </div>
            </div>

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-[var(--color-brand-darkbtn)]">Nama Lengkap</label>
                <input 
                  v-model="profil.nama" 
                  type="text" 
                  class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all"
                >
              </div>

              <div class="space-y-1.5">
                <label class="text-xs font-semibold text-[var(--color-brand-darkbtn)]">Alamat Email</label>
                <div class="relative flex items-center">
                  <input 
                    v-model="profil.email" 
                    type="email" 
                    class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl pl-4 pr-28 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all"
                  >
                  <div class="absolute right-2">
                    <span v-if="profil.terverifikasi" class="text-[10px] px-2.5 py-1 rounded-lg bg-[var(--color-brand-accent)]/40 text-[var(--color-brand-deep)] font-bold tracking-wide border border-[var(--color-brand-accent)]">
                      ✓ Terverifikasi
                    </span>
                    <button
                        v-else
                        type="button"
                        @click="sendVerificationEmail"
                        :disabled="verificationLoading"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-[var(--color-brand-deep)] px-3 py-1.5 text-xs font-semibold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <svg
                            v-if="verificationLoading"
                            class="h-3.5 w-3.5 animate-spin"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                            />
                        </svg>

                        <span>
                            {{ verificationLoading ? 'Mengirim...' : verificationSent ? 'Terkirim' : 'Verifikasi'}}
                        </span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div
                v-if="profileError"
                class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-600"
            >
                {{ profileError }}
            </div>

            <div
                v-if="profileMessage"
                class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-600"
            >
                {{ profileMessage }}
            </div>

            <div class="flex justify-end">
              <button
                  type="button"
                  @click="updateProfile"
                  :disabled="profileLoading"
                  class="text-sm font-semibold px-6 py-2.5 rounded-xl bg-[var(--color-brand-deep)] text-white hover:bg-[var(--color-brand-sidebar)] active:scale-95 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
              >
                  {{ profileLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}
              </button>
          </div>

            <!-- Password Section -->
            <div class="mt-10 pt-8 border-t border-slate-100">
              <h4 class="text-sm font-bold text-slate-800 mb-1">
                  Keamanan & Password
              </h4>

              <p class="text-xs text-slate-500 mb-4">
                  Pastikan kata sandi Anda menggunakan minimal 8 karakter dengan kombinasi angka.
              </p>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                  <input
                      v-model="passwordForm.current_password"
                      type="password"
                      placeholder="Password lama"
                      class="border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all"
                  >

                  <input
                      v-model="passwordForm.password"
                      type="password"
                      placeholder="Password baru"
                      class="border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all"
                  >

                  <input
                      v-model="passwordForm.password_confirmation"
                      type="password"
                      placeholder="Konfirmasi password"
                      class="border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all"
                  >
              </div>

              <div
                  v-if="passwordError"
                  class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-600"
              >
                  {{ passwordError }}
              </div>

              <div
                  v-if="passwordMessage"
                  class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-600"
              >
                  {{ passwordMessage }}
              </div>

              <button
                  @click="updatePassword"
                  :disabled="passwordLoading"
                  class="text-sm font-semibold px-5 py-2.5 rounded-xl border-2 border-[var(--color-brand-deep)] text-[var(--color-brand-deep)] hover:bg-[var(--color-mint-100)] active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
              >
                  {{ passwordLoading ? 'Memperbarui...' : 'Perbarui Password' }}
              </button>
          </div>
          </section>

          <!-- 4. Manajemen Pengguna -->
          <section
            v-if="activeTab === 'pengguna'"
            class="bg-white rounded-2xl border border-[var(--color-mint-200)]/60 p-6 md:p-8 shadow-sm"
        >
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5 mb-6"
            >
                <div>
                    <h3 class="text-lg font-bold text-[var(--color-brand-deep)]">
                        Manajemen Pengguna
                    </h3>

                    <p class="text-xs md:text-sm text-slate-500 mt-0.5">
                        Kelola pengguna dan hak akses pengelola kota.
                    </p>
                </div>

                <button
                    type="button"
                    @click="openInviteModal"
                    class="inline-flex items-center justify-center gap-2 text-sm font-semibold px-4 py-2.5 rounded-xl bg-[var(--color-brand-deep)] text-white hover:bg-[var(--color-brand-sidebar)] active:scale-95 transition-all shadow-sm"
                >
                    <span class="text-lg leading-none">+</span>
                    Undang Pengguna
                </button>
            </div>

            <!-- Loading -->
            <div
                v-if="usersLoading"
                class="flex items-center justify-center py-10 text-sm text-slate-500"
            >
                <svg
                    class="w-5 h-5 mr-2 animate-spin text-[var(--color-brand-deep)]"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    />

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                    />
                </svg>

                Memuat data pengguna...
            </div>

            <!-- Error -->
            <div
                v-else-if="usersError"
                class="px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-600"
            >
                {{ usersError }}
            </div>

            <!-- Empty -->
            <div
                v-else-if="anggotaTim.length === 0"
                class="text-center py-12"
            >
                <div
                    class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-[var(--color-mint-100)] text-[var(--color-brand-deep)] flex items-center justify-center"
                >
                    <svg
                        class="w-7 h-7"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                        />
                    </svg>
                </div>

                <p class="text-sm font-semibold text-slate-700">
                    Belum ada pengguna lain
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    Pengguna yang diundang akan tampil di sini.
                </p>
            </div>

            <!-- User List -->
            <div
                v-else
                class="space-y-3"
            >
                <div
                    v-for="u in anggotaTim"
                    :key="u.id"
                    class="flex items-center justify-between p-3.5 rounded-xl border border-[var(--color-mint-200)]/50 hover:border-[var(--color-mint-200)] hover:bg-[var(--color-mint-50)]/30 transition-all"
                >
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div
                            class="w-10 h-10 shrink-0 rounded-xl bg-[var(--color-mint-100)] text-[var(--color-brand-deep)] border border-[var(--color-mint-200)] flex items-center justify-center text-xs font-bold shadow-sm"
                        >
                            {{
                                u.name
                                    ?.split(' ')
                                    .filter(Boolean)
                                    .map(w => w[0])
                                    .slice(0, 2)
                                    .join('')
                                    .toUpperCase()
                            }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ u.name }}
                            </p>

                            <p class="text-xs text-slate-400 truncate">
                                {{ u.email }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="shrink-0 ml-4 text-xs px-3 py-1 rounded-lg bg-[var(--color-mint-100)] text-[var(--color-brand-sidebar)] font-semibold border border-[var(--color-mint-200)]"
                    >
                        {{ u.role || 'Pengguna' }}
                    </span>

                    <button
                        type="button"
                        @click="openDeleteUserModal(u)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition"
                        title="Hapus pengguna"
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
                                stroke-width="1.8"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

          <!-- 5. Preferensi Tampilan -->
          <section v-if="activeTab === 'tampilan'" class="bg-white rounded-2xl border border-[var(--color-mint-200)]/60 p-6 md:p-8 shadow-sm">
            <div class="border-b border-slate-100 pb-5 mb-6">
              <h3 class="text-lg font-bold text-[var(--color-brand-deep)]">Preferensi Tampilan</h3>
              <p class="text-xs md:text-sm text-slate-500 mt-0.5">Sesuaikan pengalaman visual dan bahasa aplikasi Anda.</p>
            </div>

            <div class="space-y-6">
              <div>
                <label class="text-xs font-semibold text-[var(--color-brand-darkbtn)] block mb-3">Tema Visual</label>
                <div class="flex gap-3">
                  <button class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-[var(--color-brand-deep)] text-white shadow-sm ring-2 ring-[var(--color-brand-deep)] ring-offset-2">
                    Terang
                  </button>
                  <button class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-400 bg-slate-50 cursor-not-allowed opacity-70" disabled>
                    Gelap · <span class="text-[10px] bg-slate-200 px-1.5 py-0.5 rounded text-slate-600">Segera Hadir</span>
                  </button>
                </div>
              </div>

              <div class="max-w-xs">
                <label class="text-xs font-semibold text-[var(--color-brand-darkbtn)] block mb-1.5">Bahasa Antarmuka</label>
                <select class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all">
                  <option>Bahasa Indonesia</option>
                  <option disabled>English · Segera Hadir</option>
                </select>
              </div>
            </div>
          </section>

        </div>
      </div>
    </main>
  </div>
  <!-- Modal Undang Pengguna -->
  <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
  >
      <div
          v-if="showInviteModal"
          class="fixed inset-0 z-50 flex items-center justify-center p-4"
      >
          <!-- Overlay -->
          <div
              class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
              @click="closeInviteModal"
          ></div>

          <!-- Modal -->
          <Transition
              appear
              enter-active-class="transition duration-200 ease-out"
              enter-from-class="opacity-0 translate-y-2 scale-95"
              enter-to-class="opacity-100 translate-y-0 scale-100"
              leave-active-class="transition duration-150 ease-in"
              leave-from-class="opacity-100 translate-y-0 scale-100"
              leave-to-class="opacity-0 translate-y-2 scale-95"
          >
              <div
                  v-if="showInviteModal"
                  class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-[var(--color-mint-200)] overflow-hidden"
              >
                  <!-- Header -->
                  <div
                      class="flex items-center justify-between px-6 py-5 border-b border-slate-100"
                  >
                      <div>
                          <h3
                              class="text-lg font-bold text-[var(--color-brand-deep)]"
                          >
                              Undang Pengguna
                          </h3>

                          <p class="text-xs text-slate-500 mt-1">
                              Tambahkan pengguna baru ke dalam sistem.
                          </p>
                      </div>

                      <button
                          type="button"
                          @click="closeInviteModal"
                          :disabled="inviteLoading"
                          class="w-9 h-9 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition disabled:opacity-50"
                      >
                          <svg
                              class="w-5 h-5"
                              fill="none"
                              stroke="currentColor"
                              viewBox="0 0 24 24"
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

                  <!-- Form -->
                  <form
                      @submit.prevent="createUser"
                      class="p-6 space-y-5"
                  >
                      <!-- Error -->
                      <div
                          v-if="inviteError"
                          class="px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-600"
                      >
                          {{ inviteError }}
                      </div>

                      <!-- Success -->
                      <div
                          v-if="inviteMessage"
                          class="px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-600"
                      >
                          {{ inviteMessage }}
                      </div>

                      <!-- Nama -->
                      <div class="space-y-1.5">
                          <label
                              class="text-xs font-semibold text-[var(--color-brand-darkbtn)]"
                          >
                              Nama Lengkap
                          </label>

                          <input
                              v-model="inviteForm.name"
                              type="text"
                              placeholder="Masukkan nama lengkap"
                              :disabled="inviteLoading"
                              class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all disabled:opacity-60"
                          >
                      </div>

                      <!-- Email -->
                      <div class="space-y-1.5">
                          <label
                              class="text-xs font-semibold text-[var(--color-brand-darkbtn)]"
                          >
                              Alamat Email
                          </label>

                          <input
                              v-model="inviteForm.email"
                              type="email"
                              placeholder="nama@email.com"
                              :disabled="inviteLoading"
                              class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all disabled:opacity-60"
                          >
                      </div>

                      <!-- Role -->
                      <div class="space-y-1.5">
                          <label
                              class="text-xs font-semibold text-[var(--color-brand-darkbtn)]"
                          >
                              Role Pengguna
                          </label>

                          <input
                              v-model="inviteForm.role"
                              type="text"
                              placeholder="Masukkan role pengguna"
                              :disabled="inviteLoading"
                              class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all disabled:opacity-60"
                          >
                      </div>

                      <!-- Password -->
                      <div class="space-y-1.5">
                          <label
                              class="text-xs font-semibold text-[var(--color-brand-darkbtn)]"
                          >
                              Password
                          </label>

                          <input
                              v-model="inviteForm.password"
                              type="password"
                              placeholder="Minimal 8 karakter"
                              :disabled="inviteLoading"
                              class="w-full border border-[var(--color-mint-200)] bg-[var(--color-mint-50)]/50 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-brand-active)] focus:bg-white transition-all disabled:opacity-60"
                          >

                          <p class="text-[11px] text-slate-400">
                              Password minimal 8 karakter.
                          </p>
                      </div>

                      <!-- Footer -->
                      <div
                          class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100"
                      >
                          <button
                              type="button"
                              @click="closeInviteModal"
                              :disabled="inviteLoading"
                              class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition disabled:opacity-50"
                          >
                              Batal
                          </button>

                          <button
                              type="submit"
                              :disabled="inviteLoading"
                              class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[var(--color-brand-deep)] text-white text-sm font-semibold hover:bg-[var(--color-brand-sidebar)] transition disabled:opacity-60 disabled:cursor-not-allowed"
                          >
                              <svg
                                  v-if="inviteLoading"
                                  class="w-4 h-4 animate-spin"
                                  viewBox="0 0 24 24"
                                  fill="none"
                              >
                                  <circle
                                      class="opacity-25"
                                      cx="12"
                                      cy="12"
                                      r="10"
                                      stroke="currentColor"
                                      stroke-width="4"
                                  />

                                  <path
                                      class="opacity-75"
                                      fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                  />
                              </svg>

                              {{ inviteLoading ? 'Menyimpan...' : 'Tambah Pengguna' }}
                          </button>
                      </div>
                  </form>
              </div>
          </Transition>
      </div>
  </Transition>

  <!-- Modal Konfirmasi Hapus Pengguna -->
  <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
  >
      <div
          v-if="showDeleteUserModal"
          class="fixed inset-0 z-[60] flex items-center justify-center p-4"
      >
          <!-- Overlay -->
          <div
              class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
              @click="closeDeleteUserModal"
          ></div>

          <!-- Modal -->
          <div
              class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden"
          >
              <div class="p-6">
                  <!-- Icon -->
                  <div
                      class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center mb-4"
                  >
                      <svg
                          class="w-6 h-6"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                      >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"
                          />
                      </svg>
                  </div>

                  <h3 class="text-lg font-bold text-slate-800">
                      Hapus Pengguna?
                  </h3>

                  <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                      Apakah kamu yakin ingin menghapus pengguna
                      <span class="font-semibold text-slate-700">
                          {{ selectedUser?.name }}
                      </span>
                      dari sistem?
                  </p>

                  <p class="text-xs text-rose-500 mt-2">
                      Data pengguna yang dihapus tidak dapat dipulihkan.
                  </p>

                  <!-- Error -->
                  <div
                      v-if="deleteUserError"
                      class="mt-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-600"
                  >
                      {{ deleteUserError }}
                  </div>
              </div>

              <!-- Footer -->
              <div
                  class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-100"
              >
                  <button
                      type="button"
                      @click="closeDeleteUserModal"
                      :disabled="deleteUserLoading"
                      class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition disabled:opacity-50"
                  >
                      Batal
                  </button>

                  <button
                      type="button"
                      @click="deleteUser"
                      :disabled="deleteUserLoading"
                      class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-rose-500 text-white text-sm font-semibold hover:bg-rose-600 transition disabled:opacity-60 disabled:cursor-not-allowed"
                  >
                      <svg
                          v-if="deleteUserLoading"
                          class="w-4 h-4 animate-spin"
                          viewBox="0 0 24 24"
                          fill="none"
                      >
                          <circle
                              class="opacity-25"
                              cx="12"
                              cy="12"
                              r="10"
                              stroke="currentColor"
                              stroke-width="4"
                          />

                          <path
                              class="opacity-75"
                              fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                          />
                      </svg>

                      {{
                          deleteUserLoading
                              ? 'Menghapus...'
                              : 'Hapus Pengguna'
                      }}
                  </button>
              </div>
          </div>
      </div>
  </Transition>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import Header from '../components/layout/Header2.vue'
const activeTab = ref('profil')
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

const API_USER = `${API_BASE}/api/user`;
const API_USERS = `${API_BASE}/api/users`;
const API_PROFILE = `${API_BASE}/api/user/profile`;
const API_NOTIFICATIONS = `${API_BASE}/api/notifications`;
const API_PASSWORD = `${API_BASE}/api/user/password`;
const API_VERIFICATION = `${API_BASE}/api/user/email/verification-notification`;
 

const tabs = [
    { key: 'profil', label: 'Profil' },
    { key: 'pengguna', label: 'Manajemen Pengguna'},
    { key: 'tampilan', label: 'Tampilan'},
]


const profil = reactive({
    nama: '',
    email: '',
    role: '',
    terverifikasi: true,
})

const loadingProfile = ref(false)
const profileError = ref('')

const passwordForm = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const passwordLoading = ref(false)
const passwordMessage = ref('')
const passwordError = ref('')

async function loadProfile() {
    loadingProfile.value = true
    profileError.value = ''

    try {
        const response = await fetch(API_USER, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
            credentials: 'include',
        })

        const data = await response.json()

        console.log('DATA USER DARI LARAVEL:', data)

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal mengambil data profil.'
            )
        }

        if (!data.user) {
            throw new Error('Data user tidak ditemukan.')
        }

        console.log('NAMA USER:', data.user.name)
        console.log('EMAIL USER:', data.user.email)

        profil.nama = data.user.name || ''
        profil.email = data.user.email || ''

        profil.role = data.user.role || ''

        profil.terverifikasi = !!data.user.email_verified_at

    } catch (error) {
        console.error('Gagal mengambil profil:', error)

        profileError.value =
            error.message || 'Terjadi kesalahan saat mengambil profil.'
    } finally {
        loadingProfile.value = false
    }
}

const verificationLoading = ref(false)
const verificationMessage = ref('')
const verificationError = ref('')
const verificationSent = ref(false)

async function sendVerificationEmail() {
    verificationLoading.value = true
    verificationMessage.value = ''
    verificationError.value = ''

    try {
        const xsrfToken = await getCsrfToken()
        const response = await fetch(API_VERIFICATION, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            credentials: 'include',
        })

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal mengirim email verifikasi.'
            )
        }

        verificationSent.value = true

        verificationMessage.value =
            data.message || 'Link verifikasi telah dikirim ke email Anda.'

        setTimeout(() => {
            verificationMessage.value = ''
        }, 4000)

    } catch (error) {
        console.error('Gagal mengirim email verifikasi:', error)

        verificationError.value =
            error.message || 'Terjadi kesalahan saat mengirim email verifikasi.'

        setTimeout(() => {
            verificationError.value = ''
        }, 4000)

    } finally {
        verificationLoading.value = false
    }
}

onMounted(() => {
    loadProfile()
    loadNotifications()
    loadUsers()
})

const initials = computed(() => {
    if (!profil.nama) {
        return 'U'
    }

    return profil.nama
        .split(' ')
        .filter(Boolean)
        .map(w => w[0])
        .slice(0, 2)
        .join('')
        .toUpperCase()
})

const profileLoading = ref(false)
const profileMessage = ref('')

async function updateProfile() {
    profileLoading.value = true
    profileMessage.value = ''
    profileError.value = ''

    try {
        if (!profil.nama.trim()) {
            throw new Error('Nama lengkap wajib diisi.')
        }

        if (!profil.email.trim()) {
            throw new Error('Email wajib diisi.')
        }

        const xsrfToken = await getCsrfToken()
        const response = await fetch(API_PROFILE, {
            method: 'PUT',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            credentials: 'include',
            body: JSON.stringify({
                name: profil.nama,
                email: profil.email,
            }),
        })

        const data = await response.json()

        if (!response.ok) {
            if (data.errors) {
                const firstError = Object.values(data.errors)[0]?.[0]

                throw new Error(
                    firstError || data.message || 'Gagal memperbarui profil.'
                )
            }

            throw new Error(
                data.message || 'Gagal memperbarui profil.'
            )
        }

        profil.nama = data.user.name || ''
        profil.email = data.user.email || ''
        profil.role = data.user.role || profil.role
        profil.terverifikasi = !!data.user.email_verified_at

        profileMessage.value =
            data.message || 'Profil berhasil diperbarui.'

        // Hilangkan pesan berhasil setelah 2 detik
        setTimeout(() => {
            profileMessage.value = ''
        }, 2000)

    } catch (error) {
        console.error('Gagal memperbarui profil:', error)

        profileError.value =
            error.message || 'Terjadi kesalahan saat memperbarui profil.'

        // Hilangkan pesan gagal setelah 2 detik
        setTimeout(() => {
            profileError.value = ''
        }, 2000)

    } finally {
        profileLoading.value = false
    }
}

async function updatePassword() {
    passwordLoading.value = true
    passwordMessage.value = ''
    passwordError.value = ''

    try {
        if (!passwordForm.current_password) {
            throw new Error('Password lama wajib diisi.')
        }

        if (!passwordForm.password) {
            throw new Error('Password baru wajib diisi.')
        }

        if (passwordForm.password.length < 8) {
            throw new Error('Password baru minimal 8 karakter.')
        }

        if (
            passwordForm.password !==
            passwordForm.password_confirmation
        ) {
            throw new Error('Konfirmasi password tidak cocok.')
        }

        const xsrfToken = await getCsrfToken()
        const response = await fetch(API_PASSWORD, {
            method: 'PUT',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            credentials: 'include',
            body: JSON.stringify({
                current_password: passwordForm.current_password,
                password: passwordForm.password,
                password_confirmation:
                    passwordForm.password_confirmation,
            }),
        })

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal memperbarui password.'
            )
        }

        passwordMessage.value =
            data.message || 'Password berhasil diperbarui.'

        // Kosongkan form setelah berhasil
        passwordForm.current_password = ''
        passwordForm.password = ''
        passwordForm.password_confirmation = ''

    } catch (error) {
        console.error('Gagal mengubah password:', error)

        passwordError.value =
            error.message || 'Terjadi kesalahan saat mengubah password.'
    } finally {
        passwordLoading.value = false
    }
}

const kota = reactive({
    nama: 'Makassar',
    jumlahPenduduk: 1526677,
    threshold: { aman: 30, waspada: 60, siaga: 60 },
})

const notifications = ref([])
const notificationsLoading = ref(false)
const notificationsError = ref('')

async function loadNotifications() {
    notificationsLoading.value = true
    notificationsError.value = ''

    try {
        const response = await fetch(API_NOTIFICATIONS, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
            credentials: 'include',
        })

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal mengambil data notifikasi.'
            )
        }

        notifications.value = data.data || []

        console.log('DATA NOTIFIKASI:', notifications.value)

    } catch (error) {
        console.error('Gagal mengambil notifikasi:', error)

        notificationsError.value =
            error.message ||
            'Terjadi kesalahan saat mengambil notifikasi.'
    } finally {
        notificationsLoading.value = false
    }
}

async function markNotificationAsRead(notification) {
    if (notification.is_read) {
        return
    }

    try {
        const xsrfToken = await getCsrfToken()
        const response = await fetch(
            `${API_NOTIFICATIONS}/${notification.id}/read`,
            {
                method: 'PUT',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                credentials: 'include',
            },
        )

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message ||
                'Gagal menandai notifikasi sebagai dibaca.'
            )
        }

        notification.is_read = true

    } catch (error) {
        console.error(
            'Gagal menandai notifikasi sebagai dibaca:',
            error
        )
    }
}

async function markAllNotificationsAsRead() {
    try {
        const xsrfToken = await getCsrfToken()
        const response = await fetch(
            `${API_NOTIFICATIONS}/read-all`,
            {
                method: 'PUT',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                credentials: 'include',
            },
        )

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message ||
                'Gagal menandai semua notifikasi.'
            )
        }

        notifications.value.forEach((notification) => {
            notification.is_read = true
        })

    } catch (error) {
        console.error(
            'Gagal menandai semua notifikasi:',
            error
        )
    }
}

function getNotificationIcon(type) {
    switch (type) {
        case 'environment':
            return '🌿'

        case 'infrastruktur':
            return '🏗️'

        case 'traffic':
            return '🚦'

        case 'kebijakan':
            return '📋'

        case 'system':
            return '⚙️'

        default:
            return '🔔'
    }
}

function formatNotificationDate(date) {
    if (!date) {
        return '-'
    }

    return new Date(date).toLocaleString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

const channel = reactive({ inApp: true, email: false })

const anggotaTim = ref([])
const usersLoading = ref(false)
const usersError = ref('')

const showInviteModal = ref(false)
const inviteLoading = ref(false)
const inviteError = ref('')
const inviteMessage = ref('')
const showDeleteUserModal = ref(false)
const deleteUserLoading = ref(false)
const deleteUserError = ref('')
const selectedUser = ref(null)

const inviteForm = reactive({
    name: '',
    email: '',
    role: '',
    password: '',
})

function openInviteModal() {
    inviteForm.name = ''
    inviteForm.email = ''
    inviteForm.role = ''
    inviteForm.password = ''

    inviteError.value = ''
    inviteMessage.value = ''

    showInviteModal.value = true
}

function openDeleteUserModal(user) {
    selectedUser.value = user
    deleteUserError.value = ''
    showDeleteUserModal.value = true
}

function closeDeleteUserModal() {
    if (deleteUserLoading.value) {
        return
    }

    showDeleteUserModal.value = false
    selectedUser.value = null
    deleteUserError.value = ''
}

function closeInviteModal() {
    if (inviteLoading.value) {
        return
    }

    showInviteModal.value = false
}

async function createUser() {
    inviteLoading.value = true
    inviteError.value = ''
    inviteMessage.value = ''

    try {
        if (!inviteForm.name.trim()) {
            throw new Error('Nama lengkap wajib diisi.')
        }

        if (!inviteForm.email.trim()) {
            throw new Error('Email wajib diisi.')
        }

        if (!inviteForm.role.trim()) {
            throw new Error('Role wajib dipilih.')
        }

        if (!inviteForm.password) {
            throw new Error('Password wajib diisi.')
        }

        if (inviteForm.password.length < 8) {
            throw new Error('Password minimal 8 karakter.')
        }

        const xsrfToken = await getCsrfToken()
        const response = await fetch(API_USERS, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            credentials: 'include',
            body: JSON.stringify({
                name: inviteForm.name,
                email: inviteForm.email,
                role: inviteForm.role,
                password: inviteForm.password,
            }),
        })

        const data = await response.json()

        console.log('HASIL TAMBAH USER:', data)

        if (!response.ok) {
            if (data.errors) {
                const firstError = Object.values(data.errors)[0]?.[0]

                throw new Error(
                    firstError ||
                    data.message ||
                    'Gagal menambahkan pengguna.'
                )
            }

            throw new Error(
                data.message || 'Gagal menambahkan pengguna.'
            )
        }

        inviteMessage.value =
            data.message || 'Pengguna berhasil ditambahkan.'

        await loadUsers()

        setTimeout(() => {
            showInviteModal.value = false
            inviteMessage.value = ''
        }, 800)

    } catch (error) {
        console.error('Gagal menambahkan pengguna:', error)

        inviteError.value =
            error.message ||
            'Terjadi kesalahan saat menambahkan pengguna.'
    } finally {
        inviteLoading.value = false
    }
}

async function deleteUser() {
    if (!selectedUser.value) {
        return
    }

    deleteUserLoading.value = true
    deleteUserError.value = ''

    try {
        const xsrfToken = await getCsrfToken()
        const response = await fetch(
            `${API_USERS}/${selectedUser.value.id}`,
            {
                method: 'DELETE',
                headers: {
                    Accept: 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                credentials: 'include',
            }
        )

        const data = await response.json()

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal menghapus pengguna.'
            )
        }

        await loadUsers()

        // Tutup modal setelah berhasil dihapus
        showDeleteUserModal.value = false
        selectedUser.value = null
        deleteUserError.value = ''

    } catch (error) {
        console.error('Gagal menghapus pengguna:', error)

        deleteUserError.value =
            error.message ||
            'Terjadi kesalahan saat menghapus pengguna.'

    } finally {
        deleteUserLoading.value = false
    }
}

async function loadUsers() {
    usersLoading.value = true
    usersError.value = ''

    try {
        const response = await fetch(API_USERS, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
            credentials: 'include',
        })

        const data = await response.json()

        console.log('DATA SEMUA USER:', data)

        if (!response.ok) {
            throw new Error(
                data.message || 'Gagal mengambil data pengguna.'
            )
        }

        anggotaTim.value = data.data || []
    } catch (error) {
        console.error('Gagal mengambil data pengguna:', error)

        usersError.value =
            error.message || 'Terjadi kesalahan saat mengambil data pengguna.'
    } finally {
        usersLoading.value = false
    }
}
</script>