<?php
/**
 * Template Name: Author
 * Description: Author page template
 *
 * @package NewsToday
 */

get_header();

$user_id = get_queried_object_id();
?>

<main id="primary" class="site-main author-template">
    <div class="container">
        <?php
        $global_blogs_settings_page_id = 10969;
        get_template_part('template-parts/ads/header-ads', null, array('page_id' => $global_blogs_settings_page_id));
        ?>

        <div class="author-header">
            <div class="author-left-content">
                <div class="author-avatar">
                    <div class="avatar-inner">
                        <?php echo get_avatar($user_id, 150); ?>
                    </div>
                </div>
            </div>
            <div class="author-right-content">
                <div class="author-name">
                    <h1><?php echo get_the_author_meta('display_name', $user_id); ?></h1>
                    <?php
                        $author_job_title = (string) get_user_meta( $user_id, 'author_job_title', true );
                        if ( empty( $author_job_title ) && function_exists( 'get_field' ) ) {
                            $author_job_title = (string) get_field( 'author_job_title', 'user_' . $user_id );
                        }
                        if ( empty( $author_job_title ) ) {
                            $author_job_title = __( 'iGaming Journalist', 'newstoday' );
                        }
                        $author_linkedin = (string) get_user_meta( $user_id, 'author_linkedin', true );
                        if ( empty( $author_linkedin ) && function_exists( 'get_field' ) ) {
                            $author_linkedin = (string) get_field( 'author_linkedin', 'user_' . $user_id );
                        }
                    ?>
                    <div class="author-position-wrapper">
                        <span class="author-position"><?php echo esc_html( $author_job_title ); ?></span>
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1237_6578)">
                            <path d="M15.7779 5.90766C15.5579 5.2265 15.6517 4.20401 15.0799 3.41452C14.5037 2.61881 13.5014 2.39264 12.9355 1.97873C12.3755 1.56919 11.8546 0.677981 10.9126 0.370612C9.99726 0.071903 9.06122 0.477247 8.33545 0.477247C7.60978 0.477247 6.6738 0.0718054 5.75827 0.370579C4.81649 0.677884 4.2951 1.56929 3.73549 1.97864C3.17017 2.39206 2.16718 2.61884 1.59103 3.41442C1.01976 4.20326 1.11259 5.22809 0.893 5.90763C0.684028 6.55438 0 7.33058 0 8.33578C0 9.34161 0.683246 10.1148 0.893 10.7639C1.11298 11.4451 1.0192 12.4676 1.59096 13.2571C2.16718 14.0528 3.16939 14.2789 3.73539 14.6929C4.29526 15.1023 4.81633 15.9936 5.75827 16.301C6.67302 16.5995 7.61053 16.1943 8.33545 16.1943C9.05936 16.1943 9.99905 16.599 10.9126 16.301C11.8544 15.9937 12.3755 15.1025 12.9354 14.6929C13.5007 14.2795 14.5037 14.0527 15.0799 13.2572C15.6512 12.4683 15.5583 11.4435 15.7779 10.7639C15.9869 10.1172 16.6709 9.34096 16.6709 8.33578C16.6709 7.33003 15.9878 6.55705 15.7779 5.90766ZM14.5386 10.3634C14.2822 11.1571 14.3494 12.0453 14.0251 12.4932C13.6964 12.9469 12.8329 13.1542 12.1667 13.6416C11.5077 14.1235 11.0458 14.8875 10.5086 15.0628C10.0004 15.2286 9.17222 14.8918 8.33548 14.8918C7.49262 14.8918 6.67295 15.2293 6.16231 15.0628C5.62519 14.8875 5.16397 14.124 4.50427 13.6416C3.84193 13.1572 2.97354 12.9456 2.64582 12.4931C2.32256 12.0468 2.38719 11.1524 2.13234 10.3635C1.88254 9.59053 1.30241 8.92125 1.30241 8.33578C1.30241 7.74973 1.88202 7.08276 2.13228 6.30812C2.38869 5.5145 2.32152 4.62622 2.64582 4.17841C2.97429 3.72491 3.83841 3.51695 4.50427 3.02998C5.16534 2.54649 5.62431 1.78435 6.16224 1.60882C6.67002 1.44315 7.50093 1.77973 8.33542 1.77973C9.1798 1.77973 9.99743 1.44201 10.5086 1.60882C11.0456 1.78406 11.5073 2.54779 12.1667 3.03001C12.8289 3.51441 13.6974 3.72596 14.0251 4.17845C14.3484 4.62488 14.2834 5.51834 14.5386 6.30806V6.30809C14.7884 7.08104 15.3685 7.75032 15.3685 8.33578C15.3685 8.92184 14.7889 9.5888 14.5386 10.3634ZM11.3357 6.24557C11.59 6.4999 11.59 6.91221 11.3357 7.16651L8.07617 10.426C7.82184 10.6803 7.4095 10.6803 7.1552 10.426L5.33527 8.60607C5.08094 8.35174 5.08091 7.93943 5.33524 7.68513C5.58957 7.43083 6.00195 7.4308 6.25618 7.68513L7.61567 9.04459L10.4147 6.24561C10.669 5.99128 11.0813 5.99128 11.3357 6.24557Z" fill="#4D8A52"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1237_6578">
                            <rect width="16.6709" height="16.6709" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <div class="author-social-links">
                        <?php if ( ! empty( $author_linkedin ) ) : ?>
                        <!-- author linkedin -->
                        <a href="<?php echo esc_url( $author_linkedin ); ?>" class="author-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( get_the_author_meta( 'display_name', $user_id ) ); ?> on LinkedIn">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.386125" y="0.386125" width="39.2277" height="39.2277" rx="19.6139" stroke="#3C57BC" stroke-width="0.77225"/>
                                <g clip-path="url(#clip0_linkedin_author)">
                                    <path d="M15.5 14C15.5 14.8284 14.8284 15.5 14 15.5C13.1716 15.5 12.5 14.8284 12.5 14C12.5 13.1716 13.1716 12.5 14 12.5C14.8284 12.5 15.5 13.1716 15.5 14Z" fill="#3C57BC"/>
                                    <path d="M12.5 17H15.5V27.5H12.5V17Z" fill="#3C57BC"/>
                                    <path d="M17.5 17H20.3V18.4C20.8 17.6 21.9 16.8 23.5 16.8C26.5 16.8 27.5 18.6 27.5 21.3V27.5H24.5V22C24.5 20.6 24 19.5 22.7 19.5C21.4 19.5 20.5 20.5 20.5 22V27.5H17.5V17Z" fill="#3C57BC"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_linkedin_author">
                                <rect width="17" height="17" fill="white" transform="translate(11.5 11.5)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <!-- author email -->
                        <a href="mailto:<?php echo get_the_author_meta('user_email', $user_id); ?>" class="author-social-link">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.386125" y="0.386125" width="39.2277" height="39.2277" rx="19.6139" stroke="#3C57BC" stroke-width="0.77225"/>
                                <g clip-path="url(#clip0_1236_6230)">
                                <path d="M26.5078 13.0938H13.4922C12.3937 13.0938 11.5 13.9874 11.5 15.0859V16.7293L18.811 22.1674C19.1666 22.4318 19.5833 22.5641 20 22.5641C20.4167 22.5641 20.8334 22.4319 21.189 22.1674L28.5 16.7293V15.0859C28.5 13.9874 27.6063 13.0938 26.5078 13.0938ZM27.1719 16.062L20.3963 21.1017C20.1593 21.278 19.8407 21.278 19.6037 21.1017L12.8281 16.062V15.0859C12.8281 14.7198 13.126 14.4219 13.4922 14.4219H26.5078C26.874 14.4219 27.1719 14.7198 27.1719 15.0859V16.062ZM27.1719 19.3724L28.5 18.3846V24.9141C28.5 26.0126 27.6063 26.9062 26.5078 26.9062H13.4922C12.3937 26.9062 11.5 26.0126 11.5 24.9141V18.3846L12.8281 19.3724V24.9141C12.8281 25.2802 13.126 25.5781 13.4922 25.5781H26.5078C26.874 25.5781 27.1719 25.2802 27.1719 24.9141V19.3724Z" fill="#3C57BC"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_1236_6230">
                                <rect width="17" height="17" fill="white" transform="translate(11.5 11.5)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-header">
            <div class="section-title-wrapper">
                <div class="icon-wrapper">
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27 5.91992H7L16.4737 43.9199L27 5.91992Z" fill="#FC0303"/>
                    <path d="M43 43.9199H24L33 5.91992L43 43.9199Z" fill="black"/>
                    </svg>
                </div>
                <h2 class="page-title">About Author</h2>
            </div>
        </div>

        <div class="author-content">
            <p><?php the_field('author_content', 'user_'.$user_id); ?></p>
        </div>

        <?php get_template_part('template-parts/content/author-latest-posts', null, array('author_id' => $user_id)); ?>
    </div>
</main>

<?php get_footer(); ?>