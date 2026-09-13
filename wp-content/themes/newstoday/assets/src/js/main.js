/**
 * Main JavaScript Entry Point
 * Navigation always loads; page-specific modules lazy-load when DOM exists.
 *
 * @package NewsToday
 */

// Import SCSS
import '../scss/main.scss';

// Import core (needed on every page)
import { initNavigation } from './navigation.js';
import { log } from './utils.js';

// Initialize theme
document.addEventListener('DOMContentLoaded', () => {
    console.log('NewsToday theme initialized');

    // Core: navigation (header, mobile menu, search, mega menu)
    initNavigation();

    // Lazy-load page-specific modules (code-split, loads only when needed)
    if (document.querySelector('.two-columns-directory-ad-sidebar-wrapper')) {
        import('./modules/directory-load-more.js').then((m) => m.initDirectoryLoadMore());
    }
    if (document.querySelector('.extended-posts-column')) {
        import('./modules/category-load-more.js').then((m) => m.initCategoryLoadMore());
    }
    if (document.querySelector('.search-posts-wrapper')) {
        import('./modules/search-load-more.js').then((m) => m.initSearchLoadMore());
    }
    if (document.querySelector('.preview-toggle')) {
        import('./modules/about-us.js').then((m) => m.initAboutUs());
    }
    if (document.querySelector('.contact-submit-button')) {
        import('./modules/contact-form.js').then((m) => m.initContactForm());
    }
    if (document.querySelector('.faq-question')) {
        import('./modules/faq-accordion.js').then((m) => m.initFaqAccordion());
    }
    if (document.querySelector('.newsletter-form, #newsletter-form')) {
        import('./modules/subscribe-form.js').then((m) => m.initSubscribeForm());
    }
    if (document.querySelector('.sidebar-ad-carousel')) {
        import('./modules/ad-carousel.js').then((m) => m.initAdCarousel());
    }
    if (document.querySelector('.ad-with-us-template') || document.querySelector('.single-author-page') || document.querySelector('.author-transparency-page')) {
        import('./modules/ad-with-us.js').then((m) => {
            if (document.querySelector('.ad-faq-item')) {
                m.initAdFaqAccordion();
            }
            m.initStatsCounter();
        });
    }
});
