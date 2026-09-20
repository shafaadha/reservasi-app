<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faEnvelope,
    faLocationDot,
    faPhone,
} from "@fortawesome/free-solid-svg-icons";
</script>

<template>
    <footer class="bg-second-color text-gray-300">
        <div
            class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-12"
        >
            <!-- BRAND -->
            <div class="md:col-span-2">
                <h2 class="text-xl font-bold text-white mb-3">
                    Reservation Hotel
                </h2>
                <p class="text-sm leading-relaxed max-w-md">
                    Kami hadir untuk memberikan pengalaman menginap yang nyaman,
                    hangat, dan tak terlupakan bagi setiap tamu yang datang.
                </p>
            </div>

            <!-- CONTACT -->
            <div
                class="md:text-left md:flex md:flex-col md:items-start text-sm"
            >
                <h3 class="text-white font-semibold mb-4">Contact</h3>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <FontAwesomeIcon :icon="faEnvelope" class="w-4" />
                        <span>support@reservasihotel.com</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <FontAwesomeIcon :icon="faLocationDot" class="w-4" />
                        <span>Jakarta, Indonesia</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <FontAwesomeIcon :icon="faPhone" class="w-4" />
                        <span>08910111224</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- COPYRIGHT -->
        <div
            class="border-t border-gray-700 py-4 text-center text-sm text-gray-400"
        >
            © {{ new Date().getFullYear() }} Reservasi Hotel. All rights
            reserved.
        </div>
    </footer>
</template>
