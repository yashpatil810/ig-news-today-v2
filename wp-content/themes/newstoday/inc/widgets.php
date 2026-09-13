<?php
/**
 * Widget Areas
 *
 * @package NewsToday
 */

/**
 * Register widget areas
 */
function newstoday_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'newstoday' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'newstoday' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Widget Area 1', 'newstoday' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add widgets here for footer column 1.', 'newstoday' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Widget Area 2', 'newstoday' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Add widgets here for footer column 2.', 'newstoday' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer Widget Area 3', 'newstoday' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Add widgets here for footer column 3.', 'newstoday' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'newstoday_widgets_init' );

