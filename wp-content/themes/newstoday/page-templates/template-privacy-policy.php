<?php
/**
 * Template Name: Privacy Policy
 * Description: Privacy Policy page template
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main privacy-policy-page">
    <section class="privacy-hero">
        <div class="privacy-hero-container">
            <h1 class="privacy-hero-title">
                <?php esc_html_e( 'Privacy Policy', 'newstoday' ); ?>
            </h1>
        </div>
    </section>

    <section class="privacy-content">
        <div class="privacy-content-container">
           <?php echo the_content(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
