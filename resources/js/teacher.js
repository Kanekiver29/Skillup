// resources/js/teacher.js
// AOS and Swiper are loaded via CDN scripts and are available as global variables (AOS, Swiper).

document.addEventListener('DOMContentLoaded', () => {
  // Initialize AOS animations
  AOS.init({
    once: true,
    duration: 600,
    easing: 'ease-out-cubic'
  });

  // Initialize Swiper carousel for .mySwiper
  const swiper = new Swiper('.mySwiper', {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    effect: 'slide',
  });

  // FAB button to open modal
  const fab = document.getElementById('fab');
  const modal = document.getElementById('addModal');
  const closeBtn = modal?.querySelector('.close-modal');

  if (fab && modal) {
    fab.addEventListener('click', (e) => {
      e.stopPropagation();
      modal.classList.add('show');
    });
  }

  if (closeBtn && modal) {
    closeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      modal.classList.remove('show');
    });
  }

  // Close modal when clicking outside content
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('show');
      }
    });
  }
});
