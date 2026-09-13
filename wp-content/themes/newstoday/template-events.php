<?php
/**
 * Template Name: Events Page
 * 
 * Custom template for displaying events posts.
 *
 * @package NewsToday
 */

get_header();

// Countries list for the filter dropdown.
$contriesArray = array(
    'Afghanistan' => 'Afghanistan',
    'Albania' => 'Albania',
    'Algeria' => 'Algeria',
    'Andorra' => 'Andorra',
    'Angola' => 'Angola',
    'Antigua and Barbuda' => 'Antigua and Barbuda',
    'Argentina' => 'Argentina',
    'Armenia' => 'Armenia',
    'Australia' => 'Australia',
    'Austria' => 'Austria',
    'Azerbaijan' => 'Azerbaijan',
    'Bahamas' => 'Bahamas',
    'Bahrain' => 'Bahrain',
    'Bangladesh' => 'Bangladesh',
    'Barbados' => 'Barbados',
    'Belarus' => 'Belarus',
    'Belgium' => 'Belgium',
    'Belize' => 'Belize',
    'Benin' => 'Benin',
    'Bhutan' => 'Bhutan',
    'Bolivia' => 'Bolivia',
    'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
    'Botswana' => 'Botswana',
    'Brazil' => 'Brazil',
    'Brunei' => 'Brunei',
    'Bulgaria' => 'Bulgaria',
    'Burkina Faso' => 'Burkina Faso',
    'Burundi' => 'Burundi',
    'Cambodia' => 'Cambodia',
    'Cameroon' => 'Cameroon',
    'Canada' => 'Canada',
    'Cape Verde' => 'Cape Verde',
    'Central African Republic' => 'Central African Republic',
    'Chad' => 'Chad',
    'Chile' => 'Chile',
    'China' => 'China',
    'Colombia' => 'Colombia',
    'Comoros' => 'Comoros',
    'Congo' => 'Congo',
    'Costa Rica' => 'Costa Rica',
    'Croatia' => 'Croatia',
    'Cuba' => 'Cuba',
    'Cyprus' => 'Cyprus',
    'Czech Republic' => 'Czech Republic',
    'Denmark' => 'Denmark',
    'Djibouti' => 'Djibouti',
    'Dominica' => 'Dominica',
    'Dominican Republic' => 'Dominican Republic',
    'Ecuador' => 'Ecuador',
    'Egypt' => 'Egypt',
    'El Salvador' => 'El Salvador',
    'Equatorial Guinea' => 'Equatorial Guinea',
    'Eritrea' => 'Eritrea',
    'Estonia' => 'Estonia',
    'Eswatini' => 'Eswatini',
    'Ethiopia' => 'Ethiopia',
    'Fiji' => 'Fiji',
    'Finland' => 'Finland',
    'France' => 'France',
    'Gabon' => 'Gabon',
    'Gambia' => 'Gambia',
    'Georgia' => 'Georgia',
    'Germany' => 'Germany',
    'Ghana' => 'Ghana',
    'Greece' => 'Greece',
    'Grenada' => 'Grenada',
    'Guatemala' => 'Guatemala',
    'Guinea' => 'Guinea',
    'Guinea-Bissau' => 'Guinea-Bissau',
    'Guyana' => 'Guyana',
    'Haiti' => 'Haiti',
    'Honduras' => 'Honduras',
    'Hungary' => 'Hungary',
    'Iceland' => 'Iceland',
    'India' => 'India',
    'Indonesia' => 'Indonesia',
    'Iran' => 'Iran',
    'Iraq' => 'Iraq',
    'Ireland' => 'Ireland',
    'Israel' => 'Israel',
    'Italy' => 'Italy',
    'Jamaica' => 'Jamaica',
    'Japan' => 'Japan',
    'Jordan' => 'Jordan',
    'Kazakhstan' => 'Kazakhstan',
    'Kenya' => 'Kenya',
    'Kiribati' => 'Kiribati',
    'Kuwait' => 'Kuwait',
    'Kyrgyzstan' => 'Kyrgyzstan',
    'Laos' => 'Laos',
    'Latvia' => 'Latvia',
    'Lebanon' => 'Lebanon',
    'Lesotho' => 'Lesotho',
    'Liberia' => 'Liberia',
    'Libya' => 'Libya',
    'Liechtenstein' => 'Liechtenstein',
    'Lithuania' => 'Lithuania',
    'Luxembourg' => 'Luxembourg',
    'Madagascar' => 'Madagascar',
    'Malawi' => 'Malawi',
    'Malaysia' => 'Malaysia',
    'Maldives' => 'Maldives',
    'Mali' => 'Mali',
    'Malta' => 'Malta',
    'Marshall Islands' => 'Marshall Islands',
    'Mauritania' => 'Mauritania',
    'Mauritius' => 'Mauritius',
    'Mexico' => 'Mexico',
    'Micronesia' => 'Micronesia',
    'Moldova' => 'Moldova',
    'Monaco' => 'Monaco',
    'Mongolia' => 'Mongolia',
    'Montenegro' => 'Montenegro',
    'Morocco' => 'Morocco',
    'Mozambique' => 'Mozambique',
    'Myanmar' => 'Myanmar',
    'Namibia' => 'Namibia',
    'Nauru' => 'Nauru',
    'Nepal' => 'Nepal',
    'Netherlands' => 'Netherlands',
    'New Zealand' => 'New Zealand',
    'Nicaragua' => 'Nicaragua',
    'Niger' => 'Niger',
    'Nigeria' => 'Nigeria',
    'North Korea' => 'North Korea',
    'North Macedonia' => 'North Macedonia',
    'Norway' => 'Norway',
    'Oman' => 'Oman',
    'Pakistan' => 'Pakistan',
    'Palau' => 'Palau',
    'Panama' => 'Panama',
    'Papua New Guinea' => 'Papua New Guinea',
    'Paraguay' => 'Paraguay',
    'Peru' => 'Peru',
    'Philippines' => 'Philippines',
    'Poland' => 'Poland',
    'Portugal' => 'Portugal',
    'Qatar' => 'Qatar',
    'Romania' => 'Romania',
    'Russia' => 'Russia',
    'Rwanda' => 'Rwanda',
    'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
    'Saint Lucia' => 'Saint Lucia',
    'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
    'Samoa' => 'Samoa',
    'San Marino' => 'San Marino',
    'Sao Tome and Principe' => 'Sao Tome and Principe',
    'Saudi Arabia' => 'Saudi Arabia',
    'Senegal' => 'Senegal',
    'Serbia' => 'Serbia',
    'Seychelles' => 'Seychelles',
    'Sierra Leone' => 'Sierra Leone',
    'Singapore' => 'Singapore',
    'Slovakia' => 'Slovakia',
    'Slovenia' => 'Slovenia',
    'Solomon Islands' => 'Solomon Islands',
    'Somalia' => 'Somalia',
    'South Africa' => 'South Africa',
    'South Korea' => 'South Korea',
    'South Sudan' => 'South Sudan',
    'Spain' => 'Spain',
    'Sri Lanka' => 'Sri Lanka',
    'Sudan' => 'Sudan',
    'Suriname' => 'Suriname',
    'Sweden' => 'Sweden',
    'Switzerland' => 'Switzerland',
    'Syria' => 'Syria',
    'Taiwan' => 'Taiwan',
    'Tajikistan' => 'Tajikistan',
    'Tanzania' => 'Tanzania',
    'Thailand' => 'Thailand',
    'Timor-Leste' => 'Timor-Leste',
    'Togo' => 'Togo',
    'Tonga' => 'Tonga',
    'Trinidad and Tobago' => 'Trinidad and Tobago',
    'Tunisia' => 'Tunisia',
    'Turkey' => 'Turkey',
    'Turkmenistan' => 'Turkmenistan',
    'Tuvalu' => 'Tuvalu',
    'Uganda' => 'Uganda',
    'Ukraine' => 'Ukraine',
    'United Arab Emirates' => 'United Arab Emirates',
    'United Kingdom' => 'United Kingdom',
    'United States' => 'United States',
    'Uruguay' => 'Uruguay',
    'Uzbekistan' => 'Uzbekistan',
    'Vanuatu' => 'Vanuatu',
    'Vatican City' => 'Vatican City',
    'Venezuela' => 'Venezuela',
    'Vietnam' => 'Vietnam',
    'Yemen' => 'Yemen',
    'Zambia' => 'Zambia',
    'Zimbabwe' => 'Zimbabwe',
);

