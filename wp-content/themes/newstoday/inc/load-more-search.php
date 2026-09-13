<?php
/**
 * AJAX handler for loading more search results
 *
 * @package NewsToday
 */

function newstoday_load_more_search() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'newstoday_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
    }

    $offset         = isset( $_POST['offset'] ) ? intval( $_POST['offset'] ) : 0;
    $posts_per_page = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 10;
    $search_query   = isset( $_POST['search_query'] ) ? sanitize_text_field( $_POST['search_query'] ) : '';
    $has_results    = isset( $_POST['has_results'] ) && $_POST['has_results'] === '1';

    // Build query args
    if ( $has_results && ! empty( $search_query ) ) {
        // Search results
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            'offset'         => $offset,
            's'              => $search_query,
            'orderby'        => 'relevance',
            'order'          => 'DESC',
        );
        
        // Get total search results
        $total_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => -1,
            's'              => $search_query,
            'fields'         => 'ids',
        ) );
    } else {
        // Latest posts (fallback when no search results)
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            'offset'         => $offset,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        
        // Get total posts
        $total_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ) );
    }

    $query = new WP_Query( $args );
    $total_posts = $total_query->found_posts;
    $has_more = ( $offset + $posts_per_page ) < $total_posts;

    // Ads configuration
    $settings_page_id = 11105;
    $ad_1 = get_field( 'ad_1', $settings_page_id );
    $first_ad_url = get_field( 'first_ad_url', $settings_page_id );
    $ad_2 = get_field( 'ad_2', $settings_page_id );
    $second_ad_url = get_field( 'second_ad_url', $settings_page_id );
    $first_google_ad = get_field( 'first_google_ad', $settings_page_id );
    $second_google_ad = get_field( 'second_google_ad', $settings_page_id );

    $render_search_ad = function( $slot ) use ( $first_google_ad, $second_google_ad, $ad_1, $ad_2, $first_ad_url, $second_ad_url ) {
        $is_first_slot = ( 'first' === $slot );
        $google_ad     = $is_first_slot ? $first_google_ad : $second_google_ad;
        $image_ad      = $is_first_slot ? $ad_1 : $ad_2;
        $image_url     = $is_first_slot ? $first_ad_url : $second_ad_url;

        if ( $google_ad ) {
            echo $google_ad; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted content from ACF
            return;
        }

        if ( $image_ad ) {
            $image_html = sprintf(
                '<img src="%s" alt="%s">',
                esc_url( $image_ad['url'] ),
                esc_attr( $image_ad['alt'] )
            );

            if ( $image_url ) {
                printf(
                    '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
                    esc_url( $image_url ),
                    $image_html
                );
            } else {
                echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }
    };

    // Generate HTML
    $desktop_html = '';
    $mobile_html = '';

    if ( $query->have_posts() ) :
        $post_index = 0;
        
        // Desktop HTML
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $post_index++;
            $categories = get_the_category();
            $category = ! empty( $categories ) ? $categories[0] : null;
            $category_name = $category ? $category->name : '';
            $category_color = $category ? newstoday_get_category_color( $category ) : '#606060';
            ?>
            <article class="search-post-card">
                <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                    <?php else : ?>
                        <div class="no-thumbnail"></div>
                    <?php endif; ?>
                </a>
                <div class="post-content">
                    <div class="post-meta">
                        <?php if ( $category_name ) : ?>
                            <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>">
                                <?php echo esc_html( $category_name ); ?>
                            </span>
                            <span class="separator"></span>
                        <?php endif; ?>
                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                    </div>
                    <h3 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </article>
            
            <?php
            // Inject ads after 7th and 10th items within each batch
            if ( $post_index === 7 || $post_index === 10 ) :
            ?>
                <div class="search-ad-placeholder desktop-ad">
                    <?php
                    if ( $post_index === 7 ) {
                        $render_search_ad( 'first' );
                    } else {
                        $render_search_ad( 'second' );
                    }
                    ?>
                </div>
            <?php endif; ?>
            
        <?php endwhile;

        $desktop_html = ob_get_clean();
        
        // Mobile HTML
        ob_start();
        $query->rewind_posts();
        $post_index = 0;
        while ( $query->have_posts() ) : $query->the_post();
            $post_index++;
            $categories = get_the_category();
            $category = ! empty( $categories ) ? $categories[0] : null;
            $category_name = $category ? $category->name : '';
            $category_color = $category ? newstoday_get_category_color( $category ) : '#606060';
            ?>
            <article class="search-post-card-mobile">
                <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                    <?php else : ?>
                        <div class="no-thumbnail"></div>
                    <?php endif; ?>
                </a>
                <div class="post-content">
                    <div class="post-meta">
                        <?php if ( $category_name ) : ?>
                            <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>">
                                <?php echo esc_html( $category_name ); ?>
                            </span>
                            <span class="separator"></span>
                        <?php endif; ?>
                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                    </div>
                    <h3 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </article>
            
            <?php
            // Inject ads after 7th and 10th items within each batch
            if ( $post_index === 7 || $post_index === 10 ) :
            ?>
                <div class="search-ad-placeholder mobile-ad">
                    <?php
                    if ( $post_index === 7 ) {
                        $render_search_ad( 'first' );
                    } else {
                        $render_search_ad( 'second' );
                    }
                    ?>
                </div>
            <?php endif; ?>
            
        <?php endwhile;
        wp_reset_postdata();
        $mobile_html = ob_get_clean();
    endif;

    if ( ! empty( $desktop_html ) || ! empty( $mobile_html ) ) {
        wp_send_json_success( array(
            'desktop_html' => $desktop_html,
            'mobile_html'  => $mobile_html,
            'has_more'     => $has_more,
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'No more posts' ) );
    }
}
add_action( 'wp_ajax_load_more_search', 'newstoday_load_more_search' );
add_action( 'wp_ajax_nopriv_load_more_search', 'newstoday_load_more_search' );

