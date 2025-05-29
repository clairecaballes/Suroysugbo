<template>
  <section id="compact-contact" class="compact-contact">
    <div class="contact-card">
      <!-- Left: Info -->
      <div class="contact-left">
        <h2>Contact Us</h2>
        <p class="contact-description">We’re here to help! Reach out to us anytime.</p>
        <ul class="contact-details">
          <li>
  <i class="fas fa-phone-alt"></i>
  <a href="tel:+639060490920" style="color:inherit;text-decoration:underline;">
    +63 906 049 0920
  </a>
</li>
          <li>
        <i class="fas fa-envelope"></i>
        <a href="mailto:cleyrni@gmail.com" style="color:inherit;text-decoration:underline;">
    cleyrni@gmail.com
  </a>
</li>
          <li><i class="fas fa-map-marker-alt"></i> Cogon Danao, City</li>
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

<style scoped>
#compact-contact {
  min-height: 100vh;
  width: 100vw;
  display: flex;
  justify-content: center;
  align-items: center;
  
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  


}

@media (max-width: 500px) {

  .contact-left {
    align-items: center;
    text-align: center;
  }
  .contact-image {
    max-width: 90vw;
    margin: 18px auto 0 auto;
  }
}















</style>