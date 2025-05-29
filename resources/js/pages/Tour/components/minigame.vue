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
       
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      items: ['Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort', 'Sto Nino', 'Gazebo', 'Sinulog', 'Cross', 'Mural', 'Fort'],
      funFacts: {
        "Sto Nino": 'Santo Niño image in 1565, believed to be the one gifted by Magellan in 1521.',
        "Gazebo": 'Built in 1834 to protect the cross',
        "Sinulog": 'Sinulog Festival is held annually to honor the Santo Niño, with movements symbolizing the waves that brought Christianity to Cebu',
        "Cross": 'Magellan planted the cross in 1521, marking the arrival of Christianity in the Philippines.',
        "Mural": 'Shows the baptism of Rajah Humabo',
        "Fort": 'Fort San Pedro is the oldest and smallest fort in the Philippines.',
      },
      shuffledItems: [],
      flippedCards: [],
      matchedCards: [],
      message: '',
    };
  },
  methods: {
    getImageForItem(item) {
      const images = {
        "Sto Nino": 'img/santo.jpg',
        "Gazebo": 'img/gazebo.jpg',
        "Sinulog": 'img/sinulog.jpg',
        "Cross": 'img/cross.jpg',
        "Mural": 'img/mural.jpg',
        "Fort": 'img/fort.jpg',
       
      };
      return images[item] || '';
    },
    shuffle(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
      }
    },
    setupGame() {
      this.shuffledItems = [...this.items];
      this.shuffle(this.shuffledItems);
      this.flippedCards = [];
      this.matchedCards = [];
      this.message = '';
    },
    flipCard(index) {
      if (this.flippedCards.length >= 2 || this.flippedCards.includes(index) || this.matchedCards.includes(index)) return;
      
      this.flippedCards.push(index);
      
      if (this.flippedCards.length === 2) {
        const [firstIndex, secondIndex] = this.flippedCards;
        if (this.shuffledItems[firstIndex] === this.shuffledItems[secondIndex]) {
          this.matchedCards.push(firstIndex, secondIndex);
          const matchedItem = this.shuffledItems[firstIndex];
          this.message = `Matched: ${matchedItem} — Fun fact: ${this.funFacts[matchedItem]}`;
          
          if (this.matchedCards.length === this.items.length) {
            this.message += ` Congratulations! You matched all items! Cultural hero! 🎉`;
          }
          
          this.flippedCards = [];
        } else {
          setTimeout(() => {
            this.flippedCards = [];
            this.message = '';
          }, 1000);
        }
      }
    },
    goBack() {
      this.$router.go(-1);
    },
  },
  mounted() {
    this.setupGame();
  },
};
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
}



</style>