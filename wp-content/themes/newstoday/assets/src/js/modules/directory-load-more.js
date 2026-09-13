/**
 * Directory Load More Module
 * 
 * Handles AJAX loading of more directory posts
 * 
 * @package NewsToday
 */

export function initDirectoryLoadMore() {
    const wrapper = document.querySelector('.two-columns-directory-ad-sidebar-wrapper');
    const loadMoreBtn = document.getElementById('directory-load-more');

    if (!wrapper || !loadMoreBtn) {
        return;
    }

    let offset = parseInt(wrapper.dataset.offset, 10);
    const postsPerPage = parseInt(wrapper.dataset.postsPerPage, 10);
    const totalPosts = parseInt(wrapper.dataset.totalPosts, 10);
    const pageId = wrapper.dataset.pageId || '';
    let isLoading = false;

    loadMoreBtn.addEventListener('click', async () => {
        if (isLoading) return;

        isLoading = true;
        toggleLoadingState(true);

        try {
            const formData = new FormData();
            formData.append('action', 'load_more_directory');
            formData.append('offset', offset);
            formData.append('posts_per_page', postsPerPage);
            formData.append('page_id', pageId);
            formData.append('nonce', window.newstodayData?.nonce || '');

            const response = await fetch(window.newstodayData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.success && data.data.html) {
                // Insert HTML directly before the load more section
                const loadMoreSection = wrapper.querySelector('.load-more-section');
                if (loadMoreSection) {
                    loadMoreSection.insertAdjacentHTML('beforebegin', data.data.html);
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
            console.error('Error loading more directory posts:', error);
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
        const loadMoreSection = wrapper.querySelector('.load-more-section');
        if (loadMoreSection) {
            loadMoreSection.style.display = 'none';
        }
    }
}

