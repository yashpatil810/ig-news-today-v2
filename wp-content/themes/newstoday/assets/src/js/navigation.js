/**
 * Navigation functionality
 * 
 * @package NewsToday
 */

export function initNavigation() {
    // Mobile Menu Elements
    const mobileMenuToggles = Array.from(document.querySelectorAll('.mobile-menu-toggle'));
    const mobileMenuDropdown = document.querySelector('#mobile-menu');
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');

    // Toggle Mobile Menu (open/close with same button)
    if (mobileMenuToggles.length && mobileMenuDropdown) {
        const navigationHeader = document.querySelector('.navigation-header');

        const updateMobileMenuOffsets = () => {
            // if (!navigationHeader) {
            //     return;
            // }
            // const { bottom } = navigationHeader.getBoundingClientRect();
            // const menuTop = Math.max(bottom, 0);
            // mobileMenuDropdown.style.setProperty('--mobile-menu-top', `${menuTop}px`);
        };

        const setMenuToggleState = (isOpen) => {
            mobileMenuToggles.forEach((toggle) => {
                toggle.classList.toggle('is-open', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                toggle.setAttribute('aria-label', isOpen ? 'Close Menu' : 'Open Menu');
            });
        };

        const handleMenuToggle = () => {
            const isOpen = mobileMenuDropdown.classList.contains('is-open');

            if (isOpen) {
                // Close menu
                mobileMenuDropdown.classList.remove('is-open');
                setMenuToggleState(false);
                if (navigationHeader) {
                    navigationHeader.classList.remove('menu-is-open');
                }
                document.body?.classList.remove('mobile-menu-open');
            } else {
                // Close search if open
                const mobileSearchBar = document.querySelector('#mobile-search-bar');
                const mobileSearchOverlay = document.getElementById('mobile-search-overlay');
                const mobileSearchDropdown = document.querySelector('#mobile-search-dropdown');
                const mobileSearchInput = document.getElementById('mobile-search-input');
                if (mobileSearchBar) mobileSearchBar.classList.remove('is-open');
                if (mobileSearchOverlay) mobileSearchOverlay.classList.remove('is-open');
                if (mobileSearchDropdown) mobileSearchDropdown.style.display = 'none';
                if (mobileSearchInput) mobileSearchInput.value = '';
                document.body?.classList.remove('mobile-search-active');
                if (navigationHeader) {
                    navigationHeader.classList.remove('mobile-search-is-open');
                }

                // Open menu
                updateMobileMenuOffsets();
                mobileMenuDropdown.classList.add('is-open');
                setMenuToggleState(true);
                if (navigationHeader) {
                    navigationHeader.classList.add('menu-is-open');
                }
                document.body?.classList.add('mobile-menu-open');
            }
        };

        mobileMenuToggles.forEach((toggle) => {
            toggle.addEventListener('click', handleMenuToggle);
        });

        const handleViewportChange = () => {
            if (mobileMenuDropdown.classList.contains('is-open')) {
                updateMobileMenuOffsets();
            }
        };

        window.addEventListener('resize', handleViewportChange);
        window.addEventListener('scroll', handleViewportChange, { passive: true });
    }

    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenuDropdown && mobileMenuDropdown.classList.contains('is-open')) {
            const navigationHeader = document.querySelector('.navigation-header');
            mobileMenuDropdown.classList.remove('is-open');
            if (mobileMenuToggles.length) {
                mobileMenuToggles.forEach((toggle) => {
                    toggle.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.setAttribute('aria-label', 'Open Menu');
                });
            }
            if (navigationHeader) {
                navigationHeader.classList.remove('menu-is-open');
            }
            document.body?.classList.remove('mobile-menu-open');
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (mobileMenuDropdown && mobileMenuDropdown.classList.contains('is-open')) {
            const isClickInsideMenu = mobileMenuDropdown.contains(e.target);
            const isClickOnToggle = mobileMenuToggles.some((toggle) => toggle.contains(e.target));

            if (!isClickInsideMenu && !isClickOnToggle) {
                const navigationHeader = document.querySelector('.navigation-header');
                mobileMenuDropdown.classList.remove('is-open');
                mobileMenuToggles.forEach((toggle) => {
                    toggle.classList.remove('is-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.setAttribute('aria-label', 'Open Menu');
                });
                if (navigationHeader) {
                    navigationHeader.classList.remove('menu-is-open');
                }
                document.body?.classList.remove('mobile-menu-open');
            }
        }
    });

    // Mobile Dropdown Toggle (click to open/close sub-menu)
    mobileDropdownToggles.forEach((toggle) => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const parentItem = toggle.closest('.mobile-nav-item');
            if (parentItem) {
                parentItem.classList.toggle('is-open');
            }
        });
    });

    // Legacy menu toggle support
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('#primary-menu');

    if (menuToggle && primaryMenu) {
        menuToggle.addEventListener('click', () => {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            primaryMenu.classList.toggle('toggled');
        });
    }

    // Initialize Mega Menu
    initMegaMenu();

    // Initialize Search Overlay
    initSearchOverlay();

    // Initialize Sticky Header
    initStickyHeader();
}

