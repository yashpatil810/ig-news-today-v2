/**
 * Category Load More Module
 * 
 * Handles AJAX loading of more category posts
 * 
 * @package NewsToday
 */

export function initCategoryLoadMore() {
    const wrapper = document.querySelector('.extended-posts-column');
    const loadMoreBtn = document.getElementById('category-load-more');

    if (!wrapper || !loadMoreBtn) {
        return;
    }

    let offset = parseInt(wrapper.dataset.offset, 10);
    const postsPerPage = parseInt(wrapper.dataset.postsPerPage, 10);
    const totalPosts = parseInt(wrapper.dataset.totalPosts, 10);
    const categoryId = wrapper.dataset.categoryId || '';
    let isLoading = false;

    loadMoreBtn.addEventListener('click', async () => {
        console.log('loadMoreBtn clicked');
        if (isLoading) return;

        isLoading = true;
        toggleLoadingState(true);

        try {
            const formData = new FormData();
            formData.append('action', 'load_more_category_posts');
            formData.append('offset', offset);
            formData.append('posts_per_page', postsPerPage);
            formData.append('category_id', categoryId);
            formData.append('nonce', window.newstodayData?.nonce || '');

            const response = await fetch(window.newstodayData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.success && data.data.html) {
                // Insert HTML before the load more wrapper
                const loadMoreWrapper = wrapper.querySelector('.load-more-wrapper');
                if (loadMoreWrapper) {
                    loadMoreWrapper.insertAdjacentHTML('beforebegin', data.data.html);
                } else {
                    wrapper.insertAdjacentHTML('beforeend', data.data.html);
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
            console.error('Error loading more category posts:', error);
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

