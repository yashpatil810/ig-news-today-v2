<?php
/**
 * The template for displaying all single posts
 *
 * @package NewsToday
 */

get_header();
$current_post_id = get_the_ID();
$global_blogs_settings_page_id = 10969;
the_post();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads', null, array('page_id' => $global_blogs_settings_page_id)) ?>
        <div class="single-post-body">
            <div class="single-post-content">
                <div class="single-post-breadcrumbs">
                    <a href="/">Home</a>
                    <a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>"><?php echo get_the_category()[0]->name; ?></a>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </div>
                <h1 class="single-post-title"><?php echo the_title(); ?></h1>
                <div class="single-post-meta">
                    <div class="single-post-meta-item">
                        <div class="post-author-info">
                            <?php $author_id = get_the_author_meta('ID'); ?>
                            <div class="post-author-avatar">
                                <div class="avatar-inner">
                                    <?php echo get_avatar($author_id, 32); ?>
                                </div>
                            </div>
                            <div class="post-author-name">
                                Written by <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
                            </div>
                        </div>
                        <span class="single-post-meta-item-value"><?php echo get_the_date(); ?></span>
                    </div>
                    <div class="share-buttons">
                        <?php echo do_shortcode('[addtoany]'); ?>
                    </div>
                </div>
                <div class="single-post-image">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="single-post-content-inner">
                    <?php
                    $raw_content = get_the_content();
                    $content     = apply_filters( 'the_content', $raw_content );

                    /**
                     * Smart Per-Slot Tracking Logic:
                     * Check which ad slots were explicitly placed by shortcodes in Gutenberg editor.
                     * Any unplaced slots (e.g. Slot 2, Slot 3) will be auto-injected dynamically
                     * so the user NEVER has to manually delete old [horizontal_single_ad] shortcodes!
                     */
                    $slot1_manual = ( strpos( $raw_content, '[horizontal_single_ad' ) !== false || strpos( $raw_content, 'horizontal_ad_1' ) !== false || strpos( $raw_content, 'slot="1"' ) !== false );
                    $slot2_manual = ( strpos( $raw_content, 'horizontal_ad_2' ) !== false || strpos( $raw_content, 'slot="2"' ) !== false );
                    $slot3_manual = ( strpos( $raw_content, 'horizontal_ad_3' ) !== false || strpos( $raw_content, 'slot="3"' ) !== false );

                    // If all 3 slots were manually placed, output processed content directly
                    if ( $slot1_manual && $slot2_manual && $slot3_manual ) {
                        echo $content;
                    } else {
                        $paragraphs  = explode( '</p>', $content );
                        $total_paras = count( $paragraphs ) - 1;

                        if ( $total_paras < 1 ) {
                            echo $content;
                        } else {
                            $output = '';

                            // Determine points for slots that were NOT manually placed
                            $slot_points = [];

                            // Candidate paragraph positions based on total paragraph count
                            $p_for_slot1 = ( $total_paras >= 2 ) ? 2 : 1;
                            $p_for_slot2 = ( $total_paras >= 4 ) ? 4 : ( ( $total_paras >= 2 ) ? 2 : 1 );
                            $p_for_slot3 = ( $total_paras >= 6 ) ? 6 : ( ( $total_paras >= 3 ) ? 3 : $total_paras );

                            if ( ! $slot1_manual ) {
                                $slot_points[ $p_for_slot1 ][] = 1;
                            }
                            if ( ! $slot2_manual ) {
                                $slot_points[ $p_for_slot2 ][] = 2;
                            }
                            if ( ! $slot3_manual ) {
                                $slot_points[ $p_for_slot3 ][] = 3;
                            }

                            foreach ( $paragraphs as $index => $paragraph ) {
                                if ( empty( trim( $paragraph ) ) && $index === count( $paragraphs ) - 1 ) {
                                    continue;
                                }

                                $output .= $paragraph . '</p>';
                                $p_num   = $index + 1;

                                if ( ! empty( $slot_points[ $p_num ] ) ) {
                                    foreach ( $slot_points[ $p_num ] as $inject_slot ) {
                                        ob_start();
                                        get_template_part( 'template-parts/ads/horizontal-single-ad', null, array(
                                            'slot' => $inject_slot,
                                        ) );
                                        $ad_html = ob_get_clean();

                                        if ( ! empty( trim( $ad_html ) ) ) {
                                            $output .= '<div class="auto-injected-ad-slot auto-slot-' . $inject_slot . '" style="margin:24px 0;">' . $ad_html . '</div>';
                                        }
                                    }
                                }
                            }

                            echo $output;   
                        }
                    }
                    ?>
                </div>
                <!-- Author Profile Card -->
                <?php get_template_part( 'template-parts/content/single-author-box' ); ?>
                <!-- Previous and next post -->
                <div class="single-post-previous-next"> 
                    <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                    ?>
                    <nav class="custom-post-navigation">
                        <?php if ( $next_post ) : ?>
                            <div class="nav-next">
                                <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                                    <div class="nav-thumb">
                                        <?php echo get_the_post_thumbnail( $next_post->ID, 'medium' ); ?>
                                    </div>
                                    <div class="nav-content">
                                        <span class="nav-subtitle">Previous:</span>
                                        <span class="nav-title">
                                            <?php echo get_the_title( $next_post->ID ); ?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ( $prev_post ) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                                    <div class="nav-thumb">
                                        <?php echo get_the_post_thumbnail( $prev_post->ID, 'medium' ); ?>
                                    </div>
                                    <div class="nav-content">
                                        <span class="nav-subtitle">Next:</span>
                                        <span class="nav-title">
                                            <?php echo get_the_title( $prev_post->ID ); ?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </nav>
                </div>
            </div>
            <div class="single-post-sidebar">
                <!-- Sidebar big small ad -->
                <?php get_template_part( 'template-parts/ads/sidebar-big-small-ad', null, array( 'page_id' => $current_post_id, 'show_navigation_box' => true, 'show_subscribe_form' => true, 'global_blogs_settings_page_id' => $global_blogs_settings_page_id ) ); ?>
            </div>
        </div>

        <div class="single-post-related-posts">
            <?php get_template_part('template-parts/content/related-posts', null, array('post_id' => $current_post_id)) ?>
        </div>
    </div>
</main>

<?php
get_footer();

