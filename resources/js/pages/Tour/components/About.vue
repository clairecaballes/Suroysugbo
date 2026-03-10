
<template>
  <section id="about-container" class="about-container">

    <!-- HEADER -->
    <div class="header-section">
      <div class="header-content">
        <h1>
          <span class="brand">SuroySugbo</span>
          <span class="subtitle">Discover Cebu's Heritage</span>
        </h1>
      </div>
      <div class="header-pattern"></div>
    </div>

    <!-- CONTENT -->
    <div class="content-section">

      <p class="intro">
        <strong>SuroySugbo</strong> is dedicated to preserving and promoting Cebu's rich cultural heritage through an accessible, interactive digital platform.
        Our mission is to bridge tradition and modern exploration by integrating historical landmarks with practical jeepney routes.
      </p>

      <!-- FEATURES -->
      <div class="feature-grid">

        <div
          v-for="(feature, index) in features"
          :key="feature.title"
          class="feature-item"
          @click="toggleFlip(index)"
        >

          <div
            class="feature-card"
            :class="{ flipped: flippedCards[index] }"
             @click.stop
          >

            <!-- FRONT -->
            <div class="feature-front">
              <span class="icon">{{ feature.icon }}</span>
              <p>{{ feature.title }}</p>
            </div>

            <!-- BACK -->
            <div class="feature-back">
            <p>{{ feature.description }}</p>
            <a :href="feature.link" class="more-link">click more</a>
            </div>

          </div>

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
        <p class="highlight">
          Join us in celebrating Cebu's history and keeping our culture alive! 🎉
        </p>
      </div>

    </div>
  </section>
</template>

<script>
export default {
  name: "AboutSection",

  data() {
    return {
      flippedCards: [],
      features: [
        {
          icon: "🗺️",
          title: "Mini Map",
          description: "Explore major cultural heritage sites in Cebu.",
          link: "#map-section"
        },
        {
          icon: "🏛️",
          title: "Gallery",
          description: "Learn about Cebu’s heritage through images of each major site.",
          link: "#slider-section"
        },
        {
          icon: "🎮",
          title: "Mini Game",
          description: "Discover Cebu’s culture in a fun flip-card game.",
          link: "#minigame-container"
        },
        {
          icon: "🍴",
          title: "Food spots",
          description: "Find local food near heritage sites while exploring Cebu.",
          link: "#map-section"
        }
      ]
    };
  },

  mounted() {
    this.flippedCards = this.features.map(() => false);
  },

  methods: {
    toggleFlip(index) {
      if (window.innerWidth <= 768) {
        this.flippedCards[index] = !this.flippedCards[index];
      }
    }
  }
};
</script>

<style scoped>

.about-container{
min-height:100vh;
background:linear-gradient(180deg,#f8fafc 0%,#ffffff 100%);
}

.header-section{
background:linear-gradient(135deg,#1e3a8a 0%,#1e40af 100%);
padding:6rem 2rem;
text-align:center;
color:white;
position:relative;
overflow:hidden;
}

.header-pattern{
position:absolute;
bottom:0;
left:0;
right:0;
height:40px;
background:linear-gradient(45deg,transparent 33.333%,#fff 33.333%,#fff 66.666%,transparent 66.666%),
linear-gradient(-45deg,transparent 33.333%,#fff 33.333%,#fff 66.666%,transparent 66.666%);
background-size:20px 40px;
opacity:.75;
}

.brand{
font-size:3.5rem;
font-weight:800;
display:block;
margin-bottom:1rem;
background:linear-gradient(to right,#ffffff,#e2e8f0);
-webkit-background-clip:text;
-webkit-text-fill-color:transparent;
}

.subtitle{
font-size:1.5rem;
font-weight:500;
color:#e2e8f0;
}

.content-section{
max-width:1200px;
margin:-3rem auto 0;
padding:3rem 2rem;
background:rgba(255,255,255,0.9);
border-radius:24px 24px 0 0;
box-shadow:0 -10px 30px rgba(0,0,0,0.1);
}

.intro{
font-size:1.1rem;
line-height:1.8;
color:#374151;
text-align:center;
max-width:800px;
margin:0 auto 2rem;
}

.feature-grid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:2rem;
margin:4rem 0;
}

/* FLIP CARD */

.feature-item{
perspective:1000px;
cursor:pointer;
}

.feature-card{
position:relative;
width:100%;
height:180px;
transform-style:preserve-3d;
transition:transform .6s;
}

.feature-item:hover .feature-card{
transform:rotateY(180deg);
}

.feature-card.flipped{
transform:rotateY(180deg);
}

.feature-front,
.feature-back{
position:absolute;
width:100%;
height:100%;
border-radius:20px;
padding:2rem;
backface-visibility:hidden;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
box-shadow:0 4px 20px rgba(0,0,0,0.05);
}

.feature-front{
background:linear-gradient(145deg,#ffffff,#f8fafc);
border:1px solid rgba(226,232,240,0.8);
}

.feature-back{
background:linear-gradient(135deg,#1e3a8a,#2563eb);
color:white;
transform:rotateY(180deg);
text-align:center;
}

.icon{
font-size:2.5rem;
margin-bottom:1rem;
}

.feature-front p{
color:#1e3a8a;
font-weight:600;
}

.more-link{
position:absolute;
bottom:12px;
right:15px;
font-style:italic;
font-size:.85rem;
color:white;
text-decoration:underline;
}

.description{
color:#4b5563;
line-height:1.8;
margin-bottom:1.5rem;
}

.highlight-box{
background:linear-gradient(135deg,#1e3a8a,#2563eb);
padding:4rem 2rem;
text-align:center;
margin-top:5rem;
border-radius:16px;
}

.highlight{
color:white;
font-size:1.5rem;
font-weight:600;
}

/* TABLET */

@media (max-width:768px){

.brand{
font-size:2.6rem;
}

.subtitle{
font-size:1.2rem;
}

.feature-grid{
grid-template-columns:repeat(2,1fr);
gap:1.2rem;
}

.feature-card{
height:190px;
}

}

/* MOBILE */
@media (max-width:480px) {

  .brand {
    font-size: 2.2rem;
  }

  .subtitle {
    font-size: 1rem;
  }

  .content-section {
    margin: 2rem auto 0;  /* instead of -3rem */
    padding: 3rem 1rem;   /* extra top padding for spacing */
  }

  .intro {
    font-size: 1rem;
    line-height: 1.6;
    margin-top: 1rem;    /* spacing from header */
  }

  .feature-grid {
    grid-template-columns: 1fr;
  }

  .feature-card {
    height: 200px;
  }

  .feature-front,
  .feature-back {
    padding: 1.5rem;
  }

  .icon {
    font-size: 2rem;
  }

}
</style>

