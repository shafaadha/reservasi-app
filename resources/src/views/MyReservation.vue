<template>
    <section class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">My Reservations</h1>
        <div v-if="loading" class="text-gray-500">
            Loading reservations...
        </div>
        <div v-else-if="!hotels || hotels.length === 0" class="text-gray-500">
            Tidak ada reservasi
        </div>
        <div v-else class="space-y-4">
            <div
                v-for="reservation in hotels"
                :key="reservation.id"
                class="rounded-2xl shadow p-5 border"
            >
                <div class="flex justify-between items-center mb-2">
                    <p class="font-medium">
                        {{ formatDate(reservation.check_in) }}
                        →
                        {{ formatDate(reservation.check_out) }}
                    </p>

                    <span
                        class="px-3 py-1 rounded-full text-sm"
                        :class="statusClass(reservation.status)"
                    >
                        {{ reservation.status }}
                    </span>
                </div>

                <p class="text-sm text-gray-600">
                    Guests: {{ reservation.guests }} · Room: {{ reservation.room_booked }}
                </p>

                <p class="mt-2 font-semibold">
                    Total Price:
                    <span class="text-green-600">
                        Rp {{ formatPrice(reservation.total_price) }}
                    </span>
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const hotels = ref([])
const loading = ref(true)

onMounted(async () => {
    try {
        const { data } = await api.get('/my-reservations')
        hotels.value = Array.isArray(data) ? data : []
    } catch (err) {
        console.error('Failed to load reservations:', err)
        hotels.value = []
    } finally {
        loading.value = false
    }
})

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price)
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID')
}

const statusClass = (status) => {
    return {
        pending: 'bg-yellow-100 text-yellow-700',
        confirmed: 'bg-green-100 text-green-700',
        cancelled: 'bg-red-100 text-red-700',
    }[status] || 'bg-gray-100 text-gray-700'
}
</script>
