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
          :style="{ transform: `translateX(-${currentIndex * (100 / itemsPerRow)}%)` }"
        >
          <div
            class="slider-item"
            v-for="(item, idx) in slides"
            :key="idx"
          >
            <div class="slider-image-wrapper">
              <div class="slider-link" @click="handleItemClick(item)" style="cursor: pointer;">
                <img :src="item.imageUrl" class="slider-image" />
                <div class="slider-description">{{ item.title }}</div>
              </div>
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
import { ref, onMounted, onUnmounted, inject, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
const slides = ref([]);

const openIframe = inject('openIframe')

const handleItemClick = async (item) => {
  openIframe(item.id);
}

// Reactive items per row based on screen size
const itemsPerRow = ref(3)

// Function to update items per row based on screen size
const updateItemsPerRow = () => {
  const oldItemsPerRow = itemsPerRow.value;
  
  if (window.innerWidth <= 768) {
    itemsPerRow.value = 1; // Mobile: 1 item
  } else if (window.innerWidth <= 1024) {
    itemsPerRow.value = 4; // Tablet: 4 items  
  } else {
    itemsPerRow.value = 3; // Desktop: 3 items
  }
  
  // Reset current index if it becomes invalid due to screen size change
  if (oldItemsPerRow !== itemsPerRow.value) {
    const newMaxIndex = Math.max(0, slides.value.length - itemsPerRow.value);
    if (currentIndex.value > newMaxIndex) {
      currentIndex.value = 0;
    }
  }
  
  console.log('Updated itemsPerRow to:', itemsPerRow.value, 'for screen width:', window.innerWidth);
}

onMounted(() => {
  axios.get('/api/legacy')
    .then(response => {
      slides.value = response.data;
      console.log('Loaded legacy items:', response.data.length);
    })
    .catch(error => {
      console.error('Error fetching Cebu Legacy data:', error)
    })
  
  // Set initial items per row
  updateItemsPerRow();
  
  // Listen for window resize
  window.addEventListener('resize', updateItemsPerRow);
})

// Calculate max index for navigation
const maxIndex = computed(() => {
  const max = Math.max(0, slides.value.length - itemsPerRow.value);
  console.log('Max index:', max, 'Total items:', slides.value.length, 'Items per row:', itemsPerRow.value);
  return max;
})
const currentIndex = ref(0)

// Cleanup event listener
onUnmounted(() => {
  window.removeEventListener('resize', updateItemsPerRow);
})

function prev() {
  console.log('Prev clicked, current:', currentIndex.value, 'max:', maxIndex.value);
  if (currentIndex.value === 0) {
    currentIndex.value = maxIndex.value;
  } else {
    currentIndex.value = Math.max(0, currentIndex.value - 1);
  }
  console.log('New index:', currentIndex.value);
}

function next() {
  console.log('Next clicked, current:', currentIndex.value, 'max:', maxIndex.value);
  if (currentIndex.value >= maxIndex.value) {
    currentIndex.value = 0;
  } else {
    currentIndex.value = Math.min(maxIndex.value, currentIndex.value + 1);
  }
  console.log('New index:', currentIndex.value);
}
</script>

<style scoped>
.slider-section {
  padding: 4rem 2rem;
  background: linear-gradient(180deg, #f8fafc 0%, #f5f6f8 100%);
  position: relative;
  overflow: visible;

}
.slider {
  overflow: hidden;
  width: 100%;
}


.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.slider-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #0077ffff;
  margin-bottom: 1rem;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.title-underline {
  width: 80px;
  height: 4px;
  background: linear-gradient(to right, #74a8fcff, #60a5fa);
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
  width: max-content; /* ensure track can scroll fully */
}

.slider-item {
  flex: 0 0 calc((100% / 3) - 2rem); /* 3 images per row, subtract margin */
  margin-right: 2rem;
}

.slider-item:last-child {
  margin-right: 0;
}


.slider-item:nth-child(3n-1):hover .slider-image-wrapper {
  transform: translateY(-30px);
}

/* Adjust mobile breakpoints for 3 items */
@media (max-width: 1024px) {
  .slider-item {
    flex: 0 0 25%;
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
.slider-link {
  display: block;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
}
.slider-link:hover .slider-image {
  transform: scale(1.05);
}
.slider-link::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(59, 130, 246, 0.1);
  opacity: 0;
  transition: opacity 0.3s ease;
}
.slider-link:hover::after {
  opacity: 1;
}
.slider-image {
  width: 100%;
  aspect-ratio: 1 / 1; /* always square */
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
  .slider-image {
    aspect-ratio: 4 / 3;
  
  }
   .slider-link:hover .slider-image {
    transform: none;
  }
  .slider-item {
    flex: 0 0 100%;
    margin-right: 0;
  }
  .slider-track {
    width: 100%; /* ensure full width */
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