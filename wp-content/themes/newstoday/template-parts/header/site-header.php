<?php
/**
 * Template part for displaying the site header
 *
 * @package NewsToday
 */
?>

<header id="masthead" class="site-header">
    <!-- Brand Header -->
    <div class="brand-header">
    <div class="container">
            <div class="brand-header-inner">
                <!-- Brand Logo -->
                <div class="brand-logo">
            <?php
                    if ( has_custom_logo() ) :
            the_custom_logo();
                    else :
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link">
                            <span class="site-title"><?php bloginfo( 'name' ); ?></span>
                        </a>
                        <?php
                    endif;
                    ?>
                </div>
                
                <div class="brand-header-actions">
                    <!-- Social Media Icons -->
                    <div class="brand-social">
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_facebook' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Facebook', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/Facebook.svg' ); ?>" alt="Facebook" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_instagram' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Instagram', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/Instagram.svg' ); ?>" alt="Instagram" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_x' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'X (Twitter)', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/X.svg' ); ?>" alt="X" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_linkedin' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'LinkedIn', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/Linkedin.svg' ); ?>" alt="LinkedIn" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_youtube' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'YouTube', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/Youtube.svg' ); ?>" alt="YouTube" />
                        </a>
                    </div>

                    <!-- Mobile Right Actions (Search + Hamburger) for small screens -->
                    <div class="mobile-nav-actions brand-mobile-nav-actions">
                        <!-- Mobile Search Button -->
                        <button class="mobile-search-btn" aria-label="<?php esc_attr_e( 'Search', 'newstoday' ); ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="7" stroke="#000000" stroke-width="2"/>
                                <path d="M16 16L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>

                        <!-- Mobile Menu Toggle (Hamburger / Close) -->
                        <button class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open Menu', 'newstoday' ); ?>">
                            <svg class="hamburger-icon" width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1H27" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                                <path d="M1 10H27" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                                <path d="M1 19H27" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <svg class="close-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                                <path d="M20 4L4 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <div class="navigation-header">
        <div class="container">
            <nav id="site-navigation" class="main-navigation">
                <!-- Mobile Horizontal Category Scroll -->
                <?php
                $header_categories = get_categories( array(
                    'hide_empty' => false,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ) );
                ?>
                <div class="mobile-category-scroll">
                    <?php
                    if ( ! empty( $header_categories ) && ! is_wp_error( $header_categories ) ) :
                        foreach ( $header_categories as $cat ) :
                            $category_link = get_category_link( $cat->term_id );
                    ?>
                    <a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $cat->name ); ?></a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Desktop Navigation -->
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'nav-menu desktop-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'walker'         => class_exists( 'NewsToday_Mega_Menu_Walker' ) ? new NewsToday_Mega_Menu_Walker() : '',
                        'items_wrap'     => '<ul class="%2$s">%3$s<li class="nav-divider"></li><li class="nav-item nav-search"><button class="nav-search-btn" aria-label="' . esc_attr__( 'Search', 'newstoday' ) . '"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="#000000" stroke-width="2"/><path d="M16 16L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/></svg></button></li></ul>',
                    )
                );
                ?>
            </nav>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="mobile-menu-dropdown">
            <ul class="mobile-nav-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'items_wrap'     => '%3$s',
                        'depth'          => 1,
                        'walker'         => class_exists( 'NewsToday_Mobile_Menu_Walker' ) ? new NewsToday_Mobile_Menu_Walker() : '',
                    )
                );
                ?>
            </ul>
        </div>

        <!-- Search Overlay (Desktop) -->
        <div id="search-overlay" class="search-overlay" data-search-url="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="search-overlay-bar">
                <!-- Search Input -->
                <div class="search-input-wrapper">
                    <svg class="search-input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke="#999999" stroke-width="2"/>
                        <path d="M16 16L20 20" stroke="#999999" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" id="desktop-search-input" class="search-input" placeholder="<?php esc_attr_e( 'What are you looking for?', 'newstoday' ); ?>" autocomplete="off" />
                </div>
                <!-- Search Button -->
                <button type="button" id="desktop-search-submit" class="search-submit-btn">
                    <?php esc_html_e( 'SEARCH', 'newstoday' ); ?>
                </button>
                <!-- Close Button -->
                <button type="button" class="search-close-btn" aria-label="<?php esc_attr_e( 'Close Search', 'newstoday' ); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                        <path d="M20 4L4 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <!-- Search Results Dropdown -->
            <div id="desktop-search-results" class="search-latest-news" style="display: none;">
                <div class="latest-news-header">
                    <svg width="20" height="20" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.6092 1.68966C1.00285 1.053 1.45414 0 2.33333 0H7.5H12.6667C13.5459 0 13.9971 1.053 13.3908 1.68966L8.22414 7.11466C7.83005 7.52845 7.16995 7.52845 6.77586 7.11466L1.6092 1.68966Z" fill="#FC0303"/>
                    </svg>
                    <span class="search-results-label"><?php esc_html_e( 'Search Results', 'newstoday' ); ?></span>
                </div>
                <ul class="latest-news-list" id="desktop-search-list">
                    <!-- Results will be populated via JavaScript -->
                </ul>
                <div class="no-results-message" style="display: none;">
                    <?php esc_html_e( 'No results found', 'newstoday' ); ?>
                </div>
            </div>
        </div>

        <!-- Mobile Search Overlay -->
        <div id="mobile-search-overlay" class="mobile-search-overlay" data-search-url="<?php echo esc_url( home_url( '/' ) ); ?>">
            <!-- Mobile Search Bar (replaces category scroll) -->
            <div id="mobile-search-bar" class="mobile-search-bar" data-search-url="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="mobile-search-input-wrapper">
                    <input type="text" id="mobile-search-input" class="mobile-search-input" placeholder="<?php esc_attr_e( 'What are you looking for?', 'newstoday' ); ?>" autocomplete="off" />
                </div>
                <button type="button" id="mobile-search-submit" class="mobile-search-submit-btn" aria-label="<?php esc_attr_e( 'Search', 'newstoday' ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="7" stroke="#000000" stroke-width="2"/>
                        <path d="M16 16L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <button type="button" class="mobile-search-close-btn" aria-label="<?php esc_attr_e( 'Close Search', 'newstoday' ); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4L20 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                        <path d="M20 4L4 20" stroke="#000000" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Search Results Dropdown -->
            <div id="mobile-search-dropdown" class="mobile-search-dropdown" style="display: none;">
                <div class="latest-news-header">
                    <svg width="16" height="16" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.6092 1.68966C1.00285 1.053 1.45414 0 2.33333 0H7.5H12.6667C13.5459 0 13.9971 1.053 13.3908 1.68966L8.22414 7.11466C7.83005 7.52845 7.16995 7.52845 6.77586 7.11466L1.6092 1.68966Z" fill="#FC0303"/>
                    </svg>
                    <span class="search-results-label"><?php esc_html_e( 'Search Results', 'newstoday' ); ?></span>
                </div>
                <ul class="latest-news-list" id="mobile-search-list">
                    <!-- Results will be populated via JavaScript -->
                </ul>
                <div class="no-results-message" style="display: none;">
                    <?php esc_html_e( 'No results found', 'newstoday' ); ?>
                </div>
            </div>
        </div>
    </div>
</header>

