<template>
  <section id="compact-contact" class="compact-contact">
    <div class="contact-container">
      <!-- Left: Info -->
      <div class="contact-info">
        <h2>Get in Touch</h2>
        <p class="contact-description">Have questions about Cebu's heritage or transportation? We're here to help!</p>
        
        <div class="contact-cards">
          <div class="info-card">
            <i class="fas fa-phone-alt"></i>
            <div class="info-content">
              <h3>Phone</h3>
              <a href="tel:+639060490920">+63 906 049 0920</a>
            </div>
          </div>
          
          <div class="info-card">
            <i class="fas fa-envelope"></i>
            <div class="info-content">
              <h3>Email</h3>
              <a href="mailto:jeanpics1@gmail.com"
   onclick="
      var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
      if (isMobile) {
          var now = Date.now();
          window.location = 'googlegmail://co?to=jeanpics1@gmail.com';
          setTimeout(function() {
              if (Date.now() - now < 1000) window.location = 'mailto:jeanpics1@gmail.com';
          }, 500);
          return false;
      } else {
          window.open('https://mail.google.com/mail/?view=cm&to=jeanpics1@gmail.com', '_blank');
          return false;
      }
   ">
   jeanpics1@gmail.com
</a>

            </div>
          </div>
          
          <div class="info-card">
            <i class="fas fa-map-marker-alt"></i>
            <div class="info-content">
              <h3>Location</h3>
              <p>Cogon Danao, City</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Form -->
      <div class="contact-form">
        <h2>Send us a Message</h2>
        <form @submit.prevent="submitForm">
         <div class="form-group">
  <input type="text" v-model="form.name" required placeholder="">
  <label>Your Name</label>
</div>

<div class="form-group">
  <input type="email" v-model="form.email" required placeholder="">
  <label>Your Email</label>
</div>

          
          <div class="form-group">
            <select v-model="form.subject" required>
              <option value="" disabled selected hidden>Choose a Subject</option>
              <option value="jeepney">Jeepney Fare</option>
              <option value="modes">Transportation Modes</option>
              <option value="others">Others</option>
            </select>
          </div>
          
         <div class="form-group">
  <textarea v-model="form.message" required placeholder=""></textarea>
  <label>Your Message</label>
</div>

          
          <button type="submit" class="submit-btn">
            Send Message
            <i class="fas fa-paper-plane"></i>
          </button>
        </form>
        
        <div v-if="successMessage" class="alert success">
          <i class="fas fa-check-circle"></i> {{ successMessage }}
        </div>
        <div v-if="errorMessage" class="alert error">
          <i class="fas fa-exclamation-circle"></i> {{ errorMessage }}
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const successMessage = ref('')
const errorMessage = ref('')

const submitForm = async () => {
  successMessage.value = ''
  errorMessage.value = ''
  try {
    const response = await axios.post('/message-post', form.value)
    successMessage.value = response.data.message || 'Message sent!'
    // Optionally reset form
    form.value = { name: '', email: '', subject: '', message: '' }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Failed to send message.'
  }
}
</script>

<style scoped>
.compact-contact {
  min-height: 10vh;
  background: linear-gradient(135deg, #021036 100%, #2c4888 50%);
  padding: 5rem 1rem;
  position: relative;
  overflow: hidden;
}

.contact-container {
  max-width: 900px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
  padding: 1rem;
}

.contact-info h2,
.contact-form h2 {
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
  font-weight: 800;
  background: linear-gradient(to right, #260d95, #91add1);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.contact-description {
  font-size: 0.9rem;
  margin-bottom: 1.5rem;
  line-height: 1.6;
  color: #c2cddd;
}

.contact-cards {
  display: grid;
  gap: 1rem;
}

.info-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  padding: .5rem;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.info-card:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.245);
  border-color: rgba(255, 255, 255, 0.2);
}

.info-card i {
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  font-size: 1.1rem;
  color: #3b82f6;
  transition: all 0.3s ease;
}

.info-content {
  flex: 1;
}

.info-content h3 {
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
  color: #ffffff;
}

.info-content a,
.info-content p {
  font-size: 0.875rem;
  color: #e2e8f0;
  text-decoration: none;
  line-height: 1.4;
}

.contact-form {
  background: rgba(255, 255, 255, 0.889);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  padding: 1.5rem;
  border-radius: 16px;
}

.contact-form h2 {
  font-size: 1.25rem;
  color: rgb(53, 3, 232);
  margin-bottom: 1rem;
  font-weight: 700;
  font-family: 'Inter', sans-serif;
  letter-spacing: -1.5px;
}

.form-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 0.9rem 1.2rem;
  font-size: 0.9rem;
  border-radius: 12px;
  color: #1a1a1a;
  transition: all 0.3s ease;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
  color: rgba(26, 26, 26, 0.6);
  font-weight: 500;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(59, 130, 246, 0.5);
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-group label {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: rgba(26, 26, 26, 0.6);
  pointer-events: none;
  transition: all 0.3s ease;
  background: transparent;
}

.form-group input:focus ~ label,
.form-group input:not(:placeholder-shown) ~ label,
.form-group textarea:focus ~ label,
.form-group textarea:not(:placeholder-shown) ~ label {
  top: -0.6rem;
  left: 0.8rem;
  font-size: 0.75rem;
  color: #3b82f6;
  background: rgba(237, 230, 230, 0);
  padding: 0 0.4rem;
}


.submit-btn {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  letter-spacing: 0.5px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
}

.submit-btn i {
  font-size: 1rem;
  transition: transform 0.3s ease;
}

.submit-btn:hover {
  background: linear-gradient(135deg, #0545cd, #1d4ed8);
  color: #ffffff;
  transform: scale(1.03);
  box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
}
.submit-btn:hover i {
  transform: translateX(4px);
}
.alert {
  margin-top: 1rem;
  padding: 1rem;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.alert.success {
  background: rgba(16, 185, 129, 0.1);
  border-color: rgba(16, 185, 129, 0.2);
  color: #10b981;
}

.alert.error {
  background: rgba(239, 68, 68, 0.1);
  border-color: rgba(239, 68, 68, 0.2);
  color: #ef4444;
}

@media (max-width: 768px) {
  .compact-contact {
    min-height: auto;
    padding: 1.5rem 0.75rem;
  }
  
  .contact-container {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  
  .contact-info h2,
  .contact-form h2 {
    font-size: 1.5rem;
  }
  
  .contact-form {
    padding: 1.5rem;
  }
}

@media (max-width: 480px) {
  .info-card {
    padding: 1rem;
  }
  
  .contact-form {
    padding: 1.5rem;
  }
  
  .form-group input,
  .form-group select,
  .form-group textarea {
    font-size: 0.875rem;
  }
}
</style>