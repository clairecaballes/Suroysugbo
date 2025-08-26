<template>
  <section id="slider-section" class="slider-section">
    <div class="section-header">
      <h2 class="slider-title">Cebu's Legacy</h2>
      <div class="title-underline"></div>
    </div>
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
              <a :href="`/cebu-legacy/view/${item.id}`"  class="slider-link" target="_blank">
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

 
</template>

<script setup>
import { ref, onMounted, inject, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
const slides = ref([]);

const openModal = inject('openModal')

onMounted(() => {
  axios.get('/api/legacy')
    .then(response => {
      slides.value =response.data;
    })
    .catch(error => {
      console.error('Error fetching Cebu Legacy data:', error)
    })
})

const itemsPerRow = 3 // Fixed to show 3 items

// Update maxIndex calculation for 3 items
const maxIndex = computed(() => Math.max(0, slides.value.length - itemsPerRow))
const currentIndex = ref(0)


function prev() {
  currentIndex.value = currentIndex.value === 0 ? maxIndex.value : currentIndex.value - 1
}

function next() {
  currentIndex.value = currentIndex.value === maxIndex.value ? 0 : currentIndex.value + 1
}
</script>

<style scoped>
.slider-section {
  padding: 4rem 2rem;
  background: linear-gradient(180deg, #1a365d 0%, #f5f6f8 100%);
  position: relative;
  overflow: hidden;
}

.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.slider-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 1rem;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.title-underline {
  width: 80px;
  height: 4px;
  background: linear-gradient(to right, #3b82f6, #60a5fa);
  margin: 0 auto;
  border-radius: 2px;
}

.slider-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(8px);
}

.slider-track {
  display: flex;
  transition: transform 0.5s ease-in-out;
  width: 100%;
  padding: 2rem 0;
}
.slider-item {
  flex: 0 0 33.333%; /* Show exactly 3 items */
  padding: 0 1rem;
  transition: all 0.3s ease;
}

/* Middle item elevation */
.slider-item:nth-child(3n-1) .slider-image-wrapper {
  transform: translateY(-20px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
}

.slider-item:nth-child(3n-1):hover .slider-image-wrapper {
  transform: translateY(-30px);
}

/* Adjust mobile breakpoints for 3 items */
@media (max-width: 1024px) {
  .slider-item {
    flex: 0 0 33.333%;
  }
  
  .slider-item:nth-child(3n-1) .slider-image-wrapper {
    transform: translateY(-15px);
  }
}

@media (max-width: 768px) {
  .slider-item {
    flex: 0 0 100%;
  }
  
  .slider-item:nth-child(3n-1) .slider-image-wrapper {
    transform: translateY(0);
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
  background: rgba(59, 130, 246, 0.8);
  color: white;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}
.arrow-btn:hover {
  background: #2563eb;
  transform: scale(1.1);
  border-color: rgba(255, 255, 255, 0.2);
}
.slider-image-wrapper {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}
.slider-image-wrapper:hover {
  transform: translateY(-10px);
}
.slider-image {
  width: 100%;
  height: 300px;
  object-fit: cover;
  transition: transform 0.3s ease;
}
.slider-description {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1rem;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
  color: white;
  font-weight: 500;
  transform: translateY(100%);
  transition: transform 0.3s ease;
}
.slider-image-wrapper:hover .slider-description {
  transform: translateY(0);
}
@media (max-width: 1024px) {
  .slider-section {
    padding: 3rem 1rem;
  }

  .slider-title {
    font-size: 2rem;
  }

  .slider-image {
    height: 250px;
  }
}

@media (max-width: 768px) {
  .slider-wrapper {
    padding: 1rem;
  }

  .arrow-btn {
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
  }
}

@media (max-width: 480px) {
  .slider-section {
    padding: 2rem 0.5rem;
  }

  .slider-title {
    font-size: 1.75rem;
  }

  .slider-image {
    height: 200px;
  }

  .slider-description {
    font-size: 0.9rem;
    padding: 0.75rem;
  }
}
</style>