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
            href="#map-section"
            :class="{ active: activeSection === 'map' }"
            @click="setActive('map')"
          >Mini Map</a>
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
  'map-section', //map leaflet
  'about-container',           // About (not used in nav, but included for completeness)
  'minigame-container', // Fun Facts
  'compact-contact',   // Contact
 
]
const sectionNames = [
  'home',
  'gallery',
  'map', //map leaflet
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
        activeSection.value = sectionNames[i]
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
/* Mobile & tablet */
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
    border-radius: 4px;
    transition: all 0.3s ease-in-out; /* smooth open/close */
  }

  .nav_menu.active {
    display: flex;
  }

  #open-menu-btn,
  #close-menu-btn {
    display: inline-block;
    position: absolute;
    top: 15px;
    right: 20px;
    background: none;
    border: none;
    font-size: 2rem;
    color: #fff;
    cursor: pointer;
    z-index: 200;
  }

  /* Adjust nav links inside menu */
  .nav_menu a {
    color: #fff;
    text-decoration: none;
    padding: 0.5em 0;
    display: block;
  }

  .nav_menu a:hover {
    text-decoration: underline;
  }
}

/* Desktop */
@media (min-width: 769px) {
  .nav_menu {
    display: flex; /* show nav normally */
    flex-direction: row;
    position: static;
    background: none;
    width: auto;
    padding: 0;
  }

  /* Keep multi-word nav labels on a single line */
  .nav_menu a {
    white-space: nowrap;
  }

  #open-menu-btn,
  #close-menu-btn {
    display: none; /* hide buttons */
  }
}
/* Medium screens: slightly reduce spacing so labels fit on one line */
@media (min-width: 640px) and (max-width: 900px) {
  .nav_menu {
    gap: 0.6em;
  }

  .nav_menu a {
    font-size: 0.95rem;
    padding: 0.25em 0.4em;
  }
}
/* Default (desktop/tablet) */
.map-funfacts-container {
  display: flex;
  gap: 1.5rem;
  align-items: flex-start;
}

.mini-map,
.fun-facts {
  flex: 1;
}

/* Small screen (stacked) */
@media (max-width: 768px) {
  .map-funfacts-container {
    flex-direction: column;
    gap: 1rem; /* space between stacked items */
  }

  .mini-map,
  .fun-facts {
    width: 100%;
  }
}

</style>