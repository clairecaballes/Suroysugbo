<template>
  <section id="minigame-container">
    <div class="game-container">
      <h2>Cultural Match Quest</h2>
      
      <!-- Add difficulty selector -->
      <div class="difficulty-selector" v-if="!gameStarted">
        <h3>Select Difficulty</h3>
        <div class="difficulty-buttons">
          <button @click="startGame('easy')" class="diff-btn easy">Easy (3:00)</button>
          <button @click="startGame('medium')" class="diff-btn medium">Medium (2:00)</button>
          <button @click="startGame('hard')" class="diff-btn hard">Hard (1:00)</button>
        </div>
      </div>

      <!-- Add timer display -->
      <div v-if="gameStarted" class="timer" :data-time="timeLeft <= 10 ? 'low' : ''">
        Time Left: {{ formatTime(timeLeft) }}
      </div>

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
        <button class="restart-btn" @click="restartToChoices">Restart</button>
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
import Swal from 'sweetalert2';

const items = ['Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort', 'Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort'];

const funFacts = reactive({
  "Sto Nino": 'The Santo Niño de Cebu is a small statue of the Child Jesus, found in a burned hut in Cebu in 1565, believed to be the same image gifted by Magellan to Queen Juana in 1521.',
  "Gazebo": 'Magellan’s Cross gazebo is an octagonal coral-stone structure built in 1834 beside the Basilica Minore del Santo Niño in Cebu to protect the historic cross planted by Magellan’s expedition.',
  "Sinulog": 'The Sinulog Festival is a vibrant cultural and religious celebration held every third Sunday of January in Cebu City, where devotees honor the Santo Niño through dance and devotion centered around the Basilica Minore del Santo Niño.',
  "Cross": 'Planted in 1521 by Ferdinand Magellan’s expedition, Magellan’s Cross marks the arrival of Christianity in the Philippines. Located beside the Basilica Minore del Santo Niño in Cebu City, it symbolizes faith, history, and the beginning of Spanish influence.',
  "Mural": 'The Magellan’s Cross mural was painted on the ceiling of the cross’s coral-stone gazebo in Cebu City, showing the 1521 baptism of Rajah Humabon and his people at the very site where Christianity was first introduced in the Philippines.',
  "Fort": 'Fort San Pedro is the oldest and smallest fort in the Philippines, built in 1565 by Spanish and Cebuano laborers under Miguel López de Legazpi in Cebu City’s Plaza Independencia to defend the first Spanish settlement.'
});

const shuffledItems = ref([]);
const flippedCards = ref([]);
const matchedCards = ref([]);
const message = ref('');
const showHelp = ref(false);
const showConfetti = ref(false);
const audio = new Audio('/sounds/success.mp3');

const gameStarted = ref(false);
const timeLeft = ref(0);
const timerInterval = ref(null);
const difficulty = ref(''); // empty = no difficulty

const difficultyTimes = {
  easy: 180, // 3 minutes
  medium: 120, // 2 minutes
  hard: 60 // 1 minute
};

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
  if (timerInterval.value) clearInterval(timerInterval.value);
};

