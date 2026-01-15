<script setup>
import { Award, MapPin, Users, Star } from 'lucide-vue-next'

const features = [
    {
        icon: Award,
        title: '5-Star Service',
        description: 'Award-winning hospitality that exceeds expectations'
    },
    {
        icon: MapPin,
        title: 'Prime Location',
        description: 'Located in the heart of downtown with easy access to attractions'
    },
    {
        icon: Users,
        title: 'Expert Staff',
        description: 'Dedicated team committed to making your stay memorable'
    },
    {
        icon: Star,
        title: 'Premium Amenities',
        description: 'World-class facilities including spa, pool, and fine dining'
    }
]
</script>

<template>
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="text-center mb-16">
            <h2 class="text-blue-600 mb-4 font-medium">About Us</h2>
            <p className="text-gray-600 max-w-3xl mx-auto">
                Grand Haven Hotel has been a beacon of luxury and hospitality for over 50 years.
                We pride ourselves on delivering exceptional experiences that combine timeless elegance
                with modern comfort. Our commitment to excellence has made us a preferred destination
                for travelers seeking the finest in accommodation and service.
            </p>
        </div>

        <!-- Hero -->
        <div class="relative bg-gradient-to-r from-amber-50 via-white to-sky-50 rounded-2xl overflow-hidden shadow-lg">

        </div>

        <!-- Features -->
        <div class="mt-16">
            <h2 class="text-center text-2xl font-bold mb-6">Why you choose us?</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="(feature, index) in features" :key="index"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <component :is="feature.icon" class="text-blue-600" />
                    </div>
                    <h3 class="mb-2 font-semibold">{{ feature.title }}</h3>
                    <p class="text-gray-600">{{ feature.description }}</p>
                </div>
            </div>
        </div>

    </div>

</template>

<style scoped></style>

<!-- <template>
    <div class="bg-gray-400 h-max rounded-lg shadow-lg mt-6 mx-4 ">
        <div class="grid grid-rows-2 gap-2 p-4">
            <div class="text-center mb-16">
                <h2 class="text-cyan-600 font-bold mb-4">About Us</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Hotel has been a beacon of luxury and hospitality for over 50
                    years. We pride
                    ourselves on delivering
                    exceptional experiences that combine timeless elegance with modern comfort. Our commitment to
                    excellence has made us a preferred destination for travelers seeking the finest in accommodation and
                    service.</p>
            </div>
            <div>
                <div key="">

                </div>
            </div>

        </div>
    </div>
</template> -->
