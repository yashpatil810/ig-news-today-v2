<?php
/**
 * Template part for displaying Category Posts section
 *
 * @package NewsToday
 */

// Store the current category ID
$current_category_id = get_queried_object_id();

// Get category from args
$category = isset( $args['category'] ) ? $args['category'] : null;

if ( ! $category ) {
    return;
}

// Get current page for pagination (works with custom Page template + pretty permalinks)
$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

// Query for category posts
$category_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 14,
    'paged'          => $paged,
    'cat'            => $category->term_id,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'ignore_sticky_posts' => true,
);

$category_query = new WP_Query( $category_args );

// Get category details
$category_term_id = $category->term_id;
$category_name    = $category->name;
$category_color   = newstoday_get_category_color( $category );

// ACF Sponsor fields
$sponsor_logo  = function_exists( 'get_field' ) ? get_field( 'category_sponsor_logo', 'category_' . $category_term_id ) : null;
if ( empty( $sponsor_logo ) && function_exists( 'get_field' ) ) {
    $sponsor_logo = get_field( 'sponsor_logo', 'category_' . $category_term_id );
}
    
$sponsor_name  = function_exists( 'get_field' ) ? get_field( 'category_sponsor_name', 'category_' . $category_term_id ) : '';
if ( empty( $sponsor_name ) && function_exists( 'get_field' ) ) {
    $sponsor_name = get_field( 'sponsor_name', 'category_' . $category_term_id );
}

$sponsor_url   = function_exists( 'get_field' ) ? get_field( 'category_sponsor_url', 'category_' . $category_term_id ) : '';
if ( empty( $sponsor_url ) && function_exists( 'get_field' ) ) {
    $sponsor_url = get_field( 'sponsor_url', 'category_' . $category_term_id );
}

$sponsor_label = function_exists( 'get_field' ) ? get_field( 'category_sponsor_label', 'category_' . $category_term_id ) : '';
if ( empty( $sponsor_label ) ) {
    $sponsor_label = 'SPONSORED BY';
}

// Sponsor Description (only displayed when sponsor description field is added)
$sponsor_desc = function_exists( 'get_field' ) ? get_field( 'category_sponsor_description', 'category_' . $category_term_id ) : '';
if ( empty( $sponsor_desc ) && function_exists( 'get_field' ) ) {
    $sponsor_desc = get_field( 'sponsor_description', 'category_' . $category_term_id );
}
?>

