<template>


    <Head :title="`${props.legacyItem?.title}`" />
    <div class="flex gap-8 w-900 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-7">
        <!-- add Back button -->


        <!-- Left: Image Container -->
        <div class="w-[400px] h-[400px] overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
            <img v-if="props.legacyItem && props.imageUrl" :src="props.imageUrl" alt="Tour Image"
                class="w-[400px] h-[400px]  object-cover" />
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
                <GoogleMap api-key="AIzaSyCVi0HNMRa3sByY_4O8cwrwF2D7DdVV2hA" mapId="DEMO_MAP_ID" style="width: 100%; height: 500px"
                    :center="center" :zoom="15">
                  
                    <!-- <AdvancedMarker :options="markerOptions">
                        <div style="background: white; color: black; padding: 5px; border-radius: 5px">
                            Custom Content
                        </div>
                    </AdvancedMarker> -->
                </GoogleMap>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, inject } from 'vue'
import { GoogleMap, AdvancedMarker } from 'vue3-google-map'




import { Head } from '@inertiajs/vue3'


const props = defineProps({
    legacyItem: Object,
    imageUrl: String,
})



// Split the coordinates string into latitude and longitude
const [lat, lng] = props.legacyItem.coordinates.split(',').map(coord => parseFloat(coord.trim()));

// Use the split values to set the center
const center = { lat, lng };

const markerOptions = { position: center, label: 'L', title: props.legacyItem.title }
const pinOptions = { background: '#FBBC04' }
</script>
