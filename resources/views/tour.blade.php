<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Explore Cebu</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Iconscout Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />

  <!-- External Stylesheet -->
 <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      background-color: #f8f9fa;
      color: #333;
      line-height: 1.6;
    }

    nav {
      background-color: #007bff;
      color: white;
      padding: 1rem 0;
    }

    .nav_container {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 1rem;
    }

    .nav_container h4 {
      font-size: 1.5rem;
    }

    .nav_menu {
      display: flex;
      list-style: none;
      gap: 1.5rem;
    }

    .nav_menu a {
      text-decoration: none;
      color: white;
      font-weight: 500;
    }

    .signup-btn {
      background: white;
      color: #007bff;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      font-weight: bold;
    }

/* Header Section */
.header {
  padding: 4rem 1rem;
  background-color: #061e36;
}

.header-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: auto;
  gap: 2rem;
  flex-wrap: wrap;
}

.header-left {
  flex: 1;
}

.header-left h1 {
  font-size: 2.5rem;
  color: #007bff;
  margin-bottom: 1rem;
}

.header-left p {
  font-size: 1.1rem;
  color: #ffffff;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.btn-primary {
  background-color: #4fa7ff;
  color: white;
  padding: 0.75rem 1.75rem;
  border: none;
  border-radius: 30px;
  font-size: 1rem;
  font-weight: 600;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.header-right {
  flex: 1;
  display: flex;
  justify-content: center;
}

.header-image {
  width: 100%;
  max-width: 500px;
  border-radius: 0; /* No border or rounded corners */
  box-shadow: none; /* Remove any shadow if present */
}

@media (max-width: 768px) {
  .header-container {
    flex-direction: column-reverse;
    text-align: center;
  }

  .header-left h1 {
    font-size: 2rem;
  }

  .header-left p {
    font-size: 1rem;
  }

  .header-image {
    max-width: 100%;
    margin-top: 2rem;
  }
}



    .slider-section {
      padding: 4rem 1rem;
      text-align: center;
    }

    .slider-title {
      font-size: 2rem;
      margin-bottom: 2rem;
    }

    .slider-wrapper {
      overflow: hidden;
      position: relative;
    }

    .slider-track {
      display: flex;
      transition: transform 0.3s ease-in-out;
    }

    .slider-item {
      flex: 0 0 auto;
      width: 300px;
      margin-right: 1rem;
    }

    .slider-image {
      width: 100%;
      border-radius: 12px;
    }

    .slider-description {
      margin-top: 0.5rem;
      font-weight: 500;
    }

    .arrow-buttons {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .arrow-btn {
      background-color: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      padding: 0.5rem;
      font-size: 1.5rem;
      cursor: pointer;
    }

    .compact-contact {
      background: #fff;
      padding: 3rem 1rem;
      display: flex;
      justify-content: center;
    }

    .contact-card {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      max-width: 1000px;
      width: 100%;
    }

    .contact-left,
    .contact-right {
      flex: 1 1 300px;
    }

    .contact-left img {
      max-width: 100%;
    }

    .contact-right input,
    .contact-right select,
    .contact-right textarea {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .contact-right button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 0.7rem 1.5rem;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
    }

    

    .user-ratings {
      padding: 4rem 1rem;
      background-color: #fff;
      text-align: center;
    }

    .reviews-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
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

    .signup-cta {
      margin-top: 2rem;
    }

    @media (max-width: 768px) {
      .nav_menu {
        display: none;
        flex-direction: column;
        background: #007bff;
        padding: 1rem;
        position: absolute;
        top: 70px;
        right: 0;
        width: 200px;
      }

      .header_container {
        flex-direction: column-reverse;
        text-align: center;
      }

      .slider-item {
        width: 80vw;
      }

      .contact-card {
        flex-direction: column;
      }
    }

    #close-menu-btn {
  display: none;
}

#open-menu-btn {
  background: none;
  border: none;
  font-size: 1.8rem;
  color: white;
  display: none;
  cursor: pointer;
}

.nav_menu {
  display: flex;
  list-style: none;
  gap: 1.5rem;
}

