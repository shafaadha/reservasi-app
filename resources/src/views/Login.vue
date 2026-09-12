<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "../stores/auth";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/outline";
import BaseButton from "../component/button/BaseButton.vue";

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const email = ref("");
const password = ref("");
const loading = ref(false);
const errorMessages = ref("");
const showPassword = ref(false);

const handleLogin = async () => {
    loading.value = true;
    errorMessages.value = "";

    try {
        await auth.login({
            email: email.value,
            password: password.value,
        });

        const role = auth.user?.role;

        if (role === "admin") {
            return router.push("/admin/dashboard");
        }

        const { redirect, ...query } = route.query;

        if (redirect) {
            return router.push({
                path: redirect,
                query,
            });
        }

        router.push("/");
    } catch (err) {
        console.error(err);
        errorMessages.value = err;
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="max-h-min bg-white">
        <!-- Container Form -->
        <div class="min-h-screen flex items-center justify-center">
            <div
                class="w-full max-w-md bg-white shadow-lg rounded-2xl border border-gray-300 p-8"
            >
                <h1 class="text-2xl font-bold text-center mb-6 text-gray-700">
                    Login
                </h1>

                <div
                    v-if="errorMessages"
                    class="mb-4 p-3 rounded-md bg-red-100 border border-red-400 text-red-700"
                >
                    {{ errorMessages }}
                </div>

                <form @submit.prevent="handleLogin" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm/6 font-medium text-gray-500"
                            >Email address</label
                        >
                        <div class="mt-2">
                            <input
                                type="email"
                                v-model="email"
                                name="email"
                                id="email"
                                autocomplete="email"
                                required=""
                                class="block w-full rounded-md px-3 py-2 text-neutral-700 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 border border-gray-500"
                            />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-sm/6 font-medium text-gray-500"
                            >Password</label
                        >
                        <div class="relative mt-2">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                v-model="password"
                                id="password"
                                autocomplete="current-password"
                                class="w-full rounded-md px-3 py-2 pr-10 text-neutral-700 outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:outline-indigo-500 border border-gray-500"
                            />

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                            >
                                <EyeIcon v-if="!showPassword" class="w-5 h-5" />
                                <EyeSlashIcon v-else class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-center mt-6">
                        <!-- <button
                            type="submit"
                            class="bg-sky-500 rounded-md w-full text-white py-1.5 disabled:opacity-50"
                        >
                            {{ loading ? "Loggin in..." : "Login" }}
                        </button> -->

                        <BaseButton
                            type="submit"
                            :disabled="loading"
                            :text="loading ? 'Logging in...' : 'Login'"
                            class="w-full"
                        />
                    </div>
                </form>

                <p class="mt-6 text-center text-gray-600">
                    Belum punya akun?
                    <RouterLink
                        to="/register"
                        class="text-blue-500 font-medium hover:underline"
                    >
                        Register
                    </RouterLink>
                </p>
            </div>
        </div>
    </div>
</template>
