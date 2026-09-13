<?php
/**
 * Template part for displaying Trending News section
 *
 * @package NewsToday
 */

$trending_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'offset'         => 10
);

$trending_query = new WP_Query($trending_args);

$page_id = isset($args['page_id']) ? $args['page_id'] : get_the_ID();
$acf = get_fields($page_id);

// Google Ads
$google_ad_1 = $acf['trending_news_google_ad_1'] ?? null;
$google_ad_2 = $acf['trending_news_google_ad_2'] ?? null;

$hide_trending_news_ad_1_on_mobile = $acf['hide_trending_news_ad_1_on_mobile'] ?? false;
$hide_trending_news_ad_2_on_mobile = $acf['hide_trending_news_ad_2_on_mobile'] ?? false;

// Image Ads
$ads_group_1 = [];
$ads_group_2 = [];

for ($i = 1; $i <= 5; $i++) {

    if (!empty($acf["trending_news_ad_1{$i}"])) {
        $ads_group_1[] = [
            'image' => $acf["trending_news_ad_1{$i}"],
            'link'  => $acf["trending_news_ad_link_1{$i}"] ?? ''
        ];
    }

    if (!empty($acf["trending_news_ad_2{$i}"])) {
        $ads_group_2[] = [
            'image' => $acf["trending_news_ad_2{$i}"],
            'link'  => $acf["trending_news_ad_link_2{$i}"] ?? ''
        ];
    }
}

$carousel_top_id = 'trending-top-' . wp_unique_id();
$carousel_mid_id = 'trending-mid-' . wp_unique_id();
?>

<section class="trending-news-section">

    <!-- MOBILE TOP ADS -->
    <div class="hidden-on-desktop trending-news-image <?php echo $hide_trending_news_ad_1_on_mobile ? 'hide-force' : ''; ?>">
        <?php if ($google_ad_1) { ?>

            <?php echo $google_ad_1; ?>

        <?php } elseif (!empty($ads_group_1)) { ?>

            <div class="ads-carousel" data-carousel="<?php echo esc_attr($carousel_top_id); ?>">
                <?php foreach ($ads_group_1 as $ad) { ?>
                    <div class="ads-slide">

                        <?php if (!empty($ad['link'])) { ?>
                            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank" rel="noopener">
                        <?php } ?>

                        <img src="<?php echo esc_url($ad['image']['url']); ?>"
                             alt="<?php echo esc_attr($ad['image']['alt']); ?>"
                             width="720"
                             height="100"
                             loading="lazy" decoding="async">

                        <?php if (!empty($ad['link'])) { ?></a><?php } ?>

                    </div>
                <?php } ?>
            </div>

        <?php } ?>
    </div>

    <div class="section-header">
        <div class="section-title-wrapper">
            <div class="icon-wrapper">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                    <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                </svg>
            </div>
            <h2 class="section-title">Trending</h2>
        </div>
    </div>

    <div class="trending-news-list">
        <?php
        if ($trending_query->have_posts()) {

            $post_count = 0;

            while ($trending_query->have_posts()) {
                $trending_query->the_post();
                $post_count++;

                $categories = get_the_category();
                $category_color = '#606060';
                $category_name = '';

                if (!empty($categories)) {
                    $category = $categories[0];
                    $category_name = $category->name;
                    $category_color = newstoday_get_category_color($category);
                }
        ?>

        <div class="nt-article trending-item">
            <div class="trending-meta">

                <?php if ($category_name) { ?>
                    <span class="category" style="color: <?php echo esc_attr($category_color); ?>">
                        <?php echo esc_html($category_name); ?>
                    </span>
                <?php } ?>

                <span class="separator"></span>
                <span class="time"><?php echo esc_html(newstoday_get_post_time_or_date()); ?></span>
            </div>

            <h3 class="trending-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div>

        <?php
        // AFTER 3rd POST
        if ($post_count === 3) {

            if ($google_ad_1) {

                echo $google_ad_1;

            } elseif (!empty($ads_group_1)) {
        ?>

            <div class="ads-carousel hidden-on-mobile" data-carousel="<?php echo esc_attr($carousel_mid_id); ?>">
                <?php foreach ($ads_group_1 as $ad) { ?>
                    <div class="ads-slide">

                        <?php if (!empty($ad['link'])) { ?>
                            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank" rel="noopener">
                        <?php } ?>

                        <img src="<?php echo esc_url($ad['image']['url']); ?>"
                             alt="<?php echo esc_attr($ad['image']['alt']); ?>"
                             width="720"
                             height="100"
                             loading="lazy" decoding="async">

                        <?php if (!empty($ad['link'])) { ?></a><?php } ?>

                    </div>
                <?php } ?>
            </div>

        <?php
            }
        }

        // AFTER 5th POST
        if ($post_count === 5) {

            if ($google_ad_2) {
            ?>
            <div class="<?php echo $hide_trending_news_ad_2_on_mobile ? 'hidden-on-mobile' : ''; ?>">
                <?php echo $google_ad_2; ?>
            </div>
            <?php

            } elseif (!empty($ads_group_2)) {
        ?>

            <div class="ads-carousel <?php echo $hide_trending_news_ad_2_on_mobile ? 'hidden-on-mobile' : ''; ?>" data-carousel="<?php echo esc_attr($carousel_mid_id); ?>">
                <?php foreach ($ads_group_2 as $ad) { ?>
                    <div class="ads-slide">

                        <?php if (!empty($ad['link'])) { ?>
                            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank" rel="noopener">
                        <?php } ?>

                        <img src="<?php echo esc_url($ad['image']['url']); ?>"
                             alt="<?php echo esc_attr($ad['image']['alt']); ?>"
                             width="720"
                             height="100"
                             loading="lazy" decoding="async">

                        <?php if (!empty($ad['link'])) { ?></a><?php } ?>

                    </div>
                <?php } ?>
            </div>

        <?php
            }
        }

            }

            wp_reset_postdata();

        } else {
            echo '<p class="no-posts">No trending posts found.</p>';
        }
        ?>
    </div>

</section>
