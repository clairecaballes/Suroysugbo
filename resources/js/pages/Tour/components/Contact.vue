<template>
  <section id="compact-contact" class="compact-contact">
    <div class="contact-card">
      <!-- Left: Info -->
      <div class="contact-left">
        <h2>Contact Us</h2>
        <p class="contact-description">We’re here to help! Reach out to us anytime.</p>
        <ul class="contact-details">
          <li><i class="fas fa-phone-alt"></i> +1 (123) 456-7890</li>
          <li><i class="fas fa-envelope"></i> contact@yourdomain.com</li>
          <li><i class="fas fa-map-marker-alt"></i> 1234 Your Street, City</li>
        </ul>
        <img src="img/contact.png" alt="Contact" class="contact-image">
      </div>

      <!-- Right: Form -->
      <div class="contact-right">
        <form @submit.prevent="submitForm">
          <input type="text" v-model="form.name" placeholder="Your Name" required>
          <input type="email" v-model="form.email" placeholder="Your Email" required>
          <select v-model="form.subject" required>
            <option value="" disabled selected hidden>Choose a Subject</option>
            <option value="jeepney">Jeepney Fare</option>
            <option value="modes">Transportation Modes</option>
            <option value="others">Others</option>
          </select>
          <textarea v-model="form.message" placeholder="Your Message" required></textarea>
          <button type="submit">Send</button>
        </form>
        <div v-if="successMessage" style="color:green; margin-top:1rem;">{{ successMessage }}</div>
        <div v-if="errorMessage" style="color:red; margin-top:1rem;">{{ errorMessage }}</div>
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