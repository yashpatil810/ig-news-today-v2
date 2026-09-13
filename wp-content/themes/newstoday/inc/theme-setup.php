<?php
/**
 * Theme Setup
 *
 * @package NewsToday
 */

if ( ! function_exists( 'newstoday_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function newstoday_setup() {
        // Make theme available for translation
        load_theme_textdomain( 'newstoday', NEWSTODAY_THEME_DIR . '/languages' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support( 'post-thumbnails' );

        // Register navigation menus
        register_nav_menus(
            array(
                'primary' => esc_html__( 'Primary Menu', 'newstoday' ),
                'footer'  => esc_html__( 'Footer Menu', 'newstoday' ),
            )
        );

        // Switch default core markup to output valid HTML5
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Add theme support for selective refresh for widgets
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Add support for custom logo
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        // Add support for responsive embeds
        add_theme_support( 'responsive-embeds' );

        // Add support for editor styles
        add_theme_support( 'editor-styles' );

        // Add support for wide and full alignment
        add_theme_support( 'align-wide' );
    }
endif;
add_action( 'after_setup_theme', 'newstoday_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function newstoday_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'newstoday_content_width', 1200 );
}
add_action( 'after_setup_theme', 'newstoday_content_width', 0 );

