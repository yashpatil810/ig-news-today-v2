<?php
/**
 * Template part for displaying the author's latest posts
 *
 * @package NewsToday
 */

$author_id = isset($args['author_id']) ? absint($args['author_id']) : 0;
if (!$author_id) {
    return;
}

$author_posts = get_posts(
    array(
        'author'         => $author_id,
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'ignore_sticky_posts' => true,
    )
);

if (empty($author_posts)) {
    return;
}
?>

<div class="related-posts">
    <div class="related-posts-grid">
        <?php
        foreach ($author_posts as $author_post) {
            $categories = get_the_category($author_post->ID);
            $category = !empty($categories) ? $categories[0] : null;
            $category_name = $category ? $category->name : '';
            $category_color = $category ? newstoday_get_category_color($category) : '#606060';
            $post_time = newstoday_get_post_time_or_date($author_post->ID);
            ?>
            <article class="related-post-card">
                <div class="related-post-image">
                    <a href="<?php echo get_the_permalink($author_post->ID); ?>">
                        <?php if (has_post_thumbnail($author_post->ID)) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url($author_post->ID, 'medium_large'); ?>" alt="<?php echo esc_attr(get_the_title($author_post->ID)); ?>">
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
                        <a href="<?php echo get_the_permalink($author_post->ID); ?>"><?php echo esc_html(get_the_title($author_post->ID)); ?></a>
                    </h3>
                </div>
            </article>
        <?php } ?>
    </div>
</div>
