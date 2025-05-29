<template>
    <Head :title="`${props.legacyItem?.title}`" />
    <!-- Back Button above main content -->
  <button
    @click="$inertia.go(-1)"
    class="mb-4 px-5 py-2.5 bg-gray-800 hover:bg-gray-900 rounded-lg text-white font-medium shadow-md transition duration-300 ease-in-out"
>
    ← Back
</button>
    <div class="flex gap-8 w-900 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-7">


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
                <GoogleMap api-key="AIzaSyAb2zmIqQ0nDC9lb-ZhOku_hC-0OsPK8j8" mapId="DEMO_MAP_ID" style="width: 100%; height: 500px"
                    :center="center" :zoom="15">
                    <AdvancedMarker :options="markerOptions" :pin-options="pinOptions" />
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

const center = { lat: props.legacyItem.map_lat, lng: props.legacyItem.map_lng }


const markerOptions = { position: center, label: 'L', title: props.legacyItem.title }
const pinOptions = { background: '#FBBC04' }
</script>

<style scoped>
/* Stack columns on smaller screens */
@media (max-width: 900px) {
  .flex.gap-8 {
    flex-direction: column;
    gap: 1.5rem;
  }
  .w-\[400px\], .h-\[400px\] {
    width: 100% !important;
    height: auto !important;
    min-width: 0;
    min-height: 0;
    max-width: 100vw;
    max-height: 60vw;
  }
}

/* Further adjustments for mobile */
@media (max-width: 600px) {
  .max-w-6xl {
    padding: 0.5rem !important;
  }
  .w-\[400px\], .h-\[400px\] {
    width: 100% !important;
    height: auto !important;
    max-width: 100vw;
    max-height: 40vw;
  }
  #DEMO_MAP_ID,
  .google-map {
    height: 220px !important;
    min-height: 140px;
    width: 100% !important;
  }
  table {
    font-size: 0.95rem;
  }
}

/* Always make the image cover its box */
.w-\[400px\].object-cover, .object-cover {
  object-fit: cover;
}

/* Make table horizontally scrollable on small screens */
@media (max-width: 900px) {
  table {
    display: block;
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
  }
}
</style>