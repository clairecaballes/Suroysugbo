<template>
   <Head :title="`${props.legacyItem?.title}`" />
<div class="flex gap-8 w-900 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-7">
    <!-- add Back button -->
  
    <!-- Left: Image Container -->
    <div class="w-[400px] h-[400px] overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
        <img
            v-if="props.legacyItem && props.imageUrl"
            :src="props.imageUrl"
            alt="Tour Image"
            class="w-[400px] h-[400px]  object-cover"
        />
        <span v-else class="text-gray-400">No Image Available</span>
    </div>

    <!-- Right: Description and Google Map -->
    <div class="flex-1 flex flex-col gap-6">
        <div>
            <h2 class="text-2xl font-semibold mb-2">{{ props.legacyItem?.title || 'Tour Title' }}</h2>
            <p class="text-gray-700">{{ props.legacyItem?.description || 'No description available.' }}</p>
        </div>
        <div class="flex-1">
            <h3>Jeepney Route Information</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b-2 border-gray-300 px-4 py-2">Jeepney Code</th>
                        <th class="border-b-2 border-gray-300 px-4 py-2">Route Description</th>
                        <th class="border-b-2 border-gray-300 px-4 py-2">Fare (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(route, index) in props.legacyItem?.vehicle_routes || []" :key="index">
                        <td class="border-b border-gray-200 px-4 py-2">{{ route.vehicle_code }}</td>
                        <td class="border-b border-gray-200 px-4 py-2">{{ route.description }}</td>
                        <td class="border-b border-gray-200 px-4 py-2">{{ route.price }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- Google Map View Placeholder -->
            <iframe
                v-if="props.legacyItem"
                src="https://www.google.com/maps/place/Cebu+City,+6000+Cebu/@10.3787539,123.763893,12z/data=!3m1!4b1!4m6!3m5!1s0x33a999258dcd2dfd:0x4c34030cdbd33507!8m2!3d10.3156992!4d123.8854366!16zL20vMDFwX2x5?entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D"
                class="w-full h-[250px] rounded-lg border-0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
            <div v-else class="w-full h-[250px] flex items-center justify-center bg-gray-200 rounded-lg text-gray-400">
                No Map Available
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { ref, onMounted, inject } from 'vue'
import {Head} from '@inertiajs/vue3'

const props = defineProps({
  legacyItem: Object,
  imageUrl: String,
})

</script>