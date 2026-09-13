<?php
/**
 * Template Name: Author Transparency
 * Description: Custom page template for listing authors / editorial team with transparency details.
 *
 * @package NewsToday
 */

get_header();

// Fetch template field settings (ACF)
$banner_title = function_exists( 'get_field' ) ? get_field( 'banner_title' ) : '';
$banner_description = function_exists( 'get_field' ) ? get_field( 'banner_description' ) : '';
$stats_title = function_exists( 'get_field' ) ? get_field( 'stats_title' ) : '';

// Trust Badge 1
$badge_title_1 = function_exists( 'get_field' ) ? get_field( 'badge_title_1' ) : '';
$badge_desc_1 = function_exists( 'get_field' ) ? get_field( 'badge_desc_1' ) : '';

// Trust Badge 2
$badge_title_2 = function_exists( 'get_field' ) ? get_field( 'badge_title_2' ) : '';
$badge_desc_2 = function_exists( 'get_field' ) ? get_field( 'badge_desc_2' ) : '';

// Trust Badge 3
$badge_title_3 = function_exists( 'get_field' ) ? get_field( 'badge_title_3' ) : '';
$badge_desc_3 = function_exists( 'get_field' ) ? get_field( 'badge_desc_3' ) : '';

// CTA Banner
$cta_title = function_exists( 'get_field' ) ? get_field( 'cta_title' ) : '';
$cta_subtitle = function_exists( 'get_field' ) ? get_field( 'cta_subtitle' ) : '';

// FAQs Section Title
$authors_faq_title = function_exists( 'get_field' ) ? get_field( 'authors_faq_title' ) : '';

// Icons
$page_title_icon = function_exists( 'get_field' ) ? get_field( 'page_title_icon' ) : null;
$editorial_title_icon = function_exists( 'get_field' ) ? get_field( 'editorial_title_icon' ) : null;
$faq_title_icon = function_exists( 'get_field' ) ? get_field( 'faq_title_icon' ) : null;
$badge_icon_1 = function_exists( 'get_field' ) ? get_field( 'badge_icon_1' ) : null;
$badge_icon_2 = function_exists( 'get_field' ) ? get_field( 'badge_icon_2' ) : null;
$badge_icon_3 = function_exists( 'get_field' ) ? get_field( 'badge_icon_3' ) : null;

// Editorial Team dynamic strings
$editorial_title = function_exists( 'get_field' ) ? get_field( 'editorial_title' ) : '';
$editorial_subtitle = function_exists( 'get_field' ) ? get_field( 'editorial_subtitle' ) : '';
?>

