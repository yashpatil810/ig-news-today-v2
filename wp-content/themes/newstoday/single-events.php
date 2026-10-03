<?php
/**
 * Template Name: Events Single
 *
 * @package NewsToday
 */

get_header();
$current_post_id = get_the_ID();
$global_blogs_settings_page_id = 10969;

$start_raw   = get_field( 'start_date' );
$end_raw     = get_field( 'end_date' );
$organiser_name = get_field( 'organiser_name' );
$thumbnail   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$register_link = get_field( 'register_link' );
$website = get_field( 'website' );

$date = [];
if ($start_raw) {
    $date['start'] = $start_raw;
}
if ($end_raw) {
    $date['end'] = $end_raw;
}

$date_range = implode(' - ', $date);
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads', null, array('page_id' => $global_blogs_settings_page_id)) ?>
        <div class="breadcrumbs">
            <a href="/">Home</a>
            <a href="<?php echo get_permalink(get_page_by_path('events')); ?>">iGaming Events and Conferences Calendar</a>
            <a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
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
                    <h1 class="single-event-title"><?php echo the_title(); ?></h1>
                </div>
                <div class="event-meta">
                    <div class="left-side">
                        <span class="event-meta-item">
                            <?php echo $organiser_name; ?>
                        </span>
                        <span class="date-range">
                            <?php echo $date_range; ?>
                        </span>
                    </div>
                    <div class="right-side">
                        <a href="<?php echo $register_link; ?>" class="register-link" target="_blank">Register</a>
                    </div>
                </div>
                <div class="single-event-image">
                    <div class="event-image-wrapper">
                        <img src="<?php echo $thumbnail; ?>" alt="<?php echo the_title(); ?>">
                    </div>
                    <div class="event-website-wrapper">
                        <a href="<?php echo $website; ?>" class="event-website-link" target="_blank">
                            Website
                        </a>
                    </div>
                </div>
                <div class="single-event-content-inner">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="single-event-sidebar">
                <?php get_template_part('template-parts/ads/sidebar-big-small-ad', null, array('page_id' => $global_blogs_settings_page_id)) ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>