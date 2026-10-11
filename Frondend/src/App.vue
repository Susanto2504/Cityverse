<template>
    <div class="bg-brand-deep text-slate-800 font-sans h-screen w-screen flex antialiased select-none overflow-hidden">
        <div class="w-full h-full flex flex-col md:flex-row border border-emerald-900/30 overflow-hidden relative">
            <div v-if="isSidebarOpen && showSidebar" @click="isSidebarOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden transition-opacity"></div>

            <aside v-if="showSidebar" :class="['h-full overflow-hidden bg-brand-sidebar text-white flex flex-col justify-between shrink-0 transition-all duration-300 z-50', 'fixed inset-y-0 left-0 w-72 transform md:transform-none md:static md:w-72 lg:w-80', isSidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full md:translate-x-0']">
                <Aside @close="isSidebarOpen = false" />
            </aside>

            <main :class="['flex-1 h-full overflow-y-auto bg-mint-50/90 relative', !showSidebar ? 'w-full' : '']">
                <RouterView @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import Aside from "./components/layout/Aside.vue";
import { useRoute, RouterView } from "vue-router";

const isSidebarOpen = ref(false);
const route = useRoute();

const showSidebar = computed(() => !["/", "/login"].includes(route.path));

watch(
    () => route.path,
    () => {
        isSidebarOpen.value = false;
    }
);
</script>

<style scoped>

</style>