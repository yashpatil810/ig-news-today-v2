<?php
/**
 * Optimized Header Images with Carousel Support
 * Only the LCP image (first image of second slot) gets fetchpriority="high".
 */

$page_id = isset($args['page_id']) ? $args['page_id'] : get_the_ID();
$acf     = $args['acf'] ?? get_fields($page_id);

$header_slots = array( 'first', 'second', 'third' );

// LCP is the first image of the second slot
$lcp_img  = $acf['second_ad_1'] ?? $acf['second_ad'] ?? null;
$lcp_url  = ( ! empty( $lcp_img['url'] ) ) ? $lcp_img['url'] : null;
?>

<div class="header-images">

<?php foreach ( $header_slots as $slot ) : ?>
    <?php
    $google_ad = $acf["{$slot}_google_ad"] ?? '';
    $ads       = array();

    for ( $i = 1; $i <= 5; $i++ ) {
        $img  = $acf["{$slot}_ad_{$i}"] ?? ( $acf["{$slot}_ad"] ?? '' );
        $link = $acf["{$slot}_ad_link_{$i}"] ?? ( $acf["{$slot}_ad_link"] ?? '' );
        if ( ! empty( $img ) ) {
            $ads[] = array( 'img' => $img, 'link' => $link );
        }
    }
    $ads = array_unique( $ads, SORT_REGULAR );
    ?>

    <div class="header-image-slot">

        <?php if ( ! empty( $google_ad ) ) : ?>
            <?php echo $google_ad; ?>
        <?php else : ?>

            <?php if ( count( $ads ) > 1 ) : ?>
                <div class="header-ad-carousel">
                    <?php foreach ( $ads as $index => $ad ) : ?>
                        <?php
                        $is_lcp = ( null !== $lcp_url && ( $ad['img']['url'] ?? '' ) === $lcp_url && 0 === $index );
                        ?>
                        <a href="<?php echo esc_url( $ad['link'] ); ?>"
                           class="carousel-item <?php echo 0 === $index ? 'active' : ''; ?>">
                            <img src="<?php echo esc_url( $ad['img']['url'] ); ?>"
                                 alt="<?php echo esc_attr( $ad['img']['alt'] ?? '' ); ?>"
                                 width="720"
                                 height="100"
                                 loading="<?php echo $is_lcp ? 'eager' : 'lazy'; ?>"
                                 <?php echo $is_lcp ? ' fetchpriority="high"' : ''; ?>
                                 decoding="async">
                        </a>
                    <?php endforeach; ?>
                </div>

            <?php elseif ( 1 === count( $ads ) ) : ?>
                <?php
                $is_lcp = ( null !== $lcp_url && ( $ads[0]['img']['url'] ?? '' ) === $lcp_url );
                ?>
                <a href="<?php echo esc_url( $ads[0]['link'] ); ?>">
                    <img src="<?php echo esc_url( $ads[0]['img']['url'] ); ?>"
                         alt="<?php echo esc_attr( $ads[0]['img']['alt'] ?? '' ); ?>"
                         width="720"
                         height="100"
                         loading="<?php echo $is_lcp ? 'eager' : 'lazy'; ?>"
                         <?php echo $is_lcp ? ' fetchpriority="high"' : ''; ?>
                         decoding="async">
                </a>
            <?php endif; ?>

        <?php endif; ?>

    </div>

<?php endforeach; ?>

</div>
