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
          <span class="legend-emoji">🍽️</span>
          <span>Restaurant</span>
        </div>
        <div class="legend-item">
          <span class="legend-emoji">☕</span>
          <span>Cafe</span>
        </div>
        <div class="legend-item">
          <span class="legend-emoji">🍔</span>
          <span>Fast Food</span>
        </div>
        <div class="legend-item">
          <span class="legend-emoji">🏬</span>
          <span>Mall</span>
        </div>
        <div class="legend-item">
          <span class="legend-emoji">📍</span>
          <span>Search</span>
        </div>
      </div>
      <div style="margin-top:8px; display:flex; justify-content:center;">
        <button class="center-button" @click="centerOnMe">
          <span class="me-icon">🧍‍♂️</span>
          <span class="me-text">Locate Me</span>
        </button>
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
      searchCenterMarker: null,
      nearbyMarkers: [],
      userMarker: null, // marker for "Center on Me"
     heritageSites: [] // fetched from JSON or API
    };
  },

  mounted() {
    // Populate heritage sites for location insights
    this.heritageSites = LANDMARKS.map(l => ({
      name: l.name,
      lat: l.lat,
      lon: l.lon,
      type: l.type
    }));

    // Initialize map
   this.map = L.map("map", {
  minZoom: 16,
  maxZoom: 17
}).setView([10.2923, 123.9024], 13); // initial center Cebu

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "&copy; OpenStreetMap contributors"
    }).addTo(this.map);

    this.markerCluster = L.markerClusterGroup();
    this.map.addLayer(this.markerCluster);

    const CEBU_NORTH_BUS = LANDMARKS.find(
      place => place.name === "Cebu North Bus Terminal"
    );

    // Add landmark pins with emoji 📍
    LANDMARKS.forEach(place => {
      if (place.name !== "Cebu North Bus Terminal") {
        const distance = this.calculateDistance(
          CEBU_NORTH_BUS.lat,
          CEBU_NORTH_BUS.lon,
          place.lat,
          place.lon
        );

        const fare = this.calculateJeepneyFare(distance);

        const pinIcon = L.divIcon({
          html: `<div style="font-size: 40px; text-align: center;">📍</div>`,
          iconSize: [40, 40],
          iconAnchor: [20, 40],
          popupAnchor: [0, -40],
          className: 'emoji-marker',
        });

        L.marker([place.lat, place.lon], { icon: pinIcon })
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
      const R = 6371;
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

    // JEEPNEY FARE
    calculateJeepneyFare(distanceKm) {
      const baseFare = 15;
      const extraPerKm = 2;
      if (distanceKm <= 4) return baseFare;
      return baseFare + Math.ceil(distanceKm - 4) * extraPerKm;
    },

    // SEARCH PLACE & NEARBY PLACES
    async searchPlace() {
      if (!this.searchQuery) return;

      // Clear previous nearby markers when searching a new place
      if (this.nearbyMarkers && this.nearbyMarkers.length) {
        this.nearbyMarkers.forEach(m => {
          try { if (this.map && this.map.hasLayer(m)) this.map.removeLayer(m); } catch (e) { /* ignore */ }
        });
        this.nearbyMarkers = [];
      }

      // Search via Nominatim
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

      if (this.searchCenterMarker) this.map.removeLayer(this.searchCenterMarker);

      const CEBU_NORTH_BUS = LANDMARKS.find(
        place => place.name === "Cebu North Bus Terminal"
      );

      const distance = Math.min(
        this.calculateDistance(CEBU_NORTH_BUS.lat, CEBU_NORTH_BUS.lon, lat, lon),
        30
      );
      const fare = this.calculateJeepneyFare(distance);

      // Marker for searched place with 📍 emoji
      this.searchCenterMarker = L.marker([lat, lon], {
        icon: L.divIcon({
          html: `<div style="font-size: 40px; line-height:1; transform: translate(-50%, -100%);">📍</div>`,
          iconSize: [40, 40],
          iconAnchor: [20, 40],
          popupAnchor: [0, -40],
          className: ''
        }),
      }).addTo(this.map)
        .bindPopup(`
          <div class="popup-content">
            <h3 style="color:#2563eb;">${this.searchQuery}</h3>
            <p style="font-size:12px;">📍 From: Cebu North Bus Terminal</p>
            <p style="font-size:12px;">📏 Distance: ${distance.toFixed(2)} km</p>
            <p style="font-size:13px; font-weight:600; color:#16a34a;">🚌 Jeepney Fare: ₱${fare}</p>
            <p style="font-size:12px;">🍴 Type: Search Result</p>
            <small style="font-size:10px; color:#6b7280;">*Estimated fare only</small>
          </div>
        `)
        .openPopup();

      // Emoji map for nearby places
      const iconMap = {
        restaurant: { emoji: "🍽️", label: "Restaurant" },
        cafe: { emoji: "☕", label: "Cafe" },
        fast_food: { emoji: "🍔", label: "Fast Food" },
        mall: { emoji: "🏬", label: "Mall" },
        bar: { emoji: "🍹", label: "Bar" },
      };

      // Fetch nearby places via Overpass API (includes malls)
      const radius = 1000;
      const overpassQuery = `
        [out:json];
        (
          node["amenity"="restaurant"](around:${radius},${lat},${lon});
          node["amenity"="cafe"](around:${radius},${lat},${lon});
          node["amenity"="fast_food"](around:${radius},${lat},${lon});
          node["shop"="mall"](around:${radius},${lat},${lon});
        );
        out;
      `;
      const overpassUrl = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(overpassQuery)}`;
      const placeRes = await fetch(overpassUrl);
      const placeData = await placeRes.json();

      // Debug: log raw Overpass response
      console.log('Overpass response for nearby places:', placeData);

      // If no elements returned, inform the user
      if (!placeData || !Array.isArray(placeData.elements) || placeData.elements.length === 0) {
        alert('No nearby places found within 1km for this location.');
        return;
      }

      placeData.elements.forEach(place => {
        const amenity = place.tags.amenity || "unknown";
        const name = place.tags.name || `Unnamed ${amenity}`;
        const plat = place.lat;
        const plon = place.lon;
        const pdistance = this.calculateDistance(
          CEBU_NORTH_BUS.lat, CEBU_NORTH_BUS.lon, plat, plon
        );
        const pfare = this.calculateJeepneyFare(pdistance);

        const iconData = iconMap[amenity] || { emoji: "📍", label: "Place" };
        const placeIcon = L.divIcon({
          html: `<div style="font-size:28px; text-align:center;">${iconData.emoji}</div>`,
          iconSize: [28, 28],
          iconAnchor: [14, 28],
          popupAnchor: [0, -28],
          className: 'emoji-marker'
        });

        const marker = L.marker([plat, plon], { icon: placeIcon })
          .addTo(this.map)
          .bindPopup(`
            <div style="font-size:13px; text-align:center;">
              ${iconData.emoji} <strong>${name}</strong><br>
              📍 From: Cebu North Bus Terminal<br>
              📏 Distance: ${pdistance.toFixed(2)} km<br>
              🚌 Jeepney Fare: ₱${pfare}<br>
              📌 Type: ${iconData.label}
            </div>
          `);
        // track markers so we can clear them on next search
        this.nearbyMarkers.push(marker);
      });
    },
async loadHeritageSites() {
  const res = await fetch("/data/heritage_sites.json");
  this.heritageSites = await res.json();
},
    // CENTER ON USER BUTTON
centerOnMe() {
    if (!navigator.geolocation) {
      alert('Geolocation not supported by your browser.');
      return;
    }

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const { latitude, longitude } = pos.coords;

        this.map.setView([latitude, longitude], 16);

        if (this.userMarker) this.map.removeLayer(this.userMarker);

        this.userMarker = L.marker([latitude, longitude], {
          icon: L.divIcon({
            html: `<div style="font-size:36px;">🧍‍♂️</div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 36],
          }),
        }).addTo(this.map);

        this.generateLocationInsight(latitude, longitude);
      },
      (error) => {
        alert('Unable to get your location: ' + error.message);
      }
    );
  }

  // LOCATION INSIGHT POPUP
  generateLocationInsight(lat, lon) {
    const nearestHeritage = this.heritageSites
      .map(site => ({
        ...site,
        distance: this.calculateDistance(lat, lon, site.lat, site.lon)
      }))
      .sort((a, b) => a.distance - b.distance)[0];

    const farFromHeritage = nearestHeritage.distance > 1;

    const popupHTML = `
      <div style="font-size:13px; line-height:1.4">
        <strong>🧍‍♂️ You are here</strong><br><br>

        ${farFromHeritage ? `⚠ You are far from major heritage sites<br><br>` : ``}

        <strong>Recommended Route:</strong><br>
        1️⃣ Fort San Pedro<br>
        2️⃣ Basilica del Santo Niño
      </div>
    `;

    this.userMarker.bindPopup(popupHTML).openPopup();
  }
  }
};
</script>




