/**
 * Advertise With Us - FAQ Accordion Functionality
 * 
 * Handles the expand/collapse of FAQ items on the Advertise With Us page.
 * Active state: grey (#7B7B7B) header with white text, arrow rotated 90deg down.
 * 
 * @package NewsToday
 */

export function initAdFaqAccordion() {
    const faqItems = document.querySelectorAll('.ad-faq-item');

    if (!faqItems.length) {
        return;
    }

    faqItems.forEach((item) => {
        const questionBtn = item.querySelector('.ad-faq-question');

        if (!questionBtn) return;

        questionBtn.addEventListener('click', () => {
            const isActive = item.classList.contains('is-active');

            // Close all other items first (only one open at a time)
            faqItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    otherItem.classList.remove('is-active');
                }
            });

            // Toggle the clicked item
            if (isActive) {
                item.classList.remove('is-active');
            } else {
                item.classList.add('is-active');
            }
        });
    });
}

export function initStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    if (!statNumbers.length) return;

    const animateValue = (element, start, end, duration, numLetters, symbol, originalStr) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            
            // easeOutQuart
            const easeProgress = 1 - Math.pow(1 - progress, 4);
            
            const currentVal = Math.floor(easeProgress * (end - start) + start);
            const symbolSpan = symbol ? `<span class="stat-suffix">${symbol}</span>` : '';
            element.innerHTML = currentVal + numLetters + symbolSpan;
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                if (symbol) {
                    element.innerHTML = originalStr.replace(symbol, `<span class="stat-suffix">${symbol}</span>`);
                } else {
                    element.innerHTML = originalStr;
                }
            }
        };
        window.requestAnimationFrame(step);
    };

    const statsObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const targetStr = entry.target.getAttribute('data-target');
                if (!targetStr) return;
                
                // Parse number, letters (e.g. k, M) and special symbols (e.g. +, %)
                const match = targetStr.match(/^([\d.,]+)([a-zA-Z]*)(.*)$/);
                if (match) {
                    const targetNumber = parseFloat(match[1].replace(/,/g, ''));
                    const numLetters = match[2] || '';
                    const symbol = match[3] || '';
                    
                    animateValue(entry.target, 0, targetNumber, 2000, numLetters, symbol, targetStr);
                } else {
                    entry.target.innerHTML = targetStr;
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNumbers.forEach(stat => {
        statsObserver.observe(stat);
    });
}
