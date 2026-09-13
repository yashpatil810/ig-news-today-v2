<?php
/**
 * Mailchimp Subscribe Form
 *
 * Script is bundled in the main Vite build (see assets/src/js/main.js).
 * 
 * @package NewsToday
 */

/**
 * AJAX handler to proxy MC4WP form submission over admin-ajax.
 *
 * Mailchimp for WordPress processes the POST on `init` via its listener,
 * so by the time this runs we can pull the submitted form status and
 * return a simple JSON response.
 */
function newstoday_mc4wp_submit_ajax() {
    if ( ! function_exists( 'mc4wp_get_submitted_form' ) ) {
        wp_send_json_error( array( 'message' => __( 'Mailchimp plugin is not active.', 'newstoday' ) ), 400 );
    }

    $form = mc4wp_get_submitted_form();

    if ( ! $form instanceof MC4WP_Form ) {
        wp_send_json_error( array( 'message' => __( 'Form could not be processed. Please try again.', 'newstoday' ) ), 400 );
    }

    if ( $form->has_errors() ) {
        $message_key = $form->errors[0];
        $message     = $form->get_message( $message_key );
        wp_send_json_error( array( 'message' => $message ), 400 );
    }

    $message = isset( $form->messages['subscribed'] ) ? $form->messages['subscribed'] : __( 'Thank you for subscribing!', 'newstoday' );

    wp_send_json_success( array( 'message' => $message ) );
}
add_action( 'wp_ajax_newstoday_mc4wp_submit', 'newstoday_mc4wp_submit_ajax' );
add_action( 'wp_ajax_nopriv_newstoday_mc4wp_submit', 'newstoday_mc4wp_submit_ajax' );
