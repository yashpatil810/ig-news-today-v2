<?php
/**
 * Clean RSS feed content for strict parsers (Pinterest, Google News, Apple News)
 * @package NewsToday
 */

function clean_rss_content($content) {

    // Remove inline styles
    $content = preg_replace('/ style=("|\')(.*?)("|\')/i', '', $content);

    // Remove script and iframe tags
    $content = preg_replace('#<(script|iframe)[^>]*>.*?</\1>#is', '', $content);

    // Remove empty paragraphs
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);

    // Fix double closing paragraphs
    $content = preg_replace('/<\/p>\s*<\/p>/', '</p>', $content);

    // Ensure space before links
    $content = preg_replace('/([a-zA-Z])<a /', '$1 <a ', $content);

    return $content;
}

add_filter('the_content_feed', 'clean_rss_content');
add_filter('the_excerpt_rss', 'clean_rss_content');