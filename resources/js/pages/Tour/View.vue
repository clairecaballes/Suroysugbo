<template>
<div class="flex gap-8">
    <!-- Left: Image Container -->
    <div class="w-[400px] h-[400px] overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center">
        <img
            v-if="props.legacyItem && props.imageUrl"
            :src="props.imageUrl"
            alt="Tour Image"
            class="max-w-full max-h-full object-cover"
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

const props = defineProps({
  legacyItem: Object,
  imageUrl: String,
})

</script>