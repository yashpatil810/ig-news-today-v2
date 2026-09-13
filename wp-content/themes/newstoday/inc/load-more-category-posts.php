<?php
/**
 * AJAX handler for loading more category posts
 *
 * @package NewsToday
 */

function newstoday_load_more_category_posts() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'newstoday_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
    }

    $offset         = isset( $_POST['offset'] ) ? intval( $_POST['offset'] ) : 0;
    $posts_per_page = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 8;
    $category_id    = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : 0;

    if ( ! $category_id ) {
        wp_send_json_error( array( 'message' => 'Invalid category' ) );
    }

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
        'cat'            => $category_id,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'ignore_sticky_posts' => true,
    );

    $query = new WP_Query( $args );

    // Get total posts for checking if there are more
    $total_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'cat'            => $category_id,
        'ignore_sticky_posts' => true,
        'fields'         => 'ids',
    ) );
    $total_posts = $total_query->found_posts;
    $has_more    = ( $offset + $posts_per_page ) < $total_posts;

    ob_start();

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) :
            $query->the_post();
            
            $post_categories = get_the_category();
            $post_category_name = '';
            $post_category_color = '#606060';
            
            if ( ! empty( $post_categories ) ) {
                $post_category = $post_categories[0];
                $post_category_name = $post_category->name;
                $post_category_color = newstoday_get_category_color( $post_category );
            }
            ?>
            <article class="extended-post-card">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="extended-post-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="extended-post-content">
                    <div class="post-meta">
                        <?php if ( $post_category_name ) : ?>
                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                <?php echo esc_html( $post_category_name ); ?>
                            </span>
                        <?php endif; ?>
                        <span class="separator"></span>
                        <span class="time">
                            <?php echo esc_html( newstoday_get_post_time_or_date() ); ?>
                        </span>
                    </div>
                    <h3 class="extended-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="extended-post-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 25, '...' ); ?>
                    </div>
                </div>
            </article>
            <?php
        endwhile;
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
add_action( 'wp_ajax_load_more_category_posts', 'newstoday_load_more_category_posts' );
add_action( 'wp_ajax_nopriv_load_more_category_posts', 'newstoday_load_more_category_posts' );

