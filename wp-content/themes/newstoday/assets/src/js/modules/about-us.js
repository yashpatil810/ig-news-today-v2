/**
 * About Us Page Functionality
 * 
 * @package NewsToday
 */

export function initAboutUs() {
    initPreviewToggle();
}

/**
 * Initialize Site Preview Toggle
 */
function initPreviewToggle() {
    const toggleButtons = document.querySelectorAll('.preview-toggle .toggle-btn');
    const previewImages = document.querySelectorAll('.preview-image-wrapper .preview-image');

    if (!toggleButtons.length || !previewImages.length) {
        return;
    }

    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            toggleButtons.forEach((b) => b.classList.remove('is-active'));
            
            // Add active class to clicked button
            btn.classList.add('is-active');

            // Hide all preview images
            previewImages.forEach((img) => img.classList.remove('is-active'));

            // Show corresponding preview image
            if (btn.classList.contains('toggle-desktop')) {
                document.querySelector('.preview-desktop')?.classList.add('is-active');
            } else if (btn.classList.contains('toggle-mobile')) {
                document.querySelector('.preview-mobile')?.classList.add('is-active');
            }
        });
    });
}

