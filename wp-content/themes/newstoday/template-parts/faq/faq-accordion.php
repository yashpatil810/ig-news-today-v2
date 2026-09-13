<?php
/**
 * Template part for displaying FAQ Accordion
 *
 * Usage:
 *   // Pass FAQ items directly:
 *   get_template_part( 'template-parts/faq/faq-accordion', null, array( 
 *       'faq_items' => array(
 *           array( 'question' => 'Question 1?', 'answer' => 'Answer 1.' ),
 *           array( 'question' => 'Question 2?', 'answer' => 'Answer 2.' ),
 *       )
 *   ) );
 *
 *   // Or use ACF field (if 'faq_items' field exists):
 *   get_template_part( 'template-parts/faq/faq-accordion', null, array( 
 *       'page_id' => get_the_ID()
 *   ) );
 *
 * @package NewsToday
 */

// Get FAQ items from args if passed, otherwise try ACF field
$page_id = isset( $args['page_id'] ) ? $args['page_id'] : get_the_ID();
$faq_items = isset( $args['faq_items'] ) ? $args['faq_items'] : null;

// If no FAQ items passed, try to get from ACF field
if ( empty( $faq_items ) && function_exists( 'get_field' ) ) {
    $faq_items = get_field( 'faq_items', $page_id );
}

// If still no FAQ items, use empty array (no default items - user must provide)
if ( empty( $faq_items ) ) {
    $faq_items = array();
}

/**
 * Convert email addresses in text to clickable mailto links
 *
 * @param string $text The text containing email addresses
 * @return string Text with email addresses converted to mailto links
 */
function convert_emails_to_links( $text ) {
    // Pattern to match email addresses
    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/';
    
    // Replace email addresses with mailto links
    $text = preg_replace_callback( $pattern, function( $matches ) {
        $email = esc_attr( $matches[0] );
        return '<a href="mailto:' . $email . '" class="faq-email-link">' . esc_html( $matches[0] ) . '</a>';
    }, $text );
    
    return $text;
}
?>

<div class="faq-accordion">
    <?php if ( ! empty( $faq_items ) && is_array( $faq_items ) ) : ?>
        <?php foreach ( $faq_items as $index => $faq_item ) : ?>
            <?php
            $question = isset( $faq_item['question'] ) ? $faq_item['question'] : ( isset( $faq_item['faq_question'] ) ? $faq_item['faq_question'] : '' );
            $answer   = isset( $faq_item['answer'] ) ? $faq_item['answer'] : ( isset( $faq_item['faq_answer'] ) ? $faq_item['faq_answer'] : '' );
            
            if ( empty( $question ) || empty( $answer ) ) {
                continue;
            }
            ?>
            <div class="faq-item">
                <button class="faq-question" type="button" aria-expanded="false">
                    <span class="faq-question-text"><?php echo esc_html( $question ); ?></span>
                    <span class="faq-arrow">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/src/images/down-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'Toggle', 'newstoday' ); ?>" class="faq-arrow-icon" />
                    </span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <?php 
                        // Convert email addresses to clickable links
                        $answer_with_links = convert_emails_to_links( $answer );
                        echo wp_kses_post( wpautop( $answer_with_links ) ); 
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

