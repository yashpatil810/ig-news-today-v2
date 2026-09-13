<?php
/**
 * Template part for displaying Subscribe Form
 *
 * @package NewsToday
 */
?>

<div class="sidebar-subscribe-form">
    <div class="subscribe-icon">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="24" cy="24" r="24" fill="#000000"/>
            <path d="M14 18C14 16.8954 14.8954 16 16 16H32C33.1046 16 34 16.8954 34 18V30C34 31.1046 33.1046 32 32 32H16C14.8954 32 14 31.1046 14 30V18Z" stroke="#FFFFFF" stroke-width="2"/>
            <path d="M14 18L24 25L34 18" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    
    <?php
    $sub_title    = get_theme_mod( 'newstoday_subscribe_title', __( 'Subscribe', 'newstoday' ) );
    $sub_subtitle = get_theme_mod( 'newstoday_subscribe_subtitle', __( 'Keep Up to Date with the most important news', 'newstoday' ) );
    $sub_btn_text = get_theme_mod( 'newstoday_subscribe_btn_text', __( 'Subscribe', 'newstoday' ) );
    ?>
    
    <h3 class="subscribe-title"><?php echo esc_html( $sub_title ); ?></h3>
    
    <div class="subscribe-divider"></div>
    
    <p class="subscribe-subtitle"><?php echo esc_html( $sub_subtitle ); ?></p>
    
    <form id="newsletter-form-sidebar" class="subscribe-form newsletter-form" action="#" method="post">
        <div class="form-field">
            <input type="email" name="EMAIL" placeholder="<?php esc_attr_e( 'Your email address', 'newstoday' ); ?>" required />
        </div>
        
        <button type="submit" class="subscribe-btn">
            <?php echo esc_html( $sub_btn_text ); ?>
        </button>
        
        <div class="form-checkbox">
            <label class="checkbox-label">
                <input type="checkbox" name="agree_terms" required />
                <span class="checkbox-text">
                    <?php
                    printf(
                        esc_html__( 'By pressing the Subscribe button, our %1$s and %2$s', 'newstoday' ),
                        '<a href="#">' . esc_html__( 'Privacy Policy', 'newstoday' ) . '</a>',
                        '<a href="#">' . esc_html__( 'Terms & Conditions', 'newstoday' ) . '</a>'
                    );
                    ?>
                </span>
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

