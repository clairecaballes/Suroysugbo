<template>
  <section id="map-section" style="position: relative;">
    <!-- Search Bar and Categories (if any) -->
<div class="flex items-center gap-2 p-2 rounded-lg shadow-sm"><div class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm">
<input 
  v-model="searchQuery" 
  placeholder="Search a place..."
  class="faq-search border shadow-sm focus:ring-2 focus:ring-blue-500"
>

 <button 
  @click="searchPlace"
  class="px-4 py-2 text-blue-700 rounded-md text-sm border border-blue-600 transition-all duration-300"
>
  🔍
</button>
  
</div>
      <!-- Add category checkboxes here if needed -->
    </div>

    <!-- Map -->
    <div id="map" style="height: 500px; width: 100%; margin-top: 10px;"></div>

    <!-- Legend OVER the map -->
    <div class="map-legend">
      <strong>Legend:</strong>
      <img src="https://cdn-icons-png.flaticon.com/512/1046/1046784.png" alt="Restaurant" /> Restaurant
      <img src="https://cdn-icons-png.flaticon.com/512/1046/1046790.png" alt="Cafe" /> Cafe
      <img src="https://cdn-icons-png.flaticon.com/512/1046/1046786.png" alt="Fast Food" /> Fast Food
      <img src="https://cdn-icons-png.flaticon.com/512/1046/1046787.png" alt="Mall" /> Mall
      <img src="https://cdn-icons-png.flaticon.com/512/1046/1046785.png" alt="Search Location" /> Search Location
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
  padding: 4px;
  font-size: 14px;
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
  overflow: hidden; /* Prevents scrolling beyond boundaries */
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
  position: absolute;
  left: 12px;
  bottom: 12px;
  z-index: 1000;
  background: white;
  padding: 2px 6px;
  border-radius: 3px;
  font-size: 11px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.10);
  display: flex;
  align-items: center;
  gap: 6px;
  opacity: 0.95;
  max-width: 90vw;
  flex-wrap: wrap;
}
.map-legend img {
  width: 14px !important;
  height: 14px !important;
  margin-right: 1px;
}
</style>