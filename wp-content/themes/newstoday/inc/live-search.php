<?php
/**
 * AJAX handler for live search functionality
 *
 * @package NewsToday
 */

function newstoday_live_search() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'newstoday_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
    }

    $search_query = isset( $_POST['search_query'] ) ? sanitize_text_field( $_POST['search_query'] ) : '';

    if ( strlen( $search_query ) < 3 ) {
        wp_send_json_error( array( 'message' => 'Query too short' ) );
    }

    // Search for posts
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        's'              => $search_query,
        'orderby'        => 'relevance',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    $query = new WP_Query( $args );
    $results = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $results[] = array(
                'id'        => get_the_ID(),
                'title'     => html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ),
                'permalink' => get_the_permalink(),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( array(
        'results' => $results,
        'count'   => count( $results ),
    ) );
}
add_action( 'wp_ajax_newstoday_live_search', 'newstoday_live_search' );
add_action( 'wp_ajax_nopriv_newstoday_live_search', 'newstoday_live_search' );

