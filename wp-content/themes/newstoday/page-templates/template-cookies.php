<?php
/**
 * Template Name: Cookies
 * Description: Cookies page template
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main cookies-page">
    <section class="cookies-hero">
        <div class="cookies-hero-container">
            <h1 class="cookies-hero-title">
                <?php esc_html_e( 'Cookies', 'newstoday' ); ?>
            </h1>
        </div>
    </section>

    <section class="cookies-content">
        <div class="cookies-content-container">
           <?php echo the_content(); ?>
        </div>
    </section>
</main>

<?php
get_footer();


