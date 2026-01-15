<template>
    <div class="w-full min-h-screen bg">
        <!-- Hero Section dengan gambar -->
        <div class="relative h-80">
            <img src="../assets/picture/home.jpg" alt="home"
                class="absolute inset-0 w-full h-full object-cover opacity-75">

            <!-- Card -->
            <div
                class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2
                bg-white shadow-lg rounded-2xl p-6 md:p-8 z-10 w-[90%] md:w-auto">

                <div class="grid grid-cols-1 sm:grid-cols-7 gap-4 sm:gap-6 items-end">

                    <!-- Check In -->
                    <div class="col-span-1 sm:col-span-2 flex flex-col space-y-1">
                        <label for="checkin" class="text-gray-800 font-medium">Check In</label>
                        <input v-model="checkin" type="date" id="checkin"
                            class="w-full h-12 px-4 rounded-md border border-gray-300" :min="today">
                    </div>

                    <!-- Check Out -->
                    <div class="col-span-1 sm:col-span-2 flex flex-col space-y-1">
                        <label for="checkout" class="text-gray-800 font-medium">Check Out</label>
                        <input v-model="checkout" type="date" id="checkout"
                            class="w-full h-12 px-4 rounded-md border border-gray-300" :min="checkin || today">
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
                    <button
                        class="col-span-1 sm:col-span-1 bg-cyan-100 hover:bg-cyan-200 transition rounded-md p-1 flex items-center justify-center"
                        @click="handleSearch">
                        <MagnifyingGlassCircleIcon class="w-6 h-6 text-cyan-700" />
                    </button>
                </div>

                <!-- Alert Message -->
                <div v-if="errorMessage"
                    class="mt-4 p-3 rounded-md bg-red-100 border border-red-400 text-red-700 text-sm text-center">
                    {{ errorMessage }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { MagnifyingGlassCircleIcon } from "@heroicons/vue/16/solid";

export default {
    name: "Home",
    data() {
        return {
            checkin: "",
            checkout: "",
            guest: "",
            room: "",
            today: new Date().toISOString().split("T")[0],
            errorMessage: "",
            loading: false,
        };
    },
    methods: {
        async handleSearch() {
            this.errorMessage = "";
            this.loading = true;

            try {
                if (!this.checkin || !this.checkout || !this.guest || !this.room) {
                    this.errorMessage = "Please fill in all fields.";
                    return;
                }

                const today = new Date();
                today.setHours(0, 0, 0, 0);


                if (this.guest <= 0 || this.room <= 0) {
                    this.errorMessage = "Guest and Room must be positive numbers.";
                    return;
                }

                if (isNaN(this.guest) || isNaN(this.room)) {
                    this.errorMessage = "Guest and Room must be valid numbers.";
                    return;
                }

                this.$router.push({
                    name: "available-room",
                    query: {
                        checkin: this.checkin,
                        checkout: this.checkout,
                        guest: this.guest,
                        room: this.room,
                    },
                });
            } catch (err) {
                this.errorMessage = "Something went wrong. Please try again.";
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
<style scoped>

</style>