<section class="category-posts-section">
    <!-- Category Header -->
    <div class="category-header">
        <div class="category-title-wrapper">
            <div class="icon-wrapper">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.6016 4.7373H5.60156L13.1805 35.1373L21.6016 4.7373Z" fill="#FC0303"/>
                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                </svg>
            </div>
            <h1 class="category-title">
                <?php echo esc_html( $category_name ); ?>
            </h1>
        </div>
        <?php if ( ! empty( $sponsor_logo ) || ! empty( $sponsor_name ) ) : ?>
            <div class="category-sponsor">
                <span class="sponsor-label"><?php echo esc_html( $sponsor_label ); ?></span>
                <?php if ( ! empty( $sponsor_url ) ) : ?>
                    <a href="<?php echo esc_url( $sponsor_url ); ?>" class="sponsor-link" target="_blank" rel="nofollow noopener">
                <?php endif; ?>
                <div class="sponsor-logo">
                    <?php if ( is_array( $sponsor_logo ) && ! empty( $sponsor_logo['url'] ) ) : ?>
                        <img src="<?php echo esc_url( $sponsor_logo['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $sponsor_logo['alt'] ) ? $sponsor_logo['alt'] : $sponsor_name ); ?>" />
                    <?php elseif ( is_string( $sponsor_logo ) && ! empty( $sponsor_logo ) ) : ?>
                        <img src="<?php echo esc_url( $sponsor_logo ); ?>" alt="<?php echo esc_attr( $sponsor_name ); ?>" />
                    <?php elseif ( ! empty( $sponsor_name ) ) : ?>
                        <span class="sponsor-name"><?php echo esc_html( $sponsor_name ); ?></span>
                    <?php endif; ?>
                </div>
                <?php if ( ! empty( $sponsor_url ) ) : ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( ! empty( $sponsor_desc ) ) : ?>
        <div class="category-description">
            <p><?php echo wp_kses_post( $sponsor_desc ); ?></p>
        </div>
    <?php endif; ?>

    <?php
    $posts_array = array();
    if ( $category_query->have_posts() ) :
        ?>
        <div class="category-posts-grid">
            <?php
            // Store all posts in an array
            while ( $category_query->have_posts() ) : $category_query->the_post();
                $posts_array[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'thumbnail' => get_the_post_thumbnail( get_the_ID(), 'large', array( 'alt' => get_the_title() ) ),
                    'thumbnail_medium' => get_the_post_thumbnail( get_the_ID(), 'medium', array( 'alt' => get_the_title() ) ),
                    'excerpt' => get_the_excerpt(),
                    'time' => get_the_time( 'U' ),
                    'categories' => get_the_category()
                );
            endwhile;
            wp_reset_postdata();
            
            // Column 1: Featured Post (Post #1)
            if ( isset( $posts_array[0] ) ) :
                $post = $posts_array[0];
                $post_category_name = '';
                $post_category_color = '#606060';
                
                if ( ! empty( $post['categories'] ) ) {
                    $post_category = $category;
                    $post_category_name = $post_category->name;
                    $post_category_color = newstoday_get_category_color( $post_category );
                }
                ?>
                <div class="category-featured-post">
                    <?php if ( $post['thumbnail'] ) : ?>
                        <div class="featured-post-image">
                            <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                <?php echo $post['thumbnail']; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="featured-post-content">
                        <div class="post-meta">
                            <?php if ( $post_category_name ) : ?>
                                <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                    <?php echo esc_html( $post_category_name ); ?>
                                </span>
                            <?php endif; ?>
                            <span class="separator"></span>
                            <span class="time">
                                <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                            </span>
                        </div>
                        <h2 class="featured-post-title">
                            <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                        </h2>
                        <div class="featured-post-excerpt">
                            <?php echo wp_trim_words( $post['excerpt'], 30, '.....' ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Columns 2 & 3: Posts List -->
            <div class="category-posts-list">
                <?php
                // Column 2: Posts #2, #3, and #6
                if ( isset( $posts_array[1] ) || isset( $posts_array[2] ) || isset( $posts_array[5] ) ) :
                    ?>
                    <div class="category-column">
                        <?php
                        // Post #2 (medium)
                        if ( isset( $posts_array[1] ) ) :
                            $post = $posts_array[1];
                            $post_category_name = '';
                            $post_category_color = '#606060';
                            
                            if ( ! empty( $post['categories'] ) ) {
                                $post_category = $category;
                                $post_category_name = $post_category->name;
                                $post_category_color = newstoday_get_category_color( $post_category );
                            }
                            ?>
                            <div class="category-post-card">
                                <?php if ( $post['thumbnail_medium'] ) : ?>
                                    <div class="post-card-image">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                            <?php echo $post['thumbnail_medium']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php if ( $post_category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                                <?php echo esc_html( $post_category_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time">
                                            <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                        </span>
                                    </div>
                                    <h3 class="post-card-title">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Post #3 (small)
                        if ( isset( $posts_array[2] ) ) :
                            $post = $posts_array[2];
                            $post_category_name = '';
                            $post_category_color = '#606060';
                            
                            if ( ! empty( $post['categories'] ) ) {
                                $post_category = $category;
                                $post_category_name = $post_category->name;
                                $post_category_color = newstoday_get_category_color( $post_category );
                            }
                            ?>
                            <div class="category-post-card">
                                <?php if ( $post['thumbnail_medium'] ) : ?>
                                    <div class="post-card-image">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                            <?php echo $post['thumbnail_medium']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php if ( $post_category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                                <?php echo esc_html( $post_category_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time">
                                            <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                        </span>
                                    </div>
                                    <h3 class="post-card-title">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Post #6 (small)
                        if ( isset( $posts_array[5] ) ) :
                            $post = $posts_array[5];
                            $post_category_name = '';
                            $post_category_color = '#606060';
                            
                            if ( ! empty( $post['categories'] ) ) {
                                $post_category = $category;
                                $post_category_name = $post_category->name;
                                $post_category_color = newstoday_get_category_color( $post_category );
                            }
                            ?>
                            <div class="category-post-card">
                                <?php if ( $post['thumbnail_medium'] ) : ?>
                                    <div class="post-card-image">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                            <?php echo $post['thumbnail_medium']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php if ( $post_category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                                <?php echo esc_html( $post_category_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time">
                                            <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                        </span>
                                    </div>
                                    <h3 class="post-card-title">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php
                // Column 3: Posts #4 and #5 only (space reserved for ads)
                if ( isset( $posts_array[3] ) || isset( $posts_array[4] ) ) :
                    ?>
                    <div class="category-column">
                        <?php
                        // Post #4 (medium)
                        if ( isset( $posts_array[3] ) ) :
                            $post = $posts_array[3];
                            $post_category_name = '';
                            $post_category_color = '#606060';
                            
                            if ( ! empty( $post['categories'] ) ) {
                                $post_category = $category;
                                $post_category_name = $post_category->name;
                                $post_category_color = newstoday_get_category_color( $post_category );
                            }
                            ?>
                            <div class="category-post-card">
                                <?php if ( $post['thumbnail_medium'] ) : ?>
                                    <div class="post-card-image">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                            <?php echo $post['thumbnail_medium']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php if ( $post_category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                                <?php echo esc_html( $post_category_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time">
                                            <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                        </span>
                                    </div>
                                    <h3 class="post-card-title">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Post #5 (small)
                        if ( isset( $posts_array[4] ) ) :
                            $post = $posts_array[4];
                            $post_category_name = '';
                            $post_category_color = '#606060';
                            
                            if ( ! empty( $post['categories'] ) ) {
                                $post_category = $category;
                                $post_category_name = $post_category->name;
                                $post_category_color = newstoday_get_category_color( $post_category );
                            }
                            ?>
                            <div class="category-post-card">
                                <?php if ( $post['thumbnail_medium'] ) : ?>
                                    <div class="post-card-image">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                            <?php echo $post['thumbnail_medium']; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php if ( $post_category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $post_category_color ); ?>">
                                                <?php echo esc_html( $post_category_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time">
                                            <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                        </span>
                                    </div>
                                    <h3 class="post-card-title">
                                        <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php get_template_part( 'template-parts/ads/horizontal-single-ad', null, array( 'page_id' => 'category_'.$current_category_id ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="no-posts-found">
            <p><?php esc_html_e( 'No posts found in this category.', 'newstoday' ); ?></p>
        </div>
    <?php endif; ?>
    
    <!-- Dynamic Sponsor Ad Section -->
    <?php
    $global_ad_page_id = 10969;
    $cat_ad_banner     = function_exists( 'get_field' ) ? get_field( 'category_global_ad_banner', $global_ad_page_id ) : null;
    $cat_ad_link       = function_exists( 'get_field' ) ? get_field( 'category_global_ad_link', $global_ad_page_id ) : '';

    $cat_ad_img_url = '';
    $cat_ad_img_alt = 'Contact for Ads';

    if ( ! empty( $cat_ad_banner ) ) {
        if ( is_array( $cat_ad_banner ) && ! empty( $cat_ad_banner['url'] ) ) {
            $cat_ad_img_url = $cat_ad_banner['url'];
            $cat_ad_img_alt = $cat_ad_banner['alt'] ?? 'Category Ad';
        } elseif ( is_numeric( $cat_ad_banner ) && (int) $cat_ad_banner > 0 ) {
            $src = wp_get_attachment_image_src( (int) $cat_ad_banner, 'full' );
            if ( $src && ! empty( $src[0] ) ) {
                $cat_ad_img_url = $src[0];
                $cat_ad_img_alt = get_post_meta( (int) $cat_ad_banner, '_wp_attachment_image_alt', true ) ?: 'Category Ad';
            }
        }
    }

    // Default fallback banner if empty
    if ( empty( $cat_ad_img_url ) ) {
        $cat_ad_img_url = get_template_directory_uri() . '/assets/src/images/contact-for-ads-banner.svg';
    }

    $cat_ad_target_url = ! empty( $cat_ad_link ) ? $cat_ad_link : '#';
    ?>

    <div class="category-sponsor-ad">
        <a href="<?php echo esc_url( $cat_ad_target_url ); ?>" class="sponsor-ad-link" <?php echo ( $cat_ad_target_url !== '#' ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <img src="<?php echo esc_url( $cat_ad_img_url ); ?>" alt="<?php echo esc_attr( $cat_ad_img_alt ); ?>" width="973" height="260" style="width:100%;height:auto;display:block;" />
        </a>
    </div>
    
    <!-- Posts 7-14 Section with Sidebar -->
    <?php if ( count( $posts_array ) > 6 ) : ?>
        <div class="category-extended-section">
            <!-- Mobile Only: Subscribe Form (shown before posts on mobile) -->
            <div class="mobile-subscribe-form">
                <?php get_template_part( 'template-parts/sidebar/subscribe-form' ); ?>
            </div>
            
            <!-- Left Column: Posts 7-14 -->
            <div class="extended-posts-column">
                <?php
                for ( $i = 6; $i <= 13; $i++ ) :
                    if ( isset( $posts_array[$i] ) ) :
                        $post = $posts_array[$i];
                        $post_category_name = '';
                        $post_category_color = '#606060';
                        
                        if ( ! empty( $post['categories'] ) ) {
                            $post_category = $category;
                            $post_category_name = $post_category->name;
                            $post_category_color = newstoday_get_category_color( $post_category );
                        }
                        ?>
                        <article class="extended-post-card">
                            <?php if ( $post['thumbnail_medium'] ) : ?>
                                <div class="extended-post-image">
                                    <a href="<?php echo esc_url( $post['permalink'] ); ?>">
                                        <?php echo $post['thumbnail_medium']; ?>
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
                                        <?php echo esc_html( newstoday_get_post_time_or_date( $post['id'] ) ); ?>
                                    </span>
                                </div>
                                <h3 class="extended-post-title">
                                    <a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo esc_html( $post['title'] ); ?></a>
                                </h3>
                                <div class="extended-post-excerpt">
                                    <?php echo wp_trim_words( $post['excerpt'], 25, '...' ); ?>
                                </div>
                            </div>
                        </article>
                    <?php endif;
                endfor;
                ?>
                
                <!-- Mobile Only: Contact Banner (shown before pagination on mobile) -->
                <div class="mobile-contact-banner">
                    <?php get_template_part( 'template-parts/sidebar/contact-banner' ); ?>
                </div>
            </div>
            
            <!-- Right Column: Sidebar -->
            <aside class="extended-sidebar">
                <!-- Subscribe Form -->
                <div class="desktop-subscribe-form">
                    <?php get_template_part( 'template-parts/sidebar/subscribe-form' ); ?>
                </div>
                
                <!-- Navigation Box -->
                <div class="desktop-navigation-box">
                    <?php get_template_part( 'template-parts/sidebar/navigation-box' ); ?>
                </div>
                
                <!-- Sidebar big small ad -->
                <div class="desktop-sidebar-big-small-ad">
                    <?php get_template_part( 'template-parts/ads/sidebar-big-small-ad', null, array( 'page_id' => 'category_'.$current_category_id ) ); ?>
                </div>
            </aside>
        </div>
    <?php endif; ?>
    
    <?php if ( $category_query->have_posts() && $category_query->max_num_pages > 1 ) : ?>
        <nav class="category-pagination" aria-label="<?php esc_attr_e( 'Posts pagination', 'newstoday' ); ?>">
            <?php
            global $wp_rewrite;
            $category_url = trailingslashit( get_category_link( $category ) );
            $paginate_base = $wp_rewrite->using_permalinks()
                ? $category_url . 'page/%#%/'
                : add_query_arg( 'paged', '%#%', $category_url );
            echo paginate_links( array(
                'base'      => $paginate_base,
                'format'    => '',
                'current'   => $paged,
                'total'     => $category_query->max_num_pages,
                'prev_next' => false,
                'type'      => 'plain',
            ) );
            ?>
        </nav>
    <?php endif; ?>

    <?php
    // Category FAQs
    $category_term_id = $category->term_id;
    $category_faq_title = function_exists( 'get_field' ) ? get_field( 'category_faq_title', 'category_' . $category_term_id ) : '';
    $category_faq_icon  = function_exists( 'get_field' ) ? get_field( 'category_faq_icon', 'category_' . $category_term_id ) : null;
    
    $category_faq_items = array();
    for ( $i = 1; $i <= 20; $i++ ) {
        $q = function_exists( 'get_field' ) ? get_field( 'category_faq_q' . $i, 'category_' . $category_term_id ) : '';
        $a = function_exists( 'get_field' ) ? get_field( 'category_faq_a' . $i, 'category_' . $category_term_id ) : '';
        if ( ! empty( $q ) && ! empty( $a ) ) {
            $category_faq_items[] = array(
                'question' => $q,
                'answer'   => $a,
            );
        }
    }

    if ( ! empty( $category_faq_items ) ) :
    ?>
        <section class="category-faq-section">
            <div class="category-faq-header">
                <div class="category-title-wrapper">
                    <?php if ( ! empty( $category_faq_icon ) && ! empty( $category_faq_icon['url'] ) ) : ?>
                        <div class="icon-wrapper">
                            <img src="<?php echo esc_url( $category_faq_icon['url'] ); ?>" alt="<?php echo esc_attr( $category_faq_icon['alt'] ); ?>" style="width: 40px; height: 40px; object-fit: contain;">
                        </div>
                    <?php else : ?>
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <h2 class="category-faq-title">
                        <?php echo esc_html( ! empty( $category_faq_title ) ? $category_faq_title : sprintf( __( 'Frequently Asked Questions about %s', 'newstoday' ), $category_name ) ); ?>
                    </h2>
                </div>
            </div>

            <div class="faq-content">
                <?php
                get_template_part(
                    'template-parts/faq/faq-accordion',
                    null,
                    array(
                        'faq_items' => $category_faq_items,
                    )
                );
                ?>
            </div>
        </section>
    <?php endif; ?>
</section>