<style scoped>
.popup-content {
  padding: 2px;
  font-size: 10px;
}

#map-section {
  position: relative;
}

#map {
  height: 500px;
  width: 100%;
  z-index: 0;
}

#map,
.map-element {
  max-height: calc(100vh - 80px);
  overflow: hidden;
}

.map-layout {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto auto auto;
  gap: 12px;
  padding: 12px;
  padding-left: calc(1in + 12px);
  padding-right: calc(1in + 12px);
  min-height: auto;
  background: #f8fafc;
}

.map-container {
  display: flex;
  flex-direction: column;
  gap: 8px;
  height: auto;
  background: white;
  border-radius: 8px;
  padding: 12px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

.map-legend {
  position: static;
  background: rgba(255, 255, 255, 0.98);
  border-radius: 8px;
  padding: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: none;
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
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 12px;
  margin-top: 12px;
  overflow-x: auto;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 12px;
  border-radius: 12px;
  background: #ffffffff; /* light gray background */
  transition: all 0.2s ease;
  cursor: default;
}

.legend-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  background: #e0f7fa; /* subtle hover color */
}

.legend-item img {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

.legend-emoji {
  font-size: 24px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #ffffff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
}
.legend-item:nth-child(1) .legend-emoji { background: #ffe0b2; } /* Restaurant - light orange */
.legend-item:nth-child(2) .legend-emoji { background: #fff9c4; } /* Cafe - light yellow */
.legend-item:nth-child(3) .legend-emoji { background: #ffccbc; } /* Fast Food - salmon */
.legend-item:nth-child(4) .legend-emoji { background: #b3e5fc; } /* Mall - light blue */
.legend-item:nth-child(5) .legend-emoji { background: #c8e6c9; } /* Search - light green */


.legend-item span {
  font-size: 13px;
  color: #4b5563;
  white-space: nowrap;
}
.legend-item span:last-child {
  font-weight: 600;
  color: #1a0b0bff;
}

.center-button {
  display: flex;
  align-items: center;
  gap: 2px;

  background: #2469ffff;
  color: white;
  border: none;
  border-radius: 777px; /* pill shape */

  padding: 8px 10px;
  font-size: 14px;
  font-weight: 600;

  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transition: all 0.2s ease;
}

.center-button:hover {
  background: #3b82f6;
  transform: translateX(5px);
}
.me-icon {
  font-size: 25px;
  line-height: .5;
}

.me-text {
  white-space: nowrap;
}


/* Custom Leaflet Styling */
:deep(.leaflet-control-zoom) {
  border: none !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

:deep(.leaflet-control-zoom a) {
  background: white !important;
}

/* Tablet: 768px */
@media (max-width: 768px) {
  .map-layout {
    padding: 12px;
    gap: 12px;
  }

  .map-container {
    padding: 12px;
    border-radius: 12px;
  }

  #map {
    height: 400px;
    min-height: 400px;
  }

  .search-container {
    flex-direction: column;
    align-items: center;
  }

  .search-input {
    width: 100% !important;
    padding: 12px 10px !important;
    text-align: left;
    font-size: 14px;
  }

  .search-button {
    width: 100%;
    padding: 12px 10px;
    font-size: 14px;
  }

  .legend-items {
    flex-wrap: wrap;
    gap: 10px;
  }

  .legend-item {
    padding: 6px 8px;
    font-size: 12px;
  }

  .legend-item img {
    width: 18px;
    height: 18px;
  }

  .legend-item span {
    font-size: 12px;
  }
}

/* Mobile: 640px */
@media (max-width: 640px) {
  .map-layout {
    padding: 10px;
    gap: 10px;
    min-height: calc(100vh - 56px);
  }

  .map-container {
    padding: 10px;
    gap: 8px;
  }

  #map {
    height: 350px;
    min-height: 350px;
    border-radius: 8px;
  }

  .search-wrapper {
    padding: 8px;
  }

  .search-container {
    padding: 6px;
    gap: 6px;
  }

  .search-input {
    width: 100% !important;
    padding: 10px 8px !important;
    text-align: left;
    font-size: 13px;
  }

  .search-button {
    width: 100%;
    padding: 10px 8px;
    font-size: 13px;
  }

  .map-legend {
    padding: 10px;
    margin-top: 8px;
  }

  .legend-title {
    font-size: 13px;
  }

  .legend-items {
    gap: 8px;
    overflow-x: auto;
  }

  .legend-item {
    padding: 5px 8px;
    font-size: 11px;
    flex: 0 0 auto;
  }

  .legend-item img {
    width: 16px;
    height: 16px;
  }

  .legend-item span {
    font-size: 14px;
  }
  .map-legend .legend-item {
    padding: 7px 10px;      /* bigger touch area */
    gap: 5px;
  }

  .map-legend .legend-emoji {
    font-size: 30px;         /* bigger emoji */
    width: 33px;
    height: 33px;
  }

  .map-legend .legend-item span {
    font-size: 14px;         /* bigger text */
    font-weight: 600;
  }
}

/* Small Mobile: 480px */
@media (max-width: 480px) {
  .map-layout {
    padding: 8px;
    gap: 8px;
  }

  .map-container {
    padding: 8px;
    gap: 6px;
  }

  #map {
    height: 300px;
    min-height: 300px;
  }

  .search-wrapper {
    padding: 6px;
  }

  .search-container {
    padding: 4px;
    gap: 4px;
  }

  .search-input {
    width: 100% !important;
    padding: 8px 6px !important;
    font-size: 12px;
  }

  .search-button {
    width: 100%;
    padding: 8px 6px;
    font-size: 12px;
  }

  .map-legend {
    padding: 8px;
    margin-top: 6px;
  }

  .legend-title {
    font-size: 12px;
  }

  .legend-items {
    gap: 6px;
  }

  .legend-item {
    padding: 4px 6px;
    font-size: 10px;
  }

  .legend-item img {
    width: 14px !important;
    height: 14px !important;
  }

  .legend-item span {
    font-size: 10px;
  }
}

/* Extra Small: 320px */
@media (max-width: 320px) {
  .map-layout {
    padding: 6px;
    gap: 6px;
  }

  .map-container {
    padding: 6px;
    gap: 4px;
  }

  #map {
    height: 280px;
    min-height: 280px;
  }

  .search-wrapper {
    padding: 4px;
  }

  .search-container {
    padding: 3px;
    gap: 3px;
  }

  .search-input {
    width: 100% !important;
    padding: 6px 4px !important;
    font-size: 11px;
  }

  .search-button {
    width: 100%;
    padding: 6px 4px;
    font-size: 11px;
  }

  .map-legend {
    padding: 6px;
    margin-top: 4px;
  }

  .legend-title {
    font-size: 11px;
  }

  .legend-items {
    gap: 4px;
  }

  .legend-item {
    padding: 3px 5px;
    font-size: 9px;
  }

  .legend-item img {
    width: 12px !important;
    height: 12px !important;
  }

  .legend-item span {
    font-size: 9px;
  }
}
</style>