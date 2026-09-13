/**
 * Utility functions
 * 
 * @package NewsToday
 */

/**
 * Console log wrapper
 */
export function log(message, data = null) {
    if (process.env.NODE_ENV === 'development') {
        if (data) {
            console.log(`[NewsToday] ${message}`, data);
        } else {
            console.log(`[NewsToday] ${message}`);
        }
    }
}

/**
 * Debounce function
 */
export function debounce(func, wait = 300) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Check if element is in viewport
 */
export function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

