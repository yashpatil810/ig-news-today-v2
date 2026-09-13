<?php
get_header();

$current_category_id = get_queried_object_id();
?>

<main id="primary" class="site-main category-template">
    <div class="container">
        
        <?php get_template_part('template-parts/ads/header-ads', null, array('page_id' => 'category_'.$current_category_id)); ?>

        <?php
        // Get current category object
        $category = get_queried_object();

        // Category Posts Section
        get_template_part( 
            'template-parts/category/category-posts',
            null,
            array('category' => $category)
        );
        ?>

    </div>
</main>

<?php
get_footer();
