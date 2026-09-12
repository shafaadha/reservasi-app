<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";
import { useBookingStore } from "../stores/booking";
import api from "../services/api";
import axios from "axios";
import PriceRangeSlider from "../component/PriceRangeSlider.vue";
import CategoryFilter from "../component/CategoryFilter.vue";
import RoomCard from "../component/room/RoomCard.vue";
import RoomCardSkeleton from "../component/room/RoomCardSkeleton.vue";
import UnsplashService from "../services/unplash.js";

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();
const bookingStore = useBookingStore();

const photos = ref([]);
const rooms = ref([]);
const loading = ref(true);
const selectedCategories = ref([]);

const priceRange = ref({
    min: 0,
    max: 3000000,
});

const filteredRooms = computed(() => {
    return rooms.value.filter((room) => {
        const price = Number(room.price);

        const matchPrice =
            price >= priceRange.value.min && price <= priceRange.value.max;

        const matchCategory =
            selectedCategories.value.length === 0 ||
            selectedCategories.value.includes(room.type);

        return matchPrice && matchCategory;
    });
});

const roomCategories = computed(() => {
    const types = rooms.value.map((r) => r.type);
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
        rooms.value = response.data.data || [];

        photos.value = await UnsplashService.search("hotel");
    } catch (err) {
        console.log(err.response.data);
    } finally {
        loading.value = false;
    }
});

const reservation = (room) => {
    const query = {
        hotelId: room.hotel_id,
        roomId: room.id,
        name: room.name,
        price: room.price,
        checkin: route.query.checkin,
        checkout: route.query.checkout,
        guest: route.query.guest,
        room: route.query.room,
    };

    if (!auth.isLoggedIn) {
        router.push({
            name: "login",
            query: {
                redirect: "/booking",
                ...query,
            },
        });
        return;
    }

    router.push({
        name: "BookingPage",
        query,
    });
};
</script>

<template>
    <div class="container mx-auto mt-6 px-4 text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <aside class="md:col-span-1 bg-white shadow rounded p-4 h-fit">
                <h2 class="text-lg font-semibold mb-3">Filter</h2>
                <PriceRangeSlider
                    v-model="priceRange"
                    :minLimit="0"
                    :maxLimit="3000000"
                    :gap="50000"
                    :step="10000"
                />
                <CategoryFilter
                    class="mt-4"
                    v-model="selectedCategories"
                    :categories="roomCategories"
                />
            </aside>

            <!-- Main Content -->
            <main class="md:col-span-3">
                <h1 class="text-2xl font-bold mb-5 text-center">
                    Daftar Kamar Tersedia
                </h1>
                <div v-if="loading">
                    <RoomCardSkeleton v-for="i in 5" :key="i" />
                </div>

                <div v-else-if="filteredRooms.length">
                    <RoomCard
                        v-for="(room, index) in filteredRooms"
                        :key="room.id"
                        :room="room"
                        :photo="photos[index]"
                        @reserve="reservation"
                    />
                </div>

                <div v-else>
                    <p class="text-center text-gray-500">
                        Tidak ada kamar tersedia.
                    </p>
                </div>
            </main>
        </div>
    </div>
</template>
