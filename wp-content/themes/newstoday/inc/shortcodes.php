<?php
/**
 * Shortcodes
 *
 * @package NewsToday
 */

/**
 * Horizontal Ad Shortcode (Slot-Aware)
 * 
 * Usage:
 * - [horizontal_ad] or [horizontal_ad_1] -> Slot 1
 * - [horizontal_ad slot="2"] or [horizontal_ad_2] -> Slot 2
 * - [horizontal_ad slot="3"] or [horizontal_ad_3] -> Slot 3
 * - [horizontal_single_ad] (backward compatibility for Slot 1)
 * 
 * @param array $atts Shortcode attributes
 * @return string The ad HTML
 */
function shortcode_horizontal_single_ad( $atts, $content = null, $tag = '' ) {
    $default_slot = 1;

    // Support tag names like [horizontal_ad_1], [horizontal_ad_2], [horizontal_ad_3]
    if ( preg_match( '/horizontal_ad_([1-3])/', $tag, $matches ) ) {
        $default_slot = (int) $matches[1];
    }

    $atts = shortcode_atts( array(
        'page_id' => 0,
        'slot'    => $default_slot,
    ), $atts, 'horizontal_single_ad' );

    $page_id = (int) $atts['page_id'];
    if ( $page_id <= 0 ) {
        $page_id = (int) get_the_ID();
    }

    $slot = (int) $atts['slot'];
    if ( $slot < 1 || $slot > 3 ) {
        $slot = $default_slot;
    }

    ob_start();
    get_template_part( 'template-parts/ads/horizontal-single-ad', null, array(
        'page_id' => $page_id,
        'slot'    => $slot,
    ) );
    return ob_get_clean();
}

add_shortcode( 'horizontal_single_ad', 'shortcode_horizontal_single_ad' );
add_shortcode( 'horizontal_ad', 'shortcode_horizontal_single_ad' );
add_shortcode( 'horizontal_ad_1', 'shortcode_horizontal_single_ad' );
add_shortcode( 'horizontal_ad_2', 'shortcode_horizontal_single_ad' );
add_shortcode( 'horizontal_ad_3', 'shortcode_horizontal_single_ad' );
