<template>
  <section id="map-section" class="map-layout">
    <div class="map-container">
      <!-- Search Bar -->
      <div class="flex justify-center w-full p-3 search-wrapper">
        <div class="search-container">
          <div class="relative flex items-center justify-center w-full">
            <input 
              v-model="searchQuery" 
              placeholder="🔍 Discover Places in Cebu"
              class="search-input w-full pl-4 pr-24 py-3 text-center"
              :style="{ textIndent: searchQuery ? '0' : '60px' }"
            >
            <button 
              @click="searchPlace"
              class="search-button absolute right-3"
            >
              <span>Explore</span>
            </button>
          </div>
        </div>
      </div>
      <!-- Map -->
      <div id="map" style="height: 500px; width: 100%; margin-top: 10px;"></div>
    </div>

    <!-- Legend moved outside -->
    <div class="map-legend">
      <div class="legend-header">
        <span class="legend-title">📍 Places to Visit</span>
      </div>
      <div class="legend-items">
        <div class="legend-item">
          <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Restaurant" />
          <span>Restaurant</span>
        </div>
        <div class="legend-item">
          <img src="https://cdn-icons-png.flaticon.com/512/1046/1046790.png" alt="Cafe" />
          <span>Cafe</span>
        </div>
        <div class="legend-item">
          <img src="https://cdn-icons-png.flaticon.com/512/1046/1046786.png" alt="Fast Food" />
          <span>Fast Food</span>
        </div>
        <div class="legend-item">
          <img src="https://cdn-icons-png.flaticon.com/512/1046/1046787.png" alt="Mall" />
          <span>Mall</span>
        </div>
        <div class="legend-item">
          <img src="https://cdn-icons-png.flaticon.com/512/1046/1046785.png" alt="Search Location" />
          <span>Your Search</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.markercluster";

