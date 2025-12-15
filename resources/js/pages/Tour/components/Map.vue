<template>
  <section id="map-section" class="map-layout">
    <div class="map-container">
      <!-- Search Bar -->
      <div class="flex justify-center w-full search-wrapper">
        <div class="search-container">
          <div class="relative flex items-center justify-center w-full">
            <input 
              v-model="searchQuery" 
              placeholder="🔍 Discover Places"
              class="search-input w-full"
              :style="{ textIndent: searchQuery ? '0' : '40px' }"
            >
            <button 
              @click="searchPlace"
              class="search-button absolute right-1"
            >
              <span>Explore</span>
            </button>
          </div>
        </div>
      </div>
      <!-- Map -->
      <div id="map" class="map-element"></div>
    </div>

    <!-- Legend moved outside -->
    <div class="map-legend">
      <div class="legend-header">
        <span class="legend-title">📍 Places</span>
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
          <span>Search</span>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet.markercluster";

/* ===============================
   LANDMARK LOCATIONS
================================ */
const LANDMARKS = [
  { name: "Fort San Pedro", lat: 10.2929, lon: 123.9056, type: "Historical Monument" },
  { name: "Basilica Minore del Santo Niño", lat: 10.2937, lon: 123.9026, type: "Church" },
  { name: "Magellan's Cross", lat: 10.2926, lon: 123.9022, type: "Historical Monument" },
  { name: "Cebu North Bus Terminal", lat: 10.3111, lon: 123.9158, type: "Transport Terminal" }
];


export default {
  name: "Map",

  data() {
    return {
      searchQuery: "",
      map: null,
      markerCluster: null,
      searchCenterMarker: null
    };
  },

  mounted() {
    // Initialize map
    this.map = L.map("map").setView([10.2923, 123.9024], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors"
    }).addTo(this.map);

    this.markerCluster = L.markerClusterGroup();
    this.map.addLayer(this.markerCluster);

    const CEBU_NORTH_BUS = LANDMARKS.find(
      place => place.name === "Cebu North Bus Terminal"
    );

    // Add landmark pins with distance & fare
    LANDMARKS.forEach(place => {
      if (place.name !== "Cebu North Bus Terminal") {
        const distance = this.calculateDistance(
          CEBU_NORTH_BUS.lat,
          CEBU_NORTH_BUS.lon,
          place.lat,
          place.lon
        );

        const fare = this.calculateJeepneyFare(distance);

        // Create emoji marker icon
        const redPinSvg = `
          <div style="font-size: 40px; text-align: center;">📍</div>
        `;

        const redPinIcon = L.divIcon({
          html: redPinSvg,
          iconSize: [40, 40],
          iconAnchor: [20, 40],
          popupAnchor: [0, -40],
          className: 'emoji-marker',
        });

        L.marker([place.lat, place.lon], { icon: redPinIcon })
          .addTo(this.map)
          .bindPopup(`
            <div style="font-size:13px; text-align:center;">
              📍 <strong>${place.name}</strong><br>
              📍 From: Cebu North Bus Terminal<br>
              📏 Distance: ${distance.toFixed(2)} km<br>
              🚌 Jeepney Fare: ₱${fare}<br>
              🏷 Type: ${place.type}
            </div>
          `);

      }
    });
  },
  

  methods: {
    // DISTANCE (HAVERSINE)
    calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // km
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;

      const a =
        Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;

      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    },

    // JEEPNEY FARE ESTIMATE
    calculateJeepneyFare(distanceKm) {
      const baseFare = 15; // first 4 km
      const extraPerKm = 2;
      if (distanceKm <= 4) return baseFare;
      return baseFare + Math.ceil(distanceKm - 4) * extraPerKm;
    },

    // SEARCH PLACE & NEARBY RESTAURANTS
    async searchPlace() {
      if (!this.searchQuery) return;

      // Nominatim search restricted to Cebu City
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}&bounded=1&viewbox=123.85,10.23,123.95,10.35`;
      const response = await fetch(url);
      const data = await response.json();

      if (!data.length) {
        alert("Place not found in Cebu City.");
        return;
      }

      const lat = parseFloat(data[0].lat);
      const lon = parseFloat(data[0].lon);

      this.map.setView([lat, lon], 15);

      if (this.searchCenterMarker) {
        this.map.removeLayer(this.searchCenterMarker);
      }

      const CEBU_NORTH_BUS = LANDMARKS.find(
        place => place.name === "Cebu North Bus Terminal"
      );

      // Distance & fare for searched place
      let distance = this.calculateDistance(
        CEBU_NORTH_BUS.lat,
        CEBU_NORTH_BUS.lon,
        lat,
        lon
      );

      const maxDistanceKm = 30; // limit
      if (distance > maxDistanceKm) distance = maxDistanceKm;

      const fare = this.calculateJeepneyFare(distance);

      // Marker for searched place
      this.searchCenterMarker = L.marker([lat, lon], {
        icon: L.icon({
          iconUrl: "https://cdn-icons-png.flaticon.com/512/1046/1046785.png",
          iconSize: [60, 60],
        }),
      })
        .addTo(this.map)
        .bindPopup(`
          <div class="popup-content">
            <h3 style="color:#2563eb;">${this.searchQuery}</h3>
            <p style="font-size:12px;">📍 From: Cebu North Bus Terminal</p>
            <p style="font-size:12px;">📏 Distance: ${distance.toFixed(2)} km</p>
            <p style="font-size:13px; font-weight:600; color:#16a34a;">
              🚌 Jeepney Fare: ₱${fare}
            </p>
            <p style="font-size:12px;">🍴 Type: Search Result</p>
            <small style="font-size:10px; color:#6b7280;">
              *Estimated fare only
            </small>
          </div>
        `)
        .openPopup();

      // Fetch nearby restaurants using Overpass API
      const radius = 1000; // 1 km radius
      const overpassQuery = `
        [out:json];
        node
          ["amenity"="restaurant"]
          (around:${radius},${lat},${lon});
        out;
      `;
      const overpassUrl = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(overpassQuery)}`;
      const restaurantRes = await fetch(overpassUrl);
      const restaurantData = await restaurantRes.json();

      restaurantData.elements.forEach(place => {
        const name = place.tags.name || "Unnamed Restaurant";
        const plat = place.lat;
        const plon = place.lon;
        const pdistance = this.calculateDistance(
          CEBU_NORTH_BUS.lat,
          CEBU_NORTH_BUS.lon,
          plat,
          plon
        );
        const pfare = this.calculateJeepneyFare(pdistance);

        L.marker([plat, plon])
          .addTo(this.map)
          .bindPopup(`
            <div style="font-size:13px; text-align:center;">
              🍴 <strong>${name}</strong><br>
              📍 From: Cebu North Bus Terminal<br>
              📏 Distance: ${pdistance.toFixed(2)} km<br>
              🚌 Jeepney Fare: ₱${pfare}<br>
              🍽 Type: Restaurant
            </div>
          `);
      });
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

