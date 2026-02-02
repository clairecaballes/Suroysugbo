<template>
   <button 
    v-if="isIframeOpen"
      @click="closeModal"
      class="back-button"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      <span>Back</span>
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
/* Back button with modern glassmorphism and gradient theme */
.back-button {
  position: fixed;
  top: 1.5rem;
  left: 1.5rem;
  z-index: 50;
  
  /* Modern glassmorphism effect */
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  
  /* Gradient accent border */
  border: 1.5px solid;
  border-image: linear-gradient(135deg, #3b82f6, #1e3a8a) 1;
  
  /* Padding and sizing */
  padding: 0.65rem 1.25rem;
  border-radius: 0.75rem;
  
  /* Typography */
  color: #1e3a8a;
  font-weight: 600;
  font-size: 0.95rem;
  
  /* Layout */
  display: flex;
  align-items: center;
  gap: 0.5rem;
  
  /* Transitions */
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  
  /* Shadow */
  box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
  
  /* Cursor */
  cursor: pointer;
  font-family: inherit;
  border-collapse: collapse;
}

.back-button:hover {
  /* Gradient background on hover */
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 58, 138, 0.1));
  backdrop-filter: blur(12px);
  
  /* Enhanced shadow */
  box-shadow: 0 15px 40px rgba(30, 58, 138, 0.25);
  
  /* Subtle scale */
  transform: translateY(-2px);
}

.back-button:active {
  transform: translateY(0);
  box-shadow: 0 8px 20px rgba(30, 58, 138, 0.15);
}

.back-button svg {
  stroke-width: 2.5;
  flex-shrink: 0;
}

/* Scoped styles for the modal overlay and content */
.modal-overlay {
  background-color: rgba(255, 255, 255, 0.93); /* Dark semi-transparent background */
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
