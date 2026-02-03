<template>
  <section id="about-container" class="about-container">
    <div class="header-section">
      <div class="header-content">
        <h1>
          <span class="brand">SuroySugbo</span>
          <span class="subtitle">Discover Cebu's Heritage</span>
        </h1>
      </div>
      <div class="header-pattern"></div>
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
  background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
  position: relative;
}

.header-section {
  background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
  padding: 6rem 2rem;
  text-align: center;
  color: white;
  position: relative;
  overflow: hidden;
}

.header-pattern {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 40px;
  background: linear-gradient(45deg, transparent 33.333%, #ffffffff 33.333%, #ffffff 66.666%, transparent 66.666%),
              linear-gradient(-45deg, transparent 33.333%, #ffffff 33.333%, #ffffff 66.666%, transparent 66.666%);
  background-size: 20px 40px;
  opacity: .75;
}

.brand {
  font-size: 3.5rem;
  font-weight: 800;
  display: block;
  margin-bottom: 1rem;
  background: linear-gradient(to right, #ffffff, #e2e8f0);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.subtitle {
  font-size: 1.5rem;
  font-weight: 500;
  color: #e2e8f0;
  letter-spacing: 1px;
}

.content-section {
  max-width: 1200px;
  margin: -3rem auto 0;
  padding: 3rem 2rem;
  position: relative;
  z-index: 1;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 24px 24px 0 0;
  box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(10px);
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
  margin: 4rem 0;
}

.feature-item {
  background: linear-gradient(145deg, #ffffff, #f8fafc);
  padding: 2.5rem 2rem;
  border-radius: 20px;
  text-align: center;
  transition: all 0.4s ease;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  border: 1px solid rgba(226, 232, 240, 0.8);
}

.feature-item:hover {
    transform: translateY(-10px);
  box-shadow:
    0 20px 40px rgba(0, 188, 212, 0.35),
    0 0 25px rgba(0, 188, 212, 0.25);
}

.icon {
  font-size: 2.5rem;
  margin-bottom: 1.5rem;
  display: inline-block;
  transition: transform 0.3s ease;
}

.feature-item:hover .icon {
  transform: scale(1.2);
}

.feature-item p {
  color: #1e3a8a;
  font-weight: 600;
  font-size: 1.1rem;
}

.description {
  color: #4b5563;
  line-height: 1.8;
  margin-bottom: 1.5rem;
}

.highlight-box {
  background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
  padding: 4rem 2rem;
  text-align: center;
  margin-top: 5rem;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
}

.highlight {
  color: white;
  font-size: 1.5rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  line-height: 1.6;
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