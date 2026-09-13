/**
 * Ad Carousel Functionality
 * 
 * @package NewsToday
 */

export function initAdCarousel() {
    adCarousel();
}

function adCarousel() {
    document.querySelectorAll(".sidebar-ad-carousel").forEach(carousel => {

        const items = carousel.querySelectorAll(".carousel-item");
        if (items.length <= 1) return;

        let index = 0;

        setInterval(() => {

            items[index].classList.remove("active");
            index = (index + 1) % items.length;
            items[index].classList.add("active");

        }, 8000);

    });

    // Horizontal Ad Carousel
    document.querySelectorAll(".horizontal-ad-carousel").forEach(carousel => {

        const items = carousel.querySelectorAll(".carousel-item");
        if (items.length <= 1) return;

        let index = 0;

        setInterval(() => {

            items[index].classList.remove("active");
            index = (index + 1) % items.length;
            items[index].classList.add("active");

        }, 8000);

    });

    // Header Ad Carousel
    document.querySelectorAll(".header-ad-carousel").forEach(carousel => {

        const items = carousel.querySelectorAll(".carousel-item");
        if (items.length <= 1) return;

        let index = 0;

        setInterval(() => {

            items[index].classList.remove("active");
            index = (index + 1) % items.length;
            items[index].classList.add("active");

        }, 8000);

    });

    // Four Columns Posts Ad Carousel
    document.querySelectorAll('[data-carousel]').forEach(function (carousel) {

        let slides = carousel.querySelectorAll('.ads-slide');
        if (slides.length <= 1) return;

        let index = 0;

        slides.forEach((s, i) => {
            s.style.display = i === 0 ? 'block' : 'none';
        });

        setInterval(() => {
            slides[index].style.display = 'none';
            index = (index + 1) % slides.length;
            slides[index].style.display = 'block';
        }, 8000);

    });


    // Legal & Compliance Ad Carousel
    document.querySelectorAll(".legal-ad-carousel").forEach(carousel => {

        const items = carousel.querySelectorAll(".carousel-item");
        if (items.length <= 1) return;

        let index = 0;

        setInterval(() => {

            items[index].classList.remove("active");
            index = (index + 1) % items.length;
            items[index].classList.add("active");

        }, 8000);

    });
};