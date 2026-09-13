<?php
/**
 * AJAX handler for loading more directory posts
 *
 * @package NewsToday
 */

function newstoday_load_more_directory() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'newstoday_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
    }

    $offset         = isset( $_POST['offset'] ) ? intval( $_POST['offset'] ) : 0;
   
    $posts_per_page = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 6;
    $page_id        = isset( $_POST['page_id'] ) ? intval( $_POST['page_id'] ) : 0;

    // echo "==============" . $offset;
    // die();
    $args = array(
        'post_type'      => 'directory',
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
        // Match initial queries: stable ordering prevents duplicates on paged loads.
        'meta_key'       => 'company_tag',
        'orderby'        => 'custom_company_tag',
        'order'          => 'ASC',
    );

    $query = new WP_Query( $args );

    // Get total posts for checking if there are more
    $total_query = new WP_Query( array(
        'post_type'      => 'directory',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    $total_posts = $total_query->found_posts;
    $has_more    = ( $offset + $posts_per_page ) < $total_posts;

    ob_start();

    if ( $query->have_posts() ) :
        ?>
        <div class="top-ad-section">
            <?php get_template_part( 'template-parts/ads/horizontal-single-ad', null, array( 'page_id' => $page_id ) ); ?>
        </div>
        <div class="two-columns-directory-ad-sidebar-content">
        <div class="directory-posts-section">
        <?php
        while ( $query->have_posts() ) :
            $query->the_post();

            $company_description = get_field( 'company_description' );
            $company_link        = get_field( 'company_link' );
            $company_logo        = get_field( 'company_logo' );
            $company_tag         = get_field( 'company_tag' );
            $tag_slug            = $company_tag ? strtolower( str_replace( ' ', '-', $company_tag ) ) : '';
            ?>
            <div class="directory-item <?php echo $tag_slug ? 'directory-item--' . esc_attr( $tag_slug ) : ''; ?>">
                <div class="directory-item-inner">
                    <div class="directory-item-logo-wrapper">
                        <a href="<?php the_permalink(); ?>" class="directory-item-logo-link">
                            <div class="directory-item-logo">
                                <?php if ( ! empty( $company_logo ) && is_array( $company_logo ) && ! empty( $company_logo['url'] ) ) : ?>
                                    <img 
                                        src="<?php echo esc_url( $company_logo['url'] ); ?>" 
                                        alt="<?php echo esc_attr( $company_logo['alt'] ? $company_logo['alt'] : get_the_title() ); ?>" 
                                        loading="lazy"
                                    />
                                <?php else : ?>
                                    <div class="directory-item-logo--placeholder"><?php the_title(); ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <?php if ( $company_description ) : ?>
                        <div class="directory-item-body">
                            <p class="directory-item-description">
                                <?php echo esc_html( $company_description ); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="directory-item-footer">
                        <a 
                            href="<?php the_permalink(); ?>" 
                            class="directory-item-link" 
                            rel="noopener noreferrer"
                        >
                            View Details
                        </a>
                    </div>
                    
                    <div class="directory-item-top">
                        <span class="directory-item-sponsored">
                            <?php if ( $company_tag == 'Enterprise' ) : ?>Sponsored<?php endif; ?>
                        </span>

                        <?php if ( $company_tag ) : ?>
                            <span class="directory-item-tag <?php echo $company_tag; ?>">
                                <?php echo esc_html( $company_tag ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        ?>
        </div>

        <div class="directory-ad-section">
            <?php get_template_part( 'template-parts/ads/sidebar-big-small-ad', null, array( 'page_id' => $page_id ) ); ?>
        </div>
        </div>
        <?php
        wp_reset_postdata();
    endif;

    $html = ob_get_clean();

    if ( ! empty( $html ) ) {
        wp_send_json_success( array(
            'html'     => $html,
            'has_more' => $has_more,
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'No more posts' ) );
    }
}
add_action( 'wp_ajax_load_more_directory', 'newstoday_load_more_directory' );
add_action( 'wp_ajax_nopriv_load_more_directory', 'newstoday_load_more_directory' );

add_filter( 'posts_orderby', 'directory_company_tag_orderby', 10, 2 );

function directory_company_tag_orderby( $orderby, $query ) {

    // Apply the custom ordering both on the front‑end and in AJAX calls.
    if (
        ( ! is_admin() || wp_doing_ajax() ) &&
        $query->get( 'orderby' ) === 'custom_company_tag'
    ) {
        global $wpdb;

        $orderby = "
            CASE {$wpdb->postmeta}.meta_value
                WHEN 'Enterprise' THEN 1
                WHEN 'Premium' THEN 2
                WHEN 'Basic' THEN 3
                ELSE 4
            END ASC,
            {$wpdb->posts}.post_date DESC,
            {$wpdb->posts}.ID DESC
        ";
    }

    return $orderby;
}

add_filter( 'posts_join', 'directory_company_tag_join', 10, 2 );

function directory_company_tag_join( $join, $query ) {
    global $wpdb;

    if (
        ( ! is_admin() || wp_doing_ajax() ) &&
        $query->get( 'orderby' ) === 'custom_company_tag'
    ) {
        $join .= " LEFT JOIN {$wpdb->postmeta} AS company_tag_meta
                   ON ({$wpdb->posts}.ID = company_tag_meta.post_id
                   AND company_tag_meta.meta_key = 'company_tag')";
    }

    return $join;
}


?>