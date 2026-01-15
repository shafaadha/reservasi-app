<template>
    <div class="w-full">
        <!-- Container Form -->
        <div class="flex justify-center mt-4 px-4">
            <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-center mb-6">Login</h1>

                <div v-if="errorMessages" class="mb-4 p-3 rounded-md bg-red-100 border border-red-400 text-red-700">
                    {{ errorMessages }}
                </div>

                <form @submit.prevent="handleLogin" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-500">Email address</label>
                        <div class="mt-2">
                            <input type="email" v-model="email" name="email" id="email" autocomplete="email" required=""
                                class="block w-full rounded-md bg-sky-500/5 px-3 py-1.5 text-base text-neutral-700 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm/6 font-medium text-gray-500">Password</label>
                        <div class="mt-2">
                            <input type="password" v-model="password" name="password" id="password"
                                autocomplete="current-password" required=""
                                class="block w-full rounded-md bg-sky-500/5 px-3 py-1.5 text-base text-neutral-700 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-sky-500 rounded-md w-full text-white py-1.5 disabled:opacity-50">
                            {{ loading ? "Loggin in..." : "Login" }}
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-gray-600">
                    Belum punya akun?
                    <RouterLink to="/register" class="text-blue-500 font-medium hover:underline">
                        Register
                    </RouterLink>
                </p>
            </div>
        </div>
    </div>
</template>


<script>

import api, { setAuthToken } from "../services/api";
import { errorMessages } from "vue/compiler-sfc";

export default {
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
            loading: false,
            errorMessages: "",
        };
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            try {
                const res = await api.post("/login", {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem("token", res.data.token);

                setAuthToken(res.data.token);
                window.dispatchEvent(new Event("login-success"));

                const redirectTo = this.$route.query.redirect || "/";

                this.$router.push( redirectTo );
            } catch (err) {
                this.errorMessages = "Email atau password salah!";
            } finally {
                this.loading = false;
            }
        }


    },
};
</script>
