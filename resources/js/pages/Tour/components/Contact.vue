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
        <form id="contactForm">
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Your Email" required>
          <select name="subject" required>
            <option value="" disabled selected hidden>Choose a Subject</option>
            <option value="jeepney">Jeepney Fare</option>
            <option value="modes">Transportation Modes</option>
            <option value="others">Others</option>
          </select>
          <textarea name="message" placeholder="Your Message" required></textarea>
          <button type="submit">Send</button>
        </form>
      </div>

    </div>
  </section>
</template>