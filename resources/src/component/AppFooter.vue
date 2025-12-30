<template>
    <footer class="bg-cyan-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- BRAND -->
            <div>
                <h2 class="text-xl font-bold text-white mb-3">
                    Reservation Hotel
                </h2>
                <p class="text-sm leading-relaxed max-w-md">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae pariatur accusamus quas expedita?
                    Beatae veritatis autem eligendi repudiandae sint ex perferendis consequatur, sunt illo obcaecati
                    natus? Repudiandae odit nulla in?
                </p>
            </div>

            <!-- CONTACT -->
            <div class="md:text-right">
                <h3 class="text-white font-semibold mb-3">
                    Contact
                </h3>
                <ul class="space-y-2 text-sm">
                    <li>📍 Jakarta, Indonesia</li>
                    <li>📞 0812-3456-7890</li>
                    <li>✉️ support@reservasihotel.com</li>
                </ul>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="border-t border-gray-700 py-4 text-center text-sm text-gray-400">
            © {{ new Date().getFullYear() }} Reservasi Hotel. All rights reserved.
        </div>
    </footer>
</template>