$month_options = array(
    ''   => __( 'Month', 'newstoday' ),
    '01' => __( 'January', 'newstoday' ),
    '02' => __( 'February', 'newstoday' ),
    '03' => __( 'March', 'newstoday' ),
    '04' => __( 'April', 'newstoday' ),
    '05' => __( 'May', 'newstoday' ),
    '06' => __( 'June', 'newstoday' ),
    '07' => __( 'July', 'newstoday' ),
    '08' => __( 'August', 'newstoday' ),
    '09' => __( 'September', 'newstoday' ),
    '10' => __( 'October', 'newstoday' ),
    '11' => __( 'November', 'newstoday' ),
    '12' => __( 'December', 'newstoday' ),
);

$selected_month   = isset( $_GET['month'] ) ? sanitize_text_field( wp_unslash( $_GET['month'] ) ) : '';
$selected_country = isset( $_GET['country'] ) ? sanitize_text_field( wp_unslash( $_GET['country'] ) ) : '';
?>

<main id="primary" class="site-main events-template">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads'); ?>
        <!-- Category Header -->
        <div class="category-header">
            <div class="category-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.6016 4.7373H5.60156L13.1805 35.1373L21.6016 4.7373Z" fill="#FC0303"/>
                    <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                    </svg>
                </div>
                <h1 class="category-title">Events Calendar</h1>
            </div>
            <!-- <div class="category-sponsor">
                <span class="sponsor-label">SPONSORED BY</span>
                <div class="sponsor-logo">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/iG-News-Today-red-logo.svg' ); ?>" alt="iGaming News Today" />
                </div>
            </div> -->
        </div>
        <div class="events-filters">
            <form class="events-filters__form" method="get" action="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Filter events', 'newstoday' ); ?>">
                <div class="events-filters__field events-filters__field--month">
                    <label class="screen-reader-text" for="events-month"><?php esc_html_e( 'Filter by month', 'newstoday' ); ?></label>
                    <select id="events-month" name="month">
                        <?php foreach ( $month_options as $value => $label ) : ?>
                            <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_month, $value ); ?>><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="events-filters__field events-filters__field--country">
                    <label class="screen-reader-text" for="events-country"><?php esc_html_e( 'Filter by country', 'newstoday' ); ?></label>
                    <select id="events-country" name="country">
                        <option value=""><?php esc_html_e( 'All Countries', 'newstoday' ); ?></option>
                        <?php foreach ( $contriesArray as $value => $label ) : ?>
                            <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_country, $value ); ?>><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="events-filters__submit"><?php esc_html_e( 'Search', 'newstoday' ); ?></button>
            </form>
        </div>
        <div class="events-layout">
            <div class="events-content">
                <?php get_template_part('template-parts/events/events-list'); ?>
            </div>
            <div class="events-sidebar">
                <?php get_template_part('template-parts/ads/sidebar-big-small-ad'); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>