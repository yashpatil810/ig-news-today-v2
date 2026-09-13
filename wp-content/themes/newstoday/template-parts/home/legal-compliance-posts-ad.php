<?php
/**
 * Template part for displaying Legal & Compliance Section
 * 
 * Three column layout: 1 featured post + 1 list column (5-6 posts) + 1 ad column
 *
 * @package NewsToday
 * 
 * @param string $section_category - Category slug to fetch posts from
 * @param string $section_title - Display title for the section
 * @param string $section_color - Color code for the category badge
 * @param string $redirect_url - URL for the "View More" link
 */

// Get parameters passed to the template
$section_category = isset( $args['category'] ) ? $args['category'] : 'legal-compliance';
$section_title = isset( $args['title'] ) ? $args['title'] : 'Legal & Compliance';
$section_color = isset( $args['color'] ) ? $args['color'] : '#E25600';
$redirect_url = isset( $args['redirect_url'] ) ? $args['redirect_url'] : '/legal-compliance';

$posts_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 6, // 1 featured + 5 list posts
    'orderby'        => 'date',
    'order'          => 'DESC',
    'category_name'  => $section_category
);

$posts_query = new WP_Query( $posts_args );

$page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();

$acf = get_fields($page_id);
$third_sidebar_ads = [];

for ($i = 1; $i <= 5; $i++) {

    $ad   = $acf["third_sidebar_ad_{$i}"] ?? '';
    $link = $acf["third_sidebar_ad_link_{$i}"] ?? '';

    if (!empty($ad)) {
        $third_sidebar_ads[] = [
            'ad'   => $ad,
            'link' => $link,
        ];
    }
}

$third_sidebar_google_ad = $acf['third_sidebar_google_ad'] ?? '';
?>

<section class="legal-compliance-section section-wrapper">
    <div class="legal-compliance-section-wrapper">
        <div class="legal-section-wrapper">
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

            <div class="legal-compliance-content">
                <div class="legal-compliance-grid">
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
                            <div class="legal-featured-column">
                                <div class="legal-featured-card">
                                    <div class="legal-post-thumbnail">
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
                                    <div class="legal-post-content">
                                        <div class="legal-post-meta">
                                            <span class="category" style="color: <?php echo esc_attr( $section_color ); ?>"><?php echo esc_html( $section_title ); ?></span>
                                            <span class="separator"></span>
                                            <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date( $featured_post ) ); ?></span>
                                        </div>
                                        <h3 class="legal-post-title">
                                            <a href="<?php echo get_permalink( $featured_post->ID ); ?>"><?php echo get_the_title( $featured_post->ID ); ?></a>
                                        </h3>
                                        <div class="legal-post-excerpt">
                                            <?php echo wp_trim_words( get_the_excerpt( $featured_post->ID ), 30, '' ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            wp_reset_postdata();
                        endif;
                        
                        // Render List Posts Column
                        if ( ! empty( $list_posts ) ) : ?>
                            <div class="legal-list-column">
                                <?php
                                foreach ( $list_posts as $list_index => $post ) :
                                    setup_postdata( $post );
                                    ?>
                                    <div class="legal-list-item">
                                        <div class="legal-list-thumbnail">
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
                                        <div class="legal-list-content">
                                            <div class="legal-post-meta">
                                                <span class="category" style="color: <?php echo esc_attr( $section_color ); ?>"><?php echo esc_html( $section_title ); ?></span>
                                                <span class="separator"></span>
                                                <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                                            </div>
                                            <h4 class="legal-list-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                    <?php if ( $list_index < count( $list_posts ) - 1 ) : ?>
                                        <div class="legal-divider"></div>
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
        <div class="legal-ads-column">
            <div class="legal-ad">
                <?php if ($third_sidebar_google_ad) : ?>
                    <?php echo $third_sidebar_google_ad; ?>
                <?php else : ?>
                    <?php if (count($third_sidebar_ads) > 1) : ?>

                        <div class="legal-ad-carousel">
                            <?php foreach ($third_sidebar_ads as $index => $item) : ?>
                                <a href="<?php echo esc_url($item['link']); ?>"
                                class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">

                                    <img src="<?php echo esc_url($item['ad']['url']); ?>"
                                        alt="<?php echo esc_attr($item['ad']['alt']); ?>"
                                        width="300"
                                        height="80"
                                        loading="lazy">

                                </a>
                            <?php endforeach; ?>
                        </div>

                        <?php elseif (count($third_sidebar_ads) === 1) : ?>

                        <?php $single = $third_sidebar_ads[0]; ?>

                        <a href="<?php echo esc_url($single['link']); ?>">
                            <img src="<?php echo esc_url($single['ad']['url']); ?>"
                                alt="<?php echo esc_attr($single['ad']['alt']); ?>"
                                width="300"
                                height="80"
                                loading="lazy">
                        </a>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
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

