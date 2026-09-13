<?php
/**
 * Template part for displaying horizontal single ad (Optimized & Slot-Aware)
 * 
 * - Supports slots: 1, 2, 3
 * - Fallback to Global Settings Page (ID 10969) if post-specific slot is empty
 * - Robust image resolution (handles both array and attachment ID formats)
 * - Auto-rotating slider with dot indicators if multiple ads are present
 * 
 * @package NewsToday
 */

$page_id = isset( $args['page_id'] ) ? (int) $args['page_id'] : get_the_ID();
$slot    = isset( $args['slot'] ) ? (int) $args['slot'] : 1;
if ( $slot < 1 || $slot > 3 ) {
    $slot = 1;
}

$global_page_id = 10969;
$acf            = get_fields( $page_id );
$horizontal_ads = [];

// Helper function to extract ads from an ACF fields array for a specific slot
if ( ! function_exists( 'get_slot_ads_from_acf' ) ) {
    function get_slot_ads_from_acf( $acf_fields, $slot_num ) {
        $ads = [];
        if ( ! is_array( $acf_fields ) ) return $ads;

        for ( $i = 1; $i <= 5; $i++ ) {
            $ad   = $acf_fields["horizontal_ad_{$slot_num}_{$i}"] ?? '';
            $link = $acf_fields["horizontal_ad_link_{$slot_num}_{$i}"] ?? '';

            // Backward compatibility fallback for Slot 1
            if ( $slot_num === 1 && empty( $ad ) ) {
                $ad   = $acf_fields["horizontal_single_ad_{$i}"] ?? '';
                $link = $acf_fields["horizontal_single_ad_link_{$i}"] ?? '';
            }

            if ( ! empty( $ad ) ) {
                $img_url = '';
                $img_alt = '';

                if ( is_array( $ad ) && ! empty( $ad['url'] ) ) {
                    $img_url = $ad['url'];
                    $img_alt = $ad['alt'] ?? '';
                } elseif ( is_numeric( $ad ) && (int) $ad > 0 ) {
                    $img_src = wp_get_attachment_image_src( (int) $ad, 'full' );
                    if ( $img_src && ! empty( $img_src[0] ) ) {
                        $img_url = $img_src[0];
                        $img_alt = get_post_meta( (int) $ad, '_wp_attachment_image_alt', true ) ?: '';
                    }
                }

                if ( ! empty( $img_url ) ) {
                    $ads[] = [
                        'ad'   => [ 'url' => $img_url, 'alt' => $img_alt ],
                        'link' => $link,
                    ];
                }
            }
        }
        return $ads;
    }
}

// 1. Try fetching from current post
$horizontal_ads = get_slot_ads_from_acf( $acf, $slot );
$google_ad      = $acf["horizontal_ad_google_{$slot}"] ?? '';
if ( $slot === 1 && empty( $google_ad ) ) {
    $google_ad = $acf['horizontal_single_google_ad'] ?? '';
}

// 2. Fallback to Global Settings Page (ID 10969) if post has no ad set for this slot
if ( empty( $google_ad ) && count( $horizontal_ads ) === 0 && $page_id !== $global_page_id ) {
    $global_acf     = get_fields( $global_page_id );
    $horizontal_ads = get_slot_ads_from_acf( $global_acf, $slot );
    $google_ad      = $global_acf["horizontal_ad_google_{$slot}"] ?? '';
    if ( $slot === 1 && empty( $google_ad ) ) {
        $google_ad = $global_acf['horizontal_single_google_ad'] ?? '';
    }
}

$hide_on_mobile = $acf['hide_horizontal_single_ad_on_mobile'] ?? false;
$carousel_id    = 'had-carousel-s' . $slot . '-' . uniqid();
?>

<?php if ( ! empty( $google_ad ) || count( $horizontal_ads ) > 0 ) : ?>

