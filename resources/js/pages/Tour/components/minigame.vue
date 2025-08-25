<template>
  <section id="minigame-container">
    <div class="game-container">
      <h2>Cultural Match Quest</h2>
      <p>Match all the cultural items to win!</p>
      <div class="game-board">
        <div
          v-for="(item, index) in shuffledItems"
          :key="index"
          class="card"
          :class="{ flipped: flippedCards.includes(index) || matchedCards.includes(index) }"
          @click="flipCard(index)"
        >
          <div class="card-inner">
            <div class="card-front" aria-label="Card front">?</div>
            <div class="card-back" aria-label="Card back">
              <img :src="getImageForItem(item)" :alt="item" />
              <div>{{ item }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="message">{{ message }}</div>
      <div class="buttons">
        <button class="restart-btn" @click="setupGame">Restart</button>
        <button class="help-btn" @click="showHelp = true">How to Play</button>
      </div>
    </div>
    <GameHelpGuide :is-open="showHelp" @close="showHelp = false" />
    <div v-show="showConfetti" class="confetti-container"></div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';
import GameHelpGuide from '@/components/GameHelpGuide.vue';

const items = ['Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort', 'Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort'];
const funFacts = reactive({
  "Sto Nino": 'The Santo Niño de Cebu is a small statue of the Child Jesus, found in a burned hut in Cebu in 1565, believed to be the same image gifted by Magellan to Queen Juana in 1521.',
  "Gazebo": 'Magellan’s Cross gazebo is an octagonal coral-stone structure built in 1834 beside the Basilica Minore del Santo Niño in Cebu to protect the historic cross planted by Magellan’s expedition.',
  "Sinulog": 'The Sinulog Festival is a vibrant cultural and religious celebration held every third Sunday of January in Cebu City, where devotees honor the Santo Niño through dance and devotion centered around the Basilica Minore del Santo Niño.',
  "Cross": 'what when why  of this if possible add details make it  short  because  its for thesis website: Santo Niño image in 1565, believed to be the one gifted by Magellan in 1521.',
  "Mural": 'The Magellan’s Cross mural was painted on the ceiling of the cross’s coral-stone gazebo in Cebu City, showing the 1521 baptism of Rajah Humabon and his people at the very site where Christianity was first introduced in the Philippines.',
  "Fort": 'Fort San Pedro is the oldest and smallest fort in the Philippines, built in 1565 by Spanish and Cebuano laborers under Miguel López de Legazpi in Cebu City’s Plaza Independencia to defend the first Spanish settlement.',
});

const shuffledItems = ref([]);
const flippedCards = ref([]);
const matchedCards = ref([]);
const message = ref('');
const showHelp = ref(false);
const showConfetti = ref(false);
const audio = new Audio('/sounds/success.mp3'); // Add your success sound file

const getImageForItem = (item) => {
  const images = {
    "Sto Nino": 'img/santo.jpg',
    "Gazebo": 'img/gazebo.jpg',
    "Sinulog": 'img/sinulog.jpg',
    "Cross": 'img/cross.jpg',
    "Mural": 'img/mural.jpg',
    "Fort": 'img/fort.jpg',
  };
  return images[item] || '';
};

const shuffle = (array) => {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
};

const setupGame = () => {
  shuffledItems.value = [...items];
  shuffle(shuffledItems.value);
  flippedCards.value = [];
  matchedCards.value = [];
  message.value = '';
};

const createConfetti = () => {
  const confettiContainer = document.querySelector('.confetti-container');
  for (let i = 0; i < 100; i++) {
    const confetti = document.createElement('div');
    confetti.className = 'confetti';
    confetti.style.left = Math.random() * 100 + 'vw';
    confetti.style.animationDelay = Math.random() * 2 + 's';
    confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
    confettiContainer.appendChild(confetti);
  }
};

const clearConfetti = () => {
  const confettiContainer = document.querySelector('.confetti-container');
  confettiContainer.innerHTML = '';
  showConfetti.value = false;
};

const celebrateWin = () => {
  showConfetti.value = true;
  audio.play();
  createConfetti();
  setTimeout(clearConfetti, 5000);
};

const flipCard = (index) => {
  if (flippedCards.value.length >= 2 || flippedCards.value.includes(index) || matchedCards.value.includes(index)) return;
  
  flippedCards.value.push(index);
  
  if (flippedCards.value.length === 2) {
    const [firstIndex, secondIndex] = flippedCards.value;
    if (shuffledItems.value[firstIndex] === shuffledItems.value[secondIndex]) {
      matchedCards.value.push(firstIndex, secondIndex);
      const matchedItem = shuffledItems.value[firstIndex];
      message.value = `Matched: ${matchedItem} — Fun fact: ${funFacts[matchedItem]}`;
      
      if (matchedCards.value.length === items.length) {
        message.value += ` Congratulations! You matched all items! Cultural hero! 🎉`;
        celebrateWin();
      }
      
      flippedCards.value = [];
    } else {
      setTimeout(() => {
        flippedCards.value = [];
        message.value = '';
      }, 1000);
    }
  }
};

onMounted(() => {
  setupGame();
});

onUnmounted(() => {
  audio.pause();
  audio.currentTime = 0;
  clearConfetti();
});
</script>

<style scoped>
 .game-container {  
  max-width: 800px;
  margin: 0 auto;
  background: rgb(255, 255, 255);
  padding: 20px;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(32, 32, 32, 0.2); /* Stronger and softer shadow */
  text-align: center;
  transition: box-shadow 0.3s ease-in-out;
}
.game-board {
  display: grid;
  grid-template-columns: repeat(4, auto);
  gap: 10px;
  justify-content: center;
  margin-top: 20px;
}

.card {
  width: 100px;
  height: 100px;
  perspective: 800px;
  cursor: pointer;
}

.card-inner {
  width: 100%;
  height: 100%;
  transition: transform 0.6s;
  transform-style: preserve-3d;
  position: relative;
}

.card.flipped .card-inner {
  transform: rotateY(180deg);
}

.card-front, .card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
  font-weight: bold;
}

