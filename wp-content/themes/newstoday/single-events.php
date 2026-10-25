<?php
/**
 * Template Name: Events Single
 *
 * @package NewsToday
 */

get_header();
$current_post_id = get_the_ID();
$global_blogs_settings_page_id = 10969;

$start_raw      = get_field( 'start_date' );
$end_raw        = get_field( 'end_date' );
$organiser_name = get_field( 'organiser_name' );
$thumbnail      = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$register_link  = get_field( 'register_link' );
$website        = get_field( 'website' );
$location       = get_field( 'location' );

$date = array();
if ( $start_raw ) {
    $date['start'] = $start_raw;
}
if ( $end_raw ) {
    $date['end'] = $end_raw;
}

$date_range = implode( ' - ', $date );

// Schema.org Event Structured Data (Item 3.2)
$event_schema = array(
    '@context'            => 'https://schema.org',
    '@type'               => 'Event',
    'name'                => get_the_title(),
    'url'                 => get_permalink(),
    'eventStatus'         => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
);

$excerpt = get_the_excerpt();
if ( ! empty( $excerpt ) ) {
    $event_schema['description'] = wp_strip_all_tags( $excerpt );
} elseif ( get_the_content() ) {
    $event_schema['description'] = wp_strip_all_tags( wp_trim_words( get_the_content(), 30 ) );
}

if ( ! empty( $thumbnail ) ) {
    $event_schema['image'] = array( esc_url_raw( $thumbnail ) );
}

if ( ! empty( $start_raw ) ) {
    $start_time = strtotime( $start_raw );
    if ( $start_time ) {
        $event_schema['startDate'] = date( 'c', $start_time );
    }
}

if ( ! empty( $end_raw ) ) {
    $end_time = strtotime( $end_raw );
    if ( $end_time ) {
        $event_schema['endDate'] = date( 'c', $end_time );
    }
}

if ( ! empty( $location ) ) {
    $event_schema['location'] = array(
        '@type'   => 'Place',
        'name'    => $location,
        'address' => $location,
    );
}

if ( ! empty( $organiser_name ) ) {
    $event_schema['organizer'] = array(
        '@type' => 'Organization',
        'name'  => $organiser_name,
        'url'   => ! empty( $website ) ? esc_url_raw( $website ) : get_permalink(),
    );
}

if ( ! empty( $register_link ) ) {
    $event_schema['offers'] = array(
        '@type' => 'Offer',
        'url'   => esc_url_raw( $register_link ),
    );
}
?>

<script type="application/ld+json">
<?php echo json_encode( $event_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
</script>

<main id="primary" class="site-main">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads', null, array('page_id' => $global_blogs_settings_page_id)); ?>
        <div class="breadcrumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'events' ) ) ); ?>">Events</a>
            <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
        </div>
        <div class="single-event-body">
            <div class="single-event-content">
                <div class="single-event-header">
                    <div class="icon-wrapper">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.6016 4.7373H5.60156L13.1805 35.1373L21.6016 4.7373Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                        </svg>
                    </div>
                    <h1 class="single-event-title"><?php echo esc_html( get_the_title() ); ?></h1>
                </div>
                <div class="event-meta">
                    <div class="left-side">
                        <?php if ( ! empty( $organiser_name ) ) : ?>
                            <span class="event-meta-item">
                                <?php echo esc_html( $organiser_name ); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ( ! empty( $date_range ) ) : ?>
                            <span class="date-range">
                                <?php echo esc_html( $date_range ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $register_link ) ) : ?>
                        <div class="right-side">
                            <a href="<?php echo esc_url( $register_link ); ?>" class="register-link" target="_blank" rel="noopener noreferrer">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="single-event-image">
                    <?php if ( ! empty( $thumbnail ) ) : ?>
                        <div class="event-image-wrapper">
                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $website ) ) : ?>
                        <div class="event-website-wrapper">
                            <a href="<?php echo esc_url( $website ); ?>" class="event-website-link" target="_blank" rel="noopener noreferrer">
                                Website
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="single-event-content-inner">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="single-event-sidebar">
                <?php get_template_part('template-parts/ads/sidebar-big-small-ad', null, array('page_id' => $global_blogs_settings_page_id)); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