export default {
  name: "Map",
  data() {
    return {
      searchQuery: "",
      map: null,
      markers: [],
      markerCluster: null,
      selectedCategories: ["restaurant", "cafe", "fast_food", "mall"],
      searchCenterMarker: null,
    };
  },
  mounted() {
    this.map = L.map("map").setView([10.2923, 123.9024], 17);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors",
    }).addTo(this.map);

    this.markerCluster = L.markerClusterGroup();
    this.map.addLayer(this.markerCluster);
  },
  methods: {
    async searchPlace() {
      if (!this.searchQuery) return;
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}`;
      const response = await fetch(url);
      const data = await response.json();

      if (data.length === 0) {
        alert("Place not found.");
        return;
      }

      const lat = parseFloat(data[0].lat);
      const lon = parseFloat(data[0].lon);
      this.map.setView([lat, lon], 15);

      if (this.searchCenterMarker) {
        this.map.removeLayer(this.searchCenterMarker);
      }

      this.searchCenterMarker = L.marker([lat, lon], {
        icon: L.icon({
          iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046785.png",
          iconSize: [60, 60]
        })
      })
      .addTo(this.map)
     .bindPopup(`
  <div class="popup-content">
    <h3 style='color: #007bff; margin: 2px 0;'>${this.searchQuery}</h3>
    <p style='font-size: 12px; margin: 0;'>Coordinates: ${lat}, ${lon}</p>
  </div>
`).openPopup();

      this.fetchNearbyPlaces(lat, lon);
    },

    async fetchNearbyPlaces(lat, lon) {
      let filters = "";
      const radiusLimit = 1000; // Fixed 1km radius for all categories

      for (const category of this.selectedCategories) {
        filters += `node(around:${radiusLimit},${lat},${lon})[amenity=${category}];\n`;
      }

      if (!filters) {
        alert("Please select at least one category.");
        return;
      }

      const query = `[out:json];(${filters});out;`;
      const url = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(query)}`;
      const response = await fetch(url);
      const data = await response.json();

      this.markerCluster.clearLayers();
      this.markers = [];

      const icons = {
        restaurant: L.icon({ iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046784.png", iconSize: [50, 50] }),
        cafe: L.icon({ iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046790.png", iconSize: [50, 50] }),
        fast_food: L.icon({ iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046786.png", iconSize: [50, 50] }),
        mall: L.icon({ iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046787.png", iconSize: [50, 50] }),
      };

      data.elements.forEach(el => {
        if (el.lat && el.lon) {
          const name = el.tags.name || "Unnamed Place";
          const type = el.tags.amenity || el.tags.shop;
          const marker = L.marker([el.lat, el.lon], { icon: icons[type] || icons.restaurant })
            .bindPopup(`
              <div style='text-align: center; padding: 2px; font-size: 12px;'>
                <h3 style='color: #007bff;'>${name}</h3>
                <p><strong>Type:</strong> ${type}</p>
              </div>
            `);

          this.markers.push(marker);
          this.markerCluster.addLayer(marker);
        }
      });

      this.map.addLayer(this.markerCluster);
    }
  }
};
</script>

<style scoped>
.popup-content {
  padding: 2px;
  font-size: 10px;
}

@media (max-width: 768px) {
  .popup-content {
    padding: 2px;
    font-size: 10px; /* Shrinks the popup text */
    max-width: 120px; /* Prevents large popups */
  }
}

#map-section {
  position: relative;
  
}

#map {
  height: 500px;
  width: 100%;
  z-index: 0; /* Keeps map behind navbar */
}
#map {
  max-height: calc(100vh - 80px); /* Adjust based on navbar height */
  overflow: hidden;
}
@media (max-width: 768px) {
  #map {
    height: 400px; /* Reduce map height for better visibility */
  }
}
@media (max-width: 768px) {
  .search-container {
    flex-direction: column; /* Stack elements vertically */
    align-items: center;
  }

  input {
    width: 90%; /* Makes input fill the screen */
    padding: 12px; /* Improve touch usability */
  }

  .category-container {
    flex-wrap: wrap; /* Allows checkboxes to adjust */
    justify-content: center;
  }
}
@media (max-width: 768px) {
  .search-container {
    flex-direction: column; /* Stacks elements */
    align-items: center;
  }
}
@media (max-width: 768px) {
  .map-legend {
    position: relative; /* Prevents overlap */
    width: 90%; /* Adjusts for smaller screens */
    margin-top: 12px; /* Creates space between search & legend */
    text-align: center; /* Keeps layout balanced */
  }
}
.map-legend {
  position: static;
  background: rgba(255, 255, 255, 0.98);
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 300px;
  height: fit-content;
}

.legend-header {
  margin-bottom: 8px;
  border-bottom: 1px solid #eee;
  padding-bottom: 6px;
}

.legend-title {
  font-size: 14px;
  font-weight: 600;
  color: #2563eb;
}

.legend-items {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 12px;
  margin-top: 12px;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 8px;
  border-radius: 6px;
  background: rgba(255, 255, 255, 0.8);
  transition: all 0.2s;
}

.legend-item:hover {
  background: rgba(255, 255, 255, 1);
  transform: translateY(-1px);
}

.legend-item img {
  width: 20px !important;
  height: 20px !important;
  object-fit: contain;
}

.legend-item span {
  font-size: 13px;
  color: #4b5563;
  white-space: nowrap;
}

.search-container {
  width: 100%;
  max-width: 600px;
 margin: 0 auto;
  background: white;
  border-radius: 12px;
  padding: 4px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.search-input {
  font-size: 15px;
  border: none;
  outline: none;
  background: transparent;
  border-radius: 8px;
  text-align: center;
  padding-left: 60px;
  padding-right: 100px;
}

.search-input:focus::placeholder {
  opacity: 0;
}

.search-input::placeholder {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  transition: all 0.2s ease;
  white-space: nowrap;
}

/* Reset text alignment when user starts typing */
.search-input:not(:placeholder-shown) {
  text-align: left;
}

.search-button {
  padding: 8px 16px;
  background: linear-gradient(to right, #3b82f6, #2563eb);
  color: white;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.2s;
  white-space: nowrap;
  font-size: 14px;
}

.search-button:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
}

.map-layout {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto auto auto;
  gap: 20px;
  padding: 20px;
  min-height: calc(100vh - 64px);
  background: #f8fafc;
}

.map-container {
  display: flex;
  flex-direction: column;
  gap: 16px;
  height: 100%;
  background: white;
  border-radius: 16px;
  padding: 16px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

#map {
  flex: 1;
  min-height: 600px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.search-wrapper {
  position: sticky;
  top: 0;
  z-index: 1;
  background: white;
  padding: 8px 0;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
  .map-layout {
    grid-template-columns: 1fr;
    padding: 12px;
  }

  .map-container {
    padding: 12px;
  }

  #map {
    min-height: 450px;
  }

  .map-legend {
    max-width: 100%;
    margin-bottom: 20px;
  }
}

@media (max-width: 640px) {
  .map-layout {
    padding: 8px;
    min-height: calc(100vh - 56px);
  }

  .map-container {
    padding: 8px;
    border-radius: 12px;
  }

  #map {
    min-height: 350px;
  }

  .search-wrapper {
    padding: 4px 0;
  }

  .legend-items {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Custom Leaflet Styling */
:deep(.leaflet-control-zoom) {
  border: none !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

:deep(.leaflet-control-zoom a) {
  background: white !important;
  color: #2563eb !important;
  border: 1px solid #e5e7eb !important;
}

:deep(.leaflet-popup-content-wrapper) {
  border-radius: 8px !important;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
}
</style>