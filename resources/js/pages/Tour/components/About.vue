<template>
  <section id="about-container" class="about-container">
    <div class="about-card">
      <h1>
        <span class="brand">SuroySugbo</span>
        <span class="subtitle"> | Discover Cebu’s Heritage</span>
      </h1>
      
      <p>
        <strong>SuroySugbo</strong> is dedicated to preserving and promoting Cebu’s rich cultural heritage through an accessible, interactive digital platform.
        Our mission is to bridge tradition and modern exploration by integrating historical landmarks with practical jeepney routes.
      </p>
      <p>
        We believe heritage should be accessible, engaging, and memorable. That’s why we offer a detailed map of important landmarks,
        nearby food spots, and a fun mini flipping game to make learning about Cebu’s traditions enjoyable for everyone.
      </p>
      <p>
        Whether you’re commuting, sightseeing, or simply curious about the stories behind Cebu’s iconic locations,
        <strong>SuroySugbo</strong> guides you on a journey of discovery—one route, one landmark, and one flip at a time.
      </p>
      <p class="highlight">
        Join us in celebrating Cebu’s history and keeping our culture alive!
      </p>
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
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 60vh;
  background: linear-gradient(120deg, #e3f0ff 0%, #f9f9f9 100%);
  padding: 60px 0;
}

.about-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 6px 32px rgba(0, 123, 255, 0.08), 0 1.5px 6px rgba(0,0,0,0.04);
  max-width: 1100px;
  width: 100%;
  padding: 56px 64px;
  border-left: 6px solid #007bff;
  text-align: center;
}

h1 {
  color: #222;
  font-size: 1.7rem;
  margin-bottom: 18px;
  font-weight: 700;
  letter-spacing: 1px;
}
.brand {
  color: #007bff;
  font-weight: 800;
}

.subtitle {
  color: #555;
  font-size: 1.05rem;
  font-weight: 400;
}

p {
  color: #333;
  font-size: 1rem;
  line-height: 1.7;
  margin-bottom: 1.2em;
}

.highlight {
  font-weight: bold;
  color: #007bff;
  font-size: 1.15rem;
  margin-top: 1.5em;
}

@media (max-width: 600px) {
  .about-card {
    padding: 28px 10px;
  }
  h1 {
    font-size: 1.3rem;
  }
  .subtitle {
    font-size: 0.95rem;
  }
}
</style>