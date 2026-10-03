<?php
/**
 * Template Name: Frequently Asked Questions
 * Description: FAQ page template
 *
 * @package NewsToday
 */

get_header();
$faq_page_id = get_the_ID();
?>

<main id="primary" class="site-main faq-page">
    <div class="container">
        <!-- Section 1: Ad Section (3 ad cards) -->
        <div class="faq-ads-section">
            <?php get_template_part( 'template-parts/ads/header-ads', null, array( 'page_id' => $faq_page_id ) ); ?>
        </div>

        <!-- Section 2: Title with Icon -->
        <div class="faq-header">
            <div class="section-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.5996 4.73633H5.59961L13.1786 35.1363L21.5996 4.73633Z" fill="#FC0303"/>
                        <path d="M34.3973 35.1357H19.1973L26.3973 4.73574L34.3973 35.1357Z" fill="black"/>
                    </svg>
                </div>
                <h1 class="faq-title"><?php esc_html_e( 'Frequently Asked Questions', 'newstoday' ); ?></h1>
            </div>
        </div>

        <!-- Section 3: Content (Small paragraphs) -->
        <div class="faq-content">
            <div class="faq-intro">
                <!-- add content from wordpress editor -->
                <?php 
                $content = get_the_content();
                echo wp_kses_post( wpautop( $content ) ); 
                ?>
            </div>
        </div>

        <!-- Section 4: Frequently Asked Questions and Answers -->
        <div class="faq-questions-section">
            <?php
            // Fetch FAQ items dynamically from ACF (1 to 20 fields) or Repeater field or default array
            $faq_items = array();

            // 1. Try to get ACF 1-20 individual Q&A fields
            for ( $i = 1; $i <= 20; $i++ ) {
                $q = function_exists( 'get_field' ) ? get_field( 'faq_q' . $i, $faq_page_id ) : '';
                $a = function_exists( 'get_field' ) ? get_field( 'faq_a' . $i, $faq_page_id ) : '';
                if ( ! empty( $q ) && ! empty( $a ) ) {
                    $faq_items[] = array(
                        'question' => $q,
                        'answer'   => $a,
                    );
                }
            }

            // 2. If empty, try to get ACF repeater field 'faq_items'
            if ( empty( $faq_items ) && function_exists( 'get_field' ) ) {
                $repeater_items = get_field( 'faq_items', $faq_page_id );
                if ( ! empty( $repeater_items ) && is_array( $repeater_items ) ) {
                    $faq_items = $repeater_items;
                }
            }

            // 3. Fallback to default 6 items if no ACF fields are filled yet
            if ( empty( $faq_items ) ) {
                $faq_items = array(
                    array(
                        'question' => 'What is iGamingNewsToday?',
                        'answer'   => 'iGamingNewsToday is a leading news platform covering the iGaming industry. We provide the latest news, insights, and analysis on online gaming, sports betting, casino games, and regulatory developments.'
                    ),
                    array(
                        'question' => 'Is your content original or sourced from other platforms?',
                        'answer'   => 'Our team produces original editorial content, breaking stories, and expert analysis. We also monitor industry sources to bring you the most accurate summaries when relevant.'
                    ),
                    array(
                        'question' => 'Who is your audience?',
                        'answer'   => 'Our readers include operators, suppliers, affiliates, marketers, investors, regulators, and anyone looking to stay informed about trends, deals, and developments in iGaming.'
                    ),
                    array(
                        'question' => 'Can I submit a press release?',
                        'answer'   => 'Yes. You can send your press releases to Press@wheat-bear-950363.hostingersite.com. Please include all relevant media assets and contact details.'
                    ),
                    array(
                        'question' => 'Do you accept guest posts or contributed articles?',
                        'answer'   => 'We consider expert submissions from thought leaders and professionals within the iGaming ecosystem. Email your pitch to Marketing@wheat-bear-950363.hostingersite.com.'
                    ),
                    array(
                        'question' => 'How frequently is your content updated?',
                        'answer'   => 'We publish multiple news stories and features each day to ensure our readers never miss a key development.'
                    ),
                );
            }

            // Pass FAQ items to the accordion component
            get_template_part( 'template-parts/faq/faq-accordion', null, array( 
                'page_id'   => $faq_page_id,
                'faq_items' => $faq_items
            ) );
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

