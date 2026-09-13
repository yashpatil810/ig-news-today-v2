<?php
/**
 * Template Name: Category Page
 * 
 * Custom template for displaying category posts.
 * Shows first 6 posts from selected category.
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main category-template">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads'); ?>
        <?php
        // Get ACF category field
        $selected_category = get_field('category');
        
        if ( $selected_category ) :
            // Get category object
            $category = get_category_by_slug( $selected_category );
            
            if ( ! $category ) {
                $category = get_term_by( 'name', $selected_category, 'category' );
            }
            
            if ( ! $category ) {
                $category = get_term( $selected_category, 'category' );
            }
            
            // Category Posts Section
            get_template_part( 'template-parts/category/category-posts', null, array(
                'category' => $category
            ) );
            
        else :
            ?>
            <div class="no-category-selected">
                <p><?php esc_html_e( 'Please select a category in the page settings.', 'newstoday' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
