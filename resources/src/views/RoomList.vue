<template>
  <div>
    <div class="text-gray-700 px-5 mb-5 mt-5 font-bold text-2xl">Hotel List</div>

    <!-- Looping hotel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-2 justify-items-center">

      <!-- Kalau loading, tampilkan skeleton -->
      <template v-if="loading">
        <div v-for="n in 6" :key="n" class="px-5 mb-5 w-full">
          <div class="max-w-sm rounded overflow-hidden shadow-lg animate-pulse">
            <div class="bg-gray-300 h-40 w-full"></div>
            <div class="px-6 pt-4 pb-2">
              <div class="bg-gray-300 h-6 w-3/4 mb-2"></div>
              <div class="bg-gray-300 h-4 w-full mb-1"></div>
              <div class="bg-gray-300 h-4 w-5/6"></div>
            </div>
          </div>
        </div>
      </template>

      <!-- Kalau sudah dapat data -->
      <template v-else>
        <div v-for="(hotel, index) in hotels" :key="hotel.id" class="px-5 mb-5">
          <div class="max-w-sm rounded overflow-hidden shadow-lg">
            <!-- gambar dari unsplash -->
            <img v-if="photos[index]" :src="photos[index].urls.small" :alt="photos[index].alt_description"
              class="w-full h-40 object-cover rounded-md">
            <div class="px-6 pt-4 pb-2">
              <div class="font-bold text-xl mb-2 text-gray-600">{{ hotel.name }}</div>
              <p class="text-gray-700 text-base mb-2">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis
                eaque, exercitationem praesentium nihil.
              </p>
            </div>
          </div>
        </div>
      </template>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import axios from 'axios'

// state
const hotels = ref([])
const photos = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const configRes = await api.get('/config')
    let ACCESS_KEY = configRes.data.unsplash_access_key

    // fetch hotel
    const response = await api.get("/hotels")
    hotels.value = response.data.data

    // fetch photo dari unsplash
    const res = await axios.get('https://api.unsplash.com/search/photos', {
      params: { query: 'hotel', per_page: 12 },
      headers: { Authorization: `Client-ID ${ACCESS_KEY}` }
    })
    photos.value = res.data.results
  } catch (err) {
    console.error("Error:", err)
  } finally {
    loading.value = false
  }
})
</script>
