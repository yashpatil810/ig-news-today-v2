<?php
/**
 * Duplicate post link
 *
 * @package NewsToday
 */

function wp_duplicate_post_link( $actions, $post ) {
    if ( current_user_can( 'edit_posts' ) ) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url(
            admin_url( 'admin.php?action=wp_duplicate_post&post=' . $post->ID ),
            'wp_duplicate_post_' . $post->ID
        ) . '" title="Duplicate this item">Duplicate</a>';
    }
    return $actions;
}
add_filter( 'post_row_actions', 'wp_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'wp_duplicate_post_link', 10, 2 );


// Trigger the Duplicate Action
function wp_duplicate_post_action() {
    if (
        ! ( isset( $_GET['action'] ) && $_GET['action'] === 'wp_duplicate_post' ) ||
        ! isset( $_GET['post'] ) ||
        ! wp_verify_nonce( $_GET['_wpnonce'], 'wp_duplicate_post_' . $_GET['post'] )
    ) {
        wp_die( 'Invalid request' );
    }

    $post_id = absint( $_GET['post'] );
    $post = get_post( $post_id );

    if ( ! $post ) {
        wp_die( 'Post not found' );
    }

    // Prepare the new post data
    $new_post = array(
        'post_title'     => $post->post_title . ' (Copy)',
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_status'    => 'draft',
        'post_type'      => $post->post_type,
        'post_author'    => $post->post_author,
        'post_parent'    => $post->post_parent,
        'menu_order'     => $post->menu_order,
        'post_password'  => $post->post_password,
        'comment_status' => $post->comment_status,
        'ping_status'    => $post->ping_status,
    );

    // Create the duplicate
    $new_post_id = wp_insert_post( $new_post );

    // Copy post meta
    $post_meta = get_post_meta( $post_id );
    if ( $post_meta ) {
        foreach ( $post_meta as $key => $values ) {
            foreach ( $values as $value ) {
                add_post_meta( $new_post_id, $key, maybe_unserialize( $value ) );
            }
        }
    }

    // Redirect to the editor of the new draft
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
}
add_action( 'admin_action_wp_duplicate_post', 'wp_duplicate_post_action' );