.card-front {
  background-color: #ffc107;
  color: white;
  font-size: 20px;
}

.card-back {
  background-color: white;
  border: 2px solid #2e507c;
  transform: rotateY(180deg);
  font-size: 14px;
  color: #2e507c;
}

.card-back img {
  max-width: 80px;
  max-height: 60px;
  border-radius: 8px;
  margin-bottom: 6px;
  object-fit: cover;
}

.message {
  margin-top: 20px;
  color: green;
  font-weight: bold;
  min-height: 24px;
}

.restart-btn {
  background-color: #007bff;
  color: white;
  border-radius: 100px;
  padding: 0.40em 1.5em;    /* Makes the button taller and wider */
  min-width: 160px;         /* Ensures a minimum width */
  font-size: 1.1rem;        /* Optional: makes text a bit larger */
  border: none;             /* Optional: removes default border */
  cursor: pointer;          /* Optional: pointer cursor on hover */
  transition: background 0.2s;
}
.help-btn {
  background-color: #28a745;
  color: white;
  border-radius: 100px;
  padding: 0.40em 1.5em;
  min-width: 160px;
  font-size: 1.1rem;
  border: none;
  cursor: pointer;
  transition: background 0.2s;
  margin-left: 1rem;
}
.back-btn {
  background-color: #dc3545;
  color: white;
  border-radius: 6px;
}

#minigame-container {
  background-image: url('/img/minigame.jpg');
  background-size: cover;
  /* ...rest of your styles... */

  width: 100vw;
  height: 100vh;
  min-height: 100vh;
  min-width: 100vw;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  position: relative;
  overflow: auto;
}
@media (max-width: 600px) {
  #minigame-container {
    padding: 0;
    min-width: 100vw;
    min-height: 100vh;
  }
  .game-container {
    max-width: 98vw;
    padding: 10px;
    border-radius: 10px;
  }
  .game-board {
    grid-template-columns: repeat(2);
    gap: 8px;
   
  }
  .card {
    width: 70px;
    height: 70px;
     justify-content: center; /* <-- Add this line */
    align-items: center;
  }
  .card-back img {
    max-width: 50px;
    max-height: 36px;
  }
  .restart-btn {
    min-width: 120px;
    font-size: 1rem;
    padding: 0.4em 1em;
  }
  .help-btn {
    min-width: 120px;
    font-size: 1rem;
    padding: 0.4em 1em;
    margin-top: 1rem;
    margin-left: 0;
  }
}

.confetti-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  pointer-events: none;
  z-index: 1000;
}

.confetti {
  position: absolute;
  width: 10px;
  height: 10px;
  animation: fall 3s linear forwards;
}

@keyframes fall {
  0% {
    transform: translateY(-100vh) rotate(0deg);
    opacity: 1;
  }
  100% {
    transform: translateY(100vh) rotate(720deg);
    opacity: 0;
  }
}
</style>