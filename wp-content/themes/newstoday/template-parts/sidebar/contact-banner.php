<?php
/**
 * Template part for displaying Contact Banner
 *
 * @package NewsToday
 */

    $page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();

    $first_sidebar_ad = get_field( 'first_sidebar_ad', $page_id );

    $first_sidebar_google_ad = get_field( 'first_sidebar_google_ad', $page_id );

?>

<div class="sidebar-contact-banner">
    <?php if ($first_sidebar_google_ad) : ?>
        <?php echo $first_sidebar_google_ad; ?>
    <?php else : ?>
        <?php if ($first_sidebar_ad) : ?>
            <img src="<?php echo esc_url( $first_sidebar_ad['url'] ); ?>" alt="<?php echo esc_attr( $first_sidebar_ad['alt'] ); ?>" width="300" height="600">
        <?php endif; ?>
    <?php endif; ?>
</div>

