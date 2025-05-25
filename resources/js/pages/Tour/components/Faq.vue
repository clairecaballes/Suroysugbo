<template>
  <section id="faq-section" class="faq-section">
    <div class="faq-header">
      <h2>Frequently Asked Questions</h2>
      <!-- You can implement search later with Vue -->
      <!-- <input type="text" v-model="search" placeholder="Search FAQs..." class="faq-search" /> -->
    </div>

    <div class="faq-item" v-for="(faq, idx) in faqs" :key="idx">
      <button class="faq-question" @click="toggle(idx)">
        {{ faq.question }}
      </button>
      <div class="faq-answer" v-show="openIndex === idx">
        <p>{{ faq.answer }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const openIndex = ref(null)

const faqs = [
  {
    question: "What is the purpose of this website?",
    answer: "This website aims to promote awareness and appreciation of Cebu’s cultural heritage by showcasing important historical sites, traditions, and local customs, along with pictures and directions to visit them."
  },
  {
    question: "Are these heritage sites open to the public?",
    answer: "Most of the featured sites are open to the public, but some may have specific visiting hours or entrance fees. It's best to check in advance or contact local tourism offices."
  },
  {
    question: "How can I help preserve Cebu’s cultural heritage?",
    answer: "You can help by visiting respectfully, spreading awareness, supporting local artisans and heritage programs, and following preservation guidelines set by communities or heritage groups."
  },
  {
    question: "Are local transportation options like jeepneys safe for tourists?",
    answer: "Jeepneys are widely used and affordable. While generally safe, tourists should stay alert, avoid crowded rides at night, and keep personal items secure."
  }
]

function toggle(idx) {
  openIndex.value = openIndex.value === idx ? null : idx
}
</script>

