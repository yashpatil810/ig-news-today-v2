<?php
/**
 * Template part for displaying single page sidebar
 *
 * @package NewsToday
 */

$page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();
$global_blogs_settings_page_id = 10969;

$first_sidebar_ad = get_field( 'first_sidebar_ad', $page_id );
$second_sidebar_ad = get_field( 'second_sidebar_ad', $page_id );

$first_sidebar_google_ad = get_field( 'first_sidebar_google_ad', $page_id );
$second_sidebar_google_ad = get_field( 'second_sidebar_google_ad', $page_id );

if (!($first_sidebar_ad && $first_sidebar_ad['url'])) {
    $first_sidebar_ad = get_field( 'first_sidebar_ad', $global_blogs_settings_page_id );
}

if (!($second_sidebar_ad && $second_sidebar_ad['url'])) {
    $second_sidebar_ad = get_field( 'second_sidebar_ad', $global_blogs_settings_page_id );
}

if (!($first_sidebar_google_ad && $first_sidebar_google_ad['url'])) {
    $first_sidebar_google_ad = get_field( 'first_sidebar_google_ad', $global_blogs_settings_page_id );
}

if (!($second_sidebar_google_ad && $second_sidebar_google_ad['url'])) {
    $second_sidebar_google_ad = get_field( 'second_sidebar_google_ad', $global_blogs_settings_page_id );
}

?>

<div class="sidebar-big-small-ad">
    <?php if ($first_sidebar_google_ad) : ?>
        <!-- Insert Google AdSense Code from $first_sidebar_google_ad -->
        <?php echo $first_sidebar_google_ad; ?>
    <?php else : ?>
        <!-- Insert image from $first_sidebar_ad -->
        <?php if ($first_sidebar_ad) : ?>
            <img src="<?php echo esc_url( $first_sidebar_ad['url'] ); ?>" alt="<?php echo esc_attr( $first_sidebar_ad['alt'] ); ?>" width="300" height="600">
        <?php endif; ?>
    <?php endif; ?>

    <div class="desktop-navigation-box">
        <?php get_template_part( 'template-parts/sidebar/navigation-box' ); ?>
    </div>

    <?php if ($second_sidebar_google_ad) : ?>
        <!-- Insert Google AdSense Code from $second_sidebar_google_ad -->
        <?php echo $second_sidebar_google_ad; ?>
    <?php else : ?>
        <!-- Insert image from $second_sidebar_ad -->
        <?php if ($second_sidebar_ad) : ?>
            <img src="<?php echo esc_url( $second_sidebar_ad['url'] ); ?>" alt="<?php echo esc_attr( $second_sidebar_ad['alt'] ); ?>" width="300" height="250">
        <?php endif; ?>
    <?php endif; ?>

    <div class="desktop-subscribe-form">
        <?php get_template_part( 'template-parts/sidebar/subscribe-form' ); ?>
    </div>
</div>