<template>
  <section class="user-ratings">
    <h3 class="section-title">Share Your Experience</h3>

    <div class="reviews-grid">
      <div class="review-card" v-for="(review, index) in reviews" :key="index" :style="review.style">
        <div class="review-header">
          <span class="reviewer-name">{{ review?.name }}</span>
         <span class="stars">
          <span v-for="star in review?.rating" :key="star" class="active">★</span>
          <span v-for="star in 5 - review?.rating" :key="star" class="">★</span>
        </span>
        </div>
        <p class="review-text">"{{ review.message }}"</p>
      </div>
    </div>
    <p>Want to leave a rating? <a href="#" class="leave-review-link" @click.prevent="openReviewModal">Leave a review</a>
    </p>

    <!-- Review Modal -->
    <div v-if="showReviewModal" class="modal-overlay">
      <div class="modal">
        <div class="modal-content">
          <h2 class="modal-title">Share Your Experience</h2>
          <form @submit.prevent="submitReview" class="review-form">
            <div class="rating-group">
              <label class="rating-label">Your Rating:</label>
              <div class="stars">
                <span v-for="star in 5" :key="star" @click="setRating(star)" 
                      :class="{ active: star <= rating }">★</span>
              </div>
            </div>

            <div class="form-group">
              <label for="reviewerName">Name</label>
              <input id="reviewerName" type="text" v-model="reviewerName" required>
            </div>

            <div class="form-group">
              <label for="comment">Your Review</label>
              <textarea id="comment" v-model="reviewComment" rows="4"></textarea>
            </div>

            <div class="form-group">
              <label for="email">Email (Optional)</label>
              <input id="email" type="email" v-model="reviewEmail">
            </div>

            <div class="modal-buttons">
              <button type="submit" class="submit-btn">Submit Review</button>
              <button type="button" class="cancel-btn" @click="closeReviewModal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
const showReviewModal = ref(false);
const reviewerName = ref('');
const reviewComment = ref('');
const reviewEmail = ref('');
const rating = ref(0);
const reviews = ref([]); // Store fetched reviews

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

onMounted(() => {
  axios.get('/api/show-publish-review')
    .then(response => {
      reviews.value = response.data.review;
    })
    .catch(error => {
      console.error('Error fetching Cebu Legacy data:', error)
    })
})
</script>

<style scoped>




.user-ratings {
  position: relative; /* required for ::before absolute */
  padding-top: 2rem;
  
}

.section-title {
  position: relative;
  margin-top: 0;  /* Remove the space above */
  margin-bottom: 2rem; /* Keep space below */
  font-size: 2rem; /* bigger for impact */
  font-weight: 800;
  font-family: 'Inter', sans-serif;
  text-align: center;
  letter-spacing: -1px;
  color: transparent;

  /* Gradient text */

   background: linear-gradient(95deg, #20ffffff, #070bffff, #006eff);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.06);
}

.reviews-grid {
  display: flex;
  overflow-x: auto;
  gap: 1.5rem;
  margin-bottom: 2.5rem;
  padding: 1rem 0;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none; /* Firefox */
}

.reviews-grid::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Edge */
}

.review-card {
  flex: 0 0 340px;
  scroll-snap-align: start;
  min-width: 340px;
  animation: fadeIn 0.6s ease-out forwards;
  animation-delay: calc(var(--index, 0) * 0.1s);
  opacity: 0;
  background: linear-gradient(135deg, #ffffffff 0%, #8dcffcff 50%, #f5f3ff 100%);
  border-radius: 16px;
  padding: 2rem;
  width: 340px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.14);
  transition: all 0.3s ease;
  border: 1px solid rgba(139, 92, 246, 0.1);
}

.review-card:hover {
  transform: translateY(-5px);
  background: linear-gradient(135deg, #f0f9ff 0%, #cfffffff 50%, #f8fafc 100%);
  border-color: rgba(59, 130, 246, 0.3);
  box-shadow: 0 12px 24px rgba(171, 255, 248, 1);
}

.review-text {
  transition: color 0.3s ease;
}

.review-card:hover .review-text {
  color: #0369a1;
}

.review-card:hover .stars .active {
  color: #0ea5e9;
}

.leave-review-link {
  font-weight: bold;
  font-style: italic;
  transition: color 0.3s ease;
}

.leave-review-link:hover {
  color: #0369a1;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal {
  background: white;
  border-radius: 20px;
  padding: 2rem;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  /* Keep modal within viewport and allow internal scrolling on very small screens */
  max-height: calc(100vh - 48px);
  overflow-y: auto;
}

.modal-title {
  color: #1e3a8a;
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 2rem;
  text-align: center;
}

.rating-group {
  margin-bottom: 2rem;
  text-align: center;
}

.rating-label {
  display: block;
  color: #4b5563;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.stars {
  font-size: 2rem;
}

.stars span {
  color: #d1d5db;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.stars span:hover,
.stars span.active {
  color: #fbbf24;
  transform: scale(1.2);
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  color: #4b5563;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #f9fafb;
}

.form-group input:focus,
.form-group textarea:focus {
  border-color: #3b82f6;
  background: white;
  outline: none;
}

.modal-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.submit-btn,
.cancel-btn {
  flex: 1;
  padding: 0.75rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
}

/* Responsive adjustments for very small screens */
@media (max-width: 480px) {
  .modal {
    padding: 1rem;
    width: 95%;
    max-width: 420px;
  }

  .modal-title {
    font-size: 1.25rem;
    margin-bottom: 1rem;
  }

  .stars {
    font-size: 1.5rem;
  }

  .form-group input,
  .form-group textarea {
    padding: 0.5rem;
    font-size: 0.9rem;
  }

  .modal-buttons {
    flex-direction: column;
    gap: 0.75rem;
  }

  .submit-btn,
  .cancel-btn {
    width: 100%;
    flex: none;
  }
}

/* Slightly smaller spacing for small tablets/medium phones */
@media (max-width: 768px) {
  .modal {
    max-width: 520px;
  }

  .review-card {
    flex: 0 0 300px;
    min-width: 300px;
  }
}

.submit-btn {
  background: #1e3a8a;
  color: white;
}

.submit-btn:hover {
  background: #1e40af;
  transform: translateY(-2px);
}

.cancel-btn {
  background: #f3f4f6;
  color: #4b5563;
}

.cancel-btn:hover {
  background: #e5e7eb;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px) {
  .user-ratings {
    padding-top: 4rem;
  }
  
  .fade-background::before {
    height: 100px;
  }
  
  .section-title {
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
  }

  .modal {
    padding: 1.5rem;
    margin: 1rem;
  }

  .modal-title {
    font-size: 1.5rem;
  }

  .stars {
    font-size: 1.75rem;
  }

  .form-group input,
  .form-group textarea {
    padding: 0.625rem;
    font-size: 0.875rem;
  }

  .submit-btn,
  .cancel-btn {
    padding: 0.625rem;
    font-size: 0.875rem;
  }

  .review-card {
    flex: 0 0 280px;
    min-width: 280px;
    padding: 1.5rem;
  }
}
</style>