<template>
    <div>
        <!-- Hero Section dengan gambar -->
        <div class="relative h-80">
            <img src="../assets/picture/home.jpg" alt="home"
                class="absolute inset-0 w-full h-full object-cover opacity-75">

            <!-- Card -->
            <div class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2 
                  bg-white shadow-lg rounded-2xl p-8 z-10">
                <div class="flex space-x-8">
                    <div class="flex flex-col items-start space-y-2">
                        <label for="checkin" class="text-gray-800 font-medium">Check In</label>
                        <input v-model="checkin" type="date" id="checkin"
                            class="h-12 px-4 rounded-md border border-gray-300">
                    </div>
                    <div class="flex flex-col items-start space-y-2">
                        <label for="checkout" class="text-gray-800 font-medium">Check Out</label>
                        <input v-model="checkout" type="date" id="checkout"
                            class="h-12 px-4 rounded-md border border-gray-300">
                    </div>
                    <div class="flex flex-col items-start space-y-2">
                        <label for="guest" class="text-gray-800 font-medium">Guest</label>
                        <input v-model="guest" type="number" id="guest"
                            class="h-12 px-4 rounded-md border border-gray-300">
                    </div>
                    <div class="flex flex-col items-start space-y-2">
                        <label for="room" class="text-gray-800 font-medium">Room</label>
                        <input v-model="room" type="number" id="room"
                            class="w-28 h-12 px-4 rounded-md border border-gray-300">
                    </div>
                    <!-- Tombol Search -->
                    <div class="flex justify-end mt-6">
                        <button @click="handleSearch"
                            class="bg-cyan-500 text-white px-6 py-2 rounded-lg hover:bg-cyan-600">
                            Find
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import api from "../services/api.js";
import { useRoomStore } from "../stores/roomStore";

export default {
    name: "Home",
    data() {
        return {
            checkin: "",
            checkout: "",
            guest: "",
            room: "",
            loading: false,
        };
    },
    methods: {
        async handleSearch() {
            this.loading = true;
            const roomStore = useRoomStore();

            try {
                const res = await api.post("/room/check-availability", {
                    checkin: this.checkin,
                    checkout: this.checkout,
                    guest: this.guest,
                    room: this.room,
                });

                // simpan ke store
                roomStore.setAvailableRooms(res.data);

                // pindah ke halaman available-room
                console.log("Response API:", res.data)
                this.$router.push({ name: "available-room" });
            } catch (err) {
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
