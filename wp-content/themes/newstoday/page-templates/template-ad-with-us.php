<?php
/**
 * Template Name: Ad with Us
 *
 * @package NewsToday
 */

get_header();
?>

<?php 
    $banner_image = get_field('banner_image');
?>

<main id="primary" class="site-main ad-with-us-template">
    <div class="container">
        <div class="ad-with-us-layout">
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

            <?php if ( get_field('hero_description') ) : ?>
                <div class="ad-with-us-description"><?php echo wp_kses_post( get_field('hero_description') ); ?></div>
            <?php endif; ?>

            <?php if ( get_field('hero_cta_text') ) : ?>
                <!-- Advertise with us CTA -->
                <div class="advertise-with-us-cta">
                    <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact-us' ) ) ); ?>" class="advertise-with-us-btn">
                        <?php echo esc_html( get_field('hero_cta_text') ); ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="statistics-section">
                <?php if ( get_field('stats_section_title') ) : ?>
                    <h4 class="stats-section-title"><?php echo esc_html( get_field('stats_section_title') ); ?></h4>
                <?php endif; ?>
                <?php if ( get_field('stats_section_description') ) : ?>
                    <p class="stats-section-description">
                        <?php echo wp_kses_post( get_field('stats_section_description') ); ?>
                    </p>
                <?php endif; ?>
                <div class="stats-container">
                    <?php for ($i = 1; $i <= 4; $i++) { 
                        $stat_image = get_field('stat_image_'.$i);
                        $stat_number = get_field('stat_number_'.$i);
                        $stat_title = get_field('stat_title_'.$i);
                        if ( $stat_number || $stat_title || $stat_image ) :
                    ?>
                    <div class="stat-item">
                        <?php if ( $stat_image ) : ?>
                            <img src="<?php echo esc_url($stat_image['url']); ?>" alt="<?php echo esc_attr($stat_image['alt']); ?>">
                        <?php endif; ?>
                        <span class="stat-number" data-target="<?php echo esc_attr($stat_number); ?>">0</span>
                        <span class="stat-label"><?php echo esc_html($stat_title); ?></span>
                    </div>
                    <?php 
                        endif;
                    } ?>
                </div>
            </div>

            <div class="global-high-content-section">
                <div class="global-high-content-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                            <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                        </svg>
                    </div>
                    <?php if ( get_field('global_high_content_title') ) : ?>
                        <h2 class="global-high-content-title"><?php echo esc_html( get_field('global_high_content_title') ); ?></h2>
                    <?php endif; ?>
                </div>
                <?php if ( get_field('global_high_content_description') ) : ?>
                    <div class="global-high-content-description">
                        <?php echo wp_kses_post( get_field('global_high_content_description') ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="real-engagement-section">
                <div class="real-engagement-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                            <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                        </svg>
                    </div>
                    <?php if ( get_field('real_engagement_title') ) : ?>
                        <h2 class="real-engagement-title"><?php echo esc_html( get_field('real_engagement_title') ); ?></h2>
                    <?php endif; ?>
                </div>

                <div class="real-engagement-container">
                    <?php for ($i = 1; $i <= 3; $i++) {
                        $card_image_1 = get_field('real_engagement_card_'.$i.'_image_1');
                        $card_image_2 = get_field('real_engagement_card_'.$i.'_image_2');
                        $card_text = get_field('real_engagement_card_'.$i.'_text');

                        if ($card_image_1 || $card_image_2 || $card_text) :
                    ?>
                    <div class="real-engagement-card">
                        <div class="real-engagement-images">
                            <div class="engagement-image-wrapper">
                                <?php if ($card_image_1) { ?>
                                    <img src="<?php echo esc_url($card_image_1['url']); ?>" alt="<?php echo esc_attr($card_image_1['alt']); ?>">
                                <?php } ?>
                            </div>
                            <div class="engagement-image-wrapper">
                                <?php if ($card_image_2) { ?>
                                    <img src="<?php echo esc_url($card_image_2['url']); ?>" alt="<?php echo esc_attr($card_image_2['alt']); ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($card_text) : ?>
                            <p class="real-engagement-card-text"><?php echo esc_html($card_text); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php 
                        endif;
                    } ?>
                </div>
            </div>

            <div class="website-opportunities-section">
                <div class="website-opportunities-title-wrapper">
                    <div class="icon-wrapper">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                            <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                        </svg>
                    </div>
                    <?php if ( get_field('website_opportunities_title') ) : ?>
                        <h2 class="website-opportunities-title"><?php echo esc_html( get_field('website_opportunities_title') ); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if ( get_field('website_opportunities_description') ) : ?>
                    <div class="website-opportunities-description"><?php echo wp_kses_post( get_field('website_opportunities_description') ); ?></div>
                <?php endif; ?>

                <div class="website-opportunities-content">
                    <?php for ($i = 1; $i <= 20; $i++) { 
                        $opportunity_title = get_field('opportunity_title_'.$i);
                        $opportunity_modal = get_field('opportunity_modal_'.$i);
                        $opportunity_icon = get_field('opportunity_icon_'.$i);

                        if ($opportunity_title) {
                    ?>
                    <div class="website-opportunities-item">
                        <div class="website-opportunities-item-card">
                            <div class="website-opportunities-item-left">
                                <?php if ($opportunity_icon) : ?>
                                    <img class="website-opportunities-item-icon-image" src="<?php echo esc_url($opportunity_icon['url']); ?>" alt="<?php echo esc_attr($opportunity_icon['alt']); ?>">
                                <?php endif; ?>
                                <div class="website-opportunities-item-title">
                                    <h4><?php echo esc_html($opportunity_title); ?></h4>
                                </div>
                            </div>
                            <div class="website-opportunities-item-icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.0781 0C9.09297 0 0 8.93672 0 19.9219C0 30.907 9.09297 40 20.0781 40C31.0633 40 40 30.907 40 19.9219C40 8.93672 31.0633 0 20.0781 0ZM30.625 22.2656H22.4219V30.625C22.4219 31.9172 21.3695 32.9688 20.0781 32.9688C18.7859 32.9688 17.7344 31.9172 17.7344 30.625V22.2656H9.375C8.08281 22.2656 7.03125 21.2141 7.03125 19.9219C7.03125 18.6297 8.08281 17.5781 9.375 17.5781H17.7344V9.375C17.7344 8.08281 18.7859 7.03125 20.0781 7.03125C21.3695 7.03125 22.4219 8.08281 22.4219 9.375V17.5781H30.625C31.9164 17.5781 32.9688 18.6297 32.9688 19.9219C32.9688 21.2141 31.9164 22.2656 30.625 22.2656Z" fill="#FC0303"/>
                                </svg>
                            </div>
                        </div>

                        <div class="oppurtunity-modal-wrapper">
                            <div class="oppurtunity-modal-header">
                                <h3><?php echo esc_html($opportunity_title); ?></h3>
                                <button class="close-modal-button">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_112613)">
                                        <path d="M20.0781 0C9.09297 0 0 8.93672 0 19.9219C0 30.907 9.09297 40 20.0781 40C31.0633 40 40 30.907 40 19.9219C40 8.93672 31.0633 0 20.0781 0ZM29.9391 26.468C30.8531 27.382 30.8531 28.8688 29.9391 29.7836C29.032 30.6898 27.5453 30.7047 26.6234 29.7836L20.0781 23.2359L13.3758 29.7844C12.4617 30.6984 10.975 30.6984 10.0602 29.7844C9.14609 28.8703 9.14609 27.3836 10.0602 26.4688L16.607 19.9219L10.0602 13.375C9.14609 12.4602 9.14609 10.9734 10.0602 10.0594C10.975 9.14531 12.4617 9.14531 13.3758 10.0594L20.0781 16.6078L26.6234 10.0594C27.5359 9.14687 29.0227 9.14375 29.9391 10.0594C30.8531 10.9734 30.8531 12.4602 29.9391 13.375L23.3922 19.9219L29.9391 26.468Z" fill="black"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_1_112613">
                                        <rect width="40" height="40" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                            <div class="oppurtunity-modal-content-wrapper">
                                <div class="oppurtunity-modal-content">
                                    <?php echo wp_kses_post($opportunity_modal); ?>
                                </div>
                            </div>
                            <?php if ( get_field('opportunity_cta_text') ) : ?>
                                <div class="oppurtunity-modal-footer">
                                    <a href="<?php echo esc_url( get_field('opportunity_cta_link') ); ?>" class="oppurtunity-modal-button">
                                        <?php echo esc_html( get_field('opportunity_cta_text') ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php 
                            } 
                        }
                    ?>
                </div>
            </div>
        </div> <!-- Close ad-with-us-layout -->
    </div> <!-- Close container -->

            <!-- Advertising Section (Section 6) -->
            <div class="advertising-section">
                <div class="advertising-container">
                    <div class="advertising-content">
                        <div class="advertising-title-wrapper">
                            <?php 
                            $adv_icon = get_field('advertising_icon');
                            if ($adv_icon): 
                            ?>
                                <div class="icon-wrapper">
                                    <img src="<?php echo esc_url($adv_icon['url']); ?>" alt="<?php echo esc_html($adv_icon['alt']); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            <?php else: ?>
                                <div class="icon-wrapper">
                                    <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                                        <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <?php if ( get_field('advertising_title') ) : ?>
                                <h2 class="advertising-title"><?php echo esc_html( get_field('advertising_title') ); ?></h2>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ( get_field('advertising_description') ) : ?>
                            <div class="advertising-description">
                                <?php echo wp_kses_post( get_field('advertising_description') ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ( get_field('advertising_cta_text') ) : ?>
                            <div class="advertising-btn-wrapper"> 
                                <a href="<?php echo esc_url( get_field('advertising_cta_link') ); ?>" class="advertising-btn">
                                    <?php echo esc_html( get_field('advertising_cta_text') ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="advertising-devices-wrapper">
                        <div class="device-display-area">
                            <!-- Phone Mockup -->
                            <div class="device-mockup phone-mockup active">
                                <?php 
                                $phone_img = get_field('advertising_smartphone_image');
                                $phone_img_url = $phone_img ? $phone_img['url'] : home_url('/wp-content/uploads/2026/01/global-coverage-mobile.png');
                                ?>
                                <img src="<?php echo esc_url($phone_img_url); ?>" alt="Mobile View">
                            </div>

                            <!-- Laptop Mockup -->
                            <div class="device-mockup laptop-mockup">
                                <?php 
                                $laptop_img = get_field('advertising_laptop_image');
                                $laptop_img_url = $laptop_img ? $laptop_img['url'] : home_url('/wp-content/uploads/2026/01/global-coverage-desktop.png');
                                ?>
                                <img src="<?php echo esc_url($laptop_img_url); ?>" alt="Desktop View">
                            </div>
                        </div>

                        <!-- Device Selector -->
                        <div class="device-selectors">
                            <div class="selector-item active" data-device="phone">
                                <div class="selector-dot"></div>
                                <div class="selector-btn">
                                    <svg width="20" height="32" viewBox="0 0 20 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="19" height="31" rx="4" stroke="currentColor" fill="none"/>
                                        <line x1="8" y1="28" x2="12" y2="28" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="selector-item" data-device="laptop">
                                <div class="selector-dot"></div>
                                <div class="selector-btn">
                                    <svg width="32" height="24" viewBox="0 0 32 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="0.5" y="0.5" width="31" height="19" rx="2" stroke="currentColor" fill="none"/>
                                        <path d="M0 21.5C0 20.6716 0.671573 20 1.5 20H30.5C31.3284 20 32 20.6716 32 21.5V23C32 23.5523 31.5523 24 31 24H1C0.447715 24 0 23.5523 0 23V21.5Z" fill="currentColor"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verified Platforms Section (Section 7) -->
            <div class="verified-platforms-section">
                <div class="verified-platforms-container">
                    <div class="verified-platforms-title-wrapper">
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                                <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                            </svg>
                        </div>
                        <?php if ( get_field('verified_platforms_title') ) : ?>
                            <h2 class="verified-platforms-title"><?php echo esc_html( get_field('verified_platforms_title') ); ?></h2>
                        <?php endif; ?>
                    </div>

                    <div class="verified-platforms-row">
                        <?php if ( get_field('verified_platforms_description') ) : ?>
                            <div class="verified-platforms-description-col">
                                <div class="verified-platforms-description">
                                    <?php echo wp_kses_post( get_field('verified_platforms_description') ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="verified-platforms-grid">
                            <?php
                            $verified_platforms = [
                                [
                                    'name' => 'LinkedIn',
                                    'icon_svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',
                                    'fallback_img' => 'Group-2018780147-1.webp',
                                    'acf_field' => 'verified_linkedin_image',
                                    'attachment_id' => 13813,
                                    'class' => 'linkedin-card'
                                ],
                                [
                                    'name' => 'Instagram',
                                    'icon_svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                                    'fallback_img' => 'Group-2018780147-2.webp',
                                    'acf_field' => 'verified_instagram_image',
                                    'attachment_id' => 13815,
                                    'class' => 'instagram-card'
                                ],
                                [
                                    'name' => 'Twitter/X',
                                    'icon_svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                                    'fallback_img' => 'Group-2018780147-3.webp',
                                    'acf_field' => 'verified_twitter_image',
                                    'attachment_id' => 13816,
                                    'class' => 'twitter-card'
                                ],
                                [
                                    'name' => 'Facebook',
                                    'icon_svg' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>',
                                    'fallback_img' => 'Group-2018780147.webp',
                                    'acf_field' => 'verified_facebook_image',
                                    'attachment_id' => 13792,
                                    'class' => 'facebook-card'
                                ]
                            ];

                            foreach ($verified_platforms as $platform) {
                                $custom_img = get_field($platform['acf_field']);
                                if ($custom_img) {
                                    $img_url = $custom_img['url'];
                                } else {
                                    $db_url = wp_get_attachment_url($platform['attachment_id']);
                                    $img_url = $db_url ? $db_url : home_url('/wp-content/uploads/2026/02/' . $platform['fallback_img']);
                                }
                            ?>
                                <div class="platform-card <?php echo esc_attr($platform['class']); ?>">
                                    <div class="platform-logo-badge">
                                        <?php echo $platform['icon_svg']; ?>
                                    </div>
                                    <div class="platform-banner">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($platform['name']); ?> Verification Profile">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Who Is This For Section (Section 8) -->
            <div class="who-is-this-for-section">
                <div class="who-is-this-for-container">
                    <div class="who-is-this-for-title-wrapper">
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                                <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                            </svg>
                        </div>
                        <?php if ( get_field('who_is_this_for_title') ) : ?>
                            <h2 class="who-is-this-for-title"><?php echo esc_html( get_field('who_is_this_for_title') ); ?></h2>
                        <?php endif; ?>
                    </div>

                    <div class="who-is-this-for-grid">
                        <?php
                        $target_audiences = [
                            ['acf_title' => 'operators_sportsbooks_title', 'acf_desc' => 'operators_sportsbooks_desc'],
                            ['acf_title' => 'casino_brands_title', 'acf_desc' => 'casino_brands_desc'],
                            ['acf_title' => 'game_providers_title', 'acf_desc' => 'game_providers_desc'],
                            ['acf_title' => 'affiliates_networks_title', 'acf_desc' => 'affiliates_networks_desc']
                        ];

                        foreach ($target_audiences as $audience) {
                            $title = get_field($audience['acf_title']);
                            $desc = get_field($audience['acf_desc']);
                            if ($title || $desc) {
                        ?>
                            <div class="who-card">
                                <?php if ($title) : ?>
                                    <div class="who-card-title-wrapper">
                                        <h3 class="who-card-title"><?php echo esc_html($title); ?></h3>
                                    </div>
                                <?php endif; ?>
                                <?php if ($desc) : ?>
                                    <p class="who-card-desc"><?php echo esc_html($desc); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php 
                            }
                        } 
                        ?>
                    </div>
                </div>
            </div>

            <!-- FAQ Section (Section 9) -->
            <div class="ad-faq-section">
                <div class="ad-faq-container">
                    <div class="ad-faq-title-wrapper">
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                                <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                            </svg>
                        </div>
                        <?php if ( get_field('ad_faq_title') ) : ?>
                            <h2 class="ad-faq-title"><?php echo esc_html( get_field('ad_faq_title') ); ?></h2>
                        <?php endif; ?>
                    </div>

                    <div class="faq-content">
                        <?php
                        $prepared_faq_items = array();
                        for ($i = 1; $i <= 20; $i++) {
                            $question = get_field('ad_faq_q' . $i);
                            $answer = get_field('ad_faq_a' . $i);

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
                                    'page_id'   => get_the_ID(),
                                    'faq_items' => $prepared_faq_items,
                                )
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
</main>
<div class="oppurtunity-modal-overlay"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const oppurtunityModalOverlay = document.querySelector('.oppurtunity-modal-overlay');
        const opportunityItems = document.querySelectorAll('.website-opportunities-item');
        const opportunityModalWrappers = document.querySelectorAll('.oppurtunity-modal-wrapper');

        function openOpportunityModal(modalWrapper, item) {
            modalWrapper.classList.add('is-open');
            oppurtunityModalOverlay.classList.add('is-open');
            if (item) {
                item.classList.add('modal-open');
            }
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.paddingRight = scrollbarWidth + 'px';
            document.body.style.overflow = 'hidden';
        }

        function closeOpportunityModal() {
            opportunityModalWrappers.forEach(function(modalWrapper) {
                modalWrapper.classList.remove('is-open');
            });
            opportunityItems.forEach(function(item) {
                item.classList.remove('modal-open');
            });
            oppurtunityModalOverlay.classList.remove('is-open');
            document.body.style.paddingRight = '';
            document.body.style.overflow = '';
        }

        // Click on overlay to close
        oppurtunityModalOverlay.addEventListener('click', function() {
            closeOpportunityModal();
        });

        // Click on item (but not on modal) to open
        opportunityItems.forEach(function(item) {
            item.addEventListener('click', function(e) {
                // Don't open if clicking inside the modal
                if (e.target.closest('.oppurtunity-modal-wrapper')) {
                    return;
                }
                const modalWrapper = item.querySelector('.oppurtunity-modal-wrapper');
                if (modalWrapper) {
                    openOpportunityModal(modalWrapper, item);
                }
            });
        });

        // Stop propagation when clicking inside modal
        opportunityModalWrappers.forEach(function(modalWrapper) {
            modalWrapper.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Close button
        const closeModalButtons = document.querySelectorAll('.close-modal-button');
        closeModalButtons.forEach(function(closeModalButton) {
            closeModalButton.addEventListener('click', function(e) {
                e.stopPropagation();
                closeOpportunityModal();
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOpportunityModal();
            }
        });

        // Device Mockup Switcher
        const selectorItems = document.querySelectorAll('.advertising-devices-wrapper .selector-item');
        const deviceMockups = document.querySelectorAll('.advertising-devices-wrapper .device-mockup');

        selectorItems.forEach(item => {
            item.addEventListener('click', function() {
                const device = this.getAttribute('data-device');
                
                // Toggle active state on selectors
                selectorItems.forEach(si => si.classList.remove('active'));
                this.classList.add('active');

                // Toggle active state on mockups
                deviceMockups.forEach(mockup => {
                    if (mockup.classList.contains(`${device}-mockup`)) {
                        mockup.classList.add('active');
                    } else {
                        mockup.classList.remove('active');
                    }
                });
            });
        });

    });
</script>
<?php
get_footer();