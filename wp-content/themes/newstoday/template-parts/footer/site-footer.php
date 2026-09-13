<?php
/**
 * Template part for displaying the site footer
 *
 * @package NewsToday
 */
?>

<footer id="colophon" class="site-footer">
    <!-- Section 1: Main Footer Content -->
    <div class="footer-section-1">
        <div class="footer-grid">
            <!-- Column 1: Brand Info -->
            <div class="footer-brand">
                <?php 
                $footer_logo = get_theme_mod( 'newstoday_footer_logo' );
                $footer_logo_url = ! empty( $footer_logo ) ? $footer_logo : get_template_directory_uri() . '/assets/src/images/ignt-white-logo.svg';
                ?>
                <div class="footer-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php esc_attr_e( 'iGaming News Today', 'newstoday' ); ?>" />
                    </a>
                </div>
                <p class="footer-description">
                    <?php 
                    $footer_description = get_theme_mod( 'newstoday_footer_description', __( 'iGaming News Today delivers verified, primary-source iGaming news on regulation, M&A, casino, sports betting and market moves worldwide. Trusted by operators, suppliers, affiliates and investors for accurate, timely coverage. Partner with us to reach decision-makers across global iGaming markets.', 'newstoday' ) );
                    echo esc_html( $footer_description ); 
                    ?>
                </p>
                <!-- Social Links -->
                <div class="footer-social">
                    <span class="social-label"><?php esc_html_e( 'Follow us:', 'newstoday' ); ?></span>
                    <div class="social-icons">
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_linkedin' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'LinkedIn', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/linkedin-white.svg' ); ?>" alt="<?php esc_attr_e( 'LinkedIn', 'newstoday' ); ?>" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_instagram' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Instagram', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/instagram-white.svg' ); ?>" alt="<?php esc_attr_e( 'Instagram', 'newstoday' ); ?>" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_facebook' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Facebook', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/facebook-white.svg' ); ?>" alt="<?php esc_attr_e( 'Facebook', 'newstoday' ); ?>" />
                        </a>
                        <a href="<?php echo esc_url( get_theme_mod( 'newstoday_social_media_x' ) ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'X', 'newstoday' ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/x-white.svg' ); ?>" alt="<?php esc_attr_e( 'X', 'newstoday' ); ?>" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Navigation Links -->
            <div class="footer-navigation">
                <!-- Pages -->
                <div class="footer-nav-group footer-pages-group">
                    <h4 class="footer-nav-title"><?php esc_html_e( 'Pages', 'newstoday' ); ?></h4>
                    <ul class="footer-nav-list">
                    <?php 
                        $menu1 = wp_get_nav_menu_items('footer-1');
                        foreach ( $menu1 as $item ) {
                            echo '<li><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
                        }
                    ?>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="footer-nav-group footer-categories-group">
                    <h4 class="footer-nav-title"><?php esc_html_e( 'Categories', 'newstoday' ); ?></h4>
                    <ul class="footer-nav-list">
                    <?php 
                        $menu2 = wp_get_nav_menu_items('footer-2');
                        foreach ( $menu2 as $item ) {
                            echo '<li><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
                        }
                    ?>
                    </ul>
                </div>

                <!-- Our Brands -->
                <div class="footer-nav-group footer-brands-group">
                    <h4 class="footer-nav-title"><?php esc_html_e( 'Our Brands', 'newstoday' ); ?></h4>
                    <ul class="footer-nav-list footer-brands-list">
                    <?php 
                        $menu3 = wp_get_nav_menu_items('footer-3');
                        foreach ( $menu3 as $item ) {
                            echo '<li><a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></li>';
                        }
                    ?>
                    </ul>
                </div>
            </div>

            <!-- Column 3: Social & Newsletter -->
            <div class="footer-connect">
                <!-- Newsletter Form -->
                <div class="footer-newsletter">
                    <h4 class="newsletter-title"><?php esc_html_e( 'Sign Up for Our Newsletter', 'newstoday' ); ?></h4>
                    <p class="newsletter-description"><?php esc_html_e( 'Subscribe to our newsletter to get our newest articles instantly!', 'newstoday' ); ?></p>
                    
                    <form id="newsletter-form" class="newsletter-form" method="post">
                        <div class="newsletter-input-group">
                            <input type="email" name="EMAIL" class="newsletter-input" placeholder="<?php esc_attr_e( 'Your email address', 'newstoday' ); ?>" required />
                            <button type="submit" class="newsletter-submit"><?php esc_html_e( 'Subscribe', 'newstoday' ); ?></button>
                        </div>
                        <div class="newsletter-checkbox">
                            <input type="checkbox" id="footer-terms" name="terms" required />
                            <label for="footer-terms"><?php esc_html_e( 'I have read and agree to the terms & conditions', 'newstoday' ); ?></label>
                        </div>
                        <div class="mc4wp-response"></div>
                        <?php if ( function_exists( 'mc4wp_get_form' ) ) : ?>
                            <input type="hidden" name="_mc4wp_form_id" value="11098">
                            <input type="hidden" name="_mc4wp_form_submit" value="1">

                            <!-- Required spam protection fields -->
                            <input type="hidden" name="_mc4wp_timestamp" value="<?php echo esc_attr( time() ); ?>">

                            <!-- Honeypot (must be empty) -->
                            <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;">
                        <?php endif; ?>
                    </form>

                    <!-- Success Message -->
                    <!-- <div class="newsletter-success">
                        <div class="success-badge">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="9" cy="9" r="8" stroke="white" stroke-width="1.5" fill="none"/>
                                <path d="M5.5 9L7.5 11L12.5 6" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span><?php esc_html_e( 'Successful!', 'newstoday' ); ?></span>
                        </div>
                        <p class="success-message"><?php esc_html_e( 'Thank you for subscribing.', 'newstoday' ); ?><br/><?php esc_html_e( 'Check your inbox for a confirmation email.', 'newstoday' ); ?></p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Disclaimer -->
    <div class="footer-section-2">
        <div class="top-section">
            <p class="footer-disclaimer">
                <?php 
                $footer_disclaimer = get_theme_mod( 'newstoday_footer_disclaimer', __( 'We are not responsible for any issues, disruptions, or outcomes that may arise from accessing external links or advertisements that are featured on our website.', 'newstoday' ) );
                echo esc_html( $footer_disclaimer ); 
                ?>
            </p>
            <div class="play-responsibly-wrapper footer-disclaimer">
                <span class="play-responsibly"><?php esc_html_e( 'Play Responsibly 18+', 'newstoday' ); ?></span>
                <span class="link-divider"></span>
                <a href="https://www.gambleaware.org/">GambleAware</a>
                <span class="link-divider"></span>
                <a href="https://www.gamcare.org.uk/">GamCare</a>
            </div>
        </div>
        <div class="bottom-section">
            <div class="footer-copyright">
                <div class="footer-copyright-text">
                    <?php 
                    $custom_copyright = get_theme_mod( 'newstoday_footer_copyright' );
                    if ( ! empty( $custom_copyright ) ) :
                        echo esc_html( $custom_copyright );
                    else :
                    ?>
                        <span class="brand-name"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ? get_bloginfo( 'name', 'display' ) : 'iGamingNewsToday' ); ?></span>
                        <span class="copyright-text"><?php printf( esc_html__( '© %s. All Rights Reserved.', 'newstoday' ), date( 'Y' ) ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="footer-legal-links">
                <?php 
                    $privacy_policy_url = get_permalink( get_page_by_path( 'privacy-policy' ) );
                    $cookies_url = get_permalink( get_page_by_path( 'cookies' ) );
                    $terms_and_conditions_url = get_permalink( get_page_by_path( 'terms-and-conditions' ) );
                    $responsible_gambling_url = get_permalink( get_page_by_path( 'responsible-gambling' ) );
                ?>
                <a href="<?php echo esc_url( $responsible_gambling_url ); ?>">Responsible Gambling</a>
                <span class="link-divider"></span>
                <a href="<?php echo esc_url( $privacy_policy_url ); ?>"><?php esc_html_e( 'PRIVACY POLICY', 'newstoday' ); ?></a>
                <span class="link-divider"></span>
                <a href="<?php echo esc_url( $cookies_url ); ?>"><?php esc_html_e( 'COOKIES', 'newstoday' ); ?></a>
                <span class="link-divider"></span>
                <a href="<?php echo esc_url( $terms_and_conditions_url ); ?>"><?php esc_html_e( 'TERMS & CONDITIONS', 'newstoday' ); ?></a>
            </div>
        </div>
    </div>

</footer>
