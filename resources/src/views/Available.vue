<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";
import axios from "axios";

const route = useRoute();
const router = useRouter();

const photos = ref([]);
const rooms = ref([]);
const loading = ref(true);


onMounted(async () => {
    try {
        const { checkin, checkout, guest, room } = route.query;

        // fetch kamar tersedia
        const response = await api.post("/room/check-availability", {
            checkin,
            checkout,
            guest,
            room,
        });
        rooms.value = response.data.availableRooms || [];

        // fetch access key unsplash
        const configRes = await api.get("/config");
        let ACCESS_KEY = configRes.data.unsplash_access_key;

        // fetch photo
        const res = await axios.get("https://api.unsplash.com/search/photos", {
            params: { query: "hotel", per_page: 12 },
            headers: { Authorization: `Client-ID ${ACCESS_KEY}` },
        });
        photos.value = res.data.results;
    } catch (err) {
        console.error("Error:", err);
    } finally {
        loading.value = false;
    }
});

const reservation = (room) => {
    router.push({
        name: "BookingPage",
        query: {
            roomId: room.id,
            name: room.name,
            price: room.price,
            checkin: route.query.checkin,
            checkout: route.query.checkout,
            guest: route.query.guest,
        }
    })
}
</script>

<template>
    <div class="container mx-auto mt-6 px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <aside class="md:col-span-1 bg-white shadow rounded p-4 h-fit">
                <h2 class="text-lg font-semibold mb-3">Filter</h2>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Fitur lain di sini nanti...</p>
                    <!-- contoh: filter harga, tipe kamar, tanggal -->
                    <!-- <input type="date" class="w-full border rounded px-2 py-1" /> -->
                </div>
            </aside>

            <!-- Main Content -->
            <main class="md:col-span-3">
                <h1 class="text-2xl font-bold mb-5 text-center">Daftar Kamar Tersedia</h1>

                <div v-if="rooms.length">
                    <div v-for="(room, index) in rooms" :key="room.id"
                        class="flex flex-col md:flex-row justify-between items-center border border-gray-200 rounded p-4 mb-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <img v-if="photos[index]" :src="photos[index].urls.small" :alt="photos[index].alt_description"
                            class="w-48 h-32 object-cover rounded-md mb-3 md:mb-0 md:mr-4" />

                        <div class="flex-1">
                            <h2 class="font-semibold text-lg">{{ room.name }}</h2>
                            <p>Tipe: {{ room.type }}</p>
                            <p>Kapasitas: {{ room.capacity }} orang</p>
                            <p>Jumlah tersedia: {{ room.quantity }}</p>
                        </div>

                        <div class="text-right mt-3 md:mt-0">
                            <div class="text-green-600 font-bold mb-2">
                                Rp {{ Number(room.price).toLocaleString("id-ID") }}
                            </div>
                            <button @click="() => reservation(room)"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <p class="text-center text-gray-500">Tidak ada kamar tersedia.</p>
                </div>
            </main>
        </div>
    </div>
</template>
