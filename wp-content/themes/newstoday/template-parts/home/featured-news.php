<?php
/**
 * Template part for displaying Featured News section
 *
 * @package NewsToday
 */

$featured_posts = get_field( 'featured_posts' );

?>

<section class="featured-news-section">
    <div class="section-header">
            <div class="section-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                    <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                    </svg>
                </div>
                <h2 class="section-title">Featured News</h2>
            </div>
        </div>

        <div class="featured-content">
            <?php
            $featured_posts = is_array( $featured_posts ) ? $featured_posts : array();

            $existing_ids = wp_list_pluck( $featured_posts, 'ID' );
            $needed       = max( 0, 5 - count( $existing_ids ) );

            if ( $needed > 0 ) {
                $additional_posts = get_posts(
                    array(
                        'post_type'           => 'post',
                        'posts_per_page'      => $needed + 5,
                        'offset'              => 5,
                        'post_status'         => 'publish',
                        'ignore_sticky_posts' => true,
                    )
                );

                if ( ! empty( $additional_posts ) ) {
                    foreach ( $additional_posts as $additional_post ) {
                        if ( ! in_array( $additional_post->ID, $existing_ids, true ) ) {
                            $featured_posts[] = $additional_post;
                            $existing_ids[]  = $additional_post->ID;
                            $needed--;
                            if ( 0 === $needed ) {
                                break;
                            }
                        }
                    }
                }
            }

            if ( ! empty( $featured_posts ) ) :
    $featured_main = $featured_posts[0];
    $grid_posts    = array_slice( $featured_posts, 1 );
    ?>
    
    <!-- Main Featured Article -->
    <div class="featured-main-article">
        <?php
        $post = $featured_main;
        setup_postdata( $post );

        $categories     = get_the_category();
        $category_color = '#606060';
        $category_name  = '';

        if ( ! empty( $categories ) ) {
            $category      = $categories[0];
            $category_name = $category->name;
            $category_color = newstoday_get_category_color( $category );
        }
        ?>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-main-image">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
                </a>
            </div>
        <?php endif; ?>
        <div class="featured-main-content">
            <div class="featured-main-meta">
                <?php if ( $category_name ) : ?>
                    <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>"><?php echo esc_html( $category_name ); ?></span>
                <?php endif; ?>
                <span class="separator"></span>
                <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
            </div>
            <h3 class="featured-main-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div>
    </div>

    <?php
    // Featured News Grid - Remaining posts
    if ( ! empty( $grid_posts ) ) :
        ?>
        <div class="featured-news-grid">
            <?php
            foreach ( $grid_posts as $post ) :
                setup_postdata( $post );

                $categories     = get_the_category();
                $category_color = '#606060';
                $category_name  = '';

                if ( ! empty( $categories ) ) {
                    $category      = $categories[0];
                    $category_name = $category->name;
                    $category_color = newstoday_get_category_color( $category );
                }
                ?>
                <div class="featured-news-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="card-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="card-content">
                        <div class="card-meta">
                            <?php if ( $category_name ) : ?>
                                <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>"><?php echo esc_html( $category_name ); ?></span>
                            <?php endif; ?>
                            <span class="separator"></span>
                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                        </div>
                        <h3 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </div>
                </div>
                <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    <?php endif; ?>
    <?php
    wp_reset_postdata();
else :
    ?>
    <p class="no-posts">No featured posts found.</p>
    <?php
endif;
            ?>
        </div>
</section>