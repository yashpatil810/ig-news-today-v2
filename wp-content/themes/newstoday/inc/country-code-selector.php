<?php
/**
 * Country Code Selector
 *
 * @package NewsToday
 */

function newstoday_enqueue_intl_tel_input() {
    // Load only on contact and about us pages (phone input is in contact forms)
    if ( ! is_page_template( 'page-templates/template-contact-us.php' ) && ! is_page_template( 'page-templates/template-about-us.php' ) ) {
        return;
    }

    wp_enqueue_style(
        'intl-tel-input-css',
        'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/css/intlTelInput.css',
        array(),
        '18.2.1'
    );

    wp_enqueue_script(
        'intl-tel-input-js',
        'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/intlTelInput.min.js',
        array( 'jquery' ),
        '18.2.1',
        true
    );

    wp_enqueue_script(
        'newstoday-phone-init',
        get_template_directory_uri() . '/assets/src/js/phone-init.js',
        array( 'intl-tel-input-js' ),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'newstoday_enqueue_intl_tel_input' );
?>