
<template>
    <div class="min-h-screen bg-[#F6FAF7] font-sans text-[#123524]">

        <!-- NAVBAR -->
        <header class="fixed left-0 right-0 top-0 z-50 px-4 pt-4 md:px-6 md:pt-5">
            <div class="mx-auto flex h-[72px] max-w-[1250px] items-center justify-between rounded-[22px] border border-white/70 bg-white/85 px-4 shadow-[0_12px_45px_rgba(18,53,36,0.08)] backdrop-blur-2xl md:px-6">
                <!-- LOGO -->
                <div class="group flex items-center gap-3.5">
                    <div class="flex h-11 w-11 items-center justify-center rounded-[14px]  text-[#123524] shadow-[0_6px_20px_rgba(195,233,86,0.2)] transition duration-300 group-hover:rotate-[-4deg] group-hover:scale-105">
                        <img src="../assets/WhatsApp_Image_2026-09-28_at_09.22.14-removebg-preview-3.png" alt="">
                    </div>

                    <div class="leading-none">
                        <div class="text-[7px] font-bold tracking-[0.22em] text-gray-400">MAKASSAR SMART CITY</div>
                        <div class="mt-1 text-[19px] font-black tracking-[-0.03em] text-[#123524]">
                            CITYVERSE<span class="text-[#78A82C]">.</span>
                        </div>
                    </div>
                </div>

                <!-- CENTER NAVIGATION -->
                <nav class="absolute left-1/2 hidden -translate-x-1/2 items-center rounded-full border border-gray-100 bg-gray-50/80 p-1 md:flex">
                    <button type="button" @click="scrollToSection('beranda')" :class="activeSection === 'beranda' ? 'rounded-full bg-[#123524] px-5 py-2.5 text-[11px] font-bold text-white shadow-sm transition' : 'rounded-full px-5 py-2.5 text-[11px] font-semibold text-gray-500 transition hover:bg-white hover:text-[#123524]'">Beranda</button>

                    <button type="button" @click="scrollToSection('tentang')" :class="activeSection === 'tentang' ? 'rounded-full bg-[#123524] px-5 py-2.5 text-[11px] font-bold text-white shadow-sm transition' : 'rounded-full px-5 py-2.5 text-[11px] font-semibold text-gray-500 transition hover:bg-white hover:text-[#123524]'">Tentang</button>

                    <button type="button" @click="scrollToSection('fitur')" :class="activeSection === 'fitur' ? 'rounded-full bg-[#123524] px-5 py-2.5 text-[11px] font-bold text-white shadow-sm transition' : 'rounded-full px-5 py-2.5 text-[11px] font-semibold text-gray-500 transition hover:bg-white hover:text-[#123524]'">Fitur</button>
                </nav>

                <!-- RIGHT ACTION -->
                <div class="flex items-center gap-2.5">
                    <!-- STATUS -->
                    <div class="hidden items-center gap-2 rounded-full border border-gray-100 bg-gray-50 px-3.5 py-2.5 lg:flex">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>

                        <span class="text-[9px] font-semibold text-gray-500">Sistem Aktif</span>
                    </div>

                    <!-- LOGIN -->
                    <a href="/login" class="group flex items-center gap-2 rounded-full bg-[#123524] px-5 py-3 text-[10px] font-bold text-white shadow-[0_6px_20px_rgba(18,53,36,0.15)] transition duration-300 hover:-translate-y-0.5 hover:bg-[#1C4B32] hover:shadow-[0_10px_25px_rgba(18,53,36,0.2)]">Masuk</a>
                </div>
            </div>
        </header>

        <main>

            <!-- HERO -->
            <section id="beranda" class="scroll-mt-28 relative min-h-screen overflow-hidden bg-[#123524] pt-32">
                <!-- GRID -->
                <div class="absolute inset-0 opacity-[0.08]" :style="{ backgroundImage: 'linear-gradient(#C3E956 1px, transparent 1px), linear-gradient(90deg, #C3E956 1px, transparent 1px)',backgroundSize: '60px 60px',}"></div>

                <!-- GLOW -->
                <div class="absolute -right-32 top-20 h-[500px] w-[500px] rounded-full bg-[#C3E956]/10 blur-[120px]"></div>

                <div class="absolute -left-40 bottom-0 h-[450px] w-[450px] rounded-full bg-emerald-400/10 blur-[120px]"></div>

                <div class="relative mx-auto max-w-[1250px] px-6 pb-24 pt-16">

                    <!-- HERO TEXT -->
                    <div class="mx-auto max-w-4xl text-center">

                        <div class="mx-auto inline-flex items-center gap-2 rounded-full border border-[#C3E956]/20 bg-white/5 px-4 py-2 text-[9px] font-bold uppercase tracking-[0.2em] text-[#C3E956] backdrop-blur">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#C3E956] shadow-[0_0_12px_#C3E956]"></span>
                            Smart City Platform
                        </div>

                        <h1 class="mt-7 text-5xl font-black leading-[0.95] tracking-[-0.04em] text-white md:text-7xl lg:text-[86px]">Membangun Kota <span class="block text-[#C3E956]">Lebih Cerdas</span></h1>

                        <p class="mx-auto mt-7 max-w-2xl text-sm leading-7 text-white/55 md:text-base"
                        >CityVerse mendukung keputusan perkotaan yang tepat melalui simulasi kebijakan dan rekomendasi berbasis AI.
                        </p>

                        <!-- ACTION -->
                        <div class="mt-9 flex flex-wrap justify-center gap-3">
                            <a href="/login" class="group flex items-center gap-3 rounded-full bg-[#C3E956] px-7 py-4 text-xs font-extrabold text-[#123524] transition hover:-translate-y-1 hover:shadow-[0_15px_40px_rgba(195,233,86,0.2)]">Masuk ke CityVerse</a>

                            <a href="#tentang" class="rounded-full border border-white/10 bg-white/5 px-7 py-4 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/10">Kenali CityVerse</a>
                        </div>
                    </div>

                    <!-- DASHBOARD PREVIEW -->
                    <div class="relative mx-auto mt-16 max-w-[1050px]">
                        <!-- GLOW -->
                        <div class="absolute -inset-5 rounded-[35px] bg-[#C3E956]/10 blur-3xl"></div>

                        <!-- WINDOW -->
                        <div class="relative overflow-hidden rounded-[26px] border border-white/10 bg-white/10 p-2 shadow-[0_40px_100px_rgba(0,0,0,0.35)] backdrop-blur">
                            <!-- TOP BAR -->
                            <div class="flex h-9 items-center gap-1.5 px-3">
                                <span class="h-2 w-2 rounded-full bg-white/20"></span>

                                <span class="h-2 w-2 rounded-full bg-white/20"></span>

                                <span class="h-2 w-2 rounded-full bg-white/20"></span>
                            </div>

                            <div class="overflow-hidden rounded-[20px] bg-white">
                                <img src="../assets/imge.png" alt="CityVerse Dashboard" class="block h-auto w-full"/>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- INTRODUCTION -->
            <section id="tentang" class="scroll-mt-28 relative overflow-hidden bg-[#F6FAF7] px-6 py-24">
                <div class="mx-auto max-w-[1100px]">
                    <div class="grid gap-14 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">

                        <!-- LEFT -->
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-[0.25em] text-[#78A82C]">Tentang CityVerse</span>

                            <h2 class="mt-4 text-3xl font-black leading-tight tracking-tight text-[#123524] md:text-4xl">Memetakan Risiko, <span class="text-[#78A82C]">Membangun Solusi</span></h2>
                        </div>

                        <!-- RIGHT -->
                        <div>
                            <p class="text-sm leading-7 text-gray-500 md:text-base">CityVerse dikembangkan sebagai platform Urban Digital Twin berbasis kecerdasan buatan (AI) yang dirancang untuk memetakan dan memahami keterkaitan berbagai aspek perkotaan di Kota Makassar secara terintegrasi.</p>

                            <p class="mt-5 text-sm leading-7 text-gray-500 md:text-base">Platform ini menggabungkan informasi lalu lintas, wilayah rawan banjir atau genangan air, serta kondisi infrastruktur publik. Melalui simulasi digital dan analisis risiko berbasis AI, CityVerse membantu mengevaluasi dampak kebijakan perkotaan serta menghasilkan rekomendasi alternatif untuk mendukung pengambilan keputusan yang lebih tepat, antisipatif, dan berorientasi pada keselamatan serta kesejahteraan masyarakat.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FEATURES -->
            <section id="fitur" class="scroll-mt-28 bg-white px-6 py-24">
                <div class="mx-auto max-w-[1100px]">

                    <div class="text-center">
                        <span class="text-[9px] font-black uppercase tracking-[0.25em] text-[#78A82C]">Kenapa CityVerse?</span>

                        <h2 class="mt-4 text-3xl font-black tracking-tight text-[#123524] md:text-4xl">Simulasikan Kebijakan Sebelum Menentukan Arah</h2>
                    </div>

                    <div class="mt-12 grid gap-4 md:grid-cols-3">

                        <!-- CARD 1 -->
                        <div class="group rounded-3xl border border-gray-100 bg-[#F7FAF8] p-7 transition duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(18,53,36,0.08)]">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9F6D1] text-[#557D20]">◈</div>
                            <h3 class="mt-7 text-lg font-black text-[#123524]">Terintegrasi</h3>
                            <p class="mt-3 text-xs leading-6 text-gray-500">Menggabungkan data lalu lintas, wilayah rawan banjir, dan infrastruktur publik dalam satu platform.</p>
                        </div>

                        <!-- CARD 2 -->
                        <div class="group rounded-3xl border border-gray-100 bg-[#F7FAF8] p-7 transition duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(18,53,36,0.08)]">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9F6D1] text-[#557D20]">◉</div>
                            <h3 class="mt-7 text-lg font-black text-[#123524]">Simulasi Berbasis Data dan AI</h3>
                            <p class="mt-3 text-xs leading-6 text-gray-500">Memvisualisasikan dampak kebijakan dan mengevaluasi tingkat risiko sebelum diterapkan.</p>
                        </div>

                        <!-- CARD 3 -->
                        <div class="group rounded-3xl border border-gray-100 bg-[#F7FAF8] p-7 transition duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(18,53,36,0.08)]">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#E9F6D1] text-[#557D20]"
                            >✦</div>
                            <h3 class="mt-7 text-lg font-black text-[#123524]">Rekomendasi Cerdas</h3>
                            <p class="mt-3 text-xs leading-6 text-gray-500">Menghasilkan alternatif kebijakan untuk membantu pemerintah mengambil keputusan yang lebih tepat.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="bg-[#F6FAF7] px-6 py-24">
                <div class="relative mx-auto max-w-[1100px] overflow-hidden rounded-[32px] bg-[#123524] px-8 py-14 text-center md:px-16">
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#C3E956]/10 blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-emerald-400/10 blur-3xl"></div>
                    <div class="relative">
                        <span class="text-[9px] font-bold uppercase tracking-[0.25em] text-[#C3E956]"> CityVerse </span>

                        <h2 class="mx-auto mt-4 max-w-2xl text-2xl font-black tracking-tight text-white md:text-3xl">Rancang Kebijakan dengan Lebih Cerdas.</h2>

                        <p class="mx-auto mt-4 max-w-xl text-xs leading-6 text-white/50">Masuk ke CityVerse dan Pahami kondisi Kota melalui pemetaan digital, simulasi kebijakan, dan analisis risiko berbasis AI.</p>

                        <a href="/login" class="mt-8 inline-flex items-center gap-3 rounded-full bg-[#C3E956] px-7 py-4 text-xs font-black text-[#123524] transition hover:-translate-y-1 hover:shadow-xl">Masuk ke CityVerse</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- FOOTER -->
        <footer class="border-t border-gray-100 bg-white px-6">
            <div class="mx-auto flex max-w-[1100px] flex-col justify-between gap-4 py-7 text-[9px] text-gray-400 md:flex-row">
                <span>
                    © 2026 Dinas Komunikasi dan Informatika
                    Pemerintah Kota Makassar.
                </span>

                <div class="flex gap-5">
                    <a href="#" class="transition hover:text-[#123524]">Kebijakan Privasi</a>
                    <a href="#" class="transition hover:text-[#123524]">Syarat Layanan</a>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";

const activeSection = ref("beranda");
let sectionObserver = null;

function scrollToSection(id) {
    const section = document.getElementById(id);
    if (!section) return;
    activeSection.value = id;
    section.scrollIntoView({
        behavior: "smooth",
        block: "start",
    });
}

onMounted(() => {
    const sections = document.querySelectorAll("section[id]");
    sectionObserver = new IntersectionObserver(
        (entries) => {
            const visibleSection = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (visibleSection) {
                activeSection.value = visibleSection.target.id;
            }
        },
        {
            rootMargin: "-100px 0px -60% 0px",
            threshold: 0.1,
        }
    );

    sections.forEach((section) => { sectionObserver.observe(section); });
});

onBeforeUnmount(() => {
    if (sectionObserver) {
        sectionObserver.disconnect();
    }
});
</script>
