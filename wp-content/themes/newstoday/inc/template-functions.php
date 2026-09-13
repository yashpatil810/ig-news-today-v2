<?php
/**
 * Template Helper Functions
 *
 * @package NewsToday
 */

/**
 * Adds custom classes to the array of body classes.
 */
function newstoday_body_classes( $classes ) {
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'newstoday_body_classes' );

/**
 * Preload critical fonts (400, 700 weights) for faster rendering.
 */
// function newstoday_preload_fonts() {
//     $fonts_dir  = NEWSTODAY_THEME_DIR . '/assets/dist/fonts';
//     $fonts_uri  = NEWSTODAY_THEME_URI . '/assets/dist/fonts';
//     $to_preload = array( 'Lato-Regular', 'Lato-Bold', 'MerriweatherSans-Regular', 'MerriweatherSans-Bold' );

//     foreach ( $to_preload as $font_name ) {
//         $pattern = $fonts_dir . '/' . $font_name . '*.woff2';
//         $files   = glob( $pattern );
//         if ( ! empty( $files ) ) {
//             $filename = basename( $files[0] );
//             printf(
//                 '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
//                 esc_url( $fonts_uri . '/' . $filename )
//             );
//         }
//     }
// }
// add_action( 'wp_head', 'newstoday_preload_fonts', 1 );

/**
 * Preload Latest News main article featured image on front page (LCP candidate).
 */
function newstoday_preload_latest_news_image() {
    if ( ! is_front_page() ) {
        return;
    }

    $args  = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
        'fields'         => 'ids',
    );
    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return;
    }

    $post_id   = $query->posts[0];
    $image_id  = get_post_thumbnail_id( $post_id );
    wp_reset_postdata();

    if ( ! $image_id ) {
        return;
    }

    $image_src = wp_get_attachment_image_url( $image_id, 'large' );
    if ( $image_src ) {
        printf(
            '<link rel="preload" href="%s" as="image" fetchpriority="high">' . "\n",
            esc_url( $image_src )
        );
    }
}
add_action( 'wp_head', 'newstoday_preload_latest_news_image', 2 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function newstoday_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'newstoday_pingback_header' );

/**
 * Custom excerpt length
 */
function newstoday_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'newstoday_excerpt_length' );

/**
 * Custom excerpt more
 */
function newstoday_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'newstoday_excerpt_more' );

/**
 * Get post thumbnail URL or placeholder
 */
function newstoday_get_post_thumbnail_url( $size = 'large' ) {
    if ( has_post_thumbnail() ) {
        return get_the_post_thumbnail_url( null, $size );
    }
    return NEWSTODAY_THEME_URI . '/assets/dist/images/placeholder.jpg';
}

/**
 * Display "time ago" for posts up to 12 hours old; otherwise show date.
 *
 * @param int|WP_Post $post Optional post ID or post object.
 * @param int|null    $timestamp Optional timestamp override.
 *
 * @return string
 */
function newstoday_get_post_time_or_date( $post = 0, $timestamp = null ) {
    $post_id = 0;

    if ( $post instanceof WP_Post ) {
        $post_id = $post->ID;
    } elseif ( is_numeric( $post ) && $post > 0 ) {
        $post_id = (int) $post;
    } elseif ( 0 === $post ) {
        $post_id = get_the_ID();
    }

    if ( null === $timestamp ) {
        $timestamp = $post_id ? get_the_time( 'U', $post_id ) : get_the_time( 'U' );
    } else {
        $timestamp = (int) $timestamp;
    }

    if ( ! $timestamp ) {
        return $post_id ? get_the_date( '', $post_id ) : '';
    }

    $now         = current_time( 'timestamp' );
    $age_seconds = $now - $timestamp;

    if ( $age_seconds <= 12 * HOUR_IN_SECONDS ) {
        return human_time_diff( $timestamp, $now ) . ' ago';
    }

    $date_format = get_option( 'date_format' );

    if ( $post_id ) {
        return get_the_date( $date_format, $post_id );
    }

    return date_i18n( $date_format, $timestamp );
}

/**
 * Get category color from ACF field with a safe fallback.
 */
function newstoday_get_category_color( $category ) {
    $fallback_color = '#606060';

    if ( is_object( $category ) && isset( $category->term_id ) ) {
        $term_id = (int) $category->term_id;
    } elseif ( is_numeric( $category ) ) {
        $term_id = (int) $category;
    } else {
        return $fallback_color;
    }

    if ( ! $term_id ) {
        return $fallback_color;
    }

    $color = function_exists( 'get_field' ) ? get_field( 'color', 'category_' . $term_id ) : '';

    return $color ? $color : $fallback_color;
}

    