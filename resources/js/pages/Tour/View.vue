<template>
  <Head :title="`${props.legacyItem?.title}`" />

  <div
    class="flex flex-col lg:flex-row gap-8 w-full max-w-6xl mx-auto p-4 lg:p-6 bg-white rounded-lg shadow-lg mt-4 lg:mt-7"
  >
    <!-- Left: Image Container -->
    <div class="flex flex-col items-center lg:items-start">
      <div
        class="w-full max-w-[300px] sm:max-w-[400px] h-[300px] sm:h-[400px] overflow-hidden rounded-xl bg-gray-100 flex items-center justify-center"
      >
        <img
          v-if="props.legacyItem && props.imageUrl"
          :src="props.imageUrl"
          alt="Tour Image"
          class="w-full h-full object-cover"
        />
        <span v-else class="text-gray-400">No Image Available</span>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4">
        <div
          v-for="(image, index) in props.legacyItem.tourSites"
          :key="index"
          class="relative w-24 h-24 sm:w-32 sm:h-32 mb-2 group"
        >
          <img
            :src="image.imageUrl"
            :alt="image.title"
            class="w-full h-full object-cover rounded shadow cursor-pointer"
            @click="openModal(image)"
          />
          <label
            class="absolute bottom-0 left-0 w-full px-2 py-1 bg-gray-700 bg-opacity-50 text-white text-xs sm:text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300"
          >
            {{ image.title }}
          </label>
        </div>
      </div>
    </div>

    <!-- Right: Description and Google Map -->
    <div class="flex-1 flex flex-col gap-6">
      <div>
        <h2
          class="text-xl sm:text-2xl font-semibold mb-2 text-center lg:text-left"
        >
          {{ props.legacyItem?.title || "Tour Title" }}
        </h2>
        <p class="text-gray-700 text-sm sm:text-base text-center lg:text-left">
          {{ props.legacyItem?.description || "No description available." }}
        </p>
      </div>
      <div class="flex-1">
        <h3 class="text-lg font-semibold mb-2">Jeepney Route Information</h3>
        <table class="w-full text-left border-collapse text-sm sm:text-base">
          <thead>
            <tr>
              <th class="border-b-2 border-gray-300 px-2 sm:px-4 py-2">
                Jeepney Code
              </th>
              <th class="border-b-2 border-gray-300 px-2 sm:px-4 py-2">
                Route Description
              </th>
              <th class="border-b-2 border-gray-300 px-2 sm:px-4 py-2">
                Fare (₱)
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(route, index) in props.legacyItem?.vehicle_routes || []"
              :key="index"
            >
              <td class="border-b border-gray-200 px-2 sm:px-4 py-2">
                {{ route.vehicle_code }}
              </td>
              <td class="border-b border-gray-200 px-2 sm:px-4 py-2">
                {{ route.description }}
              </td>
              <td class="border-b border-gray-200 px-2 sm:px-4 py-2">
                {{ route.price }}
              </td>
            </tr>
          </tbody>
        </table>
        <!-- Google Map View Placeholder -->
        <GoogleMap
          api-key="AIzaSyCVi0HNMRa3sByY_4O8cwrwF2D7DdVV2hA"
          mapId="DEMO_MAP_ID"
          style="width: 100%; height: 300px; sm:height: 500px;"
          :center="center"
          :zoom="15"
        >
        </GoogleMap>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
    >
    
      <button
        @click="toggleMusic"
        class="music-btn absolute top-4 left-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        style="z-index:9999;"
      >
        {{ isPlaying ? "🔇 Stop Music" : "🔊 Play Music" }}
      </button>
    

      <!-- Instruction Popup -->
      <div v-if="showInstructions" class="fixed inset-0 flex items-center justify-center z-60 p-4">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-sm w-full text-center">
          <h3 class="text-xl font-bold mb-4 text-gray-800">360° View Instructions</h3>
          <p class="text-gray-600 mb-6 text-lg">
            Drag or tilt your device to see the whole 360 view.
          </p>
          <button
            @click="showInstructions = false"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition"
          >
            Got it!
          </button>
        </div>
      </div>

      <div class="relative bg-white rounded-lg shadow-lg max-w-lg w-full flex flex-col">
        <button
          class="absolute top-2 right-2 text-2xl text-gray-700 hover:text-black z-10"
          @click="closeModal"
        >
          ×
        </button>
        <div id="street-view" class="street-view"></div>
      </div>
   
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted, inject, nextTick } from "vue";
import { GoogleMap, AdvancedMarker } from "vue3-google-map";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const container = ref(null);
const props = defineProps({
  legacyItem: Object,
  imageUrl: String,
  soundUrl: String,
});

const audio = new Audio(props.soundUrl);
audio.volume = 0.25;

// Split the coordinates string into latitude and longitude
let lat = 0;
let lng = 0;

if (props.legacyItem?.coordinates) {
  [lat, lng] = props.legacyItem.coordinates
    .split(",")
    .map((coord) => parseFloat(coord.trim()));
}
// Use the split values to set the center
const center = { lat, lng };

const markerOptions = {
  position: center,
  label: "L",
  title: props.legacyItem.title,
};
const pinOptions = { background: "#FBBC04" };

// Modal state
const isModalOpen = ref(false);
const modalImageUrl = ref("");
const showInstructions = ref(false);

// Open modal and set the image URL
const openModal = (param) => {
  modalImageUrl.value = param.imageUrl;
  isModalOpen.value = true;
  showInstructions.value = true; // Show instructions when modal opens

  nextTick(() => {
    let lat = 0;
    let lng = 0;
    if (param?.coordinates) {
      const [lat, lng] = param.coordinates
        .split(",")
        .map((coord) => parseFloat(coord.trim()));
      const location = { lat, lng }; // Change to your desired location

      const panorama = new google.maps.StreetViewPanorama(
        document.getElementById("street-view"),
        {
          position: location,
          pov: {
            heading: 34,
            pitch: 10,
          },
          zoom: 1,
        }
      );
    }

    //play mp3 audio
    audio.play();
  });
};

// Close modal
const closeModal = () => {
  if (!audio.paused) {
    audio.pause();
    audio.currentTime = 0;
  }
  isModalOpen.value = false;
  showInstructions.value = false; // Also close instructions
  modalImageUrl.value = "";
  // Clear the Street View container
  const streetViewContainer = document.getElementById("street-view");
  if (streetViewContainer) {
    streetViewContainer.innerHTML = "";
  }
};

onMounted(() => {
  const handleKeyDown = (event) => {
    if (event.key === "Escape" || event.key === "Esc") {
      closeModal();
    }
  };

  // Add event listener for keydown
  window.addEventListener("keydown", handleKeyDown);

  // Cleanup event listener when component is unmounted
  onUnmounted(() => {
    window.removeEventListener("keydown", handleKeyDown);
  });
});

const isPlaying = ref(false);

const toggleMusic = () => {
  if (isPlaying.value) {
    audio.pause();
  } else {
    audio.play();
  }
  isPlaying.value = !isPlaying.value;
};
</script>

<style scoped>
.street-view {
  width: 100%;
  height: 500px;
}
button {
  transition: background 0.3s ease;
}
</style>