<div class="horizontal-single-ad horizontal-single-ad-slot-<?php echo esc_attr( $slot ); ?> <?php echo $hide_on_mobile ? 'hidden-on-mobile' : ''; ?>">

    <?php if ( ! empty( $google_ad ) ) : ?>

        <div class="horizontal-single-ad-google-ad">
            <?php echo $google_ad; ?>
        </div>

    <?php elseif ( count( $horizontal_ads ) > 1 ) : ?>

        <!-- Multiple ads in slot: Auto-rotating carousel with dot indicators -->
        <div class="horizontal-ad-carousel-wrapper">

            <!-- Slides -->
            <div class="horizontal-ad-carousel" id="<?php echo esc_attr( $carousel_id ); ?>">
                <?php foreach ( $horizontal_ads as $index => $item ) : ?>
                    <a href="<?php echo esc_url( $item['link'] ); ?>"
                       class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>"
                       style="<?php echo $index !== 0 ? 'display:none;' : 'display:block;'; ?>">
                        <img src="<?php echo esc_url( $item['ad']['url'] ); ?>"
                             alt="<?php echo esc_attr( $item['ad']['alt'] ); ?>"
                             width="720"
                             height="100"
                             loading="lazy"
                             style="width:100%;height:auto;display:block;">
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Dot Indicators -->
            <div class="carousel-dots" id="<?php echo esc_attr( $carousel_id ); ?>-dots">
                <?php foreach ( $horizontal_ads as $index => $item ) : ?>
                    <button class="carousel-dot <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-index="<?php echo $index; ?>"
                            aria-label="Ad <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>

        <style>
        @keyframes hadFadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        #<?php echo esc_attr( $carousel_id ); ?> .carousel-item.active {
            animation: hadFadeIn 0.5s ease;
        }
        #<?php echo esc_attr( $carousel_id ); ?>-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }
        #<?php echo esc_attr( $carousel_id ); ?>-dots .carousel-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ccc;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: background 0.3s, transform 0.3s;
        }
        #<?php echo esc_attr( $carousel_id ); ?>-dots .carousel-dot.active {
            background: #FC0303;
            transform: scale(1.3);
        }
        </style>

        <script>
        (function() {
            var carouselId  = <?php echo json_encode( $carousel_id ); ?>;
            var carousel    = document.getElementById( carouselId );
            var dotsWrapper = document.getElementById( carouselId + '-dots' );
            if ( ! carousel || ! dotsWrapper ) return;

            var items   = carousel.querySelectorAll( '.carousel-item' );
            var dots    = dotsWrapper.querySelectorAll( '.carousel-dot' );
            var total   = items.length;
            var current = 0;
            var timer;

            if ( total <= 1 ) return;

            function goTo( index ) {
                items[current].style.display = 'none';
                items[current].classList.remove( 'active' );
                dots[current].classList.remove( 'active' );

                current = index;

                items[current].style.display = 'block';
                items[current].classList.add( 'active' );
                dots[current].classList.add( 'active' );
            }

            function next() {
                goTo( ( current + 1 ) % total );
            }

            // Dot click → jump to slide & reset timer
            dots.forEach( function( dot, i ) {
                dot.addEventListener( 'click', function() {
                    clearInterval( timer );
                    goTo( i );
                    timer = setInterval( next, 4000 );
                });
            });

            // Auto-rotate every 4 seconds
            timer = setInterval( next, 4000 );
        })();
        </script>

    <?php else : ?>

        <!-- Single ad in slot: show directly -->
        <?php $single = $horizontal_ads[0]; ?>
        <a href="<?php echo esc_url( $single['link'] ); ?>">
            <img src="<?php echo esc_url( $single['ad']['url'] ); ?>"
                 alt="<?php echo esc_attr( $single['ad']['alt'] ); ?>"
                 width="720"
                 height="100"
                 loading="lazy"
                 style="width:100%;height:auto;display:block;">
        </a>

    <?php endif; ?>

</div>

<?php endif; ?>