<main id="primary" class="site-main author-transparency-page">

    <!-- Page Title Header -->
    <section class="author-section author-title-description">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <?php if ( ! empty( $page_title_icon ) ) : ?>
                        <div class="icon-wrapper">
                            <img src="<?php echo esc_url( $page_title_icon['url'] ); ?>" alt="<?php echo esc_attr( $page_title_icon['alt'] ); ?>" style="width: 50px; height: 50px; object-fit: contain;">
                        </div>
                    <?php else : ?>
                        <div class="icon-wrapper">
                            <svg width="50" height="50" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <h1 class="page-title"><?php echo esc_html( $stats_title ); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero / Stats Banner -->
    <section class="author-transparency-hero">
        <div class="container">
            <div class="hero-content-wrapper">
                <h2 class="hero-headline"><?php echo esc_html( $banner_title ); ?></h2>
                <p class="hero-description"><?php echo esc_html( $banner_description ); ?></p>
            </div>

            <!-- Stats Grid inside Hero -->
            <div class="hero-stats-grid">
                <?php
                for ( $i = 1; $i <= 4; $i++ ) {
                    $stat_number = function_exists( 'get_field' ) ? get_field( 'stat_number_' . $i ) : '';
                    $stat_title  = function_exists( 'get_field' ) ? get_field( 'stat_title_' . $i ) : '';

                    if ( empty( $stat_number ) ) {
                        continue;
                    }
                    ?>
                    <div class="hero-stat-box">
                        <span class="stat-number" data-target="<?php echo esc_attr( $stat_number ); ?>">0</span>
                        <span class="stat-label"><?php echo esc_html( $stat_title ); ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Trust Badges Section -->
    <section class="trust-badges-section">
        <div class="container badges-grid">
            <?php if ( ! empty( $badge_title_1 ) ) : ?>
            <div class="badge-item">
                <div class="badge-icon">
                    <?php if ( ! empty( $badge_icon_1 ) ) : ?>
                        <img src="<?php echo esc_url( $badge_icon_1['url'] ); ?>" alt="<?php echo esc_attr( $badge_icon_1['alt'] ); ?>" style="width: 24px; height: 24px; object-fit: contain;">
                    <?php else : ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/shield-icon.svg' ); ?>" alt="" onerror="this.style.display='none';">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="fallback-icon">
                            <circle cx="12" cy="12" r="10" stroke="#FC0303" stroke-width="2"/>
                            <circle cx="12" cy="12" r="6" stroke="#FC0303" stroke-width="2"/>
                            <circle cx="12" cy="12" r="2" fill="#FC0303"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="badge-text-wrapper">
                    <h3 class="badge-title"><?php echo esc_html( $badge_title_1 ); ?></h3>
                    <p class="badge-desc"><?php echo esc_html( $badge_desc_1 ); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $badge_title_2 ) ) : ?>
            <div class="badge-item">
                <div class="badge-icon">
                    <?php if ( ! empty( $badge_icon_2 ) ) : ?>
                        <img src="<?php echo esc_url( $badge_icon_2['url'] ); ?>" alt="<?php echo esc_attr( $badge_icon_2['alt'] ); ?>" style="width: 24px; height: 24px; object-fit: contain;">
                    <?php else : ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/verified-icon.svg' ); ?>" alt="" onerror="this.style.display='none';">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="fallback-icon">
                            <circle cx="12" cy="12" r="10" stroke="#FC0303" stroke-width="2"/>
                            <path d="M7 12l3 3 7-7" stroke="#FC0303" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="badge-text-wrapper">
                    <h3 class="badge-title"><?php echo esc_html( $badge_title_2 ); ?></h3>
                    <p class="badge-desc"><?php echo esc_html( $badge_desc_2 ); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( ! empty( $badge_title_3 ) ) : ?>
            <div class="badge-item">
                <div class="badge-icon">
                    <?php if ( ! empty( $badge_icon_3 ) ) : ?>
                        <img src="<?php echo esc_url( $badge_icon_3['url'] ); ?>" alt="<?php echo esc_attr( $badge_icon_3['alt'] ); ?>" style="width: 24px; height: 24px; object-fit: contain;">
                    <?php else : ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/unbiased-icon.svg' ); ?>" alt="" onerror="this.style.display='none';">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="fallback-icon">
                            <circle cx="12" cy="13" r="8" stroke="#FC0303" stroke-width="2"/>
                            <path d="M12 9v4h3M10 2h4M12 2v3M5 6l2-2M19 6l-2-2" stroke="#FC0303" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="badge-text-wrapper">
                    <h3 class="badge-title"><?php echo esc_html( $badge_title_3 ); ?></h3>
                    <p class="badge-desc"><?php echo esc_html( $badge_desc_3 ); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Editorial Team List -->
    <section class="editorial-team-section">
        <div class="container">
            <div class="section-header">
            <div class="section-title-wrapper">
                <?php if ( ! empty( $editorial_title_icon ) ) : ?>
                    <div class="icon-wrapper">
                        <img src="<?php echo esc_url( $editorial_title_icon['url'] ); ?>" alt="<?php echo esc_attr( $editorial_title_icon['alt'] ); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                    </div>
                <?php else : ?>
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                            <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <h2 class="section-title"><?php echo esc_html( $editorial_title ); ?></h2>
            </div>
            <p class="section-subtitle"><?php echo esc_html( $editorial_subtitle ); ?></p>
        </div>

        <!-- Authors Listing with Pagination (12 per page) -->
        <div class="authors-list">
            <?php
            $number_of_authors_per_page = 12;
            $paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
            $offset = ( $paged - 1 ) * $number_of_authors_per_page;

            // Count total authors to calculate total pages
            $total_authors_query = new WP_User_Query( array(
                'role__in' => array( 'editor', 'author' ),
                'count_total' => true,
            ) );
            $total_authors = $total_authors_query->get_total();
            $total_pages = ceil( $total_authors / $number_of_authors_per_page );

            // Fetch current page's authors
            $authors_query = new WP_User_Query( array(
                'role__in' => array( 'editor', 'author' ),
                'number'   => $number_of_authors_per_page,
                'offset'   => $offset,
                'orderby'  => 'display_name',
                'order'    => 'ASC',
            ) );
            $authors = $authors_query->get_results();

            if ( ! empty( $authors ) ) :
                foreach ( $authors as $author ) :
                    $author_id = $author->ID;
                    $author_name = $author->display_name;

                    // Retrieve metadata
                    $author_job_title = (string) get_user_meta( $author_id, 'author_job_title', true );
                    if ( empty( $author_job_title ) && function_exists( 'get_field' ) ) {
                        $author_job_title = (string) get_field( 'author_job_title', 'user_' . $author_id );
                    }
                    if ( empty( $author_job_title ) ) {
                        $author_job_title = __( 'GAMING JOURNALIST', 'newstoday' );
                    }

                    $author_linkedin = (string) get_user_meta( $author_id, 'author_linkedin', true );
                    if ( empty( $author_linkedin ) && function_exists( 'get_field' ) ) {
                        $author_linkedin = (string) get_field( 'author_linkedin', 'user_' . $author_id );
                    }

                    $author_twitter = (string) get_user_meta( $author_id, 'author_twitter', true );
                    if ( empty( $author_twitter ) && function_exists( 'get_field' ) ) {
                        $author_twitter = (string) get_field( 'author_twitter', 'user_' . $author_id );
                    }

                    $author_email = $author->user_email;

                    // Retrieve Bio description
                    $author_bio = '';
                    if ( function_exists( 'get_field' ) ) {
                        $author_bio = get_field( 'author_content', 'user_' . $author_id );
                    }
                    if ( empty( $author_bio ) ) {
                        $author_bio = get_the_author_meta( 'description', $author_id );
                    }
                    ?>
                    <div class="author-list-card">
                        <div class="author-card-avatar">
                            <div class="avatar-inner">
                                <?php echo get_avatar( $author_id, 150, '', esc_attr( $author_name ) ); ?>
                            </div>
                        </div>
                        <div class="author-card-info">
                            <h3 class="author-card-name"><?php echo esc_html( $author_name ); ?></h3>
                            <span class="author-card-job"><?php echo esc_html( strtoupper( $author_job_title ) ); ?></span>
                            <div class="author-card-bio">
                                <p><?php echo esc_html( wp_trim_words( $author_bio, 45, '...' ) ); ?></p>
                            </div>
                            <div class="author-card-footer">
                                <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" class="view-profile-link">
                                    <?php esc_html_e( 'View Profile', 'newstoday' ); ?> &rarr;
                                </a>
                                <div class="author-card-socials">
                                    <?php if ( ! empty( $author_email ) ) : ?>
                                        <a href="mailto:<?php echo esc_attr( $author_email ); ?>" class="social-icon icon-email" aria-label="<?php esc_attr_e( 'Email', 'newstoday' ); ?>">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $author_linkedin ) ) : ?>
                                        <a href="<?php echo esc_url( $author_linkedin ); ?>" class="social-icon icon-linkedin" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $author_twitter ) ) : ?>
                                        <a href="<?php echo esc_url( $author_twitter ); ?>" class="social-icon icon-twitter" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>

                <!-- Pagination Links -->
                <?php if ( $total_pages > 1 ) : ?>
                    <div class="pagination-wrapper">
                        <nav class="pagination" aria-label="<?php esc_attr_e( 'Authors list pagination', 'newstoday' ); ?>">
                            <?php
                            echo paginate_links( array(
                                'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                'format'    => '?paged=%#%',
                                'current'   => $paged,
                                'total'     => $total_pages,
                                'prev_next' => false,
                                'type'      => 'plain',
                            ) );
                            ?>
                        </nav>
                    </div>
                <?php endif; ?>

            <?php
            else :
                ?>
                <p class="no-authors-found"><?php esc_html_e( 'No authors found.', 'newstoday' ); ?></p>
            <?php endif; ?>
        </div>
        </div>
    </section>

    <!-- Middle CTA Banner Section -->
    <section class="author-cta-section">
        <div class="container">
            <h2 class   ="cta-title"><?php echo esc_html( $cta_title ); ?></h2>
            <p class="cta-subtitle"><?php echo esc_html( $cta_subtitle ); ?></p>
            <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="cta-button">
                <?php esc_html_e( 'Contact Our Team', 'newstoday' ); ?>
            </a>
        </div>
    </section>

    <!-- Frequently Asked Questions Section -->
    <section class="author-section author-faq-section">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <?php if ( ! empty( $faq_title_icon ) ) : ?>
                        <div class="icon-wrapper">
                            <img src="<?php echo esc_url( $faq_title_icon['url'] ); ?>" alt="<?php echo esc_attr( $faq_title_icon['alt'] ); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                        </div>
                    <?php else : ?>
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo esc_html( $authors_faq_title ); ?></h2>
                </div>
            </div>

            <div class="faq-content">
                <?php
                $prepared_faq_items = array();
                for ( $i = 1; $i <= 20; $i++ ) {
                    $question = function_exists( 'get_field' ) ? get_field( 'authors_faq_q' . $i ) : '';
                    $answer   = function_exists( 'get_field' ) ? get_field( 'authors_faq_a' . $i ) : '';

                    if ( ! empty( $question ) && ! empty( $answer ) ) {
                        $prepared_faq_items[] = array(
                            'question' => $question,
                            'answer'   => $answer,
                        );
                    }
                }

                get_template_part(
                    'template-parts/faq/faq-accordion',
                    null,
                    array(
                        'page_id'   => get_the_ID(),
                        'faq_items' => $prepared_faq_items,
                    )
                );
                ?>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
