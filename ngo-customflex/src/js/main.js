// Import styles
import '../scss/main.scss';

// DOM ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('NGO CustomFlex theme initialized');
  
  // Mobile menu toggle
  const menuToggle = document.querySelector('.menu-toggle');
  const navigation = document.querySelector('.main-navigation');
  
  if (menuToggle && navigation) {
    menuToggle.addEventListener('click', function() {
      navigation.classList.toggle('toggled');
      if (navigation.classList.contains('toggled')) {
        menuToggle.setAttribute('aria-expanded', 'true');
      } else {
        menuToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }
});

