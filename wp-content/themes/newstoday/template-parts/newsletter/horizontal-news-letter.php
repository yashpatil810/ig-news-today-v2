<?php
/**
 * Template part for displaying Horizontal Newsletter
 *
 * @package NewsToday
 */
?>

<div class="horizontal-newsletter-section">
    <div class="newsletter-container">
        <div class="newsletter-content">
            <h2>Newsletter Sign Up</h2>
            <p>Keep Up to Date with the most important news</p>
        </div>

        <div class="divider"></div>

        <form id="horizontal-newsletter-form" class="newsletter-form" method="post">
            <div class="form-row">
                <input 
                    type="email" 
                    name="EMAIL"
                    class="email-input" 
                    placeholder="Your email address"
                    required
                >
                <button type="submit" class="subscribe-btn">Subscribe</button>
            </div>

            <div class="checkbox-wrapper">
                <input type="checkbox" id="terms" name="terms" required>
                <!-- fetch terms and conditions, privacy policy page urls -->
                <?php
                    $terms_and_conditions_url = get_permalink( get_page_by_path( 'terms-and-conditions' ) );
                    $privacy_policy_url = get_permalink( get_page_by_path( 'privacy-policy' ) );
                ?>
                <label for="terms">
                    By pressing the Subscribe button, you confirm that you have read and are agreeing to our 
                    <a href="<?php echo esc_url( $privacy_policy_url ); ?>">Privacy Policy</a> and <a href="<?php echo esc_url( $terms_and_conditions_url ); ?>">Terms & Conditions</a>
                </label>
            </div>

            <div class="mc4wp-response"></div>
            <?php if ( function_exists( 'mc4wp_get_form' ) ) : ?>
                <input type="hidden" name="_mc4wp_form_id" value="11098">
                <input type="hidden" name="_mc4wp_form_submit" value="1">
                <input type="hidden" name="_mc4wp_timestamp" value="<?php echo esc_attr( time() ); ?>">
                <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;">
            <?php endif; ?>
        </form>
    </div>
</div>