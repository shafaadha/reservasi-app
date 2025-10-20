<template>
    <div class="container">

        <!-- Container Form -->
        <div class="flex justify-center mt-4 px-4">
            <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-center mb-6">Register</h1>

                <form @submit.prevent="handleRegister" class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block mb-1 text-gray-700">Name</label>
                        <div class="mt-2">
                            <input type="text" v-model="name" name="name" id="name" placeholder="Enter your name"
                                class="block w-full rounded-md px-3 py-1.5 text-base text-neutral-700 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-500">Email address</label>
                        <div class="mt-2">
                            <input type="email" v-model="email" name="emai" id="email" required=""
                                class="block w-full rounded-md px-3 py-1.5 text-base text-neutral-700 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                placeholder="Enter your email">
                        </div>
                    </div>


                    <!-- Password -->
                    <div>
                        <label for="password">Password</label>
                        <div class="mt-2">
                            <input type="password" v-model="password" name="password" id="password" required=""
                                class="block w-full rounded-md px-3 py-1.5 text-base text-neutral-700 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                placeholder="Enter your password">
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-center mt-6">
                        <button type="submit" class="bg-sky-500 rounded-md w-full text-white py-1.5">
                            Register
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-gray-600">
                    Sudah punya akun?
                    <RouterLink to="/login" class="text-blue-500 font-medium hover:underline">
                        Login
                    </RouterLink>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { errorMessages } from "vue/compiler-sfc";
import api, { setAuthToken } from "../services/api";

export default {
    name: "Register",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            loading: false,
            errorMessages: "",
        };
    },
    methods: {
        async handleRegister() {
            this.loading = true;
            try {
                const res = await api.post("/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });

                // redirect ke hotels
                this.$router.push({ name: "hotels" });
            } catch (err) {
                this.errorMessages = err.response?.data?.message
            } finally {
                this.loading = false;
            }
        },

    },
};
</script>
