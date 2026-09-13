<?php 
/**
 * Customizer
 *
 * @package NewsToday
 */

if ( ! function_exists( 'newstoday_customize_register' ) ) :
function newstoday_customize_register( $wp_customize ) {
    // social media links
    $wp_customize->add_section( 'newstoday_social_media_section', array(
        'title' => __( 'Social Media Links', 'newstoday' ),
        'priority' => 100,
    ) );

    $wp_customize->add_setting( 'newstoday_social_media_links', array(
        'default' => '',
        'transport' => 'refresh',
    ) );

    // Facebook
    $wp_customize->add_setting( 'newstoday_social_media_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'newstoday_social_media_facebook', array(
        'label' => __( 'Facebook', 'newstoday' ),
        'section' => 'newstoday_social_media_section',
        'settings' => 'newstoday_social_media_facebook',
        'type' => 'text',
    ) );

    // Instagram
    $wp_customize->add_setting( 'newstoday_social_media_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'newstoday_social_media_instagram', array(
        'label' => __( 'Instagram', 'newstoday' ),
        'section' => 'newstoday_social_media_section',
        'settings' => 'newstoday_social_media_instagram',
        'type' => 'text',
    ) );

    // X
    $wp_customize->add_setting( 'newstoday_social_media_x', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'newstoday_social_media_x', array(
        'label' => __( 'X', 'newstoday' ),
        'section' => 'newstoday_social_media_section',
        'settings' => 'newstoday_social_media_x',
        'type' => 'text',
    ) );

    // LinkedIn
    $wp_customize->add_setting( 'newstoday_social_media_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'newstoday_social_media_linkedin', array(
        'label' => __( 'LinkedIn', 'newstoday' ),
        'section' => 'newstoday_social_media_section',
        'settings' => 'newstoday_social_media_linkedin',
        'type' => 'text',
    ) );

    // YouTube
    $wp_customize->add_setting( 'newstoday_social_media_youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'newstoday_social_media_youtube', array(
        'label' => __( 'YouTube', 'newstoday' ),
        'section' => 'newstoday_social_media_section',
        'settings' => 'newstoday_social_media_youtube',
        'type' => 'text',
    ) );

    // Footer Settings Section
    $wp_customize->add_section( 'newstoday_footer_section', array(
        'title'    => __( 'Footer Settings', 'newstoday' ),
        'priority' => 110,
    ) );

    // Footer Logo
    $wp_customize->add_setting( 'newstoday_footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'newstoday_footer_logo', array(
        'label'    => __( 'Footer White Logo', 'newstoday' ),
        'section'  => 'newstoday_footer_section',
        'settings' => 'newstoday_footer_logo',
    ) ) );

    // Footer Description
    $wp_customize->add_setting( 'newstoday_footer_description', array(
        'default'           => __( 'iGaming News Today delivers verified, primary-source iGaming news on regulation, M&A, casino, sports betting and market moves worldwide. Trusted by operators, suppliers, affiliates and investors for accurate, timely coverage. Partner with us to reach decision-makers across global iGaming markets.', 'newstoday' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'newstoday_footer_description', array(
        'label'    => __( 'Footer Description Text', 'newstoday' ),
        'section'  => 'newstoday_footer_section',
        'settings' => 'newstoday_footer_description',
        'type'     => 'textarea',
    ) );

    // Footer Disclaimer
    $wp_customize->add_setting( 'newstoday_footer_disclaimer', array(
        'default'           => __( 'We are not responsible for any issues, disruptions, or outcomes that may arise from accessing external links or advertisements that are featured on our website.', 'newstoday' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'newstoday_footer_disclaimer', array(
        'label'    => __( 'Footer Disclaimer Text', 'newstoday' ),
        'section'  => 'newstoday_footer_section',
        'settings' => 'newstoday_footer_disclaimer',
        'type'     => 'textarea',
    ) );

    // Footer Copyright
    $wp_customize->add_setting( 'newstoday_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'newstoday_footer_copyright', array(
        'label'       => __( 'Custom Copyright Text (Leave empty for default dynamic year)', 'newstoday' ),
        'section'     => 'newstoday_footer_section',
        'settings'    => 'newstoday_footer_copyright',
        'type'        => 'text',
        'description' => __( 'Default: © {year} {site_name}. All Rights Reserved.', 'newstoday' ),
    ) );

    // Subscribe Box Settings Section
    $wp_customize->add_section( 'newstoday_subscribe_section', array(
        'title'    => __( 'Subscribe Form Settings', 'newstoday' ),
        'priority' => 115,
    ) );

    // Subscribe Title
    $wp_customize->add_setting( 'newstoday_subscribe_title', array(
        'default'           => __( 'Subscribe', 'newstoday' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'newstoday_subscribe_title', array(
        'label'    => __( 'Subscribe Box Title', 'newstoday' ),
        'section'  => 'newstoday_subscribe_section',
        'settings' => 'newstoday_subscribe_title',
        'type'     => 'text',
    ) );

    // Subscribe Subtitle
    $wp_customize->add_setting( 'newstoday_subscribe_subtitle', array(
        'default'           => __( 'Keep Up to Date with the most important news', 'newstoday' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'newstoday_subscribe_subtitle', array(
        'label'    => __( 'Subscribe Box Subtitle', 'newstoday' ),
        'section'  => 'newstoday_subscribe_section',
        'settings' => 'newstoday_subscribe_subtitle',
        'type'     => 'textarea',
    ) );

    // Subscribe Button Text
    $wp_customize->add_setting( 'newstoday_subscribe_btn_text', array(
        'default'           => __( 'Subscribe', 'newstoday' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'newstoday_subscribe_btn_text', array(
        'label'    => __( 'Subscribe Button Text', 'newstoday' ),
        'section'  => 'newstoday_subscribe_section',
        'settings' => 'newstoday_subscribe_btn_text',
        'type'     => 'text',
    ) );
}

endif;
add_action( 'customize_register', 'newstoday_customize_register' );
?>