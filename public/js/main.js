// Navbar shadow on scroll
window.addEventListener('scroll', () => {
  document.querySelector('nav').classList.toggle('window-scroll', window.scrollY > 0);
});

  const openBtn = document.getElementById('open-menu-btn');
  const closeBtn = document.getElementById('close-menu-btn');
  const navMenu = document.querySelector('.nav_menu');
  const navContainer = document.querySelector('.nav_container');

  openBtn.addEventListener('click', () => {
    navMenu.classList.add('active');
    navContainer.classList.add('show-menu');
  });

  closeBtn.addEventListener('click', () => {
    navMenu.classList.remove('active');
    navContainer.classList.remove('show-menu');
  });



document.addEventListener('DOMContentLoaded', () => {
  const sliderTrack = document.getElementById('sliderTrack');
  const slideWidth = 340; // image + margin
  let currentPosition = 0;

  document.getElementById('leftArrow').addEventListener('click', () => {
    if (currentPosition < 0) {
      currentPosition += slideWidth;
      sliderTrack.style.transform = `translateX(${currentPosition}px)`;
    }
  });

  document.getElementById('rightArrow').addEventListener('click', () => {
    const maxScroll = -(sliderTrack.scrollWidth - document.querySelector('.slider').clientWidth);
    if (currentPosition > maxScroll) {
      currentPosition -= slideWidth;
      sliderTrack.style.transform = `translateX(${currentPosition}px)`;
    }
  });
});

