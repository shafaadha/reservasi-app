<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const bookingData = ref({
    name: route.query.name,
    price: route.query.price,
    roomId: route.query.roomId,
    checkin: route.query.checkin,
    checkout: route.query.checkout,
    guest: route.query.guest,
})

// const confirmBooking = () =>{

// }

</script>

<template>
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6 center">
        <h1 class="text-2xl font-bold mb-6">Detail Booking</h1>

        <div class="space-y-3">
            <p><span class="font-semibold">Nama Kamar:</span> {{ bookingData.name }}</p>
            <p><span class="font-semibold">Check-in:</span> {{ bookingData.checkin }}</p>
            <p><span class="font-semibold">Check-out:</span> {{ bookingData.checkout }}</p>
            <p><span class="font-semibold">Jumlah Tamu:</span> {{ bookingData.guest }} orang</p>
            <p><span class="font-semibold">Harga:</span> Rp {{ Number(bookingData.price).toLocaleString("id-ID") }}</p>
        </div>

        <div class="mt-6 border-t pt-4">
            <h2 class="text-lg font-semibold mb-3">Ubah Tanggal</h2>
            <div class="flex flex-col gap-3">
                <label>
                    Check-in:
                    <input v-model="bookingData.checkin" type="date" class="border rounded px-2 py-1 w-full" />
                </label>
                <label>
                    Check-out:
                    <input v-model="bookingData.checkout" type="date" class="border rounded px-2 py-1 w-full" />
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button @click="confirmBooking" class="bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-700">
                Konfirmasi Booking
            </button>
        </div>
    </div>
</template>
