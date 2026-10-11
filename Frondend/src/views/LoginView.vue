<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { login } from "@/services/api";

const router = useRouter();

const email = ref("");
const password = ref("");

const loading = ref(false);
const errorMessage = ref("");

const handleLogin = async () => {
    errorMessage.value = "";

    if (!email.value || !password.value) {
        errorMessage.value = "Email dan password wajib diisi.";
        return;
    }

    loading.value = true;

    try {
        const response = await login(
            email.value,
            password.value
        );

        console.log("Login berhasil:", response);

        // Login berhasil → dashboard
        router.replace("/dashboard");

    } catch (error) {
        console.error("Login error:", error);

        errorMessage.value =
            error.message || "Email atau password salah.";

    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="min-h-screen bg-mint-50 px-6 py-8">
        <div
            class="grid min-h-[calc(100vh-4rem)] overflow-hidden rounded-[2rem] bg-white shadow-2xl lg:grid-cols-2"
        >

            <!-- LEFT SIDE -->
            <div
                class="relative hidden overflow-hidden bg-brand-deep lg:flex"
            >
                <div
                    class="absolute -right-32 -top-32 h-80 w-80 rounded-full bg-brand-bright/20 blur-3xl"
                ></div>

                <div
                    class="absolute -bottom-40 -left-20 h-96 w-96 rounded-full bg-brand-accent/20 blur-3xl"
                ></div>

                <div
                    class="relative z-10 flex w-full flex-col justify-between p-12"
                >
                    <div>
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl  text-lg font-extrabold text-brand-deep"
                            >
                                <img src="../assets/logo.png" alt="">
                            </div>

                            <div>
                                <p class="text-lg font-bold text-white">
                                    CityVerse
                                </p>

                                <p class="text-xs text-brand-accent">
                                    Makassar Smart City
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand-accent/30 bg-white/10 px-4 py-2 text-xs font-medium text-brand-accent"
                        >
                            <span
                                class="h-2 w-2 rounded-full bg-brand-bright"
                            ></span>

                            Smart City Platform
                        </div>

                        <h1
                            class="max-w-lg text-5xl font-bold leading-tight text-white"
                        >
                            Kelola Kota dengan
                            <span class="text-brand-bright">
                                lebih cerdas.
                            </span>
                        </h1>

                        <p
                            class="mt-6 max-w-md text-sm leading-7 text-white/65"
                        >
                            Akses dashboard CityVerse untuk memantau kondisi kota,
                            mengelola data, dan mendukung pengambilan keputusan
                            berbasis data.
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-between border-t border-white/10 pt-6"
                    >
                        <p class="text-xs text-white/40">
                            © 2026 CityVerse Makassar
                        </p>

                        <div
                            class="flex items-center gap-2 text-xs text-white/40"
                        >
                            <span
                                class="h-2 w-2 rounded-full bg-brand-accent"
                            ></span>

                            System Online
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div
                class="flex items-center justify-center px-6 py-10 sm:px-10 lg:px-16"
            >
                <div class="w-full max-w-md">

                    <!-- Mobile Logo -->
                    <div class="mb-10 lg:hidden">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-deep text-sm font-extrabold text-white"
                            >
                                CV
                            </div>

                            <div>
                                <p class="font-bold text-brand-deep">
                                    CityVerse
                                </p>

                                <p class="text-xs text-gray-400">
                                    Makassar Smart City
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-8">
                        <p
                            class="mb-2 text-sm font-semibold text-brand-active"
                        >
                            Selamat datang kembali
                        </p>

                        <h2 class="text-3xl font-bold text-brand-deep">
                            Masuk ke akun Anda
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            Masukkan email dan password terdaftar untuk mengakses
                            dashboard CityVerse.
                        </p>
                    </div>

                    <!-- FORM -->
                    <form
                        class="space-y-5"
                        @submit.prevent="handleLogin"
                    >

                        <!-- EMAIL -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-semibold text-gray-700"
                            >
                                Email
                            </label>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                >
                                    @
                                </div>

                                <input
                                    v-model="email"
                                    type="email"
                                    placeholder="nama@email.com"
                                    autocomplete="email"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-active focus:bg-white focus:ring-4 focus:ring-brand-accent/20"
                                />
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <div
                                class="mb-2 flex items-center justify-between"
                            >
                                <label
                                    class="block text-sm font-semibold text-gray-700"
                                >
                                    Password
                                </label>

                                <a
                                    href="#"
                                    class="text-xs font-semibold text-brand-active hover:text-brand-deep"
                                >
                                    Lupa password?
                                </a>
                            </div>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                                >
                                    •
                                </div>

                                <input
                                    v-model="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-active focus:bg-white focus:ring-4 focus:ring-brand-accent/20"
                                />
                            </div>
                        </div>

                        <!-- ERROR -->
                        <div
                            v-if="errorMessage"
                            class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600"
                        >
                            {{ errorMessage }}
                        </div>

                        <!-- REMEMBER -->
                        <div class="flex items-center justify-between">
                            <label
                                class="flex cursor-pointer items-center gap-2.5 text-sm text-gray-500"
                            >
                                <input
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-active focus:ring-brand-active"
                                />

                                Ingat saya
                            </label>
                        </div>

                        <!-- LOGIN BUTTON -->
                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full rounded-xl bg-brand-deep px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-deep/20 transition hover:bg-brand-sidebar active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ loading ? "Memproses..." : "Masuk" }}
                        </button>
                    </form>

                    <!-- BACK -->
                    <a
                        href="/"
                        class="mx-auto mt-6 flex w-fit items-center gap-2 text-sm font-medium text-gray-400 transition hover:text-brand-deep"
                    >
                        Kembali ke Beranda
                    </a>

                </div>
            </div>
        </div>
    </div>
</template>