/**
 * Initialize Mega Menu functionality
 */
function initMegaMenu() {
    const categoryItems = document.querySelectorAll('.mega-dropdown-sidebar .category-item');
    const postsGrid = document.getElementById('mega-dropdown-posts-grid');

    if (!categoryItems.length || !postsGrid) {
        return;
    }

    // Cache for loaded posts
    const postsCache = {};

    // Track current hovered category name
    let currentCategoryName = '';

    // Load posts for a category
    const defaultCategoryColor = '#FC0303';

    async function loadPosts(categorySlug, categoryName, categoryColor = defaultCategoryColor) {
        currentCategoryName = categoryName;

        // Check cache first
        if (postsCache[categorySlug]) {
            renderPosts(postsCache[categorySlug], categoryName, categoryColor);
            return;
        }

        // Show loading state
        postsGrid.innerHTML = '<div class="posts-loading"><p>Loading posts...</p></div>';

        // Check if megaMenuData is available
        if (typeof megaMenuData === 'undefined') {
            console.error('megaMenuData is not defined');
            postsGrid.innerHTML = '<div class="posts-loading"><p>Error loading posts</p></div>';
            return;
        }

        try {
            const formData = new FormData();
            formData.append('action', 'get_mega_menu_posts');
            formData.append('category', categorySlug);
            formData.append('nonce', megaMenuData.nonce);

            const response = await fetch(megaMenuData.ajaxUrl, {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.success && data.data.columns) {
                postsCache[categorySlug] = data.data.columns;
                renderPosts(data.data.columns, categoryName, categoryColor);
            } else {
                postsGrid.innerHTML = '<div class="posts-loading"><p>No posts found</p></div>';
            }
        } catch (error) {
            console.error('Error loading posts:', error);
            postsGrid.innerHTML = '<div class="posts-loading"><p>Error loading posts</p></div>';
        }
    }

    // Render posts HTML - fills rows first (left to right, top to bottom)
    function renderPosts(columns, categoryName, categoryColor = defaultCategoryColor) {
        const color = categoryColor || defaultCategoryColor;

        // Flatten all posts from columns array
        const allPosts = columns.flat();
        const numColumns = columns.length;

        // Calculate number of rows needed
        const numRows = Math.ceil(allPosts.length / numColumns);

        if (allPosts.length === 0) {
            postsGrid.innerHTML = '<div class="posts-loading"><p>No posts found in this category</p></div>';
            return;
        }

        let html = '';

        // Build rows instead of columns
        for (let row = 0; row < numRows; row++) {
            html += '<div class="post-row">';

            for (let col = 0; col < numColumns; col++) {
                const postIndex = row * numColumns + col;
                const post = allPosts[postIndex];

                if (post) {
                    html += '<div class="post-item">';

                    if (post.is_featured) {
                        // Featured post with image
                        html += `
                            <div class="featured-post">
                                ${post.thumbnail ? `
                                    <div class="post-thumbnail">
                                        <a href="${post.permalink}">
                                            <img src="${post.thumbnail}" alt="${escapeHtml(post.title)}" />
                                        </a>
                                    </div>
                                ` : ''}
                                <div class="post-meta">
                                    ${categoryName ? `<span class="post-category" style="color: ${escapeHtml(color)};">${escapeHtml(categoryName)}</span>` : ''}
                                    <span class="post-time">${escapeHtml(post.time)}</span>
                                </div>
                                <h4 class="post-title">
                                    <a href="${post.permalink}">${escapeHtml(post.title)}</a>
                                </h4>
                            </div>
                        `;
                    } else {
                        // Text-only post
                        html += `
                            <div class="text-post">
                                <h4 class="post-title">
                                    <a href="${post.permalink}">${escapeHtml(post.title)}</a>
                                </h4>
                            </div>
                        `;
                    }

                    html += '</div>';
                } else {
                    // Empty cell to maintain grid
                    html += '<div class="post-item"></div>';
                }
            }

            html += '</div>';
        }

        postsGrid.innerHTML = html;
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Add hover listeners to category items
    categoryItems.forEach((item) => {
        item.addEventListener('mouseenter', () => {
            // Remove active class from all items
            categoryItems.forEach((i) => i.classList.remove('is-active'));

            // Add active class to hovered item
            item.classList.add('is-active');

            // Load posts for this category
            const categorySlug = item.dataset.category;
            const categoryName = item.textContent.trim();
            const categoryColor = item.dataset.color || defaultCategoryColor;
            if (categorySlug) {
                loadPosts(categorySlug, categoryName, categoryColor);
            }
        });
    });

    // Load default category posts when mega menu opens
    const megaDropdown = document.querySelector('.has-mega-dropdown');
    if (megaDropdown) {
        megaDropdown.addEventListener('mouseenter', () => {
            const activeItem = document.querySelector('.mega-dropdown-sidebar .category-item.is-active');
            if (activeItem) {
                const categorySlug = activeItem.dataset.category;
                const categoryName = activeItem.textContent.trim();
                const categoryColor = activeItem.dataset.color || defaultCategoryColor;
                if (categorySlug && !postsCache[categorySlug]) {
                    loadPosts(categorySlug, categoryName, categoryColor);
                }
            }
        });
    }
}

/**
 * Initialize Search Overlay functionality
 */
function initSearchOverlay() {
    const navigationHeader = document.querySelector('.navigation-header');

    // Desktop Search Elements
    const desktopSearchBtn = document.querySelector('.nav-search-btn');
    const searchOverlay = document.querySelector('#search-overlay');
    const searchCloseBtn = document.querySelector('.search-close-btn');
    const desktopSearchInput = document.getElementById('desktop-search-input');
    const desktopSearchSubmit = document.getElementById('desktop-search-submit');
    const desktopSearchResults = document.getElementById('desktop-search-results');
    const desktopSearchList = document.getElementById('desktop-search-list');

    // Mobile Search Elements
    const mobileSearchBtns = document.querySelectorAll('.mobile-search-btn');
    const mobileSearchOverlay = document.getElementById('mobile-search-overlay');
    const mobileSearchBar = document.querySelector('#mobile-search-bar');
    const mobileSearchDropdown = document.querySelector('#mobile-search-dropdown');
    const mobileSearchCloseBtn = document.querySelector('.mobile-search-close-btn');
    const mobileSearchInput = document.getElementById('mobile-search-input');
    const mobileSearchSubmit = document.getElementById('mobile-search-submit');
    const mobileSearchList = document.getElementById('mobile-search-list');

    // Debounce timer
    let debounceTimer = null;
    const DEBOUNCE_DELAY = 300;
    const MIN_CHARS = 3;

    // Get base URL for search
    const searchUrl = searchOverlay?.dataset.searchUrl || mobileSearchOverlay?.dataset.searchUrl || mobileSearchBar?.dataset.searchUrl || '/';

    // Desktop: Open search overlay
    if (desktopSearchBtn && searchOverlay && navigationHeader) {
        desktopSearchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.add('is-open');
            navigationHeader.classList.add('search-is-open');

            // Focus on search input
            if (desktopSearchInput) {
                setTimeout(() => desktopSearchInput.focus(), 100);
            }
        });
    }

    // Desktop: Close search overlay
    if (searchCloseBtn && searchOverlay && navigationHeader) {
        searchCloseBtn.addEventListener('click', () => {
            searchOverlay.classList.remove('is-open');
            navigationHeader.classList.remove('search-is-open');
            // Clear search and hide results
            if (desktopSearchInput) {
                desktopSearchInput.value = '';
            }
            if (desktopSearchResults) {
                desktopSearchResults.style.display = 'none';
            }
        });
    }

    // Mobile: Open search
    if (mobileSearchBtns.length && mobileSearchBar && navigationHeader) {
        mobileSearchBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();

                // Close mobile menu if open
                const mobileMenuDropdown = document.querySelector('#mobile-menu');
                if (mobileMenuDropdown && mobileMenuDropdown.classList.contains('is-open')) {
                    mobileMenuDropdown.classList.remove('is-open');
                    mobileMenuToggles.forEach((t) => {
                        t.classList.remove('is-open');
                        t.setAttribute('aria-expanded', 'false');
                        t.setAttribute('aria-label', 'Open Menu');
                    });
                    if (navigationHeader) {
                        navigationHeader.classList.remove('menu-is-open');
                    }
                    document.body?.classList.remove('mobile-menu-open');
                }

                if (mobileSearchOverlay) {
                    mobileSearchOverlay.classList.add('is-open');
                }
                mobileSearchBar.classList.add('is-open');
                navigationHeader.classList.add('mobile-search-is-open');
                document.body?.classList.add('mobile-search-active');

                // Focus on search input
                if (mobileSearchInput) {
                    setTimeout(() => mobileSearchInput.focus(), 100);
                }
            });
        });
    }

    // Mobile: Close search
    if (mobileSearchCloseBtn && mobileSearchBar && navigationHeader) {
        mobileSearchCloseBtn.addEventListener('click', () => {
            mobileSearchBar.classList.remove('is-open');
            if (mobileSearchOverlay) {
                mobileSearchOverlay.classList.remove('is-open');
            }
            if (mobileSearchDropdown) {
                mobileSearchDropdown.style.display = 'none';
            }
            navigationHeader.classList.remove('mobile-search-is-open');
            document.body?.classList.remove('mobile-search-active');
            // Clear search
            if (mobileSearchInput) {
                mobileSearchInput.value = '';
            }
        });
    }

    // Live Search function
    async function performLiveSearch(query, resultsList, resultsContainer) {
        if (query.length < MIN_CHARS) {
            if (resultsContainer) {
                resultsContainer.style.display = 'none';
            }
            return;
        }

        try {
            const formData = new FormData();
            formData.append('action', 'newstoday_live_search');
            formData.append('search_query', query);
            formData.append('nonce', window.newstodayData?.nonce || '');

            const response = await fetch(window.newstodayData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.success && data.data.results.length > 0) {
                // Render results
                let html = '';
                data.data.results.forEach(post => {
                    html += `<li><a href="${escapeHtml(post.permalink)}">${post.title}</a></li>`;
                });
                resultsList.innerHTML = html;

                // Show results, hide no-results message
                resultsList.style.display = 'block';
                const noResultsMsg = resultsContainer.querySelector('.no-results-message');
                if (noResultsMsg) {
                    noResultsMsg.style.display = 'none';
                }
                resultsContainer.style.display = 'block';
            } else {
                // No results
                resultsList.innerHTML = '';
                resultsList.style.display = 'none';
                const noResultsMsg = resultsContainer.querySelector('.no-results-message');
                if (noResultsMsg) {
                    noResultsMsg.style.display = 'block';
                }
                resultsContainer.style.display = 'block';
            }
        } catch (error) {
            console.error('Live search error:', error);
        }
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Redirect to search results page
    function redirectToSearch(query) {
        if (query.trim().length > 0) {
            window.location.href = `${searchUrl}?s=${encodeURIComponent(query.trim())}`;
        }
    }

    // Desktop: Live search on keyup with debounce
    if (desktopSearchInput && desktopSearchList && desktopSearchResults) {
        desktopSearchInput.addEventListener('keyup', (e) => {
            // Handle Enter key
            if (e.key === 'Enter') {
                redirectToSearch(desktopSearchInput.value);
                return;
            }

            // Debounced live search
            clearTimeout(debounceTimer);
            const query = desktopSearchInput.value;

            if (query.length < MIN_CHARS) {
                desktopSearchResults.style.display = 'none';
                return;
            }

            debounceTimer = setTimeout(() => {
                performLiveSearch(query, desktopSearchList, desktopSearchResults);
            }, DEBOUNCE_DELAY);
        });
    }

    // Desktop: Search button click
    if (desktopSearchSubmit && desktopSearchInput) {
        desktopSearchSubmit.addEventListener('click', () => {
            redirectToSearch(desktopSearchInput.value);
        });
    }

    // Mobile: Live search on keyup with debounce
    if (mobileSearchInput && mobileSearchList && mobileSearchDropdown) {
        mobileSearchInput.addEventListener('keyup', (e) => {
            // Handle Enter key
            if (e.key === 'Enter') {
                redirectToSearch(mobileSearchInput.value);
                return;
            }

            // Debounced live search
            clearTimeout(debounceTimer);
            const query = mobileSearchInput.value;

            if (query.length < MIN_CHARS) {
                mobileSearchDropdown.style.display = 'none';
                return;
            }

            debounceTimer = setTimeout(() => {
                performLiveSearch(query, mobileSearchList, mobileSearchDropdown);
            }, DEBOUNCE_DELAY);
        });
    }

    // Mobile: Search button click
    if (mobileSearchSubmit && mobileSearchInput) {
        mobileSearchSubmit.addEventListener('click', () => {
            redirectToSearch(mobileSearchInput.value);
        });
    }

    // Close search on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            // Close desktop search
            if (searchOverlay && searchOverlay.classList.contains('is-open')) {
                searchOverlay.classList.remove('is-open');
                if (navigationHeader) {
                    navigationHeader.classList.remove('search-is-open');
                }
                if (desktopSearchInput) {
                    desktopSearchInput.value = '';
                }
                if (desktopSearchResults) {
                    desktopSearchResults.style.display = 'none';
                }
            }

            // Close mobile search
            if (mobileSearchBar && mobileSearchBar.classList.contains('is-open')) {
                mobileSearchBar.classList.remove('is-open');
                if (mobileSearchDropdown) {
                    mobileSearchDropdown.style.display = 'none';
                }
                if (mobileSearchOverlay) {
                    mobileSearchOverlay.classList.remove('is-open');
                }
                if (navigationHeader) {
                    navigationHeader.classList.remove('mobile-search-is-open');
                }
                document.body?.classList.remove('mobile-search-active');
                if (mobileSearchInput) {
                    mobileSearchInput.value = '';
                }
            }
        }
    });
}

