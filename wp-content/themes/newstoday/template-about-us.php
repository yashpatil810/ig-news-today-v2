<?php
/**
 * Template Name: About Us
 * Description: About Us page template
 *
 * @package NewsToday
 */

get_header();
$about_page_id = get_the_ID();
?>

<main id="primary" class="site-main about-us-page">
    <section class="about-section about-us-title-description">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                        <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                        </svg>
                    </div>
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </div>
            </div>

            <div class="section-content ad-with-us-description"><?php echo get_field('about_us_description'); ?></div>
        </div>
    </section>
    <!-- Section 1: What We Do -->
    <section class="about-section about-what-we-do">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <h2 class="section-title"><?php echo get_field('what_we_do_title'); ?></h2>
                </div>
            </div>
            <div class="section-content what-we-do-content"><?php echo get_field('what_we_do_content'); ?></div>
        </div>
    </section>

    <!-- Section 2: Our Footprints -->
    <section class="about-section about-our-footprints">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo get_field('footprint_title'); ?></h2>
                </div>
            </div>
            <div class="section-content our-footprints-content"><?php echo get_field('footprint_content'); ?></div>
        </div>
        <div class="our-footprints-image">
            <img src="<?php echo get_field('footprint_image')['url']; ?>" alt="<?php echo get_field('footprint_image')['alt']; ?>" />
        </div>
    </section>

    <!-- Section 3: What We Cover -->
    <section class="about-section about-what-we-cover">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('what_we_cover_title') ? get_field('what_we_cover_title') : 'What We Cover' ); ?></h2>
                </div>
            </div>
        </div>
        <div class="what-we-cover-content">
            <div class="container">
                <div class="what-we-cover-grid" role="list">
                    <?php
                    for ($i = 1; $i <= 20; $i++) {
                        $cover_title = get_field('what_we_cover_title_' . $i);
                        $cover_desc = get_field('what_we_cover_desc_' . $i);

                        if ($cover_title && $cover_desc) {
                            ?>
                            <article class="what-we-cover-card" role="listitem">
                                <h3 class="what-we-cover-card__title"><?php echo esc_html($cover_title); ?></h3>
                                <p class="what-we-cover-card__description"><?php echo esc_html($cover_desc); ?></p>
                            </article>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: OUR EDITORIAL PRINCIPLES -->
    <section class="about-section about-title-description-template about-our-editorial-principles">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('our_editorial_principles_title') ? get_field('our_editorial_principles_title') : 'Our Editorial Principles' ); ?></h2>
                </div>
            </div>
            <div class="section-content our-editorial-principles-content"><?php echo get_field('our_editorial_principles_content'); ?></div>
        </div>
    </section>

    <!-- Section 5: Exclusive Industry Access -->
    <section class="about-section about-title-description-template about-our-editorial-principles">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('exclusive_industry_access_title') ? get_field('exclusive_industry_access_title') : 'Exclusive Industry Access' ); ?></h2>
                </div>
            </div>
            <div class="section-content exclusive-industry-access-content"><?php echo get_field('exclusive_industry_access_content'); ?></div>
        </div>
    </section>

    <!-- Section 6: Why Brands Work With Us -->
    <section class="about-section about-title-description-template about-why-brands-work-with-us">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('why_brands_work_with_us_title') ? get_field('why_brands_work_with_us_title') : 'Why Brands Work With Us' ); ?></h2>
                </div>
            </div>
            <div class="section-content why-brands-work-with-us-content"><?php echo get_field('why_brands_work_with_us_content'); ?></div>
        </div>
    </section>

    <!-- Section 7: Author Transparency -->
    <section class="about-section about-title-description-template about-author-transparency">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('author_transparency_title') ? get_field('author_transparency_title') : 'Author Transparency' ); ?></h2>
                </div>
            </div>
            <div class="section-content author-transparency-content"><?php echo get_field('author_transparency_content'); ?></div>

            <?php
            $about_team_users = get_users(
                array(
                    'role__in' => array( 'editor', 'author' ),
                    'orderby'  => 'display_name',
                    'order'    => 'ASC',
                )
            );
            ?>
            <?php if ( ! empty( $about_team_users ) ) : ?>
                <div class="authour-list-outer">
                    <div class="authour-list" role="list">
                        <?php
                        foreach ( $about_team_users as $about_user ) :
                            $about_uid = $about_user->ID;

                            // WordPress user profile: Biographical Info (stored as description).
                            $about_bio = get_the_author_meta( 'description', $about_uid );

                            // Prefer the native user_meta field (saved from WP Admin user profile).
                            // Fall back to ACF field, then default label.
                            $about_job_title = (string) get_user_meta( $about_uid, 'author_job_title', true );
                            if ( empty( $about_job_title ) && function_exists( 'get_field' ) ) {
                                $about_job_title = (string) get_field( 'author_job_title', 'user_' . $about_uid );
                            }
                            if ( empty( $about_job_title ) ) {
                                $about_job_title = __( 'iGaming Journalist', 'newstoday' );
                            }

                            // Prefer the native user_meta field (saved from WP Admin user profile).
                            // Fall back to ACF field.
                            $about_linkedin = (string) get_user_meta( $about_uid, 'author_linkedin', true );
                            if ( empty( $about_linkedin ) && function_exists( 'get_field' ) ) {
                                $about_linkedin = (string) get_field( 'author_linkedin', 'user_' . $about_uid );
                            }

                            $about_email = $about_user->user_email;
                            $about_name  = $about_user->display_name;
                            $author_url  = get_author_posts_url( $about_uid );
                            ?>
                            <article class="authour-card" role="listitem">
                                <div class="authour-card__avatar-ring">
                                    <div class="avatar-inner">
                                        <?php echo get_avatar( $about_uid, 256, '', esc_attr( $about_name ) ); ?>
                                    </div>
                                </div>

                                <div class="authour-card__name-row">
                                    <h3 class="authour-card__name">
                                        <a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $about_name ); ?></a>
                                    </h3>
                                    <div class="authour-card__socials">
                                        <?php if ( ! empty( $about_linkedin ) ) : ?>
                                            <a href="<?php echo esc_url( $about_linkedin ); ?>" class="authour-card__social authour-card__social--linkedin" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( sprintf( __( '%s on LinkedIn', 'newstoday' ), $about_name ) ); ?>">
                                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M14 28C21.732 28 28 21.732 28 14C28 6.26801 21.732 0 14 0C6.26801 0 0 6.26801 0 14C0 21.732 6.26801 28 14 28Z" fill="#007AB9"/>
                                                    <path d="M22.3636 15.1289V20.9008H19.0172V15.5157C19.0172 14.1636 18.534 13.2402 17.3224 13.2402C16.3978 13.2402 15.8485 13.8618 15.6059 14.4638C15.5178 14.6789 15.4951 14.9776 15.4951 15.2794V20.9005H12.1485C12.1485 20.9005 12.1934 11.78 12.1485 10.8359H15.4954V12.2621C15.4886 12.2734 15.4791 12.2844 15.4731 12.2951H15.4954V12.2621C15.9401 11.5778 16.7332 10.5995 18.5113 10.5995C20.713 10.5995 22.3636 12.038 22.3636 15.1289ZM8.64759 5.98438C7.50285 5.98438 6.75391 6.73581 6.75391 7.72308C6.75391 8.68939 7.48113 9.46254 8.60367 9.46254H8.62538C9.79259 9.46254 10.5183 8.68939 10.5183 7.72308C10.4961 6.73581 9.79259 5.98438 8.64759 5.98438ZM6.95281 20.9008H10.2982V10.8359H6.95281V20.9008Z" fill="#F1F2F2"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $about_email ) ) : ?>
                                            <a href="mailto:<?php echo esc_attr( $about_email ); ?>" class="authour-card__social authour-card__social--email" aria-label="<?php esc_attr_e( 'Email', 'newstoday' ); ?>">
                                                <svg class="authour-card__social-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <p class="authour-card__job"><?php echo esc_html( $about_job_title ); ?></p>

                                <?php if ( ! empty( $about_bio ) ) : ?>
                                    <div class="authour-card__bio">
                                        <?php echo wp_kses_post( wpautop( $about_bio ) ); ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Section 8: FAQ -->
    <section class="about-section about-title-description-template about-faq">
        <div class="container">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="section-title"><?php echo esc_html( get_field('faq_title') ? get_field('faq_title') : 'Frequently Asked Questions' ); ?></h2>
                </div>
            </div>
            <div class="faq-content">
                <?php
                $prepared_faq_items = array();
                for ($i = 1; $i <= 20; $i++) {
                    $question = get_field('about_faq_q' . $i);
                    $answer = get_field('about_faq_a' . $i);

                    if ($question && $answer) {
                        $prepared_faq_items[] = array(
                            'question' => $question,
                            'answer'   => $answer,
                        );
                    }
                }

                if (!empty($prepared_faq_items)) {
                    get_template_part(
                        'template-parts/faq/faq-accordion',
                        null,
                        array(
                            'page_id'   => $about_page_id,
                            'faq_items' => $prepared_faq_items,
                        )
                    );
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Section 9: Contact Us Form Section -->
    <section class="about-contact-section">
        <div class="about-contact-container">
            <div class="about-contact-inner">
                <div class="about-contact-header">
                    <div class="about-contact-title-row">
                        <div class="icon-wrapper">
                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 5.91992H27L17.5263 43.9199L7 5.91992Z" fill="#FC0303"/>
                                <path d="M24 43.9199H43L34 5.91992L24 43.9199Z" fill="#FFFFFF"/>
                            </svg>
                        </div>
                        <h2 class="contact-title"><?php echo esc_html( get_field('about_contact_title') ? get_field('about_contact_title') : 'Contact Us' ); ?></h2>
                    </div>
                    <p class="contact-subtitle">
                        <?php echo esc_html( get_field('about_contact_subtitle') ? get_field('about_contact_subtitle') : 'iGaming News Today works with licensed casinos, sportsbooks, iGaming providers, affiliates, and service companies to build trusted' ); ?>
                    </p>
                </div>

                <div class="contact-form-container">
                    <div class="contact-form-wrapper">
                        <?php 
                        $shortcode = get_field('about_contact_form_shortcode');
                        if (empty($shortcode)) {
                            $shortcode = '[contact-form-7 id="10982" title="Contact form 1"]';
                        }
                        echo do_shortcode($shortcode); 
                        ?>
                    </div>
                    <div class="contact-form-submit-section">
                        <p class="contact-privacy-text">
                            <?php 
                            printf(
                                esc_html__( 'By clicking submit, I acknowledge %s\'s %s', 'newstoday' ),
                                'igamingnewstoday.co',
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
    </section>
</main>

<?php
get_footer();

