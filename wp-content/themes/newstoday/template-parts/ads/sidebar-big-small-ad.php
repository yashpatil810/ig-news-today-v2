<?php
/**
 * Optimized Sidebar big small ads with carousel
 */

$page_id = isset($args['page_id']) ? $args['page_id'] : get_the_ID();

$show_navigation_box = isset($args['show_navigation_box']) ? $args['show_navigation_box'] : false;
$show_subscribe_form = isset($args['show_subscribe_form']) ? $args['show_subscribe_form'] : false;
$global_blogs_settings_page_id = isset($args['global_blogs_settings_page_id']) ? $args['global_blogs_settings_page_id'] : false;

/**
 * IMPORTANT:
 * get_fields() loads ALL ACF values in ONE DB query
 */
$page_acf = get_fields($page_id);
$acf = is_array($page_acf) ? $page_acf : [];

// print_r($acf);

if ($global_blogs_settings_page_id) {
    $global_acf = get_fields($global_blogs_settings_page_id);
    // print_r($global_acf);
    if (is_array($global_acf)) {
        foreach ($global_acf as $key => $value) {
            // echo $key . ' - ';
            // echo empty($acf[$key]) ? 'empty' : 'not empty';
            // echo !array_key_exists($key, $acf) ? ' - not exists' : ' - exists';
            if (empty($acf[$key])) {
                // echo 'empty';
                $acf[$key] = $value;
            }
            // echo '<br>';
        }
    }
}

// print_r($acf);

$ad_blocks = [
    'first_sidebar',
    'second_sidebar',
    'third_sidebar'
];
?>

<div class="sidebar-big-small-ad">

<?php foreach ($ad_blocks as $index => $block) : ?>

    <?php
    $width = 300;
    $height = 250;
    if ($block === 'first_sidebar') {
        $height = 600;
    } elseif ($block === 'third_sidebar') {
        $height = 80;
    }
    ?>

    <?php
    $google_ad = $acf["{$block}_google_ad"] ?? '';

    // trim _sidebar from block
    $hidden_block = str_replace('_sidebar', '', $block);
    $is_hidden = $acf["hide_{$hidden_block}_ad_on_mobile"] ?? false;

    $ads = [];

    for ($i = 1; $i <= 5; $i++) {

        $img  = $acf["{$block}_ad_{$i}"] ?? '';
        $link = $acf["{$block}_ad_link_{$i}"] ?? '';

        if (!empty($img)) {
            $ads[] = [
                'img'  => $img,
                'link' => $link
            ];
        }
    }
    ?>

    <div class="sidebar-ad-block">

        <?php if (!empty($google_ad)) : ?>

            <div class="sidebar-google-ad <?php echo $is_hidden ? 'hidden-on-mobile' : ''; ?>">
                <?php echo $google_ad; ?>
            </div>

        <?php else : ?>

            <?php if (count($ads) > 1) : ?>

                <div class="sidebar-ad-carousel <?php echo $is_hidden ? 'hidden-on-mobile' : ''; ?>">
                    <?php foreach ($ads as $index => $ad) : ?>
                        <a href="<?php echo esc_url($ad['link']); ?>"
                           class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">

                            <img src="<?php echo esc_url($ad['img']['url']); ?>"
                                 alt="<?php echo esc_attr($ad['img']['alt']); ?>"
                                 width="<?php echo $width; ?>"
                                 height="<?php echo $height; ?>"
                                 loading="lazy">

                        </a>
                    <?php endforeach; ?>
                </div>

            <?php elseif (count($ads) === 1) : ?>

                <a href="<?php echo esc_url($ads[0]['link']); ?>" class="<?php echo $is_hidden ? 'hidden-on-mobile' : ''; ?>">
                    <img src="<?php echo esc_url($ads[0]['img']['url']); ?>"
                         alt="<?php echo esc_attr($ads[0]['img']['alt']); ?>"
                         width="<?php echo $width; ?>"
                         height="<?php echo $height; ?>"
                         loading="lazy">
                </a>

            <?php endif; ?>

        <?php endif; ?>

    </div>

    <?php if ($show_navigation_box && $index === 0) : ?>
        <div class="desktop-navigation-box">
            <?php get_template_part('template-parts/sidebar/navigation-box'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_subscribe_form && $index === 1) : ?>
        <div class="desktop-subscribe-form">
            <?php get_template_part('template-parts/sidebar/subscribe-form'); ?>
        </div>
    <?php endif; ?>

<?php endforeach; ?>

</div>