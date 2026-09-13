/**
 * Contact Form Functionality
 * 
 * @package NewsToday
 */
export function initContactForm() {
    // Initialize stats counting animation
    initContactStats();

    const submitButton = document.querySelector('.contact-submit-button');
    const formContainer = document.querySelector('.contact-form-container');
    const thankYouContainer = document.querySelector('.contact-thank-you-container');
    const formWrapper = document.querySelector('.contact-form-wrapper');

    if (!submitButton || !formContainer || !thankYouContainer || !formWrapper) {
        return;
    }

    const cf7Form = formWrapper.querySelector('form.wpcf7-form');
    if (!cf7Form) {
        return;
    }


    // Listen for inputs on required fields to clear error tips instantly
    cf7Form.querySelectorAll('.wpcf7-validates-as-required, [aria-required="true"]').forEach((field) => {
        const handler = () => {
            if (field.value.trim() && !(field.tagName === 'SELECT' && (field.value === '' || field.value === 'Select an option'))) {
                field.classList.remove('wpcf7-not-valid');
                const tip = field.parentNode.querySelector('.wpcf7-not-valid-tip');
                if (tip) {
                    tip.remove();
                }
            }
        };
        field.addEventListener('input', handler);
        field.addEventListener('change', handler);
    });

    // Trigger CF7 submit on custom button click
    submitButton.addEventListener('click', (e) => {
        e.preventDefault();

        // Validate all mandatory fields (Google reCAPTCHA v3 runs silently via CF7 integration)
        let hasErrors = false;
        const requiredFields = cf7Form.querySelectorAll('.wpcf7-validates-as-required, [aria-required="true"]');
        requiredFields.forEach((field) => {
            const val = field.value.trim();
            if (!val || (field.tagName === 'SELECT' && (val === '' || val === 'Select an option'))) {
                hasErrors = true;
                field.classList.add('wpcf7-not-valid');
                
                // Show validation tip like CF7 does
                let tip = field.parentNode.querySelector('.wpcf7-not-valid-tip');
                if (!tip) {
                    tip = document.createElement('span');
                    tip.className = 'wpcf7-not-valid-tip';
                    tip.setAttribute('aria-hidden', 'true');
                    tip.textContent = 'Please fill out this field.';
                    field.parentNode.appendChild(tip);
                }
            } else {
                field.classList.remove('wpcf7-not-valid');
                const tip = field.parentNode.querySelector('.wpcf7-not-valid-tip');
                if (tip) {
                    tip.remove();
                }
            }
        });

        if (hasErrors) {
            const firstError = cf7Form.querySelector('.wpcf7-not-valid');
            if (firstError) {
                firstError.focus();
            }
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML = 'SUBMITTING...';

        const cf7SubmitButton = cf7Form.querySelector(
            'input[type="submit"], button[type="submit"]'
        );

        if (cf7SubmitButton) {
            cf7SubmitButton.click();
        } else {
            cf7Form.submit();
        }
    });

    // Show thank you ONLY after successful submission
    document.addEventListener('wpcf7mailsent', (event) => {
        if (event.target !== cf7Form) {
            return;
        }

        formContainer.style.display = 'none';
        thankYouContainer.style.display = 'flex';

        thankYouContainer.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    // Re-enable button on validation or server error
    document.addEventListener('wpcf7invalid', resetButton);
    document.addEventListener('wpcf7mailfailed', resetButton);

    function resetButton(event) {
        if (event.target !== cf7Form) {
            return;
        }

        submitButton.disabled = false;
        submitButton.innerHTML = 'SUBMIT';
    }

    // Direct reach card navigation trigger
    const directCardLink = document.querySelector('.contact-direct-card-link');
    if (directCardLink) {
        directCardLink.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = 'mailto:info@igamingnewstoday.com';
        });
    }

    // Connect package list items with form service dropdown
    const serviceSelect = cf7Form.querySelector('select[name="services"]');
    const benefitItems = document.querySelectorAll('.contact-benefit-item');

    if (serviceSelect && benefitItems.length > 0) {
        benefitItems.forEach((item) => {
            item.addEventListener('click', () => {
                const benefitText = item.querySelector('.benefit-text').textContent.trim();
                
                // Find matching option in the dropdown
                let matchedValue = '';
                Array.from(serviceSelect.options).forEach((option) => {
                    if (option.text.trim() === benefitText) {
                        matchedValue = option.value;
                    }
                });

                if (matchedValue) {
                    serviceSelect.value = matchedValue;
                    // Trigger native change event
                    const event = new Event('change', { bubbles: true });
                    serviceSelect.dispatchEvent(event);
                }
            });
        });

        // Sync dropdown selection back to list item highlight
        serviceSelect.addEventListener('change', () => {
            const selectedText = serviceSelect.options[serviceSelect.selectedIndex].text.trim();
            benefitItems.forEach((item) => {
                const benefitText = item.querySelector('.benefit-text').textContent.trim();
                if (benefitText === selectedText) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        });
    }

    // Helper function for smart matching between plan card titles and dropdown options
    function isSmartMatch(cardTitle, optionText) {
        const cTitle = cardTitle.toLowerCase().trim();
        const oText = optionText.toLowerCase().trim();

        // 1. Direct equality or substring check
        if (cTitle === oText || oText.includes(cTitle) || cTitle.includes(oText)) {
            return true;
        }

        // 2. Overlap of key words (words longer than 3 characters, e.g. sponsored, interview, partnership)
        const cWords = cTitle.split(/\s+/).filter(w => w.length > 3);
        const oWords = oText.split(/\s+/).filter(w => w.length > 3);

        for (const cWord of cWords) {
            for (const oWord of oWords) {
                // If words match or one contains another (e.g. partnership vs partnerships)
                if (cWord === oWord || cWord.includes(oWord) || oWord.includes(cWord)) {
                    return true;
                }
            }
        }
        return false;
    }

    // Connect plan cards with form service dropdown and smooth scroll to form
    const planCards = document.querySelectorAll('.contact-plan-card');
    if (serviceSelect && planCards.length > 0) {
        planCards.forEach((card) => {
            card.addEventListener('click', () => {
                const cardTitleText = card.querySelector('.plan-card-title').textContent.trim();
                
                // Find matching option in the dropdown using smart matching
                let matchedValue = '';
                Array.from(serviceSelect.options).forEach((option) => {
                    if (isSmartMatch(cardTitleText, option.text)) {
                        matchedValue = option.value;
                    }
                });

                if (matchedValue) {
                    serviceSelect.value = matchedValue;
                    // Trigger change event to highlight list items and clear errors
                    const changeEvent = new Event('change', { bubbles: true });
                    serviceSelect.dispatchEvent(changeEvent);

                    // Add highlight/selected state to clicked card and remove from others
                    planCards.forEach(c => c.classList.remove('active-selection'));
                    card.classList.add('active-selection');

                    // Smooth scroll to the form title/container
                    const formHeader = document.querySelector('.contact-form-header-box');
                    if (formHeader) {
                        formHeader.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Sync dropdown selection back to plan card highlight using smart matching
        serviceSelect.addEventListener('change', () => {
            const selectedText = serviceSelect.options[serviceSelect.selectedIndex].text.trim();
            planCards.forEach((card) => {
                const cardTitleText = card.querySelector('.plan-card-title').textContent.trim();
                if (isSmartMatch(cardTitleText, selectedText)) {
                    card.classList.add('active-selection');
                } else {
                    card.classList.remove('active-selection');
                }
            });
        });
    }
}

/**
 * Animated statistics counter that counts up when visible on screen
 */
function initContactStats() {
    const statsContainer = document.querySelector('.contact-stats-container');
    if (!statsContainer) return;

    const statNumbers = statsContainer.querySelectorAll('.stat-number-value');
    
    const countUp = (el) => {
        const text = el.textContent.trim();
        const match = text.match(/^([\d.,]+)(.*)$/);
        if (!match) return;

        const target = parseFloat(match[1].replace(/,/g, ''));
        const suffix = match[2];
        const duration = 2000; // 2 seconds
        const startTime = performance.now();

        const updateCount = (currentTime) => {
            const elapsedTime = currentTime - startTime;
            const progress = Math.min(elapsedTime / duration, 1);
            
            // Easing function (easeOutQuad)
            const easeProgress = progress * (2 - progress);
            
            const currentVal = Math.floor(easeProgress * target);
            
            // Format number if original had commas
            const formattedVal = match[1].includes(',') ? currentVal.toLocaleString() : currentVal;
            el.textContent = formattedVal + suffix;

            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                el.textContent = text; // Ensure exact final text
            }
        };

        requestAnimationFrame(updateCount);
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                statNumbers.forEach(countUp);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(statsContainer);
}
