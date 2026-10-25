<?php

/**
 * Template Name: Home Page
 * 
 * Custom template for the home page with header and footer only.
 * No sidebar, minimal structure for custom content.
 *
 * @package NewsToday
 */

get_header();
$home_page_id     = get_option('page_on_front');
?>

<main id="primary" class="site-main home-template">
    <div class="container">
        <div class="home-layout">
            <?php get_template_part('template-parts/ads/header-ads') ?>
            <div class="section-wrapper">
                <div class="home-main-content">
                    <?php
                    // Featured News Section
                    get_template_part('template-parts/home/featured-news');

                    // Latest News Section
                    get_template_part('template-parts/home/latest-news');
                    ?>
                </div>

                <div class="home-sidebar">
                    <?php
                    // Trending News Section
                    get_template_part('template-parts/home/trending-news');
                    ?>
                </div>
            </div>

            <?php get_template_part('template-parts/ads/horizontal-single-ad') ?>
            <?php
            // Key Coverage: permanent links to the category hubs plus the 4 newest exclusive interviews.
            // Counts and interviews update on their own. Sizes copied from the Casino & Games section. Added Oct 2026.
            $kc_cats = array(
                'legal-compliance'     => 'Legal &amp; Compliance',
                'casino-games'         => 'Casino &amp; Games',
                'company-news'         => 'Company News',
                'finance'              => 'Finance',
                'sports-betting'       => 'Sports Betting',
                'regions'              => 'Regions',
                'events'               => 'Events',
                'marketing-affiliates' => 'Marketing &amp; Affiliates',
            );
            $kc_query = new WP_Query(array(
                's'                   => 'Exclusive',
                'post_type'           => 'post',
                'post_status'         => 'publish',
                'posts_per_page'      => 30,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            ));
            $kc_posts = array();
            foreach ($kc_query->posts as $kc_p) {
                if (stripos(get_post_field('post_title', $kc_p), 'Exclusive') === 0) {
                    $kc_posts[] = $kc_p;
                }
                if (count($kc_posts) === 4) {
                    break;
                }
            }
            ?>
            <section class="kc-section section-wrapper">
                <style>
                    .kc-section {
                        display: flex;
                        flex-direction: column;
                        align-items: center
                    }

                    .kc-section>.section-header {
                        width: 1320px;
                        max-width: 100%;
                        margin: 0 auto;
                        box-sizing: border-box
                    }

                    .kc-section .kc-body {
                        width: 1320px;
                        max-width: 100%;
                        margin: 0 auto;
                        display: flex;
                        flex-direction: column;
                        gap: 30px;
                        box-sizing: border-box
                    }

                    .kc-section .kc-cats {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 31fr)) minmax(0, 30fr);
                        gap: 12px 30px
                    }

                    .kc-section .kc-cat {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        gap: 4px;
                        min-width: 0;
                        border: 1px solid #D9D9D9;
                        border-left: 4px solid #FC0303;
                        padding: 14px 16px;
                        text-decoration: none;
                        font-family: 'Merriweather', sans-serif;
                        font-weight: 700;
                        font-size: 16px;
                        line-height: 1.3;
                        color: #000;
                        background: #fff;
                        transition: color .3s ease
                    }

                    .kc-section .kc-cat:hover {
                        color: #FC0303
                    }

                    .kc-section .kc-cat span {
                        font-weight: 400;
                        font-size: 14px;
                        line-height: 1.257;
                        color: #606060
                    }

                    .kc-section .kc-sub {
                        font-family: 'Merriweather', sans-serif;
                        font-weight: 700;
                        font-size: 18px;
                        line-height: 1.3;
                        color: #000;
                        margin: 0
                    }

                    .kc-section .kc-ex {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 31fr)) minmax(0, 30fr);
                        gap: 30px
                    }

                    .kc-section .kc-card {
                        display: flex;
                        flex-direction: column;
                        gap: 15px;
                        min-width: 0
                    }

                    .kc-section .kc-thumb {
                        width: 100%;
                        height: 163px;
                        border-radius: 12px;
                        overflow: hidden;
                        background: #E5E5E5
                    }

                    .kc-section .kc-thumb a {
                        display: flex;
                        height: 100%
                    }

                    .kc-section .kc-thumb img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover
                    }

                    .kc-section .kc-content {
                        display: flex;
                        flex-direction: column;
                        gap: 15px
                    }

                    .kc-section .kc-meta {
                        display: flex;
                        align-items: center;
                        gap: 5px
                    }

                    .kc-section .kc-meta .kc-label {
                        font-family: 'Merriweather', sans-serif;
                        font-weight: 700;
                        font-size: 14px;
                        line-height: 1.257;
                        color: #FC0303
                    }

                    .kc-section .kc-meta .kc-sep {
                        width: 1px;
                        height: 10px;
                        background: #606060
                    }

                    .kc-section .kc-meta .kc-time {
                        font-family: 'Merriweather', sans-serif;
                        font-weight: 400;
                        font-size: 14px;
                        line-height: 1.257;
                        color: #606060
                    }

                    .kc-section .kc-title {
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        font-weight: 400;
                        margin: 0;
                        line-height: 1
                    }

                    .kc-section .kc-title a {
                        font-family: 'Merriweather', sans-serif;
                        font-weight: 700;
                        font-size: 16px;
                        line-height: 1.3;
                        color: #000;
                        text-decoration: none;
                        transition: color .3s ease
                    }

                    .kc-section .kc-title a:hover {
                        color: #FC0303
                    }

                    @media (max-width:1367px) {

                        .kc-section>.section-header,
                        .kc-section .kc-body {
                            padding: 0 20px
                        }
                    }

                    @media (max-width:1023px) {
                        .kc-section .kc-cats {
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 12px 15px
                        }

                        .kc-section .kc-ex {
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 25px 15px
                        }

                        .kc-section .kc-thumb {
                            height: auto;
                            aspect-ratio: 300/158
                        }
                    }

                    @media (max-width:767px) {
                        .kc-section>.section-header {
                            width: 100%;
                            padding: 0
                        }

                        .kc-section .section-title-wrapper {
                            gap: 11.83px;
                            margin-bottom: 20px
                        }

                        .kc-section .kc-body {
                            width: 390px;
                            padding: 0;
                            gap: 25px
                        }

                        .kc-section .kc-cat {
                            font-size: 14px;
                            padding: 12px
                        }

                        .kc-section .kc-cat span {
                            font-size: 13px
                        }

                        .kc-section .kc-meta .kc-label,
                        .kc-section .kc-meta .kc-time {
                            font-size: 13px
                        }

                        .kc-section .kc-content {
                            gap: 10px
                        }

                        .kc-section .kc-meta {
                            flex-wrap: wrap;
                            row-gap: 2px
                        }

                        .kc-section .kc-meta .kc-sep {
                            display: none
                        }

                        .kc-section .kc-meta .kc-time {
                            width: 100%;
                            white-space: nowrap
                        }

                        .kc-section .kc-title {
                            -webkit-line-clamp: 3
                        }

                        .kc-section .kc-title a {
                            font-size: 15px
                        }
                    }
                </style>
                <div class="section-header">
                    <div class="section-title-wrapper">
                        <div class="icon-wrapper">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"></path>
                                <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"></path>
                            </svg>
                        </div>
                        <h2 class="section-title">Key Coverage</h2>
                    </div>
                </div>
                <div class="kc-body">
                    <div class="kc-cats">
                        <?php foreach ($kc_cats as $kc_slug => $kc_label) :
                            $kc_cat = get_category_by_slug($kc_slug);
                            if (! $kc_cat) {
                                continue;
                            } ?>
                            <a class="kc-cat" href="<?php echo esc_url(get_category_link($kc_cat)); ?>"><?php echo $kc_label; ?><span><?php echo esc_html(number_format_i18n($kc_cat->count)); ?> articles</span></a>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($kc_posts) : ?>
                        <p class="kc-sub">Exclusive Interviews</p>
                        <div class="kc-ex">
                            <?php foreach ($kc_posts as $kc_p) :
                                $kc_title = preg_replace('/^Exclusive:\s*/i', '', get_post_field('post_title', $kc_p));
                                $kc_link  = get_permalink($kc_p); ?>
                                <div class="kc-card">
                                    <div class="kc-thumb">
                                        <a href="<?php echo esc_url($kc_link); ?>"><?php echo get_the_post_thumbnail($kc_p, 'medium', array('alt' => wp_strip_all_tags($kc_title), 'loading' => 'lazy')); ?></a>
                                    </div>
                                    <div class="kc-content">
                                        <div class="kc-meta">
                                            <span class="kc-label">Exclusive</span>
                                            <span class="kc-sep"></span>
                                            <span class="kc-time"><?php echo esc_html(function_exists('newstoday_get_post_time_or_date') ? newstoday_get_post_time_or_date($kc_p) : get_the_date('', $kc_p)); ?></span>
                                        </div>
                                        <h3 class="kc-title"><a href="<?php echo esc_url($kc_link); ?>"><?php echo esc_html(wp_strip_all_tags($kc_title)); ?></a></h3>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>


            <?php
            // Casino & Games Category Section
            $casino_games_color = newstoday_get_category_color(get_category_by_slug('casino-games'));
            $casino_games_category_url = get_category_link(get_category_by_slug('casino-games'));
            get_template_part('template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Casino & Games',
                'title'        => 'Casino & Games',
                'color'        => $casino_games_color,
                'redirect_url' => $casino_games_category_url,
                'field_name'   => 'casino_games',
                'page_id'      => $home_page_id
            ));
            ?>

            <?php get_template_part('template-parts/newsletter/horizontal-news-letter'); ?>

            <?php
            // Sports Betting Category Section
            $sports_betting_category_url = get_category_link(get_category_by_slug('sports-betting'));
            $sports_betting_color = newstoday_get_category_color(get_category_by_slug('sports-betting'));
            get_template_part('template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Sports Betting',
                'title'        => 'Sports Betting',
                'color'        => $sports_betting_color,
                'redirect_url' => $sports_betting_category_url,
                'field_name'   => 'sports_betting',
                'page_id'      => $home_page_id
            ));
            ?>

            <?php
            // Regions Category Section
            $regions_category_url = get_category_link(get_category_by_slug('regions'));
            $regions_color = newstoday_get_category_color(get_category_by_slug('regions'));
            get_template_part('template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Regions',
                'title'        => 'Regions',
                'color'        => $regions_color,
                'redirect_url' => $regions_category_url,
                'field_name'   => 'regions',
                'page_id'      => $home_page_id
            ));
            ?>

            <?php get_template_part('template-parts/ads/horizontal-single-ad', null, array('page_id' => $home_page_id)); ?>

            <?php
            // Legal & Compliance Category Section
            $legal_compliance_color = newstoday_get_category_color(get_category_by_slug('legal-compliance'));
            $legal_compliance_category_url = get_category_link(get_category_by_slug('legal-compliance'));
            get_template_part('template-parts/home/legal-compliance-posts-ad', null, array(
                'category'     => 'Legal & Compliance',
                'title'        => 'Legal & Compliance',
                'color'        => $legal_compliance_color,
                'redirect_url' => $legal_compliance_category_url,
                'page_id'      => $home_page_id
            ));
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
