<template>
  <div>
    <div class="text-gray-700 px-5 mb-5 font-bold text-2xl">Hotel List</div>

    <!-- Looping hotel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-2 justify-items-center">
      <div v-for="(hotel, index) in hotels" :key="hotel.id" class="px-5 mb-5">
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
          <!-- gambar dari unsplash -->
          <img v-if="photos[index]" :src="photos[index].urls.small" :alt="photos[index].alt_description" class="w-full h-40 object-cover rounded-md">
          <div class="px-6 pt-4 pb-2">
            <div class="font-bold text-xl mb-2 text-gray-600">{{ hotel.name }}</div>
            <p class="text-gray-700 text-base">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis
              eaque, exercitationem praesentium nihil.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import axios from 'axios'

// state
const hotels = ref([])
const photos = ref([]) // simpan gambar unsplash

// Unsplash API key
const ACCESS_KEY = 'ZKZOPEf5308spp9gsOPMCfXdw5lwFqmemPYnoiu65LY'

// lifecycle
onMounted(async () => {
  try {
    // fetch hotel dari backend
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
  }
})
</script>
