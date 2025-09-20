<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "../services/api";
import axios from "axios";

const route = useRoute();

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
    rooms.value = response.data.availableRooms || []; // asumsi response ada property availableRooms

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
</script>

<template>
  <div>
    <h1 class="text-xl font-bold mb-4">Daftar Kamar Tersedia</h1>

    <div v-if="rooms.length">
      <div v-for="(room, index) in rooms" :key="room.id"
        class="flex flex-row justify-between border border-gray-200 rounded p-4 mb-3 shadow h-full w-150">
        <img v-if="photos[index]" :src="photos[index].urls.small" :alt="photos[index].alt_description"
          class="w-40 h-32 object-cover rounded-md mx-2" />

        <div>
          <h2 class="font-semibold text-lg">{{ room.name }}</h2>
          <p>Tipe: {{ room.type }}</p>
          <p>Kapasitas: {{ room.capacity }} orang</p>
          <p>Jumlah tersedia: {{ room.quantity }}</p>
        </div>

        <div class="text-green-600 font-bold text-right mt-4">
          Rp {{ Number(room.price).toLocaleString("id-ID") }}
        </div>
      </div>
    </div>

    <!-- Kalau kosong -->
    <div v-else>
      <p>Tidak ada kamar tersedia.</p>
    </div>
  </div>
</template>
