<template>
  <div class="help-overlay" v-if="isOpen" @click.self="close">
    <div class="help-content">
      <button class="close-btn" @click="close">&times;</button>
      <h3>How to Play Cultural Match Quest</h3>
      <div class="instructions">
        <ol>
          <li>Find matching pairs of cultural items by flipping cards</li>
          <li>Click on any card to reveal the cultural item</li>
          <li>Try to match another card with the same item</li>
          <li>If the cards match, they'll stay face up</li>
          <li>If they don't match, they'll flip back</li>
          <li>Learn interesting facts about each matched pair</li>
          <li>Match all cards to win the game!</li>
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

const close = () => {
  emit('close');
};
</script>

<style scoped>
.help-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.help-content {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  max-width: 500px;
  width: 90%;
  position: relative;
  max-height: 80vh;
  overflow-y: auto;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  padding: 5px;
}

.instructions {
  margin: 1rem 0;
}

.tips {
  margin-top: 1rem;
  padding: 1rem;
  background: #f5f5f5;
  border-radius: 8px;
}

h3 {
  color: #2e507c;
  margin-bottom: 1rem;
}

ol li, ul li {
  margin: 0.5rem 0;
  line-height: 1.4;
}
</style>
