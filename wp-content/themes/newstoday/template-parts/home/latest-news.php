<?php
/**
 * Template part for displaying Latest News section
 *
 * @package NewsToday
 */

$latest_main_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$latest_side_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'offset'         => 1,
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$latest_main_query = new WP_Query( $latest_main_args );
$latest_side_query = new WP_Query( $latest_side_args );
?>

<section class="latest-news-section">
    <div class="section-header">
            <div class="section-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                    <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                    </svg>
                </div>
                <h1 class="section-title">Latest iGaming News</h1>
            </div>
        </div>

        <div class="latest-news-content">
            <div class="latest-news-layout">
                <!-- Main Featured Article -->
                <div class="latest-main">
                    <?php
                    if ( $latest_main_query->have_posts() ) :
                        while ( $latest_main_query->have_posts() ) : $latest_main_query->the_post();
                            $categories = get_the_category();
                            $category_color = '#606060';
                            $category_name = '';
                            
                            if ( ! empty( $categories ) ) {
                                $category = $categories[0];
                                $category_name = $category->name;
                                $category_color = newstoday_get_category_color( $category );
                            }
                            ?>
                            <div class="nt-article main-article">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="article-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title(), 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="article-content">
                                    <div class="article-meta">
                                        <?php if ( $category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>"><?php echo esc_html( $category_name ); ?></span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                                    </div>
                                    <h3 class="article-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="article-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 30, '.....' ); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <div class="divider-vertical"></div>

                <!-- Side Articles -->
                <div class="latest-side">
                    <?php
                    if ( $latest_side_query->have_posts() ) :
                        while ( $latest_side_query->have_posts() ) : $latest_side_query->the_post();
                            $categories = get_the_category();
                            $category_color = '#606060';
                            $category_name = '';
                            
                            if ( ! empty( $categories ) ) {
                                $category = $categories[0];
                                $category_name = $category->name;
                                $category_color = newstoday_get_category_color( $category );
                            }
                            ?>
                            <div class="nt-article side-article">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="side-article-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="side-article-content">
                                    <div class="article-meta">
                                        <?php if ( $category_name ) : ?>
                                            <span class="category" style="color: <?php echo esc_attr( $category_color ); ?>"><?php echo esc_html( $category_name ); ?></span>
                                        <?php endif; ?>
                                        <span class="separator"></span>
                                        <span class="time"><?php echo esc_html( newstoday_get_post_time_or_date() ); ?></span>
                                    </div>
                                    <h4 class="side-article-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
</section>