@media (max-width: 768px) {
  .nav_menu {
    display: none;
    flex-direction: column;
    background: #007bff;
    position: absolute;
    top: 70px;
    right: 1rem;
    width: 200px;
    padding: 1rem;
    z-index: 1000;
  }

  .nav_menu.active {
    display: flex;
  }

  #open-menu-btn {
    display: block;
  }

  #close-menu-btn {
    display: none;
  }

  .nav_container.show-menu #open-menu-btn {
    display: none;
  }

  .nav_container.show-menu #close-menu-btn {
    display: block;
  }
}
  </style>
</head>

<body>
   <nav>
        <div class="container nav_container">
            <a href="index.html"><h4>Explore Cebu</h4></a>
            <ul class="nav_menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="#slider-section">Gallery</a></li>
                <li><a href="#compact-contact">Contact</a></li>
                <li><a href="courses.html">About</a></li>
                <li><a href="#faq-section">FAQ</a></li>
                <li><a href="signup.html" class="signup-btn">Sign Up</a></li>
            </ul>
            <button id="open-menu-btn"><i class="uil uil-bars"></i></button>
            <button id="close-menu-btn"><i class="uil uil-multiply"></i></button>

        </div>
    </nav>

<header class="header">
  <div class="container header-container">
    <div class="header-left">
      <h1>Explore the Beauty of Cebu</h1>
      <p>
        From stunning beaches to rich culture, discover unforgettable experiences
        in the heart of the Philippines. Let your adventure begin here.
      </p>
      <a href="courses.html" class="btn-primary">Start Exploring</a>
    </div>
    <div class="header-right">
      <img src="./img/header1.png" alt="Cebu Scenery" class="header-image" />
    </div>
  </div>
