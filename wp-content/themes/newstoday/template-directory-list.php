<?php
/**
 * Template Name: Directory Listing Page
 *
 * @package NewsToday
 */

get_header();
?>

<main id="primary" class="site-main directory-listing-template">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads'); ?>
        <div class="directory-listing-layout">
            <div class="directory-listing-content">
                <div class="section-header">
                    <div class="section-title-wrapper">
                        <div class="icon-wrapper">
                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                            <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                            </svg>
                        </div>
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </div>

                <div class="directory-list-description">
                    <?php the_field('description'); ?>
                </div>
            </div>

            <div class="directory-list">
                <?php
                    // sort by company_tag - Enterprise, Premium, Basic

                    $args = array(
                        'post_type'      => 'directory',
                        'posts_per_page' => 6,
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
                    endif;
                ?>
                <!-- Repeat ad -->
                <?php ?>
            </div>

            <div class="directory-list-sidebar">
                <?php get_template_part('template-parts/directory/two-columns-directory-ad-sidebar'); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();