#map,
.map-element {
  max-height: calc(100vh - 80px); /* Adjust based on navbar height */
  overflow: hidden;
}

@media (max-width: 768px) {
  #map {
    height: 400px; /* Reduce map height for better visibility */
  }
}

/* Small screens - search bar and legend optimization */
@media (max-width: 640px) {
  .search-container {
    flex-direction: column;
    align-items: stretch;
    padding: 8px;
    gap: 8px;
  }

  .search-input {
    width: 100% !important;
    padding: 10px 12px !important;
    text-align: left;
    font-size: 14px;
  }

  .search-button {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
  }

  .map-legend {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
  }

  .legend-title {
    font-size: 13px;
  }

  .legend-items {
    flex-wrap: wrap;
    gap: 8px;
    overflow-x: visible;
  }

  .legend-item {
    flex: 0 0 auto;
    padding: 6px 10px;
    font-size: 12px;
  }

  .legend-item span {
    font-size: 12px;
  }

  #map {
    height: 350px;
  }
}

/* Extra small screens */
@media (max-width: 480px) {
  .search-container {
    padding: 6px;
    gap: 6px;
  }

  .search-input {
    padding: 8px 10px !important;
    font-size: 13px;
  }

  .search-button {
    padding: 8px 10px;
    font-size: 13px;
  }

  .map-legend {
    padding: 10px;
  }

  .legend-title {
    font-size: 12px;
  }

  .legend-items {
    gap: 6px;
  }

  .legend-item {
    padding: 4px 8px;
    font-size: 11px;
  }

  .legend-item img {
    width: 16px !important;
    height: 16px !important;
  }

  .legend-item span {
    font-size: 11px;
  }

  #map {
    height: 300px;
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

  .legend-items {
    flex-wrap: wrap; /* Allow wrapping on mobile */
    justify-content: center;
  }
}

.map-legend {
  position: static;
  background: rgba(255, 255, 255, 0.98);
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: none; /* remove fixed 300px so items can stretch */
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
  display: flex;              /* horizontal layout */
  flex-wrap: nowrap;          /* prevent wrapping by default */
  justify-content: center;    /* center items */
  gap: 12px;                  /* spacing between items */
  margin-top: 12px;
  overflow-x: auto;           /* scroll if too many items */
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 4px 8px;
  border-radius: 6px;
  background: rgba(255, 255, 255, 0.8);
  transition: all 0.2s;
  flex: 0 0 auto;             /* prevent shrinking, keep items inline */
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
  padding: 8px;
  width: 100%;
  box-sizing: border-box;
}

/* Ultra small screens - 220px width */
@media (max-width: 320px) {
  #map-section {
    padding: 4px !important;
  }

  .search-wrapper {
    padding: 4px;
  }

  .search-container {
    padding: 2px !important;
    gap: 4px;
  }

  .search-input {
    font-size: 12px !important;
    padding: 6px 4px !important;
    padding-right: 40px !important;
  }

  .search-button {
    padding: 6px 8px !important;
    font-size: 11px !important;
  }

  .search-button span {
    display: none;
  }

  .search-button::after {
    content: '🔍';
  }

  .map-element {
    height: 250px !important;
    margin-top: 4px !important;
  }

  .map-legend {
    padding: 6px !important;
    margin-top: 6px !important;
  }

  .legend-header {
    margin-bottom: 4px !important;
    padding-bottom: 2px !important;
  }

  .legend-title {
    font-size: 10px !important;
  }

  .legend-items {
    gap: 4px !important;
    flex-wrap: wrap;
  }

  .legend-item {
    padding: 2px 4px !important;
    gap: 2px !important;
    font-size: 9px !important;
  }

  .legend-item img {
    width: 12px !important;
    height: 12px !important;
  }

  .legend-item span {
    font-size: 9px !important;
  }
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
  background: white !
}
</style>