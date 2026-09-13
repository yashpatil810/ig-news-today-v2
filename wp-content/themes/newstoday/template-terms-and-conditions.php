<?php
/**
 * Template Name: Terms and Conditions
 * Description: Terms and Conditions page template
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main terms-page">
    <section class="terms-hero">
        <div class="terms-hero-container">
            <h1 class="terms-hero-title">
                <?php esc_html_e( 'Terms and Conditions', 'newstoday' ); ?>
            </h1>
        </div>
    </section>

    <section class="terms-content">
        <div class="terms-content-container">
            <?php echo the_content(); ?>
        </div>
    </section>
</main>

<?php
get_footer();


