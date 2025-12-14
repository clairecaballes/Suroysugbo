<template>
  <div class="help-overlay" v-if="isOpen" @click.self="close">
    <div class="help-content">
      <button class="close-btn" @click="close">&times;</button>
      <h3>How to Play Cultural Match Quest</h3>

      <div class="instructions">
        <ol>
          <li>Flip the cards to find matching pairs of cultural items.</li>
          <li>Click any card to reveal the item.</li>
          <li>Try to find another card with the same item to make a match.</li>
          <li>If the cards match, they will remain face up.</li>
          <li>If they don’t match, they will flip back over.</li>
          <li>
            When no difficulty is chosen, you can learn interesting facts about each matched pair.  
            <strong>Note:</strong> If you select a difficulty level, only the names of the items will be shown, not the fun facts.
          </li>
          <li>Match all the cards to win the game!</li>
        </ol>
      </div>

      <div class="tips">
        <h4>Tips:</h4>
        <ul>
          <li>Try to remember the locations of cards you've seen</li>
          <li>Take your time to read the fun facts about matches</li>
          <li>Use the Restart button any time to shuffle and start over</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  isOpen: Boolean
});

const emit = defineEmits(['close']);

const close = () => emit('close');
</script>

<style scoped>
/* Overlay */
.help-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease forwards;
}

/* Content card */
.help-content {
  position: relative; /* Ensure button is inside */
  background: #ffffff;
  padding: 2rem 2.5rem;
  border-radius: 16px;
  max-width: 520px;
  width: 90%;
  max-height: 80vh;
  overflow-y: auto;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  font-family: 'Poppins', sans-serif;
}

/* Close button */
.close-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  background: #f0f0f0;
  border: none;
  font-size: 24px;
  font-weight: bold;
  border-radius: 50%;
  cursor: pointer;
  width: 36px;
  height: 36px;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10; /* Ensure it's above content */
}

/* Headings */
h3 {
  color: #1f3a63;
  margin-bottom: 1.2rem;
  font-size: 1.5rem;
  text-align: center;
}

h4 {
  margin-bottom: 0.8rem;
  color: #2e507c;
  font-size: 1.2rem;
  border-bottom: 1px solid #dcdcdc;
  padding-bottom: 0.3rem;
}

/* Instructions & Tips */
.instructions ol,
.tips ul {
  padding-left: 1.2rem;
}

.instructions li,
.tips li {
  margin: 0.6rem 0;
  line-height: 1.5;
  font-size: 0.95rem;
}

.tips {
  margin-top: 1.5rem;
  padding: 1rem 1.2rem;
  background: #f5f7fa;
  border-radius: 12px;
}

/* Scrollbar styling */
.help-content::-webkit-scrollbar {
  width: 8px;
}

.help-content::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 8px;
}

.help-content::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 8px;
}

/* Fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
