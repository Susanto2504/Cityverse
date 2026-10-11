<script setup>
import { ref, onMounted } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { getUser, logout } from "@/services/api";

defineEmits(["close"]);

const router = useRouter();

const user = ref(null);
const loadingUser = ref(true);

const loadUser = async () => {
  try {
    const data = await getUser();
    user.value = data.user ?? data;
  } catch (error) {
    console.error("Gagal mengambil data user:", error);
    user.value = null;
  } finally {
    loadingUser.value = false;
  }
};


const getInitials = (name) => {
    if (!name) return "U";

    return name
        .split(" ")
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join("");
};

const handleLogout = async () => {
    try {
        await logout();

        router.replace("/login");
    } catch (error) {
        console.error("Logout gagal:", error);

        router.replace("/login");
    }
};

onMounted(() => {
    loadUser();
});
</script>

<template>
    <!-- Top Branding and Navigation Links -->
    <div class="p-6 md:p-7">
      <!-- Logo & City Title -->
      <div class="flex items-center gap-3.5 mb-8">
        <div class="flex items-center justify-center text-brand-bright text-xl">
          <img src="../../assets/logo.png" class="w-11 h-11 ">
        </div>

        <div>
          <h1 class="text-2xl font-extrabold tracking-wider text-white font-sans">CITYVERSE</h1>
          <p class="text-[11px] uppercase tracking-widest text-emerald-200/70 font-semibold">Makassar Smart Metro</p>
        </div>
      </div>

      <!-- Section Title -->
      <div class="text-xs font-bold uppercase tracking-wider text-emerald-200/80 mb-4 px-2">
        Navigation
      </div>

      <!-- Navigation Menu -->
      <nav class="space-y-2">
        <!-- Item 1: Dashboard -->
        <RouterLink 
          to="/dashboard" 
          @click="$emit('close')"
          active-class="bg-white/20 text-white shadow-sm"
          class="w-full flex items-center gap-3.5 px-4 py-3 rounded-full text-sm font-semibold transition-all duration-200 text-emerald-100 hover:bg-white/10"
        >
          <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white text-sm shrink-0">
            <i class="fa-solid fa-house"></i>
          </span>
          <span>Dashboard</span>
        </RouterLink>

        <!-- Item 2: Data dan Konfigurasi Kota -->
        <RouterLink 
          to="/config"
          @click="$emit('close')" 
          active-class="bg-white/20 text-white shadow-sm"
          class="w-full flex items-center gap-3.5 px-4 py-3 rounded-full text-sm font-semibold transition-all duration-200 text-emerald-100 hover:bg-white/10"
        >
          <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-emerald-200 text-sm shrink-0">
            <i class="fa-solid fa-layer-group"></i>
          </span>
          <span class="truncate">Data dan Konfigurasi Kota</span>
        </RouterLink>

        <!-- Item 3: Simulasi dan Analisis -->
        <RouterLink 
          to="/simulation"
          @click="$emit('close')" 
          active-class="bg-white/20 text-white shadow-sm"
          class="w-full flex items-center gap-3.5 px-4 py-3 rounded-full text-sm font-semibold transition-all duration-200 text-emerald-100 hover:bg-white/10"
        >
          <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-emerald-200 text-sm shrink-0">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
          </span>
          <span class="truncate">Simulasi dan Analisis</span>
        </RouterLink>

        <!-- Item 4: Laporan Data -->
        <RouterLink 
          to="/laporan"
          @click="$emit('close')" 
          active-class="bg-white/20 text-white shadow-sm"
          class="w-full flex items-center gap-3.5 px-4 py-3 rounded-full text-sm font-semibold transition-all duration-200 text-emerald-100 hover:bg-white/10"
        >
          <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-emerald-200 text-sm shrink-0">
            <i class="fa-solid fa-folder-open"></i>
          </span>
          <span>Laporan Data</span>
        </RouterLink>

        <!-- Item 5: Pengaturan -->
        <RouterLink 
          to="/settings" 
          @click="$emit('close')"
          active-class="bg-white/20 text-white shadow-sm"
          class="w-full flex items-center gap-3.5 px-4 py-3 rounded-full text-sm font-semibold transition-all duration-200 text-emerald-100 hover:bg-white/10"
        >
          <span class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-emerald-200 text-sm shrink-0">
            <i class="fa-solid fa-gear"></i>
          </span>
          <span>Pengaturan</span>
        </RouterLink>
      </nav>
    </div>

    <!-- Bottom User Profile & Status Widget -->
    <div class="p-5 mx-4 mb-5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="relative">
          <div class="w-10 h-10 rounded-full bg-emerald-100 text-brand-deep font-bold flex items-center justify-center text-sm border-2 border-brand-bright">
            {{ getInitials(user?.name) }}
          </div>
          <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-400 border-2 border-brand-sidebar rounded-full"></span>
        </div>

        <div>
          <h4 class="text-xs font-bold text-white tracking-wide leading-tight">{{ loadingUser ? "Memuat..." : user?.name || "User" }}</h4>
          <p class="text-[10px] text-emerald-200/80">{{ loadingUser ? "Memuat..." : user?.role || "Pengguna" }}</p>
        </div>
      </div>

      <button 
        @click="handleLogout" 
        class="text-white/60 hover:text-white p-2 text-sm rounded-lg hover:bg-white/10 transition" 
        title="Keluar / Logout"
      >
        <i class="fa-solid fa-right-from-bracket"></i>
      </button>
    </div>
  
</template>