<template>
    <!-- Top Action Bar -->
    <div class="sticky top-0 z-40 bg-mint-50/90 h-20 px-7 md:px-9 flex items-center justify-between border-b border-emerald-900/5 shrink-0">
        <div class="flex items-center gap-3">
            <button @click="$emit('toggle-sidebar')" class="md:hidden w-10 h-10 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-700 active:scale-95 transition" aria-label="Toggle Navigation">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <!-- Title and City Scope Subtitle -->
            <div>
                <h2 class="text-xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-none" id="header-main-title">
                    {{ title }}
                </h2>

                <p class="text-[10px] md:text-sm font-bold text-emerald-800/70 tracking-wide mt-1 uppercase" id="header-sub-title">
                    Kota MAKASSAR
                </p>
            </div>
        </div>

        <!-- Global Header Controls -->
        <div class="flex items-center gap-4">

            <!-- Notification -->
            <div class="relative">

                <!-- Bell Button -->
                <button @click="toggleNotification" class="relative w-10 h-10 md:w-11 md:h-11 rounded-full bg-white hover:bg-emerald-50 border border-slate-200/80 shadow-sm flex items-center justify-center text-slate-700 transition-all duration-200" aria-label="Notifikasi">
                    <i class="fa-regular fa-bell text-base md:text-lg"></i>

                    <!-- Notification Badge -->
                    <span v-if="notificationCount > 0" class="absolute -top-0.5 -right-0.5 min-w-5 h-5 px-1 bg-rose-500 text-white text-[10px] font-extrabold rounded-full flex items-center justify-center shadow-md border-2 border-white">
                        {{ notificationCount }}
                    </span>
                </button>

                <!-- Notification Flyout -->
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 translate-y-2 scale-95"
                    enter-to-class="opacity-100 translate-y-0 scale-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 translate-y-0 scale-100"
                    leave-to-class="opacity-0 translate-y-2 scale-95"
                >
                    <div
                        v-if="showNotification"
                        class="absolute right-0 mt-4 w-[390px] max-w-[calc(100vw-2rem)] bg-white rounded-3xl shadow-2xl shadow-slate-900/15 border border-slate-200/80 overflow-hidden z-50"
                    >
                        <!-- Header -->
                        <div class="relative px-5 pt-5 pb-4 bg-gradient-to-br from-emerald-50 via-white to-white border-b border-slate-100">

                            <!-- Decorative -->
                            <div class="absolute -top-8 -right-8 w-24 h-24 bg-emerald-100/50 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="relative flex items-start justify-between">

                                <!-- Title -->
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-600/20">
                                        <i class="fa-solid fa-bell text-sm"></i>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-sm font-extrabold text-slate-900">
                                                Notifikasi
                                            </h3>

                                            <span
                                                v-if="notificationCount > 0"
                                                class="min-w-[20px] h-5 px-1.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-extrabold flex items-center justify-center"
                                            >
                                                {{ notificationCount }}
                                            </span>
                                        </div>

                                        <p class="text-[11px] text-slate-500 mt-1">
                                            Informasi terbaru sistem
                                        </p>
                                    </div>
                                </div>

                                <!-- Close -->
                                <button
                                    @click="showNotification = false"
                                    class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-700 hover:bg-slate-50 hover:border-slate-300 flex items-center justify-center transition-all duration-200"
                                    aria-label="Tutup notifikasi"
                                >
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>

                            <!-- Notification Summary -->
                            <div
                                v-if="notificationCount > 0"
                                class="relative flex items-center justify-between mt-4 px-3.5 py-2.5 rounded-xl bg-white/80 border border-emerald-100"
                            >
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2.5 w-2.5">
                                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-60 animate-ping"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                    </span>

                                    <span class="text-[11px] font-semibold text-slate-600">
                                        {{ notificationCount }} notifikasi belum dibaca
                                    </span>
                                </div>

                                <button
                                    @click="markAllAsRead"
                                    class="text-[10px] font-extrabold text-emerald-700 hover:text-emerald-800 hover:underline transition"
                                >
                                    Tandai dibaca
                                </button>
                            </div>
                        </div>

                        <!-- Notification List -->
                        <div class="max-h-[380px] overflow-y-auto custom-scrollbar">

                            <!-- Empty State -->
                            <div
                                v-if="notifications.length === 0"
                                class="px-6 py-12 text-center"
                            >
                                <div class="relative w-16 h-16 mx-auto">
                                    <div class="absolute inset-0 rounded-2xl bg-slate-100"></div>

                                    <div class="relative w-full h-full rounded-2xl flex items-center justify-center text-slate-400">
                                        <i class="fa-regular fa-bell-slash text-xl"></i>
                                    </div>
                                </div>

                                <h4 class="mt-4 text-sm font-extrabold text-slate-700">
                                    Tidak ada notifikasi
                                </h4>

                                <p class="mt-1.5 text-[11px] leading-5 text-slate-400 max-w-[230px] mx-auto">
                                    Semua informasi terbaru dari sistem akan muncul di sini.
                                </p>
                            </div>

                            <!-- Notification Item -->
                            <div
                                v-for="notification in notifications"
                                :key="notification.id"
                                @click="readNotification(notification.id)"
                                class="group relative px-5 py-4 border-b border-slate-100 cursor-pointer transition-all duration-200 hover:bg-slate-50"
                                :class="{
                                    'bg-emerald-50/40': notification.unread
                                }"
                            >
                                <!-- Unread Indicator -->
                                <div
                                    v-if="notification.unread"
                                    class="absolute left-0 top-0 bottom-0 w-[3px] bg-emerald-500 rounded-r-full"
                                ></div>

                                <div class="flex gap-3">

                                    <!-- Icon -->
                                    <div
                                        :class="getNotificationIcon(notification.type).wrapper"
                                        class="shrink-0 w-11 h-11 rounded-2xl flex items-center justify-center transition-transform duration-200 group-hover:scale-105"
                                    >
                                        <i
                                            :class="getNotificationIcon(notification.type).icon"
                                            class="text-sm"
                                        ></i>
                                    </div>

                                    <!-- Content -->
                                    <div class="min-w-0 flex-1">

                                        <!-- Title -->
                                        <div class="flex items-start justify-between gap-3">

                                            <h4 class="text-xs font-extrabold text-slate-800 leading-5 group-hover:text-emerald-700 transition-colors">
                                                {{ notification.title }}
                                            </h4>

                                            <!-- Unread Dot -->
                                            <span
                                                v-if="notification.unread"
                                                class="shrink-0 w-2 h-2 mt-1.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/40"
                                            ></span>
                                        </div>

                                        <!-- Message -->
                                        <p class="text-[11px] text-slate-500 leading-5 mt-1">
                                            {{ notification.message }}
                                        </p>

                                        <!-- Time -->
                                        <div class="flex items-center gap-1.5 mt-2.5 text-[10px] text-slate-400">
                                            <i class="fa-regular fa-clock"></i>
                                            <span>{{ notification.time }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-5 py-3.5 bg-slate-50/80 border-t border-slate-100">
                            <div class="flex items-center justify-center gap-2">
                                <i class="fa-solid fa-shield-halved text-[10px] text-emerald-600"></i>

                                <p class="text-[10px] text-slate-400 font-medium">
                                    Notifikasi sistem diperbarui secara otomatis
                                </p>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useNotifications } from "@/composables/useNotifications";

defineProps({
    title: {
        type: String,
        required: true,
        default: "Dashboard",
    },
});

const showNotification = ref(false);

const {
    notifications,
    notificationCount,
    markAsRead,
    markAllAsRead,
} = useNotifications();

const toggleNotification = () => {
    showNotification.value = !showNotification.value;
};

const readNotification = async (id) => {
    await markAsRead(id);
};

const getNotificationIcon = (type) => {
    const icons = {
        flood: {
            icon: "fa-solid fa-droplet",
            wrapper: "bg-blue-100 text-blue-600",
        },

        traffic: {
            icon: "fa-solid fa-car",
            wrapper: "bg-amber-100 text-amber-600",
        },

        environment: {
            icon: "fa-solid fa-leaf",
            wrapper: "bg-emerald-100 text-emerald-600",
        },

        infrastructure: {
            icon: "fa-solid fa-building",
            wrapper: "bg-violet-100 text-violet-600",
        },

        system: {
            icon: "fa-solid fa-circle-check",
            wrapper: "bg-slate-100 text-slate-500",
        },
    };

    return icons[type] || icons.system;
};
</script>
