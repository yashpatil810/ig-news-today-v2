<?php
/**
 * NewsToday Theme Functions
 *
 * @package NewsToday
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define theme constants
define( 'NEWSTODAY_VERSION', '1.0.0' );
define( 'NEWSTODAY_THEME_DIR', get_template_directory() );
define( 'NEWSTODAY_THEME_URI', get_template_directory_uri() );

// Load theme setup
require_once NEWSTODAY_THEME_DIR . '/inc/theme-setup.php';

// Load asset enqueue functions
require_once NEWSTODAY_THEME_DIR . '/inc/enqueue-assets.php';

// Load custom post types
require_once NEWSTODAY_THEME_DIR . '/inc/custom-post-types.php';

// Load widgets
require_once NEWSTODAY_THEME_DIR . '/inc/widgets.php';

// Load template functions
require_once NEWSTODAY_THEME_DIR . '/inc/template-functions.php';

// Load SVG support
require_once NEWSTODAY_THEME_DIR . '/inc/svg-support.php';

// Load load more directory
require_once NEWSTODAY_THEME_DIR . '/inc/load-more-directory.php';

// Load load more category posts
require_once NEWSTODAY_THEME_DIR . '/inc/load-more-category-posts.php';

// Load load more search results
require_once NEWSTODAY_THEME_DIR . '/inc/load-more-search.php';

// Load custom mega menu walker
require_once NEWSTODAY_THEME_DIR . '/inc/class-mega-menu-walker.php';

// Load custom mobile menu walker
require_once NEWSTODAY_THEME_DIR . '/inc/class-mobile-menu-walker.php';

// Load live search
require_once NEWSTODAY_THEME_DIR . '/inc/live-search.php';

// Load duplicate post
require_once NEWSTODAY_THEME_DIR . '/inc/duplicate-post.php';

// Load mega menu AJAX handler
require_once NEWSTODAY_THEME_DIR . '/inc/mega-menu-ajax.php';

// Load shortcodes
require_once NEWSTODAY_THEME_DIR . '/inc/shortcodes.php';

// Load related posts
require_once NEWSTODAY_THEME_DIR . '/inc/get-related-posts.php';

// Load customizer
require_once NEWSTODAY_THEME_DIR . '/inc/customizer.php';

// Load country code selector
require_once NEWSTODAY_THEME_DIR . '/inc/country-code-selector.php';

// Load mailchimp subscribe form
require_once NEWSTODAY_THEME_DIR . '/inc/mailchimp-subscribe-form.php';

// Load optimize page speed
require_once NEWSTODAY_THEME_DIR . '/inc/optimize-page-speed.php';

// Load redirect old posts
require_once NEWSTODAY_THEME_DIR . '/inc/redirect-old-posts.php';

// Load clean RSS feed
require_once NEWSTODAY_THEME_DIR . '/inc/clean-rss-feed.php';

// Load author user profile fields (Job Title, LinkedIn URL)
require_once NEWSTODAY_THEME_DIR . '/inc/author-user-fields.php';

/**
 * Dynamically populate CF7 'services' dropdown with ACF fields
 */
add_filter( 'wpcf7_form_tag', 'newstoday_dynamic_cf7_services_dropdown', 10, 2 );
function newstoday_dynamic_cf7_services_dropdown( $tag, $replace ) {
    if ( $tag['name'] !== 'services' ) {
        return $tag;
    }

    // Find the Contact Us page ID
    $contact_page = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/template-contact-us.php'
    ));
    $page_id = !empty($contact_page) ? $contact_page[0]->ID : 0;

    if ( $page_id ) {
        $options = array();
        $options[] = 'Select an option'; // first_as_label placeholder
        
        $interests_text = get_field('contact_us_interests', $page_id);
        
        if ( !empty($interests_text) ) {
            $lines = array_filter(array_map('trim', explode("\n", $interests_text)));
            foreach ($lines as $line) {
                $options[] = $line;
            }
        } else {
            // Fallback options
            $options = array_merge($options, array(
                'Sponsored Article / PR Coverage',
                'Executive Interview Feature',
                'Banner Advertising',
                'Directory Listing',
                'Long-Term Partnership',
                'General Enquiry'
            ));
        }

        // If we found dynamic options, replace the default CF7 tag options
        if ( count($options) > 1 ) {
            $tag['raw_values'] = $options;
            $tag['values'] = $options;
            $tag['labels'] = $options;
        }
    }

    return $tag;
}