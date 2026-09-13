<?php
/**
 * Template part for displaying Search Results in Four Columns Grid
 * 
 * Grid layout:
 * - Row 1: 4 posts (positions 1-4)
 * - Row 2: 3 posts + 1 ad (positions 5-7, ad at 8)
 * - Row 3: 3 posts + 1 ad (positions 8-10, ad at 12)
 *
 * @package NewsToday
 */

// Get search query
$search_query = get_search_query();

// Initial query - 10 posts
$search_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    's'              => $search_query,
    'orderby'        => 'relevance',
    'order'          => 'DESC'
);

$search_results = new WP_Query( $search_args );

// Get total posts count
$total_posts = $search_results->found_posts;
$has_results = $search_results->have_posts();

// If no search results, get latest 10 posts
if ( ! $has_results ) {
    $search_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    $search_results = new WP_Query( $search_args );
    
    // Get total for latest posts
    $total_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    $total_posts = $total_query->found_posts;
}

// get ads from page id 11105
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


?>

<section class="search-results-section">
    <!-- Section Header -->
    <div class="search-results-header">
        <div class="section-title-wrapper">
            <div class="icon-wrapper">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                </svg>
            </div>
            <?php if ( $has_results || ! empty( $search_query ) ) : ?>
                <h1 class="search-title">
                    <?php
                    if ( ! $has_results ) {
                        printf( esc_html__( 'No results found for: %s', 'newstoday' ), '<span>"' . esc_html( $search_query ) . '"</span>' );
                    } else {
                        printf( esc_html__( 'Search Results for: %s', 'newstoday' ), '<span>"' . esc_html( $search_query ) . '"</span>' );
                    }
                    ?>
                </h1>
            <?php else : ?>
                <h1 class="search-title"><?php esc_html_e( 'Latest Posts', 'newstoday' ); ?></h1>
            <?php endif; ?>
        </div>
        
        <?php if ( ! $has_results && ! empty( $search_query ) ) : ?>
            <p class="no-results-message"><?php esc_html_e( 'Here are some latest posts you might be interested in:', 'newstoday' ); ?></p>
        <?php endif; ?>
    </div>

    <!-- Posts Grid Container -->
    <div class="search-posts-wrapper"
        data-offset="10"
        data-posts-per-page="10"
        data-total-posts="<?php echo esc_attr( $total_posts ); ?>"
        data-search-query="<?php echo esc_attr( $search_query ); ?>"
        data-has-results="<?php echo $has_results ? '1' : '0'; ?>"
    >
        <?php if ( $search_results->have_posts() ) : ?>
            <!-- Desktop Grid -->
            <div class="search-posts-grid desktop-grid">
                <?php
                $post_index = 0;
                while ( $search_results->have_posts() ) : $search_results->the_post();
                    $post_index++;
                    $categories = get_the_category();
                    $category_name = ! empty( $categories ) ? $categories[0]->name : '';
                    $category_color = ! empty( $categories ) ? newstoday_get_category_color( $categories[0] ) : '#606060';
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
                    // Inject ads after 7th and 10th items
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
                    
                <?php endwhile; ?>
            </div>
            
            <!-- Mobile List -->
            <div class="search-posts-grid mobile-grid">
                <?php
                $search_results->rewind_posts();
                $post_index = 0;
                while ( $search_results->have_posts() ) : $search_results->the_post();
                    $post_index++;
                    $categories = get_the_category();
                    $category_name = ! empty( $categories ) ? $categories[0]->name : '';
                    $category_color = ! empty( $categories ) ? newstoday_get_category_color( $categories[0] ) : '#606060';
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
                    // Inject ads after 7th and 10th items
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
                    
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            
        <?php else : ?>
            <p class="no-posts"><?php esc_html_e( 'No posts available.', 'newstoday' ); ?></p>
        <?php endif; ?>
        
        <!-- Load More Button -->
        <?php if ( $total_posts > 10 ) : ?>
        <div class="load-more-wrapper">
            <button type="button" id="search-load-more" class="load-more-btn">
                <span class="load-more-text"><?php esc_html_e( 'Load more', 'newstoday' ); ?></span>
                <span class="load-more-spinner" style="display: none;">
                    <svg class="spinner-icon" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.4 31.4" stroke-linecap="round">
                            <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                        </circle>
                    </svg>
                </span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>

