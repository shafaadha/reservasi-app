<template>
    <div>
        <div class="text-gray-700 px-5 mb-5 mt-5 font-bold text-2xl">
            Hotel List
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-3 gap-y-2 justify-items-center">

            <div v-for="(item, index) in (loading ? Array(6) : hotels)" :key="loading ? index : item.id"
                class="px-5 mb-5 w-full flex justify-center">
                <div class="max-w-sm w-full rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="h-40 w-full overflow-hidden">
                        <div v-if="loading" class="bg-gray-300 h-full w-full animate-pulse"></div>

                        <img v-else :src="photos[index]?.urls.small" :alt="photos[index]?.alt_description"
                            class="h-full w-full object-cover" />
                    </div>
                    <div class="px-6 pt-4 pb-4">
                        <div v-if="loading" class="bg-gray-300 h-6 w-3/4 mb-2 animate-pulse"></div>

                        <h3 v-else class="font-bold text-xl mb-2 text-gray-600">
                            {{ item.name }}
                        </h3>

                        <div v-if="loading" class="space-y-2">
                            <div class="bg-gray-300 h-4 w-full animate-pulse"></div>
                            <div class="bg-gray-300 h-4 w-5/6 animate-pulse"></div>
                        </div>

                        <p v-else class="text-gray-700 text-base">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
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

const hotels = ref([])
const photos = ref([])
const loading = ref(true)

onMounted(async () => {
    try {
        const configRes = await api.get('/config')
        let ACCESS_KEY = configRes.data.unsplash_access_key

        const response = await api.get("/hotels")
        hotels.value = response.data.data

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
