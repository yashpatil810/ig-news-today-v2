<?php
/**
 * Get weighted related posts
 *
 * @package NewsToday
 */

function get_weighted_related_posts( $post_id, $limit = 4 ) {

$post = get_post( $post_id );
if ( ! $post ) return [];

// Weight configuration
$category_weight = 1;
$tag_weight      = 2;
$title_weight    = 3;

// Get current post data
$current_title = $post->post_title;
$categories    = wp_get_post_categories( $post_id );
$tags          = wp_get_post_tags( $post_id, [ 'fields' => 'ids' ] );

// Query candidate posts (large pool → more accurate results)
$args = [
    'post_type'      => 'post',
    'posts_per_page' => 30,
    'post__not_in'   => [ $post_id ],
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$candidate_posts = get_posts( $args );

// Scored results
$scored = [];

foreach ( $candidate_posts as $candidate ) {

    $score = 0;

    // CATEGORY MATCH
    $candidate_cats = wp_get_post_categories( $candidate->ID );
    $cat_matches = array_intersect( $categories, $candidate_cats );
    $score += count( $cat_matches ) * $category_weight;

    // TAG MATCH
    $candidate_tags = wp_get_post_tags( $candidate->ID, [ 'fields' => 'ids' ] );
    $tag_matches = array_intersect( $tags, $candidate_tags );
    $score += count( $tag_matches ) * $tag_weight;

    // TITLE SIMILARITY
    similar_text(
        mb_strtolower( $current_title ),
        mb_strtolower( $candidate->post_title ),
        $percent
    );
    $score += ($percent / 100) * $title_weight;

    // Store results
    $scored[] = [
        'post'  => $candidate,
        'score' => $score
    ];
}

// Sort by score DESC
usort($scored, function($a, $b) {
    return $b['score'] <=> $a['score'];
});

// Top N posts - return only post objects
$top_posts = array_slice($scored, 0, $limit);
return array_map( function($item) { return $item['post']; }, $top_posts );
}
?>