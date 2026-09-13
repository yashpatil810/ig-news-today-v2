/**
 * Subscribe Form Functionality
 * 
 * @package NewsToday
 */

export function initSubscribeForm() {
    const forms = document.querySelectorAll('.newsletter-form, #newsletter-form');
    if (!forms.length) return;

    forms.forEach((form) => {
        if (form.dataset.mc4wpBound === 'true') return;
        form.dataset.mc4wpBound = 'true';

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const responseContainer = form.querySelector('.mc4wp-response');
            const submitButton = form.querySelector('button[type="submit"]');
            const isHorizontalNewsletter = form.id === 'horizontal-newsletter-form';

            const setSubmitting = (isSubmitting) => {
                if (!submitButton) return;
                if (isSubmitting) {
                    submitButton.dataset.originalText = submitButton.textContent;
                    submitButton.textContent = isHorizontalNewsletter ? 'Subscribing...' : 'Submiting...';
                    submitButton.disabled = true;
                } else {
                    submitButton.textContent = submitButton.dataset.originalText || submitButton.textContent;
                    submitButton.disabled = false;
                }
            };

            // Submit via admin-ajax; Mailchimp plugin processes the POST on init.
            const ajaxUrl = (() => {
                if (typeof newstodayData?.ajaxUrl === 'string') {
                    return newstodayData.ajaxUrl;
                }
                return '/wp-admin/admin-ajax.php';
            })();

            formData.append('action', 'newstoday_mc4wp_submit');

            setSubmitting(true);

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                },
            })
                .then(async (response) => {
                    const contentType = response.headers.get('content-type') || '';
                    const isJson = contentType.includes('application/json');
                    const data = isJson ? await response.json() : null;

                    if (response.ok && data?.success) {
                        responseContainer.innerHTML = `<p class="mc4wp-success">${data.data?.message || 'Thank you for subscribing!'}</p>`;
                        form.reset();
                    } else {
                        const message = data?.data?.message || 'Unable to subscribe. Please check your details and try again.';
                        responseContainer.innerHTML = `<p class="mc4wp-error">${message}</p>`;
                    }
                })
                .catch(() => {
                    responseContainer.innerHTML = '<p class="mc4wp-error">Something went wrong. Please try again.</p>';
                })
                .finally(() => {
                    setSubmitting(false);
                });
        });
    });
}
