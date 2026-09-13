<?php
/**
 * Template part for displaying events list
 *
 * @package NewsToday
 */

if ( ! function_exists( 'newstoday_format_event_date_range' ) ) {
    /**
     * Format ACF start/end date values into a readable range.
     *
     * @param string|null $start_raw
     * @param string|null $end_raw
     * @return string
     */
    function newstoday_format_event_date_range( $start_raw, $end_raw ) {
        $start_display = '';
        $end_display   = '';

        if ( $start_raw ) {
            $start = date_create( $start_raw );
            if ( $start ) {
                $start_display = date_format( $start, 'M j' );
            }
        }

        if ( $end_raw ) {
            $end = date_create( $end_raw );
            if ( $end ) {
                $end_display = date_format( $end, 'M j' );
            }
        }

        if ( $start_display && $end_display ) {
            return sprintf( '%1$s - %2$s', $start_display, $end_display );
        }

        if ( $start_display ) {
            return $start_display;
        }

        if ( $end_display ) {
            return $end_display;
        }

        return '';
    }
}

$paged            = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$per_page         = 4;
$selected_month   = isset( $_GET['month'] ) ? sanitize_text_field( wp_unslash( $_GET['month'] ) ) : '';
$selected_country = isset( $_GET['country'] ) ? sanitize_text_field( wp_unslash( $_GET['country'] ) ) : '';

// Validate month value to be sure it is one of the 12 calendar months.
$valid_months = array( '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12' );
if ( ! in_array( $selected_month, $valid_months, true ) ) {
    $selected_month = '';
}

$meta_query = array( 'relation' => 'AND' );

if ( $selected_month ) {
    $current_year = (int) date( 'Y' );
    $month_start  = sprintf( '%04d-%02d-01', $current_year, (int) $selected_month );
    $month_end    = date( 'Y-m-t', strtotime( $month_start ) ); // Last day of the month.

    // Match events that overlap the selected month based on start/end date ACF fields.
    $meta_query[] = array(
        'relation' => 'OR',
        array(
            'relation' => 'AND',
            array(
                'key'     => 'start_date',
                'value'   => $month_end,
                'compare' => '<=',
                'type'    => 'DATE',
            ),
            array(
                'key'     => 'end_date',
                'value'   => $month_start,
                'compare' => '>=',
                'type'    => 'DATE',
            ),
        ),
        array(
            'key'     => 'start_date',
            'value'   => array( $month_start, $month_end ),
            'compare' => 'BETWEEN',
            'type'    => 'DATE',
        ),
    );
}

if ( $selected_country ) {
    // ACF stores multiple select values as serialized arrays; match the quoted value to be reliable.
    $meta_query[] = array(
        'relation' => 'OR',
        array(
            'key'     => 'countries',
            'value'   => '"' . $selected_country . '"',
            'compare' => 'LIKE',
        ),
        array(
            'key'     => 'countries',
            'value'   => $selected_country,
            'compare' => '=',
        ),
    );
}

$query_args = array(
    'post_type'      => 'events',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value',
    'meta_key'       => 'start_date',
    'meta_type'      => 'DATE',
    'order'          => 'DESC',
);

if ( count( $meta_query ) > 1 ) {
    $query_args['meta_query'] = $meta_query;
}

$events_q = new WP_Query( $query_args );

$max_pages  = (int) $events_q->max_num_pages;
$has_prev   = $paged > 1;
$has_next   = $paged < $max_pages;
$base_url   = add_query_arg(
    array_filter(
        array(
            'month'   => $selected_month,
            'country' => $selected_country,
        )
    ),
    get_permalink()
);

?>

