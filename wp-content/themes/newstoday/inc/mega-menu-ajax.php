<?php
/**
 * Mega Menu AJAX Handler
 * 
 * Handles AJAX requests for fetching posts in the mega dropdown menu
 *
 * @package NewsToday
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * AJAX handler to get posts for mega menu dropdown
 */
function newstoday_get_mega_menu_posts() {
    // Verify nonce for security
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mega_menu_nonce' ) ) {
        wp_send_json_error( 'Invalid nonce' );
        return;
    }

    $category_slug = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';

    if ( empty( $category_slug ) ) {
        wp_send_json_error( 'No category provided' );
        return;
    }

    // Map category slugs to actual WordPress category slugs
    $category_map = array(
        'casino-games'         => 'casino-games',
        'sports-betting'       => 'sports-betting',
        'regions'              => 'regions',
        'legal-compliance'     => 'legal-compliance',
        'marketing-affiliates' => 'marketing-affiliates',
        'finance'              => 'finance',
        'events'               => 'events',
        'pr'                   => 'pr',
    );

    $wp_category_slug = isset( $category_map[ $category_slug ] ) ? $category_map[ $category_slug ] : $category_slug;

    // Get category by slug
    $category = get_category_by_slug( $wp_category_slug );

    if ( ! $category ) {
        wp_send_json_success( array(
            'columns' => array( array(), array(), array(), array() ),
            'total'   => 0,
        ) );
        return;
    }

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 16,
        'post_status'    => 'publish',
        'cat'            => $category->term_id,
    );

    $query = new WP_Query( $args );

    $posts = array();
    $index = 0;

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $post_data = array(
                'id'        => get_the_ID(),
                'title'     => html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ),
                'permalink' => get_the_permalink(),
                'time'      => newstoday_get_post_time_or_date( get_the_ID() ),
            );

            // First post of each column (0, 4, 8, 12) gets image
            if ( $index < 4 ) {
                $post_data['is_featured'] = true;
                $post_data['thumbnail']   = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                
                // Get category name
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    $post_data['category'] = $categories[0]->name;
                }
            } else {
                $post_data['is_featured'] = false;
            }

            $posts[] = $post_data;
            $index++;
        }
        wp_reset_postdata();
    }

    // Organize posts into 4 columns (4 posts each)
    $columns = array();
    for ( $i = 0; $i < 4; $i++ ) {
        $columns[ $i ] = array_slice( $posts, $i * 4, 4 );
    }

    wp_send_json_success( array(
        'columns' => $columns,
        'total'   => count( $posts ),
    ) );
}
add_action( 'wp_ajax_get_mega_menu_posts', 'newstoday_get_mega_menu_posts' );
add_action( 'wp_ajax_nopriv_get_mega_menu_posts', 'newstoday_get_mega_menu_posts' );

/**
 * Enqueue mega menu script and localize data
 */
function newstoday_mega_menu_scripts() {
    wp_localize_script( 'newstoday-main', 'megaMenuData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'mega_menu_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'newstoday_mega_menu_scripts', 20 );

