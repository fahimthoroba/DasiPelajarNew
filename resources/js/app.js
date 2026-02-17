import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'slide',
    once: true,
});

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