/**
 * Initialize Sticky Header functionality
 * Hides the header when scrolling down, shows it when scrolling up.
 */
function initStickyHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    let lastScrollY = window.scrollY;
    let accumulatedDelta = 0;
    const scrollThreshold = 80; // 80px scroll delta to trigger hide/show
    const startScrollY = 100; // Only start hiding/showing header after scrolling past 100px

    window.addEventListener('scroll', () => {
        // If mobile menu or search overlay is open, don't toggle header visibility
        if (
            document.body.classList.contains('mobile-menu-open') ||
            document.body.classList.contains('mobile-search-active') ||
            document.querySelector('.navigation-header')?.classList.contains('search-is-open')
        ) {
            lastScrollY = window.scrollY;
            return;
        }

        const currentScrollY = window.scrollY;

        // If we are at the top of the page, show header and clear classes
        if (currentScrollY <= startScrollY) {
            header.classList.remove('scroll-down');
            header.classList.remove('scroll-up');
            accumulatedDelta = 0;
            lastScrollY = currentScrollY;
            return;
        }

        const delta = currentScrollY - lastScrollY;

        // Reset accumulated delta if scroll direction changes
        if ((delta > 0 && accumulatedDelta < 0) || (delta < 0 && accumulatedDelta > 0)) {
            accumulatedDelta = 0;
        }
        accumulatedDelta += delta;

        if (accumulatedDelta > scrollThreshold) {
            // Scrolling down: hide header
            header.classList.add('scroll-down');
            header.classList.remove('scroll-up');
            accumulatedDelta = 0;
        } else if (accumulatedDelta < -scrollThreshold) {
            // Scrolling up: show header
            header.classList.remove('scroll-down');
            header.classList.add('scroll-up');
            accumulatedDelta = 0;
        }

        lastScrollY = currentScrollY;
    }, { passive: true });
}


