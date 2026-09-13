<?php
/**
 * Template part for displaying Navigation Box (Categories)
 *
 * @package NewsToday
 */

// Get all categories
$categories = get_categories( array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => false,
) );
?>

<div class="sidebar-navigation-box">
    <div class="sidebar-navigation-header">
        <div class="navigation-icon">
        <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.7667 3.44043H2.98242L8.09076 23.9305L13.7667 3.44043Z" fill="#FC0303"/>
        <path d="M22.3954 23.9312H12.1504L17.0033 3.44104L22.3954 23.9312Z" fill="white"/>
        </svg>
        </div>
        <h3 class="navigation-title"><?php esc_html_e( 'Categories', 'newstoday' ); ?></h3>
    </div>
    
    <?php if ( ! empty( $categories ) ) : ?>
        <ul class="navigation-list">
            <?php foreach ( $categories as $category ) : ?>
                <li class="navigation-item">
                    <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                        <span class="item-arrow">
                            <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.5 1L6.5 6L1.5 11" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="item-text"><?php echo esc_html( $category->name ); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

