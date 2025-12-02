<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../services/api";
import axios from "axios";
import PriceRangeSlider from "../component/PriceRangeSlider.vue";
import CategoryFilter from "../component/CategoryFilter.vue";

const route = useRoute();
const router = useRouter();

const photos = ref([]);
const rooms = ref([]);
const loading = ref(true);
const selectedCategories = ref([]);

const priceRange = ref({
    min: 0,
    max: 3000000
})

const filteredRooms = computed(() => {
    return rooms.value.filter(room => {
        const price = Number(room.price);

        const matchPrice =
            price >= priceRange.value.min &&
            price <= priceRange.value.max;

        const matchCategory =
            selectedCategories.value.length === 0 ||
            selectedCategories.value.includes(room.type);

        return matchPrice && matchCategory;
    });
});


const roomCategories = computed(() => {
    const types = rooms.value.map(r => r.type);
    return [...new Set(types)];
});


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
            params: { query: "hotel", per_page: 100 },
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
                <PriceRangeSlider v-model="priceRange" :minLimit="0" :maxLimit="3000000" :gap="50000" :step="10000" />
                <CategoryFilter class="mt-4" v-model="selectedCategories" :categories="roomCategories" />

            </aside>

            <!-- Main Content -->
            <main class="md:col-span-3">
                <h1 class="text-2xl font-bold mb-5 text-center">Daftar Kamar Tersedia</h1>

                <div v-if="filteredRooms.length">
                    <div v-for="(room, index) in filteredRooms" :key="room.id"
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