</header>



    <section id="slider-section" class="slider-section">
      <h2 class="slider-title">Cebu's Legacy</h2>
    
      <div class="slider-wrapper">
        <div class="slider">
          <div class="slider-track" id="sliderTrack">
            <div class="slider-item">
              <div class="slider-image-wrapper">
                <a href="about.html" class="slider-link">
                  <img src="img/image1.jpg" class="slider-image" />
                  <div class="slider-description">Magellan’s Cross</div>
                </a>
              </div>
            </div>
    
            <div class="slider-item">
              <div class="slider-image-wrapper">
                <a href="https://example.com/page2" class="slider-link">
                  <img src="img/image2.jpg" class="slider-image" />
                  <div class="slider-description">Basilica del Santo Niño</div>
                </a>
              </div>
            </div>
    
            <div class="slider-item">
              <div class="slider-image-wrapper">
                <a href="https://example.com/page3" class="slider-link">
                  <img src="img/image3.jpg" class="slider-image" />
                  <div class="slider-description">Fort San Pedro</div>
                </a>
              </div>
            </div>

            <div class="slider-item">
              <div class="slider-image-wrapper">
                <a href="about.html" class="slider-link">
                  <img src="img/image1.jpg" class="slider-image" />
                  <div class="slider-description">Magellan’s Cross</div>
                </a>
              </div>
            </div>
    
            <!-- Add more items if needed -->
          </div>
        </div>
    
        <div class="arrow-buttons">
          <button class="arrow-btn" id="leftArrow">&#10094;</button>
          <button class="arrow-btn" id="rightArrow">&#10095;</button>
        </div>
      </div>
    </section>
    
    
    
      <script src="main.js"></script>

     
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
          <form>
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

    
    <section id="faq-section" class="faq-section">
      <div class="faq-header">
        <h2>Frequently Asked Questions</h2>
        <input type="text" id="faqSearch" placeholder="Search FAQs..." class="faq-search" oninput="filterFAQs()">
      </div>
    
      <div class="faq-item">
        <button class="faq-question">
          What is the purpose of this website?
          <span class="faq-keywords" hidden>cebu heritage culture history travel site about</span>
        </button>
        <div class="faq-answer">
          <p>This website aims to promote awareness and appreciation of Cebu’s cultural heritage by showcasing important historical sites, traditions, and local customs, along with pictures and directions to visit them.</p>
        </div>
      </div>
    
      <div class="faq-item">
        <button class="faq-question">
          Are these heritage sites open to the public?
          <span class="faq-keywords" hidden>open hours visiting access tourism</span>
        </button>
        <div class="faq-answer">
          <p>Most of the featured sites are open to the public, but some may have specific visiting hours or entrance fees. It's best to check in advance or contact local tourism offices.</p>
        </div>
      </div>
    
      <div class="faq-item">
        <button class="faq-question">
          How can I help preserve Cebu’s cultural heritage?
          <span class="faq-keywords" hidden>support preserve local tradition donation awareness</span>
        </button>
        <div class="faq-answer">
          <p>You can help by visiting respectfully, spreading awareness, supporting local artisans and heritage programs, and following preservation guidelines set by communities or heritage groups.</p>
        </div>
      </div>
    
      <div class="faq-item">
        <button class="faq-question">
          Are local transportation options like jeepneys safe for tourists?
          <span class="faq-keywords" hidden>jeepney transport safety travel tips safe</span>
        </button>
        <div class="faq-answer">
          <p>Jeepneys are widely used and affordable. While generally safe, tourists should stay alert, avoid crowded rides at night, and keep personal items secure.</p>
        </div>
      </div>
    </section>
    
    <script>
      // Accordion toggle
      const questions = document.querySelectorAll('.faq-question');
    
      questions.forEach(button => {
        button.addEventListener('click', () => {
          const answer = button.nextElementSibling;
    
          // Close other open answers
          document.querySelectorAll('.faq-answer').forEach(a => {
            if (a !== answer) a.style.display = 'none';
          });
    
          // Toggle this one
          answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        });
      });
    
      // Search filter
      function filterFAQs() {
        const query = document.getElementById('faqSearch').value.toLowerCase();
        const items = document.querySelectorAll('.faq-item');
    
        items.forEach(item => {
          const question = item.querySelector('.faq-question').innerText.toLowerCase();
          const keywords = item.querySelector('.faq-keywords')?.innerText.toLowerCase() || '';
          if (question.includes(query) || keywords.includes(query)) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
      }
    </script>
    
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
    
      <div class="signup-cta">
        <p>Want to leave a rating? <a href="signup.html">Sign up now</a> </p>
      </div>
    </section>

<!--cards aesthetic     
    <style>
      body {
        background-color: #f0f8ff;
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
      }
    
      section.virtual-tour {
        padding: 4rem 2rem;
        text-align: center;
      }
    
      .virtual-tour h2 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: #2c3e50;
      }
    
      .virtual-place {
        max-width: 350px;
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(100, 149, 237, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 0 auto;
      }
    
      .virtual-place:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(70, 130, 180, 0.3);
      }
    
      .virtual-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }
    
      .virtual-content {
        padding: 1.5rem;
      }
    
      .virtual-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
      }
    
      .virtual-location {
        font-size: 0.95rem;
        color: #888;
        margin-bottom: 1rem;
      }
    
      .virtual-description {
        font-size: 1rem;
        color: #555;
        line-height: 1.4;
        margin-bottom: 1rem;
      }
    
      .virtual-stars {
        color: #FFD700;
        margin-bottom: 1rem;
        font-size: 1.2rem;
      }
    
      .virtual-button {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        background-color: #007BFF;
        color: #fff;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
      }
    
      .virtual-button:hover {
        background-color: #0056b3;
      }
    </style>
    
    <section class="virtual-tour">
      <h2>Explore a Virtual Place</h2>
    
      <div class="virtual-place">
        <img src="img/image1.jpg" alt="Magellan's Cross" class="virtual-image" />
        
        <div class="virtual-content">
          <div class="virtual-title">Magellan’s Cross</div>
          <div class="virtual-location">Cebu City, Philippines</div>
          <div class="virtual-description">
            Planted by Portuguese and Spanish explorers in 1521, this iconic cross marks the birth of Christianity in the Philippines.
          </div>
          <div class="virtual-stars">★★★★★</div>
          <a href="virtual-tour.html" class="virtual-button">Explore Virtual Tour</a>
        </div>
      </div>
    </section>
    -->
    

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Your go-to travel partner for amazing destinations and experiences.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                  <!--  <a href="#"><img src="facebook-" alt="Facebook"></a>
                    <a href="#"><img src="twitter-icon.png" alt="Twitter"></a>
                    <a href="#"><img src="instagram-icon.png" alt="Instagram"></a> -->
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 CebuExplorer. All rights reserved.</p>
        </div>
    </footer>
    
   


  <!-- Content remains unchanged -->
  <!-- Paste your HTML body content here as it is -->
  <!-- Only styles were improved -->

      <script type="text/javascript"
          src="{{ URL::asset('/js/main.js')}}"></script>
</body>

</html>