const restartToChoices = () => {
  if (timerInterval.value) {
    clearInterval(timerInterval.value);
    timerInterval.value = null;
  }
  setupGame();
  gameStarted.value = false;
  timeLeft.value = 0;
  difficulty.value = '';
  showConfetti.value = false;
  clearConfetti();
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
  clearInterval(timerInterval.value);
  showConfetti.value = true;
  audio.play();
  createConfetti();
  gameStarted.value = false;

  Swal.fire({
    title: 'Congratulations! 🎉',
    text: 'You\'ve completed the Cultural Match Quest!',
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: 'Play Again',
    cancelButtonText: 'Change Difficulty',
    background: '#fff',
    customClass: {
      popup: 'congratulations-modal',
      title: 'congratulations-title',
      confirmButton: 'congratulations-button',
      cancelButton: 'change-difficulty-button'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      startGame(difficulty.value);
    } else {
      setupGame();
      gameStarted.value = false;
    }
  });

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

      // Show fun fact only if no difficulty selected
      if (!difficulty.value) {
        message.value = `Matched: ${matchedItem} — Fun fact: ${funFacts[matchedItem]}`;
      } else {
        message.value = `Matched: ${matchedItem}`;
      }

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

const formatTime = (seconds) => {
  const mins = Math.floor(seconds / 60);
  const secs = seconds % 60;
  return `${mins}:${secs.toString().padStart(2, '0')}`;
};

const startGame = (level) => {
  difficulty.value = level; // sets difficulty
  timeLeft.value = difficultyTimes[level] || 0;
  gameStarted.value = true;
  setupGame();
  if (level) startTimer(); // start timer only if difficulty selected
};

const startTimer = () => {
  clearInterval(timerInterval.value);
  timerInterval.value = setInterval(() => {
    if (timeLeft.value > 0) {
      timeLeft.value--;
      if (timeLeft.value === 10) {
        Swal.fire({
          title: 'Hurry Up!',
          text: '10 seconds remaining!',
          icon: 'warning',
          timer: 2000,
          showConfirmButton: false,
          position: 'top-end',
          toast: true
        });
      }
    }
    if (timeLeft.value <= 0) {
      endGame(false);
    }
  }, 1000);
};

const endGame = (won = false) => {
  if (!won && gameStarted.value && timeLeft.value <= 0) {
    clearInterval(timerInterval.value);
    gameStarted.value = false;

    Swal.fire({
      title: 'Time\'s Up! ⏰',
      html: `
        <div class="times-up-modal">
          <p>Don't give up! Want to try again?</p>
          <div class="score-info">
            <p>Matched Pairs: ${matchedCards.value.length / 2}</p>
            <p>Remaining Pairs: ${(items.length - matchedCards.value.length) / 2}</p>
          </div>
        </div>
      `,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Try Again',
      cancelButtonText: 'Change Difficulty',
      allowOutsideClick: false,
      customClass: {
        popup: 'times-up-popup',
        confirmButton: 'try-again-button',
        cancelButton: 'change-difficulty-button'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        startGame(difficulty.value);
      } else {
        setupGame();
        gameStarted.value = false;
      }
    });
  }
};

onMounted(() => {
  setupGame();
});

onUnmounted(() => {
  clearInterval(timerInterval.value);
  audio.pause();
  audio.currentTime = 0;
  clearConfetti();
});
</script>


<style scoped>
.game-container {  
  max-width: 800px; /* Reduced from 800px */
  margin: 50px auto;
  background: rgba(255, 255, 255, 0.42);
  padding: 1.5rem; /* Reduced padding */
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(32, 32, 32, 0.46);
  text-align: center;
  display: block;
  visibility: visible;
  opacity: 1;
}

h2 {
  font-size: 2rem;
  margin-bottom: 1.5rem;
  text-align: center;
  font-weight: 700;
  display: block;
  visibility: visible;
  opacity: 1;
  position: relative;
  z-index: 10;
  
  /* Modern gradient text */
  background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 50%, #2563eb 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  
  /* Text effects */
  text-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
  letter-spacing: 1px;
  
  /* Hover animation */
  transition: all 0.3s ease;
}

.game-board {
  display: grid;
  grid-template-columns: repeat(4, auto);
  gap: 6px; /* Reduced gap */
  justify-content: center;
  margin-top: 1rem; /* Reduced margin */
}

.card {
  width: 90px; /* Reduced from 120px */
  height: 90px; /* Reduced from 120px */
  perspective: 1000px;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.card:hover {
  transform: translateY(-2px);
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
  color: rgba(255, 255, 255, 0.941);
  font-size: 30px;
}

.card-back {
  background: linear-gradient(to bottom, #ffffff, #f8fafc);
  border: 2px solid #3b82f6;
  transform: rotateY(180deg);
  font-size: 14px;
  color: #1e3a8a;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-back img {
  width: 80%;
  height: 55%;
  border-radius: 8px;
  margin-bottom: 6px;
  object-fit: cover;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
  border: 2px solid #e2e8f0;
  padding: 2px;
  background-color: white;
}

.card.flipped:hover .card-back img {
  transform: scale(1.05);
}

.card-back div {
  font-weight: 600;
  font-size: 12px;
  color: #2563eb;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  word-wrap: break-word;
  white-space: normal;
  padding: 0 4px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  line-height: 1.2;
}

.message {
  margin-top: 1.5 rem;
  color: rgb(0, 0, 0);
  font-weight: bold;
  min-height: 20px;
  background-color: #ffffff60;
}

.restart-btn {
  background-color: #007bff;
  color: white;
  border-radius: 150px;
  padding: 0.40em 1.5em;    /* Makes the button taller and wider */
  min-width: 150px;         /* Ensures a minimum width */
  font-size: 1rem;        /* Optional: makes text a bit larger */
  border: none;             /* Optional: removes default border */
  cursor: pointer;          /* Optional: pointer cursor on hover */
  transition: background 0.2s;
}
.help-btn {
  background-color: #007bff;
  color: white;
  border-radius: 150px;
  padding: 0.40em 1.5em;    /* Makes the button taller and wider */
  min-width: 150px;         /* Ensures a minimum width */
  font-size: 1rem;        /* Optional: makes text a bit larger */
  border: none;             /* Optional: removes default border */
  cursor: pointer;          /* Optional: pointer cursor on hover */
  transition: background 0.2s;
  margin-left: 1rem;
}
.help-btn:hover {
background: #3414ea; /* darker green */
  box-shadow: 0 6px 16px rgba(34, 48, 197, 0.4);
  transform: translateY(-2px);
}
.restart-btn:hover {
 background: #3414ea; /* darker green */
  box-shadow: 0 6px 16px rgba(34, 48, 197, 0.4);
  transform: translateY(-2px);
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
    width: 100vw;
    height: 100vh;
  }

  .game-container {
    max-width: 90vw;
    min-height: 70vh;
    padding: 1rem;
  }

  .game-board {
    grid-template-columns: repeat(4, 1fr);
    gap: 6px;
  }

  .card {
    width: 75px;  /* Slightly larger on small screens */
    height: 75px;
  }

  .card-back img {
    width: 85%;
    height: auto; /* fixed invalid % */
  }

  .card-back div {
    font-size: 11px;
  }

  .restart-btn,
  .help-btn {
    min-width: 120px;
    font-size: 1rem;
    padding: 0.4em 1em;
  }

  .help-btn {
    margin-top: 1rem;
    margin-left: 0;
  }

  .diff-btn.easy,
  .diff-btn.medium,
  .diff-btn.hard {
    padding: 0.4rem 1rem;
    font-size: 0.8rem;
    min-width: 80px;
  }

  h2 {
    font-size: 1.2rem;
    text-align: center;
    margin-bottom: 1rem;
  }
}

  .h2{
    font-size: .5rem;
    font-weight: 700;
    color: #ffffff;
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
  width: 8px;
  height: 16px;
  background-color: var(--confetti-color);
  animation: fall 4s linear forwards, sway 2s ease-in-out infinite alternate;
}

@keyframes fall {
  0% {
    transform: translateY(-100vh) rotate(0deg);
    opacity: 1;
  }
  90% {
    opacity: 1;
  }
  100% {
    transform: translateY(100vh) rotate(720deg);
    opacity: 0;
  }
}

@keyframes sway {
  0% {
    transform: translateX(-5px) rotate(-15deg);
  }
  100% {
    transform: translateX(5px) rotate(15deg);
  }
}

/* SweetAlert Custom Styles */
:deep(.congratulations-modal) {
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 0 30px rgba(0,0,0,0.1);
}

:deep(.congratulations-title) {
  color: #2563eb;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

:deep(.congratulations-button) {
  background: linear-gradient(to right, #3b82f6, #2563eb);
  color: white;
  border-radius: 8px;
  padding: 12px 24px;
  font-weight: 600;
  transition: all 0.3s ease;
}

:deep(.congratulations-button:hover) {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.difficulty-selector {
  margin-bottom: 2.5 rem;
  padding: 1.2 rem;
  background: rgba(255, 255, 255, 0.004);
  border-radius: 12px;
}

.difficulty-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 1.5 rem;
}

.diff-btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.diff-btn.easy {
  background: #22c55e;
  color: white;
}

.diff-btn.medium {
  background: #f59e0b;
  color: white;
}

.diff-btn.hard {
  background: #ef4444;
  color: white;
}

/* Hover effects */
.diff-btn.easy:hover {
  background: #038c35; /* darker green */
  box-shadow: 0 6px 16px rgba(34, 197, 94, 0.4);
  transform: translateY(-2px);
}

.diff-btn.medium:hover {
  background: #e67c03; /* darker amber */
  box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
  transform: translateY(-2px);
}

.diff-btn.hard:hover {
  background: #dc2626; /* darker red */
  box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
  transform: translateY(-2px);
}

.timer {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e3a8a;
  margin: 1.8  rem 0;
  padding: 0.5rem 1rem;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 8px;
  display: inline-block;
  transition: color 0.3s ease;
}

.timer[data-time="low"] {
  color: #ef4444;
  animation: pulse 1s infinite;
}

@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0.5; }
  100% { opacity: 1; }
}

/* Mobile Responsive Styles */
@media (max-width: 768px) {
  .game-container {
    max-width: 100%;
    margin: 30px auto;
    padding: 1rem;
  }

  h2 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    text-align: center;
    color: #1e3a8a;
  }

  .game-board {
    grid-template-columns: repeat(3, auto);
    gap: 8px;
  }

  .card {
    width: 100px;
    height: 100px;
  }

  .card-front {
    font-size: 26px;
  }

  .card-back div {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .game-board {
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
    padding: 0 8px;
  }

  .card {
    width: 100%;
    height: auto;
    aspect-ratio: 1;
    min-width: 75px;
    max-width: 110px;
  }

  .card-front {
    font-size: 22px;
  }

  .card-back {
    font-size: 13px;
  }

  .card-back div {
    font-size: 11px;
    line-height: 1.1;
    padding: 0 3px;
  }

  .card-back img {
    height: 65%;
    margin-bottom: 6px;
  }
}

/* Times Up Modal Styles */
:deep(.times-up-popup) {
  border-radius: 16px;
  padding: 2rem;
}

.times-up-modal {
  text-align: center;
  margin: 1rem 0;
}

.score-info {
  margin-top: 1rem;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 8px;
}

.score-info p {
  margin: 0.5rem 0;
  color: #1e3a8a;
  font-weight: 500;
}
</style>