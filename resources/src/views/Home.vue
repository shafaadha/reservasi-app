<template>
    <div>
        <!-- Hero Section dengan gambar -->
        <div class="relative h-80">
            <img src="../assets/picture/home.jpg" alt="home"
                class="absolute inset-0 w-full h-full object-cover opacity-75">

            <!-- Card -->
            <div class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2 
            bg-white shadow-lg rounded-2xl p-6 md:p-8 z-10 w-[90%] md:w-auto">
                <div class="grid grid-cols-1 sm:grid-cols-7 gap-4 sm:gap-6 items-end">

                    <!-- Check In -->
                    <div class="col-span-1 sm:col-span-2 flex flex-col space-y-1">
                        <label for="checkin" class="text-gray-800 font-medium">Check In</label>
                        <input v-model="checkin" type="date" id="checkin"
                            class="w-full h-12 px-4 rounded-md border border-gray-300">
                    </div>

                    <!-- Check Out -->
                    <div class="col-span-1 sm:col-span-2 flex flex-col space-y-1">
                        <label for="checkout" class="text-gray-800 font-medium">Check Out</label>
                        <input v-model="checkout" type="date" id="checkout"
                            class="w-full h-12 px-4 rounded-md border border-gray-300">
                    </div>

                    <!-- Guest -->
                    <div class="col-span-1 sm:col-span-1 flex flex-col space-y-1">
                        <label for="guest" class="text-gray-800 font-medium">Guest</label>
                        <input v-model="guest" type="number" id="guest"
                            class="w-full h-12 px-4 rounded-md border border-gray-300">
                    </div>

                    <!-- Room -->
                    <div class="col-span-1 sm:col-span-1 flex flex-col space-y-1">
                        <label for="room" class="text-gray-800 font-medium">Room</label>
                        <input v-model="room" type="number" id="room"
                            class="w-full h-12 px-4 rounded-md border border-gray-300">
                    </div>

                    <!-- Tombol Find -->
                    <button class="col-span-1 sm:col-span-1 bg-cyan-100 rounded-md p-1 flex items-center justify-center"
                        v-on:click="handleSearch">
                        <MagnifyingGlassCircleIcon class="w-6 h-6 text-cyan-700" />
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { MagnifyingGlassCircleIcon } from "@heroicons/vue/16/solid";
import api from "../services/api.js";

export default {
    name: "Home",
    data() {
        return {
            checkin: "",
            checkout: "",
            guest: "",
            room: "",
        };
    },
    methods: {
        async handleSearch() {
            this.loading = true;

            try {
                // pindah ke halaman available-room
                console.log("Response API:", res.data)
                this.$router.push({
                    name: "available-room", query: {
                        checkin: this.checkin,
                        checkout: this.checkout,
                        guest: this.guest,
                        room: this.room,
                    }
                });
            } catch (err) {
                console.error(err);
            } finally {
            }
        },
    },
};
</script>
