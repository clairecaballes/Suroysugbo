<template>
  <section class="about-container">
    <div class="header-section">
      <h1>
        <span class="brand">SuroySugbo</span>
        <span class="subtitle">Discover Cebu's Heritage</span>
      </h1>
    </div>
    
    <div class="content-section">
      <p class="intro">
        <strong>SuroySugbo</strong> is dedicated to preserving and promoting Cebu's rich cultural heritage through an accessible, interactive digital platform.
        Our mission is to bridge tradition and modern exploration by integrating historical landmarks with practical jeepney routes.
      </p>
      
      <div class="feature-grid">
        <div class="feature-item">
          <span class="icon">🗺️</span>
          <p>Interactive Maps & Routes</p>
        </div>
        <div class="feature-item">
          <span class="icon">🏛️</span>
          <p>Historical Landmarks</p>
        </div>
        <div class="feature-item">
          <span class="icon">🎮</span>
          <p>Fun Mini Games</p>
        </div>
        <div class="feature-item">
          <span class="icon">🍴</span>
          <p>Local Food Spots</p>
        </div>
      </div>

      <p class="description">
        We believe heritage should be accessible, engaging, and memorable. That's why we offer a detailed map of important landmarks,
        nearby food spots, and a fun mini flipping game to make learning about Cebu's traditions enjoyable for everyone.
      </p>
      
      <p class="description">
        Whether you're commuting, sightseeing, or simply curious about the stories behind Cebu's iconic locations,
        <strong>SuroySugbo</strong> guides you on a journey of discovery—one route, one landmark, and one flip at a time.
      </p>
      
      <div class="highlight-box">
        <p class="highlight">Join us in celebrating Cebu's history and keeping our culture alive! 🎉</p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "AboutSection",
};
</script>

<style scoped>
.about-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
}

.header-section {
  background: linear-gradient(120deg, #2563eb 0%, #3b82f6 100%);
  padding: 4rem 2rem;
  text-align: center;
  color: white;
  margin-bottom: 3rem;
}

.brand {
  font-size: 2.5rem;
  font-weight: 800;
  display: block;
  margin-bottom: 0.5rem;
  background: linear-gradient(120deg, #ffffff 0%, #e5e7eb 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.subtitle {
  font-size: 1.25rem;
  font-weight: 400;
  opacity: 0.9;
  display: block;
}

.content-section {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem 4rem;
}

.intro {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #374151;
  text-align: center;
  max-width: 800px;
  margin: 0 auto 2rem;
}

.feature-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
  margin: 3rem 0;
}

.feature-item {
  background: white;
  padding: 2rem;
  border-radius: 16px;
  text-align: center;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.feature-item:hover {
  transform: translateY(-5px);
}

.icon {
  font-size: 2rem;
  margin-bottom: 1rem;
  display: block;
}

.description {
  color: #4b5563;
  line-height: 1.8;
  margin-bottom: 1.5rem;
}

.highlight-box {
  background: white;
  padding: 3rem 2rem;
  text-align: center;
  margin-top: 4rem;
  border-top: 1px solid #e5e7eb;
}

.highlight {
  color: #2563eb;
  font-size: 1.25rem;
  font-weight: 600;
}

@media (max-width: 768px) {
  .header-section {
    padding: 3rem 1rem;
    margin-bottom: 2rem;
  }

  .content-section {
    padding: 0 1rem 3rem;
  }

  .feature-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }
}

@media (max-width: 480px) {
  .header-section {
    padding: 2rem 1rem;
  }

  .feature-grid {
    grid-template-columns: 1fr;
  }

  .feature-item {
    padding: 1.5rem;
  }
}
</style>