<template>
   <button 
    v-if="isIframeOpen"
      @click="closeModal"
      class="fixed top-4 left-4 z-50 bg-white hover:bg-gray-100 text-gray-800 px-4 py-2 rounded-lg shadow-lg transition-colors flex items-center gap-2 border border-gray-300"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      Back
    </button>
  <div v-if="isIframeOpen">
    <!-- Back button -->
   
    
    <iframe
      :src="`/cebu-legacy/view/${viewid}`"
      style="width: 100%; height: 100vh; border: none"
    ></iframe>
  </div>
  <div v-if="!isIframeOpen">
    <PageNav />
    <PageHeader />
    <CebuLegacy />
    <Map />
    <About />
    <minigame />
    <Contact />
    <UserReview />
    <PageFooter />
  </div>
</template>

<script setup>
import { ref, provide, onMounted, onUnmounted, h } from "vue";
import PageNav from "./components/Nav.vue";
import PageHeader from "./components/Header.vue";
import CebuLegacy from "./components/CebuLegacy.vue";
import Contact from "./components/Contact.vue";
import PageFooter from "./components/Footer.vue";
import Faq from "./components/Faq.vue";
import UserReview from "./components/UserReview.vue";
import About from "./components/About.vue";
import Minigame from "./components/minigame.vue";
import Map from "./components/Map.vue";

// Reactive state for modal visibility and data
const isIframeOpen = ref(false);
const viewid = ref(null);
const modalData = ref(null);

// Function to open the modal
const openIframe = (id) => {
  isIframeOpen.value = true;
  viewid.value = id;
};

// Function to close the modal
const closeModal = () => {
  isIframeOpen.value = false;
  viewid.value = null;
  // Refresh the page
  window.location.reload();
};


// Handle Escape key to close modal
const handleKeydown = (event) => {
  if (event.key === "Escape" && isIframeOpen.value) {
    closeModal();
  }
};

// Add and remove event listener for keydown on mount/unmount
onMounted(() => {
  document.addEventListener("keydown", handleKeydown);
});

onUnmounted(() => {
  document.removeEventListener("keydown", handleKeydown);
});

provide("openIframe", openIframe);
</script>

<style scoped>
/* Scoped styles for the modal overlay and content */
.modal-overlay {
  background-color: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
  backdrop-filter: blur(5px); /* Optional: blur effect for the background */
  z-index: 999; /* Ensure it's on top */
}
.modal-content {
  z-index: 1000; /* Ensure content is above overlay */
  transform: scale(0.95); /* Slightly scale down when hidden */
  opacity: 0; /* Hidden by default */
  transition: all 0.3s ease-out; /* Smooth transition for appearance */
}
.modal-content.open {
  transform: scale(1); /* Full size when open */
  opacity: 1; /* Fully visible when open */
}
</style>
