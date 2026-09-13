<?php
/**
 * Enqueue scripts and styles with Vite support
 *
 * @package NewsToday
 */

/**
 * Check if we're in development mode
 */
function newstoday_is_vite_development() {
    return defined( 'WP_DEBUG' ) && WP_DEBUG && file_exists( NEWSTODAY_THEME_DIR . '/assets/dist/.vite' );
}

/**
 * Get Vite manifest
 */
function newstoday_get_vite_manifest() {
    static $manifest = null;

    if ( $manifest === null ) {
        $manifest_path = NEWSTODAY_THEME_DIR . '/assets/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
        } else {
            $manifest = array();
        }
    }

    return $manifest;
}

/**
 * Enqueue Vite development server or production assets
 */
function newstoday_enqueue_assets() {
    $is_dev = newstoday_is_vite_development();

    if ( $is_dev ) {
        // Development mode - load from Vite dev server
        wp_enqueue_script(
            'newstoday-vite-client',
            'http://localhost:5173/@vite/client',
            array(),
            null,
            false
        );
        wp_script_add_data( 'newstoday-vite-client', 'type', 'module' );

        wp_enqueue_script(
            'newstoday-main',
            'http://localhost:5173/assets/src/js/main.js',
            array(),
            null,
            true
        );
        wp_script_add_data( 'newstoday-main', 'type', 'module' );
    } else {
        // Production mode - load from dist folder
        $manifest = newstoday_get_vite_manifest();

        if ( isset( $manifest['assets/src/js/main.js'] ) ) {
            $main_js = $manifest['assets/src/js/main.js'];
            wp_enqueue_script(
                'newstoday-main',
                NEWSTODAY_THEME_URI . '/assets/dist/' . $main_js['file'],
                array(),
                NEWSTODAY_VERSION,
                true
            );

            // Enqueue CSS if it exists
            if ( isset( $main_js['css'] ) && is_array( $main_js['css'] ) ) {
                foreach ( $main_js['css'] as $index => $css_file ) {
                    wp_enqueue_style(
                        'newstoday-main-' . $index,
                        NEWSTODAY_THEME_URI . '/assets/dist/' . $css_file,
                        array(),
                        NEWSTODAY_VERSION
                    );
                }
            }
        }
    }

    // Localize script for AJAX and theme data
    wp_localize_script(
        'newstoday-main',
        'newstodayData',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'newstoday_nonce' ),
            'themeUrl' => NEWSTODAY_THEME_URI,
        )
    );

    // Enqueue comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'newstoday_enqueue_assets' );

/**
 * Add type="module" to theme script tags (required for Vite ES module output).
 * ES modules are deferred by default; no render-blocking.
 */
function newstoday_script_loader_tag( $tag, $handle, $src ) {
    if ( is_admin() ) {
        return $tag;
    }
    if ( strpos( $handle, 'newstoday' ) === 0 ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'newstoday_script_loader_tag', 10, 3 );

