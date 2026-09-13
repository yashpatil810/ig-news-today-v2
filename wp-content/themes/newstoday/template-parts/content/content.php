<?php
/**
 * Template part for displaying posts
 *
 * @package NewsToday
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        if ( 'post' === get_post_type() ) :
            ?>
            <div class="entry-meta">
                <?php
                newstoday_posted_on();
                newstoday_posted_by();
                ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if ( is_singular() ) :
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newstoday' ),
                    'after'  => '</div>',
                )
            );
        else :
            the_excerpt();
            ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more">
                <?php esc_html_e( 'Read More', 'newstoday' ); ?>
            </a>
            <?php
        endif;
        ?>
    </div>

    <footer class="entry-footer">
        <?php newstoday_entry_footer(); ?>
    </footer>
</article>

<?php
/**
 * Display posted on date
 */
function newstoday_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        esc_html( get_the_date() )
    );

    $posted_on = sprintf(
        esc_html_x( 'Posted on %s', 'post date', 'newstoday' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span>';
}

/**
 * Display post author
 */
function newstoday_posted_by() {
    $byline = sprintf(
        esc_html_x( 'by %s', 'post author', 'newstoday' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="byline"> ' . $byline . '</span>';
}

/**
 * Display entry footer meta
 */
function newstoday_entry_footer() {
    $categories_list = get_the_category_list( esc_html__( ', ', 'newstoday' ) );
    if ( $categories_list ) {
        printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'newstoday' ) . '</span>', $categories_list );
    }

    $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'newstoday' ) );
    if ( $tags_list ) {
        printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'newstoday' ) . '</span>', $tags_list );
    }
}

