<?php
/**
 * Template part for displaying two columns directory and ad sidebar
 *
 * @package NewsToday
 */

// Get total directory posts count
$total_posts_query = new WP_Query( array(
    'post_type'      => 'directory',
    'posts_per_page' => -1,
    'fields'         => 'ids',
) );
$total_posts = $total_posts_query->found_posts;
wp_reset_postdata();

$posts_per_page = 6;
$initial_offset = 6; // First 6 are shown in the main directory-list section
$current_offset = $initial_offset + $posts_per_page; // After loading this section, offset will be 12
?>

<div class="two-columns-directory-ad-sidebar-wrapper" 
     data-offset="<?php echo esc_attr( $current_offset ); ?>" 
     data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>"
     data-total-posts="<?php echo esc_attr( $total_posts ); ?>"
     data-page-id="<?php echo esc_attr( get_the_ID() ); ?>">
    
    <div class="top-ad-section">
        <?php get_template_part('template-parts/ads/horizontal-single-ad'); ?>
    </div>
    <div class="two-columns-directory-ad-sidebar-content">
        <div class="directory-posts-section">
        <?php
            $args = array(
                'post_type'      => 'directory',
                'posts_per_page' => $posts_per_page,
                'offset'         => $initial_offset,
                // Stabilise ordering so the second batch starts exactly after the first 6.
                'meta_key'       => 'company_tag',
                'orderby'        => 'custom_company_tag',
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();

                    $company_description = get_field( 'company_description' );
                    $company_link        = get_field( 'company_link' );
                    $company_logo        = get_field( 'company_logo' ); // ACF image array
                    $company_tag         = get_field( 'company_tag' );   // Enterprise / Premium / Basic

                    // Normalise tag value for classes
                    $tag_slug = $company_tag ? strtolower( str_replace( ' ', '-', $company_tag ) ) : '';
        ?>
            <div class="directory-item <?php echo $tag_slug ? 'directory-item--' . esc_attr( $tag_slug ) : ''; ?>">
                <div class="directory-item-inner">
                    <div class="directory-item-logo-wrapper">
                        <a href="<?php the_permalink(); ?>" class="directory-item-logo-link">
                            <div class="directory-item-logo">
                                <?php if ( ! empty( $company_logo ) && is_array( $company_logo ) && ! empty( $company_logo['url'] ) ) : ?>
                                    <img 
                                        src="<?php echo esc_url( $company_logo['url'] ); ?>" 
                                        alt="<?php echo esc_attr( $company_logo['alt'] ? $company_logo['alt'] : get_the_title() ); ?>" 
                                        loading="lazy"
                                    />
                                <?php else : ?>
                                    <div class="directory-item-logo--placeholder"><?php the_title(); ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <?php if ( $company_description ) : ?>
                        <div class="directory-item-body">
                            <p class="directory-item-description">
                                <?php echo esc_html( $company_description ); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <div class="directory-item-footer">
                        <a 
                            href="<?php the_permalink(); ?>" 
                            class="directory-item-link" 
                            rel="noopener noreferrer"
                        >
                            View Details
                        </a>
                    </div>
                    <div class="directory-item-top">
                        <span class="directory-item-sponsored">
                            <?php if ($company_tag == 'Enterprise') : ?>Sponsored<?php endif; ?>
                        </span>

                        <?php if ( $company_tag ) : ?>
                            <span class="directory-item-tag <?php echo $company_tag ?>">
                                <?php echo esc_html( $company_tag ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php
                endwhile;
                wp_reset_postdata();
            endif;
        ?>
        </div>

        <div class="directory-ad-section">
            <?php get_template_part('template-parts/ads/sidebar-big-small-ad'); ?>
        </div>
    </div>

    <?php if ( $total_posts > $current_offset ) : ?>
    <div class="load-more-section">
        <button class="load-more-button" id="directory-load-more">
            <span class="load-more-text">Load More</span>
            <span class="load-more-spinner" style="display: none;">
                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="31.4 31.4" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </span>
        </button>
    </div>
    <?php endif; ?>
</div>
