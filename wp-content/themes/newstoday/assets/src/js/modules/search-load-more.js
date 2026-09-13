/**
 * Search Load More Module
 * 
 * Handles AJAX loading of more search results
 * 
 * @package NewsToday
 */

export function initSearchLoadMore() {
    const wrapper = document.querySelector('.search-posts-wrapper');
    const loadMoreBtn = document.getElementById('search-load-more');

    if (!wrapper || !loadMoreBtn) {
        return;
    }

    let offset = parseInt(wrapper.dataset.offset, 10);
    const postsPerPage = parseInt(wrapper.dataset.postsPerPage, 10);
    const totalPosts = parseInt(wrapper.dataset.totalPosts, 10);
    const searchQuery = wrapper.dataset.searchQuery || '';
    const hasResults = wrapper.dataset.hasResults || '0';
    let isLoading = false;

    const desktopGrid = wrapper.querySelector('.desktop-grid');
    const mobileGrid = wrapper.querySelector('.mobile-grid');

    loadMoreBtn.addEventListener('click', async () => {
        if (isLoading) return;

        isLoading = true;
        toggleLoadingState(true);

        try {
            const formData = new FormData();
            formData.append('action', 'load_more_search');
            formData.append('offset', offset);
            formData.append('posts_per_page', postsPerPage);
            formData.append('search_query', searchQuery);
            formData.append('has_results', hasResults);
            formData.append('nonce', window.newstodayData?.nonce || '');

            const response = await fetch(window.newstodayData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                // Append desktop HTML
                if (data.data.desktop_html && desktopGrid) {
                    desktopGrid.insertAdjacentHTML('beforeend', data.data.desktop_html);
                }

                // Append mobile HTML
                if (data.data.mobile_html && mobileGrid) {
                    mobileGrid.insertAdjacentHTML('beforeend', data.data.mobile_html);
                }

                // Update offset
                offset += postsPerPage;
                wrapper.dataset.offset = offset;

                // Hide button if no more posts
                if (!data.data.has_more) {
                    hideLoadMoreButton();
                }
            } else {
                // No more posts or error
                hideLoadMoreButton();
            }
        } catch (error) {
            console.error('Error loading more search results:', error);
        } finally {
            isLoading = false;
            toggleLoadingState(false);
        }
    });

    function toggleLoadingState(loading) {
        const textEl = loadMoreBtn.querySelector('.load-more-text');
        const spinnerEl = loadMoreBtn.querySelector('.load-more-spinner');

        if (textEl) {
            textEl.style.display = loading ? 'none' : 'inline';
        }
        if (spinnerEl) {
            spinnerEl.style.display = loading ? 'inline-flex' : 'none';
        }

        loadMoreBtn.disabled = loading;
    }

    function hideLoadMoreButton() {
        const loadMoreWrapper = wrapper.querySelector('.load-more-wrapper');
        if (loadMoreWrapper) {
            loadMoreWrapper.style.display = 'none';
        }
    }
}

