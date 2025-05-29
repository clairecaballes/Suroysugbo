<template>
  <nav>
     <div class="container nav_container">
    <button id="open-menu-btn" @click="menuOpen = true" v-if="!menuOpen">
  <i class="uil uil-bars"></i>
</button>
<button id="close-menu-btn" @click="menuOpen = false" v-if="menuOpen">
  <i class="uil uil-multiply"></i>
</button>
    <a href="/">
      <h4>SuroySugbo</h4>
    </a>
    <ul class="nav_menu" :class="{ active: menuOpen }">
        <li>
          <a
            href="#index.html"
            :class="{ active: activeSection === 'home' }"
            @click="setActive('home')"
          >Home</a>
        </li>
        <li>
          <a
            href="#slider-section"
            :class="{ active: activeSection === 'gallery' }"
            @click="setActive('gallery')"
          >Gallery</a>
        </li>
        <li>
          <a
            href="#about-container"
            :class="{ active: activeSection === 'about' }"
            @click="setActive('about')"
          >About</a>
        </li>
        <li>
          <a
            href="#minigame-container"
            :class="{ active: activeSection === 'minigame' }"
            @click="setActive('minigame')"
            >Fun Facts</a>
        </li>
        <li>
          <a
            href="#compact-contact"
            :class="{ active: activeSection === 'contact' }"
            @click="setActive('contact')"
          >Contact</a>
        </li>
    
      </ul>
    
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
const activeSection = ref('home')
const menuOpen = ref(false)

function setActive(section) {
  activeSection.value = section
  menuOpen.value = false
}

// Section IDs in the same order as your nav
const sectionIds = [
  'index.html',        // Home
  'slider-section',    // Gallery
  'about-container',           // About (not used in nav, but included for completeness)
  'minigame-container', // Fun Facts
  'compact-contact',   // Contact
 
]
const sectionNames = [
  'home',
  'gallery',
  'about',
  'minigame',
  'contact'
]
function onScroll() {
  let found = false
  for (let i = 0; i < sectionIds.length; i++) {
    const el = document.getElementById(sectionIds[i])
    if (el) {
      const rect = el.getBoundingClientRect()
      if (rect.top <= 80 && rect.bottom > 80) { // 80px offset for navbar height
        activeSection.value = ['home', 'gallery', 'about', 'minigame', 'contact'][i]
        found = true
        break
      }
    }
  }
  if (!found) {
    activeSection.value = 'home'
  }
}

onMounted(() => {
  window.addEventListener('scroll', onScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', onScroll)
})
</script>

<style scoped>
.nav_menu a.active {
  color: #fff;
  border-bottom: 2px solid #fff;
  background: transparent;
  border-radius: 0;
  padding-bottom: 0.25em;
  transition: border-bottom 0.2s, color 0.2s;
}
.nav_menu {
  display: flex;
  gap: 1em;
}
#open-menu-btn, #close-menu-btn {
  display: none;
}
@media (max-width: 768px) {
  .nav_menu {
    display: none;
    flex-direction: column;
    background: #0a3a6e;
    position: absolute;
    top: 60px;
    right: 0;
    width: 200px;
    z-index: 100;
    padding: 1em;
  }
  .nav_menu.active {
    display: flex;
  }
  #open-menu-btn, #close-menu-btn {
    display: inline-block;
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    font-size: 2rem;
    color: #fff;
    cursor: pointer;
    z-index: 200;
  }
}
@media (min-width: 769px) {
  #open-menu-btn, #close-menu-btn {
    display: none;
  }
}
</style>