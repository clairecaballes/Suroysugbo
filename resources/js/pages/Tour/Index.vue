<template>
  <PageNav/>
  <PageHeader/>
  <CebuLegacy />
  <Contact />
  <Faq />
  <UserReview />
  <PageFooter/>
</template>

<script setup>
import { ref } from 'vue'
import PageNav from './components/Nav.vue'
import PageHeader from './components/Header.vue'
import CebuLegacy from './components/CebuLegacy.vue'
import Contact from './components/Contact.vue'
import PageFooter from './components/Footer.vue'
import Faq from './components/Faq.vue'
import UserReview from './components/UserReview.vue'
</script>

<style scoped>

</style>