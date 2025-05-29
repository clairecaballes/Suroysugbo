<template>
    <Head :title="`${props.legacyItem?.title}`" />
    <div class="flex flex-col gap-4 max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-7">
        <!-- Back Button -->
        <button
            @click="$inertia.visit('/tour')"
            class="self-start mb-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-semibold"
        >
            ← Back
        </button>


        <div class="flex gap-8">
            <!-- Left: Image Container -->
            <div class="w-[400px] h-[400px] overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
                <img v-if="props.legacyItem && props.imageUrl" :src="props.imageUrl" alt="Tour Image"
                    class="w-[400px] h-[400px]  object-cover" />
                <span v-else class="text-gray-400">No Image Available</span>
            </div>


            <!-- Right: Description and Map -->
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
                    <!-- Leaflet Map -->
                    <div id="DEMO_MAP_ID" style="width: 100%; height: 500px"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
    legacyItem: Object,
    imageUrl: String,
})

onMounted(() => {
    if (!props.legacyItem?.map_lat || !props.legacyItem?.map_lng) return;

    const map = L.map('DEMO_MAP_ID').setView([props.legacyItem.map_lat, props.legacyItem.map_lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    L.marker([props.legacyItem.map_lat, props.legacyItem.map_lng])
      .addTo(map)
      .bindPopup(`<b>${props.legacyItem.title}</b>`);
});
</script>
<style scoped>
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
  #DEMO_MAP_ID {
    height: 250px !important;
    min-height: 180px;
  }
  table {
    font-size: 0.95rem;
  }
}
</style>
