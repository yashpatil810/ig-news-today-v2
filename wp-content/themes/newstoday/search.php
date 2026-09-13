<?php
/**
 * The template for displaying search results pages
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main search-results-template">
    <div class="container">
        <?php get_template_part( 'template-parts/ads/header-ads' ); ?>
        
        <?php get_template_part( 'template-parts/search/four-columns-posts-grid' ); ?>
    </div>
</main>

<?php
get_footer();
