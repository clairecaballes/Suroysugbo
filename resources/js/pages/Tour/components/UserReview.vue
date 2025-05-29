<template>
  <section class="user-ratings">
    <h3>User Reviews</h3>

    <div class="reviews-grid">
      <div class="review-card">
        <div class="review-header">
          <span class="reviewer-name">Maria L.</span>
          <span class="stars">★★★★★</span>
        </div>
        <p class="review-text">"An amazing cultural experience! Highly recommended for history lovers."</p>
      </div>

      <div class="review-card">
        <div class="review-header">
          <span class="reviewer-name">James T.</span>
          <span class="stars">★★★★☆</span>
        </div>
        <p class="review-text">"Great photos and directions! I just wish there were more food spots listed."</p>
      </div>

      <div class="review-card">
        <div class="review-header">
          <span class="reviewer-name">Ana G.</span>
          <span class="stars">★★★★★</span>
        </div>
        <p class="review-text">"I learned a lot about Cebu. Especially loved the story behind Magellan’s Cross!"</p>
      </div>
    </div>

    <p>Want to leave a rating? <a href="#" class="leave-review-link" @click.prevent="openReviewModal">Leave a review</a></p>

    <!-- Review Modal -->
    <div v-if="showReviewModal" class="modal">
      <div class="modal-content">
        <h2>Leave a Review</h2>
        <form @submit.prevent="submitReview">
          <!-- Star Rating -->
          <label>Your Rating:</label>
          <div class="stars">
            <span
              v-for="star in 5"
              :key="star"
              @click="setRating(star)"
              :class="{ active: star <= rating }"
            >★</span>
          </div>

          <!-- Name Field -->
          <div class="form-group">
            <label for="reviewerName">Your Name:</label>
            <input
              id="reviewerName"
              type="text"
              v-model="reviewerName"
              placeholder="Enter your name"
              required
              class="input-box"
            >
          </div>

          <!-- Comment -->
          <textarea
            id="comment"
            v-model="reviewComment"
            placeholder="Share your thoughts..."
          ></textarea>

          <!-- Optional Email -->
          <div class="form-group">
            <label for="email">Optional Email:</label>
            <input
              id="email"
              type="email"
              v-model="reviewEmail"
              placeholder="Enter your email"
              class="input-box"
            >
          </div>

          <!-- Submit Button -->
          <div class="modal-buttons">
            <button type="submit">Submit Review</button>
            <button type="button" @click="closeReviewModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
const showReviewModal = ref(false);
const reviewerName = ref('');
const reviewComment = ref('');
const reviewEmail = ref('');
const rating = ref(0);

const openReviewModal = () => {
  showReviewModal.value = true;
};

const closeReviewModal = () => {
  showReviewModal.value = false;
  reviewComment.value = '';
  reviewEmail.value = '';
  reviewerName.value = '';
  rating.value = 0;
};

const setRating = (star) => {
  rating.value = star;
};

const submitReview = () => {
  axios.post('/review-post', {
    name: reviewerName.value,
    message: reviewComment.value,
    email: reviewEmail.value,
    rating: rating.value
  }).then(() => {
       Swal.fire({ // Show success message
                icon: 'success',
                title: 'Success!',
                text: 'Thank you for your review!',
                confirmButtonText: 'OK'
            });
    closeReviewModal();
  });
};
</script>

<style scoped>
.leave-review-link {
  font-weight: bold;
  color: #007bff;
  text-decoration: underline;
  cursor: pointer;
}

.leave-review-link:hover {
  color: #0056b3;
}

.form-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 12px;
}

.form-group label {
  font-weight: 500;
  margin-bottom: 4px;
  color: #222;
}

.input-box {
  width: 100%;
  padding: 8px 12px;
  border-radius: 6px;
  border: 1.5px solid #cfd8dc;
  font-size: 1rem;
  background: #f7faff;
  box-sizing: border-box;
  margin-bottom: 0;
}

.user-ratings {
  padding: 4rem 1rem;
  text-align: center;
}

.reviews-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}

.review-card {
  background-color: #f8f8f8;
  border-radius: 12px;
  padding: 1.5rem;
  width: 300px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.review-header {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  margin-bottom: 1rem;
}

.reviewer-name {
  font-weight: bold;
  color: #007bff;
  text-align: left;
  flex: 1;
  margin-right: auto;
}

.review-text {
  color: #222;
  font-size: 1rem;
}

.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgb(252, 252, 252);
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  min-width: 320px;
  max-width: 95vw;
}

.modal-content {
  display: flex;
  flex-direction: column;
}

.stars {
  font-size: 24px;
  cursor: pointer;
  margin-bottom: 10px;
}

.stars span {
  color: gray;
  transition: color 0.3s;
  cursor: pointer;
}

.stars span:hover,
.stars span.active {
  color: gold;
}

textarea,
input[type="email"] {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #cfd8dc;
  font-size: 1rem;
  resize: vertical;
}

button {
  margin-top: 10px;
  padding: 8px;
  border: none;
  background: #007bff;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}

.modal-buttons {
  display: flex;
  gap: 12px;
  margin-top: 10px;
}

@media (max-width: 900px) {
  .reviews-grid {
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }

  .review-card {
    width: 90vw;
    min-width: 0;
    max-width: 400px;
    margin: 0 auto;
    padding: 1rem;
  }
}

@media (max-width: 600px) {
  .user-ratings {
    padding: 2rem 0.5rem;
  }

  .reviews-grid {
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
  }

  .review-card {
    width: 98vw;
    max-width: 98vw;
    min-width: 0;
    padding: 0.75rem;
    font-size: 0.98rem;
  }

  .modal {
    min-width: 98vw;
    max-width: 98vw;
    padding: 8px;
  }

  .modal-content {
    padding: 0;
  }

  .stars {
    font-size: 20px;
  }

  .input-box,
  textarea,
  input[type="email"] {
    font-size: 0.98rem;
    padding: 7px 10px;
  }

  button {
    font-size: 0.98rem;
    padding: 7px;
  }
}
</style>