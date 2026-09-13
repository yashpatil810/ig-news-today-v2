<?php
/**
 * Template part for displaying primary navigation menu
 *
 * @package NewsToday
 */
?>

<nav class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'newstoday' ); ?>">
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'depth'          => 2,
            )
        );
    }
    ?>
</nav>

