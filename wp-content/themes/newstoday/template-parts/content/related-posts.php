<?php
/**
 * Template part for displaying related posts
 *
 * @package NewsToday
 */

$post_id = isset($args['post_id']) ? $args['post_id'] : get_the_ID();
?>

<div class="related-posts">
    <div class="related-posts-header">
        <div class="icon-wrapper">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.6016 4.7373H5.60156L13.1805 35.1373L21.6016 4.7373Z" fill="#FC0303"/>
            <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
            </svg>
        </div>
        <h2 class="related-posts-title">Recommended for you</h2>
    </div>

    <div class="related-posts-grid">
        <?php
        $related_posts = get_weighted_related_posts($post_id);
        foreach ($related_posts as $post) {
            $categories = get_the_category($post->ID);
            $category = !empty($categories) ? $categories[0] : null;
            $category_name = $category ? $category->name : '';
            $category_color = $category ? newstoday_get_category_color( $category ) : '#606060';
            $post_time = newstoday_get_post_time_or_date( $post->ID );
            ?>
            <article class="related-post-card">
                <div class="related-post-image">
                    <a href="<?php echo get_the_permalink($post->ID); ?>">
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium_large'); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        <?php endif; ?>
                    </a>
                </div>
                <div class="related-post-content">
                    <div class="related-post-meta">
                        <?php if ($category_name) : ?>
                            <span class="related-post-category" style="color: <?php echo esc_attr($category_color); ?>">
                                <?php echo esc_html($category_name); ?>
                            </span>
                            <span class="related-post-separator"></span>
                        <?php endif; ?>
                        <span class="related-post-time"><?php echo esc_html($post_time); ?></span>
                    </div>
                    <h3 class="related-post-title">
                        <a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a>
                    </h3>
                </div>
            </article>
        <?php
        }
        ?>
    </div>
</div>
