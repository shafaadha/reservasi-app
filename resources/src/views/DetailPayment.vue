<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import api from "../services/api";
import UnsplashService from "../services/unplash";
import { useFormatter } from "../composables/useFormatter";
import { calculateDays } from "../utils/date";

const { formatDate, formatCurrency, statusClass, statusLabel } = useFormatter();
const route = useRoute();

const loading = ref(true);
const detailPayment = ref({});
const photo = ref([]);
const reservationId = route.query.reservationId;

const getPaymentDetail = async (id) => {
    const { data } = await api.get(`/payment/${id}`);
    detailPayment.value = data.data;
};

const night = computed(() => {
    const reservation = detailPayment.value.reservation;
    return calculateDays(reservation?.check_in, reservation?.check_out);
});

const totalPrice = computed(() => {
    total = Number(detailPayment.value.amount ?? 0);
    return formatCurrency(totalPrice);
});

const canPay = computed(() => {
    return detailPayment.value.status === "pending";
});

const reservation = computed(() => detailPayment.value.reservation ?? {});

const hotel = computed(() => reservation.value.hotel ?? {});

const roomUnit = computed(() => reservation.value.room_units?.[0] ?? {});

const room = computed(() => roomUnit.value.room ?? {});

const ratePerNight = computed(() => Number(room.value.price ?? 0));

onMounted(async () => {
    try {
        await getPaymentDetail(reservationId);

        photo.value = await UnsplashService.search("hotel");
        console.log("isi", photo.value);
    } catch (error) {
        console.error("Failed to load payment detail:", error);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <section>
        <main class="max-w-4xl mx-auto px-4 py-6">
            <div
                class="flex flex-col gap-4 md:flex-row md:gap-6 md:items-start"
            >
                <!-- LEFT -->
                <div class="flex flex-col gap-4 md:flex-1">
                    <div class="bg-white border rounded-lg overflow-hidden">
                        <div class="relative h-52">
                            <div
                                v-if="loading"
                                class="bg-gray-300 h-full w-full animate-pulse"
                            ></div>

                            <img
                                v-else-if="photo.length"
                                :src="photo[0].urls.small"
                                :alt="photo[0].alt_description"
                                class="w-full h-full object-cover"
                            />

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"
                            ></div>

                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-xs uppercase tracking-widest">
                                    {{ hotel.name }}
                                </p>

                                <h2 class="text-xl font-bold">
                                    {{ room.name }}
                                </h2>

                                <p class="text-sm">
                                    {{ room.type }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">
                                        Check In
                                    </p>

                                    <p class="font-semibold">
                                        {{ formatDate(reservation.check_in) }}
                                    </p>
                                </div>

                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">
                                        Check Out
                                    </p>

                                    <p class="font-semibold">
                                        {{ formatDate(reservation.check_out) }}
                                    </p>
                                </div>

                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">
                                        Lama Menginap
                                    </p>

                                    <p class="font-semibold">
                                        {{ nights }} malam
                                    </p>
                                </div>

                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">Tamu</p>

                                    <p class="font-semibold">
                                        {{ reservation.guests }} Orang
                                    </p>
                                </div>

                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">
                                        Nomor Kamar
                                    </p>

                                    <p class="font-semibold">
                                        {{ roomUnit.room_number }}
                                    </p>
                                </div>

                                <div class="bg-gray-100 rounded p-3">
                                    <p class="text-xs text-gray-500">
                                        Kapasitas
                                    </p>

                                    <p class="font-semibold">
                                        {{ room.capacity }} Orang
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 md:w-72 md:sticky md:top-6">
                    <!-- Price -->
                    <div class="bg-white border rounded-lg">
                        <div class="border-b p-4">
                            <h3 class="font-semibold">Rincian Harga</h3>
                        </div>

                        <div class="p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500"> Harga kamar </span>

                                <span>
                                    {{ formatCurrency(ratePerNight) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Lama menginap
                                </span>

                                <span> {{ nights }} malam </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500"> Total kamar </span>

                                <span>
                                    {{ formatCurrency(ratePerNight * nights) }}
                                </span>
                            </div>

                            <div class="border-t pt-3 flex justify-between">
                                <span class="font-semibold">
                                    Total Pembayaran
                                </span>

                                <span class="text-xl font-bold text-blue-600">
                                    {{ total }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Button -->

                    <button
                        v-if="canPay"
                        @click="handlePay"
                        :disabled="loading"
                        class="w-full py-3.5 rounded-lg text-white font-semibold transition"
                        :style="{
                            background: loading ? '#748ffc' : '#2563eb',
                            opacity: loading ? 0.8 : 1,
                        }"
                    >
                        {{
                            loading
                                ? "Memproses..."
                                : `Bayar Sekarang · ${formatRp(total)}`
                        }}
                    </button>

                    <p class="text-center text-xs text-gray-400">
                        Diproses melalui
                        <span class="text-gray-800 font-medium">
                            Midtrans
                        </span>
                        · SSL 256-bit
                    </p>
                </div>
            </div>
        </main>
    </section>
</template>
