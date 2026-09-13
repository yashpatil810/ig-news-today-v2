<?php
/**
 * Template part for displaying Four Columns Posts with Ad Section
 * 
 * Reusable template for displaying posts in 4 columns (3 post columns + 1 ad column)
 *
 * @package NewsToday
 * 
 * @param string $section_category - Category slug to fetch posts from
 * @param string $section_title - Display title for the section
 * @param string $section_color - Color code for the category badge
 * @param string $redirect_url - URL for the "View More" link
 */

// Get parameters passed to the template
$section_category = isset( $args['category'] ) ? $args['category'] : 'casino-games';
$section_title = isset( $args['title'] ) ? $args['title'] : 'Casino & Games';
$section_color = isset( $args['color'] ) ? $args['color'] : '#0097B2';
$redirect_url = isset( $args['redirect_url'] ) ? $args['redirect_url'] : '/casino-games';

$posts_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 15,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'category_name'  => $section_category
);

$posts_query = new WP_Query( $posts_args );

$page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();
$field_name = isset( $args['field_name'] ) ? $args['field_name'] : 'four_columns_posts_ad';

?>

<section class="casino-games-section section-wrapper">
    <div class="section-header">
        <div class="section-title-wrapper">
            <div class="icon-wrapper">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                </svg>
            </div>
            <h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
        </div>
    </div>

    <div class="casino-games-content">
        <div class="casino-games-grid">
            <?php
            if ( $posts_query->have_posts() ) :
                $post_count = 0;
                $column_posts = array(array(), array(), array()); // 3 columns
                $all_posts = array();
                
                // Distribute posts into columns and collect all posts
                while ( $posts_query->have_posts() ) : $posts_query->the_post();
                    $column_index = $post_count % 3;
                    $column_posts[$column_index][] = get_post();
                    $all_posts[] = get_post();
                    $post_count++;
                endwhile;
                wp_reset_postdata();
                
                // Render columns for desktop
                foreach ( $column_posts as $column_index => $posts ) :
                    if ( empty( $posts ) ) continue;
                    $featured_post = $posts[0] ?? null;
                    $list_posts = array_slice( $posts, 1, 4 ); // Limit to 4 list items per column
                    ?>
                    <div class="casino-column">
                        <?php
                        // Featured post
                        if ( $featured_post instanceof WP_Post ) :
                            ?>
                            <div class="casino-featured-post">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url( get_permalink( $featured_post ) ); ?>">
                                    <?php 
                                    if ( has_post_thumbnail( $featured_post ) ) {
                                        echo get_the_post_thumbnail( $featured_post, 'medium', array( 'alt' => esc_attr( get_the_title( $featured_post ) ) ) );
                                    } else {
                                        echo '<img src="" alt="' . esc_attr( get_the_title( $featured_post ) ) . '">';
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
                                        <a href="<?php echo esc_url( get_permalink( $featured_post ) ); ?>"><?php echo esc_html( get_the_title( $featured_post ) ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $list_posts ) ) : ?>
                            <div class="post-divider"></div>
                            <div class="casino-list-posts">
                                <?php foreach ( $list_posts as $list_index => $list_post ) : ?>
                                    <?php if ( $list_index > 0 ) : ?>
                                        <div class="post-divider"></div>
                                    <?php endif; ?>
                                    <div class="casino-list-item">
                                        <h4 class="list-title">
                                            <a href="<?php echo esc_url( get_permalink( $list_post ) ); ?>"><?php echo esc_html( get_the_title( $list_post ) ); ?></a>
                                        </h4>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
                
            <?php else : ?>
                <p class="no-posts">No posts found for <?php echo esc_html( $section_title ); ?>.</p>
            <?php endif; ?>
        </div>
        
        <!-- Ad Column -->
    
        <div class="casino-ads-column">
            <?php
            $ads_data = get_fields($page_id);

            // Google Ads
            $google_ad_1 = $ads_data[$field_name . '_google_ad_1'] ?? null;
            $google_ad_2 = $ads_data[$field_name . '_google_ad_2'] ?? null;

            $hide_ad_1_on_mobile = $ads_data["hide_{$field_name}_ad_1_on_mobile"] ?? false;
            $hide_ad_2_on_mobile = $ads_data["hide_{$field_name}_ad_2_on_mobile"] ?? false;

            // Image groups with links
            $ad_group_1 = [];
            $ad_group_2 = [];

            for ($i = 1; $i <= 5; $i++) {

                $img1  = $ads_data[$field_name . '_ad_1' . $i] ?? null;
                $link1 = $ads_data[$field_name . '_ad_link_1' . $i] ?? null;

                $img2  = $ads_data[$field_name . '_ad_2' . $i] ?? null;
                $link2 = $ads_data[$field_name . '_ad_link_2' . $i] ?? null;

                if ($img1) {
                    $ad_group_1[] = ['image' => $img1, 'link' => $link1];
                }

                if ($img2) {
                    $ad_group_2[] = ['image' => $img2, 'link' => $link2];
                }
            }

            $carousel1 = 'ads-carousel-' . wp_unique_id();
            $carousel2 = 'ads-carousel-' . wp_unique_id();
            ?>

            <?php if ($google_ad_1) : ?>
                <div class="google-ad <?php echo $hide_ad_1_on_mobile ? 'hidden-on-mobile' : ''; ?>">
                    <?php echo $google_ad_1; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($ad_group_1)) : ?>
            <div class="ads-carousel <?php echo $hide_ad_1_on_mobile ? 'hidden-on-mobile' : ''; ?>" data-carousel="<?php echo esc_attr($carousel1); ?>">
                <?php foreach ($ad_group_1 as $ad) : ?>
                    <div class="ads-slide">

                        <?php if (!empty($ad['link'])) : ?>
                            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank" rel="noopener">
                        <?php endif; ?>

                            <img 
                                src="<?php echo esc_url($ad['image']['url']); ?>"
                                alt="<?php echo esc_attr($ad['image']['alt']); ?>"
                                width="<?php echo esc_attr( $ad['image']['width'] ?? 300 ); ?>"
                                height="<?php echo esc_attr( $ad['image']['height'] ?? 250 ); ?>"
                                loading="lazy"
                                decoding="async"
                            >

                        <?php if (!empty($ad['link'])) : ?>
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($google_ad_2) : ?>
                <div class="google-ad <?php echo $hide_ad_2_on_mobile ? 'hidden-on-mobile' : ''; ?>">
                    <?php echo $google_ad_2; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($ad_group_2)) : ?>
            <div class="ads-carousel <?php echo $hide_ad_2_on_mobile ? 'hidden-on-mobile' : ''; ?>" data-carousel="<?php echo esc_attr($carousel2); ?>">
                <?php foreach ($ad_group_2 as $ad) : ?>
                    <div class="ads-slide">

                        <?php if (!empty($ad['link'])) : ?>
                            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank" rel="noopener">
                        <?php endif; ?>

                            <img 
                                src="<?php echo esc_url($ad['image']['url']); ?>"
                                alt="<?php echo esc_attr($ad['image']['alt']); ?>"
                                width="<?php echo esc_attr( $ad['image']['width'] ?? 300 ); ?>"
                                height="<?php echo esc_attr( $ad['image']['height'] ?? 250 ); ?>"
                                loading="lazy"
                                decoding="async"
                            >

                        <?php if (!empty($ad['link'])) : ?>
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
        
    </div>
    
    <!-- View More Link -->
    <div class="view-more-wrapper">
        <a href="<?php echo esc_url( $redirect_url ); ?>" class="view-more-link">
            <span class="view-more-text">View more</span>
            <div class="view-more-icon">
                <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.15053 5.41077H12.6536M12.6536 5.41077L7.96714 1.15039M12.6536 5.41077L7.96714 9.67116" stroke="#FC0303" stroke-width="2.30097" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </a>
    </div>
</section>

