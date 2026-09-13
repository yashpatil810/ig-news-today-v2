<?php
/**
 * Template part for displaying Author Bio Box at the bottom of single posts
 *
 * @package NewsToday
 */

$author_id = get_the_author_meta( 'ID' );

if ( ! $author_id ) {
    return;
}

$author_name = get_the_author_meta( 'display_name', $author_id );

// Job title
$author_job_title = (string) get_user_meta( $author_id, 'author_job_title', true );
if ( empty( $author_job_title ) && function_exists( 'get_field' ) ) {
    $author_job_title = (string) get_field( 'author_job_title', 'user_' . $author_id );
}
if ( empty( $author_job_title ) ) {
    $author_job_title = __( 'iGaming Journalist', 'newstoday' );
}

// Author bio content
$author_bio = '';
if ( function_exists( 'get_field' ) ) {
    $author_bio = (string) get_field( 'author_content', 'user_' . $author_id );
}
if ( empty( $author_bio ) ) {
    $author_bio = (string) get_the_author_meta( 'description', $author_id );
}

// Social links
$author_linkedin = (string) get_user_meta( $author_id, 'author_linkedin', true );
if ( empty( $author_linkedin ) && function_exists( 'get_field' ) ) {
    $author_linkedin = (string) get_field( 'author_linkedin', 'user_' . $author_id );
}

$author_twitter = (string) get_user_meta( $author_id, 'author_twitter', true );
if ( empty( $author_twitter ) && function_exists( 'get_field' ) ) {
    $author_twitter = (string) get_field( 'author_twitter', 'user_' . $author_id );
}

$author_email = get_the_author_meta( 'user_email', $author_id );
$author_posts_url = get_author_posts_url( $author_id );
?>

<div class="single-author-card">
    <div class="author-card-left">
        <a href="<?php echo esc_url( $author_posts_url ); ?>" class="author-avatar-link">
            <div class="author-avatar-gradient">
                <div class="avatar-inner">
                    <?php echo get_avatar( $author_id, 150, '', esc_attr( $author_name ) ); ?>
                </div>
            </div>
        </a>
    </div>
    <div class="author-card-right">
        <div class="author-card-header">
            <h3 class="author-card-name">
                <a href="<?php echo esc_url( $author_posts_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
            </h3>
            <?php if ( ! empty( $author_email ) || ! empty( $author_linkedin ) || ! empty( $author_twitter ) ) : ?>
                <div class="author-social-actions">
                    <?php if ( ! empty( $author_email ) ) : ?>
                        <a href="mailto:<?php echo esc_attr( $author_email ); ?>" class="social-circle-btn" aria-label="<?php esc_attr_e( 'Email Author', 'newstoday' ); ?>">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#000000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 6L12 13L2 6" stroke="#000000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $author_linkedin ) ) : ?>
                        <a href="<?php echo esc_url( $author_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="social-circle-btn" aria-label="<?php echo esc_attr( $author_name ); ?> on LinkedIn">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z" stroke="#000000" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="4" cy="4" r="2" fill="#000000"/>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $author_twitter ) ) : ?>
                        <a href="<?php echo esc_url( $author_twitter ); ?>" target="_blank" rel="noopener noreferrer" class="social-circle-btn" aria-label="<?php echo esc_attr( $author_name ); ?> on X / Twitter">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" fill="#000000"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="author-card-position">
            <?php echo esc_html( $author_job_title ); ?>
        </div>

        <?php if ( ! empty( $author_bio ) ) : ?>
            <div class="author-card-bio">
                <p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $author_bio ), 25, '...' ) ); ?></p>
            </div>
        <?php endif; ?>

        <div class="author-card-action">
            <a href="<?php echo esc_url( $author_posts_url ); ?>" class="view-profile-btn">
                <?php esc_html_e( 'View Author Profile', 'newstoday' ); ?>
            </a>
        </div>
    </div>
</div>
