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
              <a :href="item.link" class="slider-link" target="_blank">
                <img :src="item.img" class="slider-image" />
                <div class="slider-description">{{ item.desc }}</div>
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
import { ref } from 'vue'

const itemsPerRow = 4

const slides = [
  {
    img: '/img/image1.jpg',
    desc: "Magellan’s Cross",
    link: 'about.html',
  },
  {
    img: '/img/image2.jpg',
    desc: 'Basilica del Santo Niño',
    link: 'https://example.com/page2',
  },
  {
    img: '/img/image3.jpg',
    desc: 'Fort San Pedro',
    link: 'https://example.com/page3',
  },
  {
    img: '/img/image4.jpg',
    desc: 'Temple of Leah',
    link: 'https://example.com/page4',
  },
  {
    img: '/img/image3.jpg',
    desc: 'Fort San Pedro',
    link: 'https://example.com/page3',
  },
  {
    img: '/img/image4.jpg',
    desc: 'Temple of Leah',
    link: 'https://example.com/page4',
  },
  // Add more items if needed
]

const maxIndex = Math.max(0, slides.length - itemsPerRow)
const currentIndex = ref(0)

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
</style>