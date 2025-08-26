<template>
  <header class="header">
    <div class="gradient-overlay"></div>
    <div class="container header-container">
      <div class="header-left">
        <h1>Discover Cebu’s Heritage</h1>
        <p>
         Where History, Faith, and Celebration Unite.
From iconic landmarks to vibrant traditions, experience the living legacy of Cebu.

        </p>
        <router-link to="/about" class="btn-primary">Learn More</router-link>
      </div>
      <div class="header-right">
        <img src="/img/header1.png" alt="Cebu Scenery" class="header-image" />
      </div>
    </div>
  </header>
</template>

<style scoped>
.header {
  position: relative;
  min-height: 100vh;
  background: linear-gradient(
    to right bottom,
    #01133b,
    #001758,
    #1b45d2,
    #021036
  );
  overflow: hidden;
}
h1 {
  color: white;
}

.gradient-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(
    circle at center,
    rgba(59, 130, 246, 0.1) 0%,
    rgba(30, 58, 138, 0.4) 100%
  );
  z-index: 1;
}

.header-container {
  position: relative;
  z-index: 2;
}

.header-left p {
  font-size: 1.25rem;
  color: #ffffff;
  margin-bottom: 2rem;
  line-height: 1.7;
}

.btn-primary {
  display: inline-block;
  padding: 1rem 2.5rem;
  background: linear-gradient(to right, #3b82f6, #1d4ed8);
  color: white;
  border-radius: 100px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}

.header-right {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}
.header-image {
  max-width: 100%;
  height: auto;
  border-radius: 0px;
  transition: transform 0.3s ease;
}

.header-image:hover {
  transform: translateY(-10px);
}
</style>
