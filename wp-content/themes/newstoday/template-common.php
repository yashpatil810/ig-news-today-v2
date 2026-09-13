<?php
/**
 * Template Name: Common Page
 * Description: Common page template
 *
 * @package NewsToday
 */

get_header();
$page_id = get_the_ID();
?>

<main id="primary" class="terms-page">
    <section class="terms-hero">
        <div class="terms-hero-container">
            <h1 class="terms-hero-title">
                <?php echo get_the_title($page_id); ?>
            </h1>
        </div>
    </section>

    <section class="container terms-content">
        <div class="terms-content-container">
            <?php echo get_the_content($page_id); ?>
        </div>
    </section>
</main>

<?php
get_footer();


