<?php
/**
 * Template Name: Contact Us
 * Description: Contact Us page template
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main contact-us-page">
    
    <!-- Contact Hero Section -->
    <section class="contact-hero-section">
        <div class="contact-hero-inner">
            <h1 class="contact-hero-title">
                <?php echo esc_html( get_field('contact_hero_title') ); ?>
            </h1>
            <p class="contact-hero-description">
                <?php echo esc_html( get_field('contact_hero_description') ); ?>
            </p>
        </div>
    </section>

    <!-- Contact Stats Row -->
    <section class="contact-stats-section">
        <div class="contact-stats-container">
            <?php 
            $stats = array();
            $stats_text = get_field('contact_stats_list');
            if ( $stats_text ) {
                $lines = array_filter(array_map('trim', explode("\n", $stats_text)));
                foreach ($lines as $line) {
                    $parts = array_map('trim', explode('|', $line));
                    if (count($parts) >= 2) {
                        $stats[] = array(
                            'val' => $parts[0],
                            'lbl' => $parts[1],
                        );
                    }
                }
            }
            
            foreach ($stats as $index => $stat) {
                ?>
                <div class="stat-counter-item">
                    <span class="stat-number-value"><?php echo esc_html($stat['val']); ?></span>
                    <span class="stat-label-text"><?php echo esc_html($stat['lbl']); ?></span>
                </div>
                <?php
            }
            ?>
        </div>
    </section>

    <div class="contact-us-container">
        
        <!-- Two Column Layout -->
        <div class="contact-us-content">
            <!-- Column 1: 673px -->
            <div class="contact-us-column contact-us-column-1">
                <!-- Section 1: Benefits List -->
                <div class="contact-benefits-section">
                    <!-- Header -->
                    <h2 class="contact-us-header">
                        <?php echo esc_html( get_field('contact_us_title') ); ?>
                    </h2>
                    <div class="contact-us-description">
                        <?php echo esc_html( get_field('contact_us_description') ); ?>
                    </div>
                    <ul class="contact-benefits-list">
                        <?php
                        $packages = array();
                        $interests_text = get_field('contact_us_interests');
                        if ( $interests_text ) {
                            $packages = array_filter(array_map('trim', explode("\n", $interests_text)));
                        }
                        
                        foreach ($packages as $pkg) {
                            ?>
                            <li class="contact-benefit-item">
                                <span class="benefit-icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="6.945" cy="6.945" r="6.945" fill="#FC0303"/>
                                        <path d="M4.17 6.91L5.9 8.99L9.72 5.17" stroke="white" stroke-width="1.21" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="benefit-text"><?php echo esc_html($pkg); ?></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <!-- Section 2: Prefer to Reach Us Directly? -->
                <div class="contact-direct-box">
                    <h3 class="contact-direct-title">
                        <?php echo esc_html( get_field('contact_direct_title') ); ?>
                    </h3>
                    <?php 
                    $contact_direct_email = get_field('contact_direct_email');
                    $contact_direct_label = get_field('contact_direct_label');
                    ?>
                    <a href="mailto:<?php echo esc_attr($contact_direct_email); ?>" class="contact-direct-card-link">
                        <div class="contact-direct-card">
                            <div class="contact-direct-icon-container">
                                <span class="contact-direct-icon">
                                    <svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.5 1.5L9 7.5L16.5 1.5" stroke="#FF0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <rect x="1.5" y="1.5" width="15" height="10" rx="1.5" stroke="#FF0000" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="contact-direct-info">
                                <span class="contact-direct-label"><?php echo esc_html($contact_direct_label); ?></span>
                                <span class="contact-direct-email"><?php echo esc_html($contact_direct_email); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Column Divider Line -->
            <div class="contact-columns-divider"></div>

            <!-- Column 2: 525px -->
            <div class="contact-us-column contact-us-column-2">
                <!-- Form Headers -->
                <div class="contact-form-header-box">
                    <h2 class="contact-form-title">
                        <?php echo esc_html( get_field('contact_form_title') ); ?>
                    </h2>
                    <p class="contact-form-subtitle">
                        <?php echo esc_html( get_field('contact_form_subtitle') ); ?>
                    </p>
                </div>

                <div class="contact-form-container">
                    <div class="contact-form-wrapper">
                        <?php echo do_shortcode( get_field('contact_form_shortcode') ); ?>
                    </div>
                    <div class="contact-form-submit-section">
                        <p class="contact-privacy-text">
                            <?php 
                            printf(
                                esc_html__( 'By clicking submit, I acknowledge %s\'s %s', 'newstoday' ),
                                'igamingnewstoday.com',
                                '<a href="' . esc_url( home_url( '/privacy-policy/' ) ) . '" class="privacy-policy-link">' . esc_html__( 'Privacy Policy', 'newstoday' ) . '</a>'
                            );
                            ?>
                        </p>
                        <button type="submit" class="contact-submit-button">
                            <?php esc_html_e( 'SUBMIT', 'newstoday' ); ?>
                        </button>
                    </div>
                </div>

                <!-- Thank You Section -->
                <div class="contact-thank-you-container" style="display: none;">
                    <h2 class="thank-you-title">
                        <?php esc_html_e( 'Thank You!', 'newstoday' ); ?>
                    </h2>
                    <p class="thank-you-description">
                        <?php esc_html_e( 'Thank you for sending your query to us. Sit back and relax while we weave our magic and get back to you with all the information', 'newstoday' ); ?>
                    </p>
                    <div class="thank-you-social">
                        <span class="thank-you-social-label"><?php esc_html_e( 'Follow Us:', 'newstoday' ); ?></span>
                        <div class="thank-you-social-icons">
                            <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_facebook' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Facebook', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/dark/Facebook.svg' ); ?>" alt="<?php esc_attr_e( 'Facebook', 'newstoday' ); ?>" />
                            </a>
                            <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_instagram' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Instagram', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/dark/Instagram.svg' ); ?>" alt="<?php esc_attr_e( 'Instagram', 'newstoday' ); ?>" />
                            </a>
                            <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_x' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'X', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/dark/X.svg' ); ?>" alt="<?php esc_attr_e( 'X', 'newstoday' ); ?>" />
                            </a>
                            <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_linkedin' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'LinkedIn', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/dark/Linkedin.svg' ); ?>" alt="<?php esc_attr_e( 'LinkedIn', 'newstoday' ); ?>" />
                            </a>
                            <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_youtube' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'YouTube', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/logo/dark/Youtube.svg' ); ?>" alt="<?php esc_attr_e( 'YouTube', 'newstoday' ); ?>" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Plans Section (Not Sure Where to Start?) -->
    <?php 
    $plans_section_title = get_field('plans_section_title');
    $plans_section_subtitle = get_field('plans_section_subtitle');
    $plans_explore_button_text = get_field('plans_explore_button_text');
    $plans_explore_button_link = get_field('plans_explore_button_link');
    ?>
    <section class="contact-plans-section">
        <div class="contact-plans-container">
            <div class="contact-plans-header">
                <h2 class="contact-plans-title"><?php echo esc_html($plans_section_title); ?></h2>
                <p class="contact-plans-subtitle"><?php echo esc_html($plans_section_subtitle); ?></p>
            </div>
            
            <div class="contact-plans-grid">
                <?php 
                $plans = array();
                $plans_text = get_field('contact_plans_list');
                if ( $plans_text ) {
                    $lines = array_filter(array_map('trim', explode("\n", $plans_text)));
                    foreach ($lines as $line) {
                        $parts = array_map('trim', explode('|', $line));
                        if (count($parts) >= 3) {
                            $plans[] = array(
                                'title'       => $parts[0],
                                'text'        => $parts[1],
                                'price'       => $parts[2],
                                'is_featured' => !empty($parts[3]),
                                'tag'         => isset($parts[3]) ? $parts[3] : '',
                                'btn_text'    => 'contact us',
                            );
                        }
                    }
                }
                
                foreach ($plans as $index => $plan) {
                    if ($index > 0) {
                        ?>
                        <div class="plan-card-divider"></div>
                        <?php
                    }
                    
                    $card_class = 'contact-plan-card';
                    if ( $plan['is_featured'] ) {
                        $card_class .= ' featured-plan';
                    }
                    ?>
                    <div class="<?php echo esc_attr($card_class); ?>">
                        <?php if ( $plan['is_featured'] && !empty($plan['tag']) ) : ?>
                            <span class="most-popular-tag"><?php echo esc_html($plan['tag']); ?></span>
                        <?php endif; ?>
                        <h3 class="plan-card-title"><span class="title-bullet"></span><?php echo esc_html($plan['title']); ?></h3>
                        <p class="plan-card-text"><?php echo esc_html($plan['text']); ?></p>
                        <span class="plan-card-price"><?php echo esc_html($plan['price']); ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            
            <div class="contact-plans-action">
                <a href="<?php echo esc_url($plans_explore_button_link); ?>" class="explore-plans-button"><?php echo esc_html($plans_explore_button_text); ?></a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>