<div class="events-list">
    <?php if ( $events_q->have_posts() ) : ?>
        <?php
        while ( $events_q->have_posts() ) :
            $events_q->the_post();
            $start_raw   = get_field( 'start_date' );
            $end_raw     = get_field( 'end_date' );
            $date_range  = newstoday_format_event_date_range( $start_raw, $end_raw );
            $thumbnail   = get_the_post_thumbnail_url( get_the_ID(), 'large' );
            $excerpt     = get_the_excerpt();
            ?>
            <article <?php post_class( 'event-card' ); ?>>
                <div class="event-card__body">
                    <div class="event-card__media">
                        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                            <?php if ( $thumbnail ) : ?>
                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                            <?php else : ?>
                                <div class="event-card__placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="event-card__content">
                        <h2 class="event-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="event-card__header">
                            <?php if ( $date_range ) : ?>
                                <div class="event-card__date">
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_107338)">
                                        <path d="M20.1733 1.92605H19.2408V0.982475C19.2408 0.44336 18.8038 0.00634766 18.2647 0.00634766C17.7255 0.00634766 17.2885 0.44336 17.2885 0.982475V1.92605H7.71141V0.982475C7.71141 0.44336 7.27439 0.00634766 6.73528 0.00634766C6.19616 0.00634766 5.75915 0.44336 5.75915 0.982475V1.92605H4.82671C2.16525 1.92605 0 4.0913 0 6.75271L0 20.1685C0 22.83 2.16525 24.9952 4.82671 24.9952H20.1733C22.8347 24.9952 25 22.83 25 20.1685V6.75271C25 4.0913 22.8347 1.92605 20.1733 1.92605ZM4.82671 3.8783H5.75915V5.78175C5.75915 6.32087 6.19616 6.75788 6.73528 6.75788C7.27439 6.75788 7.71141 6.32087 7.71141 5.78175V3.8783H17.2886V5.78175C17.2886 6.32087 17.7256 6.75788 18.2647 6.75788C18.8038 6.75788 19.2408 6.32087 19.2408 5.78175V3.8783H20.1733C21.7583 3.8783 23.0477 5.16777 23.0477 6.75271V7.6852H1.95225V6.75271C1.95225 5.16777 3.24172 3.8783 4.82671 3.8783ZM20.1733 23.043H4.82671C3.24172 23.043 1.95225 21.7535 1.95225 20.1685V9.63746H23.0477V20.1685C23.0477 21.7535 21.7583 23.043 20.1733 23.043Z" fill="#747474"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_1_107338">
                                        <rect width="25" height="25" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="event-card__date-range"><?php echo esc_html( $date_range ); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="event-card__location">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_961_4585)">
                                    <path d="M13.2172 13.0969C15.2679 9.87907 15.0101 10.2805 15.0692 10.1966C15.8158 9.14357 16.2104 7.90416 16.2104 6.61231C16.2104 3.18642 13.4304 0.364258 10 0.364258C6.58081 0.364258 3.78958 3.18085 3.78958 6.61231C3.78958 7.90333 4.19247 9.17518 4.96354 10.2424L6.7827 13.097C4.83771 13.3959 1.53125 14.2866 1.53125 16.2479C1.53125 16.9628 1.9979 17.9817 4.221 18.7757C5.7733 19.33 7.82564 19.6354 10 19.6354C14.0659 19.6354 18.4688 18.4884 18.4688 16.2479C18.4688 14.2862 15.1662 13.3965 13.2172 13.0969ZM5.90673 9.62135C5.90052 9.61164 5.89405 9.60216 5.88727 9.59282C5.24564 8.71012 4.91875 7.66398 4.91875 6.61231C4.91875 3.78872 7.19236 1.49342 10 1.49342C12.8018 1.49342 15.0812 3.78974 15.0812 6.61231C15.0812 7.66568 14.7605 8.67632 14.1536 9.53576C14.0992 9.6075 14.383 9.16668 10 16.0442L5.90673 9.62135ZM10 18.5062C5.55884 18.5062 2.66042 17.2008 2.66042 16.2479C2.66042 15.6074 4.14971 14.5543 7.44989 14.1438L9.52387 17.3982C9.62753 17.5609 9.80706 17.6593 9.99996 17.6593C10.1929 17.6593 10.3724 17.5608 10.4761 17.3982L12.55 14.1438C15.8502 14.5543 17.3396 15.6074 17.3396 16.2479C17.3396 17.1927 14.4672 18.5062 10 18.5062Z" fill="#252733" stroke="#252733" stroke-width="0.3"/>
                                    <path d="M10.0007 3.78955C8.44409 3.78955 7.17773 5.05591 7.17773 6.61247C7.17773 8.16902 8.44409 9.43538 10.0007 9.43538C11.5572 9.43538 12.8236 8.16902 12.8236 6.61247C12.8236 5.05591 11.5572 3.78955 10.0007 3.78955ZM10.0007 8.30622C9.06672 8.30622 8.3069 7.5464 8.3069 6.61247C8.3069 5.67853 9.06672 4.91872 10.0007 4.91872C10.9346 4.91872 11.6944 5.67853 11.6944 6.61247C11.6944 7.5464 10.9346 8.30622 10.0007 8.30622Z" fill="#252733" stroke="#252733" stroke-width="0.3"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_961_4585">
                                    <rect width="20" height="20" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                                <?php echo esc_html( get_field( 'location' ) ); ?>
                            </div>
                        </div>
                        <?php if ( $excerpt ) : ?>
                            <p class="event-card__excerpt"><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p>
                        <?php endif; ?>

                        <a class="event-card__cta" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Event', 'newstoday' ); ?></a>
                    </div>
                    </div>
            </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="events-list__empty"><?php esc_html_e( 'No upcoming events found.', 'newstoday' ); ?></p>
    <?php endif; ?>
</div>

<?php if ( $max_pages > 1 ) : ?>
    <div class="events-pagination">
        <?php
        $prev_url = $has_prev ? add_query_arg( 'paged', $paged - 1, $base_url ) : '#';
        $next_url = $has_next ? add_query_arg( 'paged', $paged + 1, $base_url ) : '#';
        ?>
        <a class="events-pagination__btn prev <?php echo $has_prev ? '' : 'is-disabled'; ?>" href="<?php echo esc_url( $prev_url ); ?>" <?php echo $has_prev ? '' : 'aria-disabled="true"'; ?>>
            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="25" r="25" fill="black"/>
            <path d="M35 25.0901L21 15V25.0901V35L35 25.0901Z" fill="white"/>
            </svg>
        </a>
        <a class="events-pagination__btn next <?php echo $has_next ? '' : 'is-disabled'; ?>" href="<?php echo esc_url( $next_url ); ?>" <?php echo $has_next ? '' : 'aria-disabled="true"'; ?>>
            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="25" r="25" fill="black"/>
            <path d="M35 25.0901L21 15V25.0901V35L35 25.0901Z" fill="white"/>
            </svg>
        </a>
    </div>
<?php endif; ?>