<template>
  <section id="slider-section" class="slider-section">
    <h2 class="slider-title">Cebu's Legacy</h2>
    <div class="slider-wrapper">
      <div class="slider">
        <div
          class="slider-track"
          :style="{ transform: `translateX(-${currentIndex * 100 / itemsPerRow}%)` }"
        >
          <div
            class="slider-item"
            v-for="(item, idx) in slides"
            :key="idx"
          >
            <div class="slider-image-wrapper">
              <a @click="openModal(item)" class="slider-link" target="_blank">
                <img :src="item.imageUrl" class="slider-image" />
                <div class="slider-description">{{ item.title }}</div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="arrow-buttons">
        <button class="arrow-btn" @click="prev">&#10094;</button>
        <button class="arrow-btn" @click="next">&#10095;</button>
      </div>
    </div>
  </section>
<div v-if="showModal" class="fixed inset-0 bg-stone-300 opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 min-w-[300px] max-w-[90vw]">
               
            
                <button
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click="closeModal"
                >Close</button>
            </div>
        </div>
 
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
const slides = ref([]);

onMounted(() => {
  axios.get('/api/legacy')
    .then(response => {
      slides.value =response.data;
    })
    .catch(error => {
      console.error('Error fetching Cebu Legacy data:', error)
    })
})

const itemsPerRow = 4

const showModal = ref(false)
const selectedLegacy = ref({})

const maxIndex = Math.max(0, slides.length - itemsPerRow)
const currentIndex = ref(0)

function openModal(item) {
    selectedLegacy.value = item
    showModal.value = true

}

function closeModal() {
    showModal.value = false
    selectedMessage.value = {}
}
function prev() {
  currentIndex.value = currentIndex.value === 0 ? maxIndex : currentIndex.value - 1
}

function next() {
  currentIndex.value = currentIndex.value === maxIndex ? 0 : currentIndex.value + 1
}
</script>

<style scoped>
.slider-track {
  display: flex;
  transition: transform 0.3s ease-in-out;
  width: 100%;
}
.slider-item {
  flex: 0 0 25%;
  box-sizing: border-box;
  padding: 0 0.5rem;
}
@media (max-width: 1024px) {
  .slider-item {
    flex: 0 0 50%;
  }
}
@media (max-width: 600px) {
  .slider-item {
    flex: 0 0 100%;
  }
}
.arrow-buttons {
  position: absolute;
  top: 50%;
  width: 100%;
  display: flex;
  justify-content: space-between;
  transform: translateY(-50%);
}
.arrow-btn {
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 0.5rem;
  font-size: 1.5rem;
  cursor: pointer;
}
.slider-wrapper {
  overflow: hidden;
  position: relative;
}

.modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
       background: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    min-width: 300px;
    max-width: 90vw;
}
</style>