<?php
/**
 * Redirect old posts to the correct permalink.
 *
 * @package NewsToday
 */

function safe_slug_redirect() {
    // Do not run in admin, feeds, REST, or AJAX
    if ( is_admin() || is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || wp_doing_ajax() ) {
        return;
    }

    // Run only on 404 pages
    if ( ! is_404() ) {
        return;
    }

    if ( empty( $_SERVER['REQUEST_URI'] ) ) {
        return;
    }

    // Strip query string before extracting slug
    $path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    $slug = sanitize_title( basename( trim( $path, '/' ) ) );

    // Skip empty or suspiciously short slugs
    if ( strlen( $slug ) < 3 ) {
        return;
    }

    // Allow only valid slug characters
    if ( ! preg_match( '/^[a-z0-9\-]+$/', $slug ) ) {
        return;
    }

    $blocked = array(
        'feed',
        'wp-json',
        'xmlrpc.php',
        'sitemap.xml',
        'page',
        'tag',
        'category',
        'author',
        'attachment',
    );

    if ( in_array( $slug, $blocked, true ) ) {
        return;
    }

    $post = get_page_by_path( $slug, OBJECT, 'post' );

    if ( $post && $post->post_status === 'publish' ) {
        $correct_url = get_permalink( $post->ID );

        if ( $correct_url ) {
            wp_safe_redirect( $correct_url, 301 );
            exit;
        }
    }
}

add_action( 'template_redirect', 'safe_slug_redirect' );