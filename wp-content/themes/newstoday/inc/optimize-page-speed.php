<?php
/**
 * Optimize Page Speed
 *
 * @package NewsToday
 */

// Load block CSS only on single posts
function load_block_css_only_on_single_posts() {
    if ( ! is_single() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'global-styles' );
    }
}
add_action( 'wp_enqueue_scripts', 'load_block_css_only_on_single_posts', 100 );

// Move jQuery to footer (frontend only - admin and plugins unaffected)
function move_jquery_to_footer() {
    if ( is_admin() ) {
        return;
    }

    wp_deregister_script( 'jquery' );
    wp_register_script(
        'jquery',
        includes_url( '/js/jquery/jquery.min.js' ),
        [],
        '3.7.1',
        true // footer
    );
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'move_jquery_to_footer', 100 );


// Remove jQuery Migrate
function remove_jquery_migrate($scripts) {
    if ( ! is_admin() && isset($scripts->registered['jquery']) ) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');


// Remove AddToAny scripts and styles when not on single posts
function load_addtoany_only_when_needed() {
    if ( ! is_single() ) {
        wp_dequeue_script( 'addtoany-core' );
        wp_dequeue_script( 'addtoany-jquery' );
        wp_dequeue_style( 'addtoany' );
    }
}
add_action( 'wp_enqueue_scripts', 'load_addtoany_only_when_needed', 100 );


// Remove Contact Form 7 styles when not on contact page (home/front)
function remove_cf7_from_home() {
    if ( is_front_page() || is_home() ) {
        wp_dequeue_style( 'contact-form-7' );
        wp_deregister_style( 'contact-form-7' );
    }
}
add_action( 'wp_enqueue_scripts', 'remove_cf7_from_home', 999 );


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Add defer to scripts that are not required for first paint.
 * Preserves execution order for dependents (jQuery -> plugins).
 */
function newstoday_add_defer_to_scripts( $tag, $handle, $src ) {
    if ( is_admin() ) {
        return $tag;
    }

    $defer_handles = array(
        'jquery',
        'comment-reply',
        'addtoany-core',
        'addtoany-jquery',
        'intl-tel-input-js',
        'newstoday-phone-init',
    );

    if ( in_array( $handle, $defer_handles, true ) ) {
        if ( strpos( $tag, ' defer' ) === false && strpos( $tag, 'async' ) === false ) {
            return str_replace( ' src=', ' defer src=', $tag );
        }
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'newstoday_add_defer_to_scripts', 10, 3 );

/**
 * Preload LCP image only: first image of second header slot on front page.
 */
function newstoday_preload_lcp_image() {
    if ( ! is_front_page() ) {
        return;
    }

    $page_id = get_option( 'page_on_front' );
    if ( ! $page_id ) {
        return;
    }

    $acf = get_fields( $page_id );
    if ( empty( $acf ) ) {
        return;
    }

    $img = $acf['second_ad_1'] ?? $acf['second_ad'] ?? null;

    if ( empty( $img['url'] ) ) {
        return;
    }
    ?>
    <link rel="preload" as="image" href="<?php echo esc_url( $img['url'] ); ?>" fetchpriority="high">
    <?php
}
add_action( 'wp_head', 'newstoday_preload_lcp_image', 1 );