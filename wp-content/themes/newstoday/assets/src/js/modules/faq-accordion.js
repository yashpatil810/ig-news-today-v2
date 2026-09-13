/**
 * FAQ Accordion Functionality
 * 
 * @package NewsToday
 */

export function initFaqAccordion() {
    if (window.__faqAccordionInitialized) {
        return;
    }
    window.__faqAccordionInitialized = true;

    document.addEventListener('click', (event) => {
        const questionBtn = event.target.closest('.faq-question, .ad-faq-question');
        if (!questionBtn) return;

        const faqItem = questionBtn.closest('.faq-item, .ad-faq-item');
        if (!faqItem) return;

        event.preventDefault();

        const isOpen = faqItem.classList.contains('is-open') || faqItem.classList.contains('is-active');
        const container = faqItem.closest('.faq-accordion, .ad-faq-list, .faq-content');

        // Close other items in the same accordion container
        if (container) {
            const siblingItems = container.querySelectorAll('.faq-item, .ad-faq-item');
            siblingItems.forEach((sibling) => {
                if (sibling !== faqItem) {
                    sibling.classList.remove('is-open', 'is-active');
                    const siblingBtn = sibling.querySelector('.faq-question, .ad-faq-question');
                    if (siblingBtn) {
                        siblingBtn.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }

        // Toggle clicked item
        if (isOpen) {
            faqItem.classList.remove('is-open', 'is-active');
            questionBtn.setAttribute('aria-expanded', 'false');
        } else {
            faqItem.classList.add('is-open', 'is-active');
            questionBtn.setAttribute('aria-expanded', 'true');
        }
    });
}

