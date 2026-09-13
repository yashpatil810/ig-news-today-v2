<?php
/**
 * Template part for displaying Three Columns Posts with Ad Section
 * 
 * Reusable template for displaying posts in 3 columns (1 featured post + 1 list column + 1 ad column)
 *
 * @package NewsToday
 * 
 * @param string $section_category - Category slug to fetch posts from
 * @param string $section_title - Display title for the section
 * @param string $section_color - Color code for the category badge
 * @param string $redirect_url - URL for the "View More" link
 */

// Get parameters passed to the template
$section_category = isset( $args['category'] ) ? $args['category'] : 'regions';
$section_title = isset( $args['title'] ) ? $args['title'] : 'Regions';
$section_color = isset( $args['color'] ) ? $args['color'] : '#22C55E';
$redirect_url = isset( $args['redirect_url'] ) ? $args['redirect_url'] : '/regions';
$regions_background_image = isset( $args['background_image'] ) ? $args['background_image'] : null;

$posts_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 6, // 1 featured + 5 list posts
    'orderby'        => 'date',
    'order'          => 'DESC',
    'category_name'  => $section_category
);

$posts_query = new WP_Query( $posts_args );

// Process background image URL
$background_image_url = !empty($regions_background_image) && is_array($regions_background_image) && isset($regions_background_image['url']) ? $regions_background_image['url'] : '';

$page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();


$first_sidebar_ad = get_field( 'first_sidebar_ad', $page_id );
$second_sidebar_ad = get_field( 'second_sidebar_ad', $page_id );

$first_sidebar_google_ad = get_field( 'first_sidebar_google_ad', $page_id );
$second_sidebar_google_ad = get_field( 'second_sidebar_google_ad', $page_id );
?>

<section class="three-columns-section section-wrapper">
    <div class="two-columns-wrapper">
        <div class="section-header" style="<?php if ($background_image_url) : ?>background-image: url(<?php echo esc_url($background_image_url); ?>); background-size: cover; background-position: center;<?php endif; ?>">
            <div class="section-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.6016 4.7373H5.60156L13.1805 35.1373L21.6016 4.7373Z" fill="#FC0303"/>
                    <path d="M34.3975 35.1357H19.1975L26.3975 4.73574L34.3975 35.1357Z" fill="white"/>
                    </svg>
                </div>
                <h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
            </div>
        </div>
    
        <div class="three-columns-content">
            <div class="three-columns-grid">
                <?php
                if ( $posts_query->have_posts() ) :
                    $post_count = 0;
                    $featured_post = null;
                    $list_posts = array();
                    
                    // Separate featured post and list posts
                    while ( $posts_query->have_posts() ) : $posts_query->the_post();
                        if ( $post_count === 0 ) {
                            $featured_post = get_post();
                        } else {
                            $list_posts[] = get_post();
                        }
                        $post_count++;
                    endwhile;
                    wp_reset_postdata();
                    
                    // Render Featured Post Column
                    if ( $featured_post ) :
                        setup_postdata( $featured_post );
                        ?>
                        <div class="featured-column">
                            <div class="featured-post-card">
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if ( has_post_thumbnail( $featured_post->ID ) ) {
                                        echo get_the_post_thumbnail( $featured_post->ID, 'large', array( 'alt' => esc_attr( get_the_title( $featured_post->ID ) ) ) );
                                    } else {
                                        echo '<img src="" alt="' . esc_attr( get_the_title( $featured_post->ID ) ) . '">';
                                    }
                                    ?>
                                    </a>
                                </div>
                                <div class="post-content">
                                    <div class="post-meta">
                                        <span class="category" style="color: <?php echo esc_attr( $section_color ); ?>"><?php echo esc_html( $section_title ); ?></span>
                                        <span class="separator"></span>
                                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date( $featured_post ) ); ?></span>
                                    </div>
                                    <h3 class="post-title">
                                        <a href="<?php echo get_permalink( $featured_post->ID ); ?>"><?php echo get_the_title( $featured_post->ID ); ?></a>
                                    </h3>
                                    <div class="post-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt( $featured_post->ID ), 30, '.....' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        wp_reset_postdata();
                    endif;
                    
                    // Render List Posts Column
                    if ( ! empty( $list_posts ) ) : ?>
                        <div class="list-column">
                            <?php
                            foreach ( $list_posts as $list_index => $post ) :
                                setup_postdata( $post );
                                ?>
                                <div class="list-post-item">
                                    <div class="list-post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                        <?php 
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) );
                                        } else {
                                            echo '<img src="" alt="' . esc_attr( get_the_title() ) . '">';
                                        }
                                        ?>
                                        </a>
                                    </div>
                                    <div class="list-post-content">
                                        <div class="post-meta">
                                            <span class="category" style="color: <?php echo esc_attr( $section_color ); ?>"><?php echo esc_html( $section_title ); ?></span>
                                            <span class="separator"></span>
                                            <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                                        </div>
                                        <h4 class="list-post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                    </div>
                                </div>
                                
                                <?php if ( $list_index < count( $list_posts ) - 1 ) : ?>
                                    <div class="post-divider"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                <?php else : ?>
                    <p class="no-posts">No posts found for <?php echo esc_html( $section_title ); ?>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Ad Column -->
    <div class="three-columns-ads">
        <!-- Ad 1 - Large promotional ad -->
        <?php if ($first_sidebar_google_ad) : ?>
            <?php echo $first_sidebar_google_ad; ?>
        <?php else : ?>
            <?php if ($first_sidebar_ad) : ?>
                <img src="<?php echo esc_url( $first_sidebar_ad['url'] ); ?>" alt="<?php echo esc_attr( $first_sidebar_ad['alt'] ); ?>" width="300" height="600">
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Ad 2 - Small ad -->
        <?php if ($second_sidebar_google_ad) : ?>
            <?php echo $second_sidebar_google_ad; ?>
        <?php else : ?>
            <?php if ($second_sidebar_ad) : ?>
                <img src="<?php echo esc_url( $second_sidebar_ad['url'] ); ?>" alt="<?php echo esc_attr( $second_sidebar_ad['alt'] ); ?>" width="300" height="80">
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

