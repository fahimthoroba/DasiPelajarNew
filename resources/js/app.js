import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-out',
    once: true,
});

// Initialize Swiper carousels (only on pages that have them)
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.mySwiper-ipnu')) {
        new Swiper('.mySwiper-ipnu', {
            slidesPerView: 'auto',
            spaceBetween: 14,
            loop: true,
            autoplay: {
                delay: 2200,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.mySwiper-ipnu .swiper-pagination',
                clickable: true,
            },
        });
    }

    // Berita portal hero slider
    if (document.querySelector('.mySwiperBerita')) {
        new Swiper('.mySwiperBerita', {
            spaceBetween: 0,
            effect: 'fade',
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.mySwiperBerita .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.mySwiperBerita .swiper-button-next',
                prevEl: '.mySwiperBerita .swiper-button-prev',
            },
        });
    }

    if (document.querySelector('.mySwiper-ippnu')) {
        new Swiper('.mySwiper-ippnu', {
            slidesPerView: 'auto',
            spaceBetween: 14,
            loop: true,
            autoplay: {
                delay: 2600,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.mySwiper-ippnu .swiper-pagination',
                clickable: true,
            },
        });
    }
});

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
