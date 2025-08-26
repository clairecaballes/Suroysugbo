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
              <a href="https://mail.google.com/mail/?view=cm&to=cleyrni@gmail.com" target="_blank">
                cleyrni@gmail.com
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
            <input type="text" v-model="form.name" required>
            <label>Your Name</label>
          </div>
          
          <div class="form-group">
            <input type="email" v-model="form.email" required>
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
            <textarea v-model="form.message" required></textarea>
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
  min-height: 100vh;
  background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
  padding: 2rem;
}

.contact-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  padding: 2rem;
}

.contact-info h2,
.contact-form h2 {
  font-size: 2rem;
  font-family: 'Inter', sans-serif;
  color: #1a365d; /* Darker blue */
  margin-bottom: 1.5rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.contact-description {
  color: #121a25;
  margin-bottom: 2rem;
  font-size: 1.1rem;
  line-height: 1.6;
}

.contact-cards {
  display: grid;
  gap: 1rem;
}

.info-card {
  display: flex;
  align-items: center;
  gap: rem;
  padding: 1.5rem;
  background: rgb(17, 0, 255);
  border-radius: 12px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.info-card:hover {
  transform: translateY(-2px);
}

.info-card i {
  font-size: 1.5rem;
  color: #000000;
  width: 40px;
  text-align: center;
}

.info-content h3 {
  font-size: 1rem;
  color: #ffffff;
  margin-bottom: 0.25rem;
}

.info-content a,
.info-content p {
  color: #ffffff;
  text-decoration: none;
}

.contact-form {
  background: #1a365d;
  padding: 2.5rem;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
  color: white;
}

.contact-form h2 {
  font-size: 2.25rem;
  color: white;
  margin-bottom: 2rem;
  font-weight: 700;
  font-family: 'Inter', sans-serif;
  letter-spacing: -0.5px;
}

.form-group {
  position: relative;
  margin-bottom: 1.5rem;
}
.form-group label {
  transition: all 0.3s ease;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.05);
  color: rgb(249, 247, 247);
  font-size: 1rem;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s;
}

.form-group label {
  position: absolute;
  left: 1rem;
  top: 0.75rem;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.3s;
  pointer-events: none;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  background: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.3);
}

.form-group input::placeholder,
.form-group textarea::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.submit-btn {
  width: 100%;
  padding: 1.25rem;
  background: white;
  color: #1a365d;
  font-weight: 600;
  font-size: 1.1rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  cursor: pointer;
  transition: all 0.3s;
}

.submit-btn:hover {
  background: #f8fafc;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
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
  .contact-container {
    grid-template-columns: 1fr;
    padding: 1rem;
    gap: 2rem;
  }
  
  .compact-contact {
    padding: 1rem;
  }
  
  .contact-info h2,
  .contact-form h2 {
    font-size: 1.5rem;
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