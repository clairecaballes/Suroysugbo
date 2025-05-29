<template>
  <PageNav/>
  <PageHeader/>
  <CebuLegacy />
  <Map />
  <About/>
  <minigame/>
  <Contact />
  <UserReview />
  <PageFooter/>

 <div
      v-if="isModalOpen"
      class="fixed inset-0 flex items-center justify-center modal-overlay"
      @click.self="closeModal"
    >
      <div
        :class="{ 'open': isModalOpen }"
        class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col lg:flex-row relative modal-content"
      >
        <button
          @click="closeModal"
          class="absolute top-4 right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <div class="lg:w-1/2 p-6 flex flex-col">
          <div class="mb-6">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300 rounded-md p-2 transition duration-200 ease-in-out">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              <span class="font-medium text-lg">Back</span>
            </button>
          </div>

          <div class="relative rounded-lg overflow-hidden flex-grow shadow-lg">
            <img src="image_410a1a.jpg" alt="Interior of a room with large windows and furniture" class="w-full h-full object-cover">
            <img src="https://placehold.co/600x400/E0E0E0/333333?text=Image+Unavailable" alt="Placeholder" class="w-full h-full object-cover hidden" onerror="this.style.display='block'; this.previousElementSibling.style.display='none';">

            <div class="absolute bottom-4 left-4 bg-white bg-opacity-80 text-gray-800 text-sm font-semibold py-1.5 px-4 rounded-full shadow-md">
              cebu
            </div>
          </div>
        </div>

        <div class="lg:w-1/2 p-6 flex flex-col justify-between">
          <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-4">Picture's Name</h1>
            <p class="text-gray-600 leading-relaxed text-base sm:text-lg mb-6">
              This is the detailed description for Image 1. This is the detailed description for Image 1. Context
              or anything relevant to the image. Enjoy exploring it virtually. It is the detailed description for Image 1.
              You can explain content of this here, here, is the detailed description for Image 1. This is the
              detailed description for Image 1. This is a detailed description for Image here, I can explain content
              of this here, here. This is detailed description for Image 1. You can explain content of the image.
            </p>
          </div>

          <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mt-6">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-200 ease-in-out
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75
                           flex-grow sm:flex-grow-0 text-lg">
              View Location's Info
            </button>
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md transition duration-200 ease-in-out
                           focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-75
                           flex-grow sm:flex-grow-0 text-lg">
              Fun Facts
            </button>
          </div>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref, provide } from 'vue'
import PageNav from './components/Nav.vue'
import PageHeader from './components/Header.vue'
import CebuLegacy from './components/CebuLegacy.vue'
import Contact from './components/Contact.vue'
import PageFooter from './components/Footer.vue'
import Faq from './components/Faq.vue'
import UserReview from './components/UserReview.vue'

import {  onMounted, onUnmounted } from 'vue';
import About from './components/About.vue'
import Minigame from './components/minigame.vue'
import Map from './components/Map.vue'

// Reactive state for modal visibility
const isModalOpen = ref(false);

// Function to open the modal
const openModal = () => {
  isModalOpen.value = true;
};

// Function to close the modal
const closeModal = () => {
  isModalOpen.value = false;
};

// Handle Escape key to close modal
const handleKeydown = (event) => {
  if (event.key === 'Escape' && isModalOpen.value) {
    closeModal();
  }
};

// Add and remove event listener for keydown on mount/unmount
onMounted(() => {
  document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown);
});

provide('openModal', openModal)


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