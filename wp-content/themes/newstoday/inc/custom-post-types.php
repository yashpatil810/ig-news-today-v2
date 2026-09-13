<?php
/**
 * Custom Post Types
 *
 * @package NewsToday
 */

/**
 * Register events post type
 */
function newstoday_register_events_post_type() {
    register_post_type( 'events',
        array(
            'labels' => array(
                'name' => __( 'Events', 'newstoday' ),
                'singular_name' => __( 'Event', 'newstoday' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'event' ),
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'menu_icon' => 'dashicons-calendar-alt',
        )
    );
}
add_action( 'init', 'newstoday_register_events_post_type' );

/**
 * Register custom taxonomies
 */
function newstoday_register_taxonomies() {
    // Example: Register a custom taxonomy
    // Uncomment and modify as needed

    /*
    register_taxonomy( 'news_category',
        array( 'news' ),
        array(
            'hierarchical' => true,
            'labels' => array(
                'name' => __( 'News Categories', 'newstoday' ),
                'singular_name' => __( 'News Category', 'newstoday' )
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'news-category' ),
        )
    );
    */
}
add_action( 'init', 'newstoday_register_taxonomies' );


function register_directory_post_type() {
    $labels = array(
        'name' => 'Directories',
        'singular_name' => 'Directory',
        'add_new' => 'Add New Directory',
        'add_new_item' => 'Add New Directory',
        'edit_item' => 'Edit Directory',
        'new_item' => 'New Directory',
        'view_item' => 'View Directory',
        'search_items' => 'Search Directories',
        'not_found' => 'No directories found',
        'menu_name' => 'Directories',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'directories'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array( 'post_tag' ),
        'show_in_rest' => true,
    );

    register_post_type('directory', $args);
}
add_action('init', 'register_directory_post_type');

