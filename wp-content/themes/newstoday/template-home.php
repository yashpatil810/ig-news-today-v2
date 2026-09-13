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
$home_page_id     = get_option( 'page_on_front' );
?>

<main id="primary" class="site-main home-template">
    <div class="container">
        <div class="home-layout">
            <?php get_template_part( 'template-parts/ads/header-ads' ) ?>
            <div class="section-wrapper">
                <div class="home-main-content">
                    <?php
                    // Featured News Section
                    get_template_part( 'template-parts/home/featured-news' );
                    
                    // Latest News Section
                    get_template_part( 'template-parts/home/latest-news' );
                    ?>
                </div>
                
                <div class="home-sidebar">
                    <?php
                    // Trending News Section
                    get_template_part( 'template-parts/home/trending-news' );
                    ?>
                </div>
            </div>

            <?php get_template_part( 'template-parts/ads/horizontal-single-ad' ) ?>
            
            <?php
            // Casino & Games Category Section
            $casino_games_color = newstoday_get_category_color( get_category_by_slug( 'casino-games' ) );
            $casino_games_category_url = get_category_link( get_category_by_slug( 'casino-games' ) );
            get_template_part( 'template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Casino & Games',
                'title'        => 'Casino & Games',
                'color'        => $casino_games_color,
                'redirect_url' => $casino_games_category_url,
                'field_name'   => 'casino_games',
                'page_id'      => $home_page_id
            ) );
            ?>

            <?php get_template_part( 'template-parts/newsletter/horizontal-news-letter' ); ?>

            <?php
            // Sports Betting Category Section
            $sports_betting_category_url = get_category_link( get_category_by_slug( 'sports-betting' ) );
            $sports_betting_color = newstoday_get_category_color( get_category_by_slug( 'sports-betting' ) );
            get_template_part( 'template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Sports Betting',
                'title'        => 'Sports Betting',
                'color'        => $sports_betting_color,
                'redirect_url' => $sports_betting_category_url,
                'field_name'   => 'sports_betting',
                'page_id'      => $home_page_id
            ) );
            ?>

            <?php
            // Regions Category Section
            $regions_category_url = get_category_link( get_category_by_slug( 'regions' ) );
            $regions_color = newstoday_get_category_color( get_category_by_slug( 'regions' ) );
            get_template_part( 'template-parts/home/four-columns-posts-ad', null, array(
                'category'     => 'Regions',
                'title'        => 'Regions',
                'color'        => $regions_color,
                'redirect_url' => $regions_category_url,
                'field_name'   => 'regions',
                'page_id'      => $home_page_id
            ) );
            ?>

            <?php get_template_part( 'template-parts/ads/horizontal-single-ad', null, array( 'page_id' => $home_page_id ) ); ?>

            <?php
            // Legal & Compliance Category Section
            $legal_compliance_color = newstoday_get_category_color( get_category_by_slug( 'legal-compliance' ) );
            $legal_compliance_category_url = get_category_link( get_category_by_slug( 'legal-compliance' ) );
            get_template_part( 'template-parts/home/legal-compliance-posts-ad', null, array(
                'category'     => 'Legal & Compliance',
                'title'        => 'Legal & Compliance',
                'color'        => $legal_compliance_color,
                'redirect_url' => $legal_compliance_category_url,
                'page_id'      => $home_page_id
            ) );
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

