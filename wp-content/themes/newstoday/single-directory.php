<?php
/**
 * Template Name: Single Directory
 * 
 * Custom template for displaying single directory posts.
 *
 * @package NewsToday
 */

get_header();
$current_post_id = get_the_ID();
$global_blogs_settings_page_id = 10969;

$company_logo = get_field('company_logo');
$company_link = get_field('company_link');
$company_description = get_field('company_description');
$company_tag = get_field('company_tag');
$company_type = get_field('company_type');
$company_email = get_field('company_email');
$company_phone = get_field('company_phone');
$company_address = get_field('company_address');

$tags = get_the_tags();

?>

<main id="primary" class="site-main">
    <div class="container">
        <?php get_template_part('template-parts/ads/header-ads', null, array('page_id' => $global_blogs_settings_page_id)) ?>
        <div class="single-directory-body">
            <div class="single-directory-content">
                <div class="directory-section">
                    <div class="directory-section-left">
                        <div class="directory-logo">
                            <?php if ( ! empty( $company_logo ) && is_array( $company_logo ) && ! empty( $company_logo['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $company_logo['url'] ); ?>" alt="<?php echo esc_attr( $company_logo['alt'] ? $company_logo['alt'] : $company_name ); ?>" loading="lazy" />
                            <?php else : ?>
                                <div class="directory-logo--placeholder"><?php echo the_title(); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="directory-section-right">
                        <h1 class="directory-title"><?php echo the_title(); ?></h1>
                        <span class="directory-company-type"><?php echo $company_type; ?></span>
                        <a class="directory-website-link" href="<?php echo $company_link; ?>">
                            <span>Visit Website</span>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_103_4223)">
                                <path d="M16.5913 0H10.2707C9.83433 0 9.48058 0.353745 9.48058 0.790086C9.48058 1.22643 9.83433 1.58017 10.2707 1.58017H14.6839L6.55173 9.71236C6.24317 10.0209 6.24317 10.5211 6.55173 10.8297C6.70596 10.9839 6.90816 11.0611 7.11036 11.0611C7.31255 11.0611 7.51479 10.984 7.66905 10.8296L15.8012 2.69749V7.11071C15.8012 7.54705 16.155 7.90079 16.5913 7.90079C17.0277 7.90079 17.3814 7.54705 17.3814 7.11071V0.790086C17.3814 0.353745 17.0276 0 16.5913 0Z" fill="#3C57BC"/>
                                <path d="M13.4313 7.90061C12.995 7.90061 12.6412 8.25435 12.6412 8.69069V15.8014H1.58014V4.74029H8.69085C9.12719 4.74029 9.48093 4.38655 9.48093 3.95021C9.48093 3.51387 9.12719 3.16016 8.69085 3.16016H0.790086C0.353745 3.16016 0 3.5139 0 3.95024V16.5915C0 17.0278 0.353745 17.3815 0.790086 17.3815H13.4313C13.8677 17.3815 14.2214 17.0278 14.2214 16.5915V8.69069C14.2214 8.25435 13.8676 7.90061 13.4313 7.90061Z" fill="#3C57BC"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_103_4223">
                                <rect width="17.3817" height="17.3817" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="directory-section">
                    <div class="directory-section-left">
                        <div class="directory-section-title">Company details</div>
                    </div>
                    <div class="directory-section-right">
                        <div class="directory-tags">
                            <?php foreach ($tags as $tag) : ?>
                                <span class="directory-tag"><?php echo $tag->name; ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php if ( $company_description ) : ?>
                            <div class="directory-description"><?php echo $company_description; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="directory-section">
                    <div class="directory-section-left">
                        <div class="directory-section-title">Contact info</div>
                    </div>
                    <div class="directory-section-right">
                        <div class="directory-contact-details">
                            <?php if ( $company_address ) : ?>
                                <div class="directory-contact-detail">
                                    <span class="directory-contact-detail-label">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.2687 29.6086C14.4317 29.8531 14.7062 30 15 30C15.2938 30 15.5683 29.8532 15.7313 29.6086C17.8113 26.4887 20.875 22.6355 23.0099 18.7167C24.717 15.5833 25.5469 12.9109 25.5469 10.5469C25.5469 4.73133 20.8155 0 15 0C9.18445 0 4.45312 4.73133 4.45312 10.5469C4.45312 12.9109 5.28299 15.5833 6.99006 18.7167C9.1234 22.6325 12.1929 26.4951 14.2687 29.6086ZM15 1.75781C19.8463 1.75781 23.7891 5.70059 23.7891 10.5469C23.7891 12.6096 23.0293 15.0069 21.4663 17.8757C19.6261 21.2536 17 24.6801 15 27.5607C13.0003 24.6805 10.374 21.2538 8.53365 17.8757C6.97072 15.0069 6.21094 12.6096 6.21094 10.5469C6.21094 5.70059 10.1537 1.75781 15 1.75781Z" fill="black"/>
                                        <path d="M15 15.8203C17.9078 15.8203 20.2734 13.4546 20.2734 10.5469C20.2734 7.6391 17.9078 5.27344 15 5.27344C12.0922 5.27344 9.72656 7.6391 9.72656 10.5469C9.72656 13.4546 12.0922 15.8203 15 15.8203ZM15 7.03125C16.9385 7.03125 18.5156 8.60836 18.5156 10.5469C18.5156 12.4854 16.9385 14.0625 15 14.0625C13.0615 14.0625 11.4844 12.4854 11.4844 10.5469C11.4844 8.60836 13.0615 7.03125 15 7.03125Z" fill="black"/>
                                        </svg>
                                    </span>
                                    <span class="directory-contact-detail-value"><?php echo $company_address; ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $company_phone ) : ?>
                                <div class="directory-contact-detail">
                                    <span class="directory-contact-detail-label">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.2146 16.8326C20.2012 17.8473 18.6181 19.4321 17.2925 20.7669C15.7169 19.7355 14.2926 18.5974 13.1473 17.452C11.733 16.0377 9.96431 14.0239 9.0085 12.5974C10.222 11.3925 11.809 9.80763 12.9735 8.64418L5.97772 1.64844L2.48716 5.07617L2.48201 5.08132C1.50519 6.05814 1.09156 7.39153 1.25264 9.04443C1.76783 14.3298 8.23108 21.9856 13.9445 25.8199C17.2524 28.0399 22.0069 30.0949 24.8191 27.2825C26.8609 25.2409 27.6414 24.4091 27.6738 24.3747L28.1974 23.8156L21.2146 16.8326ZM23.6998 26.1631C21.5708 28.2918 17.3488 26.1979 14.8266 24.5053C9.52472 20.9469 3.29322 13.6593 2.82829 8.89075C2.7154 7.73348 2.97475 6.82917 3.59891 6.20336L5.96763 3.87729L10.7337 8.64356C8.31657 11.057 7.58839 11.7763 7.00934 12.3496L7.31647 12.879C8.24921 14.4857 10.4126 16.9562 12.028 18.5716C13.7999 20.3436 15.6188 21.5946 17.5208 22.785L17.9663 22.3353C18.944 21.3488 20.3647 19.9244 21.2153 19.0724L25.9879 23.8451C25.5459 24.3013 24.8074 25.0553 23.6998 26.1631Z" fill="black"/>
                                        </svg>
                                    </span>
                                    <span class="directory-contact-detail-value"><?php echo $company_phone; ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ( $company_email ) : ?>
                                <div class="directory-contact-detail">
                                    <span class="directory-contact-detail-label">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 3.63281V26.3672H30V3.63281H0ZM15 16.7173L3.0798 5.39062H26.9202L15 16.7173ZM10.2102 14.5907L1.75781 23.3176V6.55928L10.2102 14.5907ZM11.4845 15.8016L15 19.1421L18.5155 15.8016L27.0463 24.6094H2.95371L11.4845 15.8016ZM19.7899 14.5907L28.2422 6.55928V23.3176L19.7899 14.5907Z" fill="black"/>
                                        </svg>
                                    </span>
                                    <span class="directory-contact-detail-value"><?php echo $company_email; ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $company_link ) : ?>
                                <div class="directory-contact-detail">
                                    <span class="directory-contact-detail-label">
                                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_105_4660)">
                                        <path d="M25.6066 4.39343C22.7735 1.56024 19.0067 0 15 0C10.9934 0 7.2265 1.56024 4.39343 4.39337C1.56024 7.2265 0 10.9934 0 15C0 19.0067 1.56024 22.7735 4.39343 25.6066C7.2265 28.4398 10.9934 30 15 30C19.0067 30 22.7735 28.4398 25.6067 25.6066C28.4398 22.7735 30.0001 19.0066 30.0001 15C30.0001 10.9933 28.4398 7.2265 25.6066 4.39343ZM5.63767 5.63767C6.95667 4.31866 8.50513 3.3126 10.1929 2.65594C9.74334 3.21715 9.32269 3.86221 8.93721 4.58772C8.48949 5.4303 8.10318 6.35568 7.78144 7.3441C6.66687 7.15912 5.63415 6.93165 4.71153 6.6647C5.00069 6.30927 5.30919 5.96614 5.63767 5.63767ZM3.64624 8.17883C4.72536 8.52435 5.95947 8.81574 7.30607 9.04654C6.93107 10.6383 6.71035 12.3512 6.65767 14.1202H1.78922C1.9275 11.9972 2.56512 9.97104 3.64624 8.17883ZM3.55044 21.6585C2.52768 19.9066 1.92334 17.9389 1.78916 15.8798H6.66101C6.71855 17.5983 6.93488 19.2625 7.29722 20.8126C5.92296 21.0354 4.65786 21.3194 3.55044 21.6585ZM5.63767 24.3624C5.26384 23.9885 4.91567 23.5959 4.59288 23.1873C5.54931 22.9221 6.61853 22.6975 7.76949 22.5174C8.09351 23.5195 8.48398 24.4571 8.93715 25.3101C9.35726 26.1007 9.81916 26.7954 10.3147 27.3905C8.57972 26.7352 6.98837 25.713 5.63767 24.3624ZM14.1202 28.0146C12.7838 27.6402 11.5196 26.4199 10.4911 24.4844C10.1314 23.8075 9.81547 23.069 9.54482 22.282C10.9938 22.1225 12.5357 22.0282 14.1202 22.0061V28.0146ZM14.1202 20.2463C12.3631 20.2703 10.6504 20.3806 9.04654 20.569C8.69275 19.1065 8.47988 17.5234 8.42146 15.8799H14.1202V20.2463H14.1202ZM14.1202 14.1202H8.41812C8.4715 12.4307 8.68777 10.8035 9.05258 9.30371C10.6462 9.50293 12.3553 9.6241 14.1202 9.65879V14.1202ZM14.1202 7.89892C12.5296 7.86687 10.9911 7.76316 9.55232 7.59394C9.82133 6.81511 10.1348 6.08409 10.4911 5.41337C11.5195 3.4779 12.7838 2.2575 14.1202 1.88315V7.89892ZM26.4093 8.27228C27.4566 10.0414 28.0749 12.0339 28.211 14.1202H23.3425C23.2904 12.3715 23.0739 10.6779 22.7068 9.1018C24.0622 8.88289 25.3116 8.60439 26.4093 8.27228ZM24.3623 5.63767C24.7156 5.99093 25.0456 6.36124 25.3534 6.74568C24.4116 7.00285 23.3628 7.22111 22.236 7.39677C21.9109 6.38849 21.5186 5.4453 21.0629 4.58772C20.6774 3.86221 20.2568 3.21715 19.8072 2.65594C21.4949 3.3126 23.0434 4.31866 24.3623 5.63767ZM15.8799 15.8799H21.5787C21.5198 17.5362 21.3041 19.1312 20.9453 20.6032C19.3519 20.4051 17.6436 20.2851 15.8799 20.2513V15.8799ZM15.8799 14.1202V9.66465C17.638 9.64156 19.352 9.53217 20.9574 9.34449C21.3163 10.833 21.529 12.446 21.5819 14.1202H15.8799ZM15.8798 1.88315H15.8798C17.2162 2.2575 18.4804 3.4779 19.5089 5.41337C19.8709 6.09464 20.1886 6.83826 20.4605 7.63103C19.0095 7.78994 17.4658 7.88351 15.8798 7.9049V1.88315ZM15.8799 28.0146V22.0112C17.4689 22.0424 19.0063 22.1451 20.4445 22.3133C20.1762 23.0886 19.8638 23.8165 19.5089 24.4844C18.4805 26.4199 17.2163 27.6402 15.8799 28.0146ZM24.3623 24.3624C23.0117 25.713 21.4203 26.7352 19.6853 27.3904C20.1808 26.7953 20.6427 26.1007 21.0629 25.3101C21.5093 24.4698 21.8948 23.5471 22.216 22.5617C23.3565 22.7499 24.4117 22.9827 25.3516 23.2565C25.0444 23.6401 24.715 24.0097 24.3623 24.3624ZM26.4027 21.7389C25.3109 21.3878 24.059 21.0924 22.6922 20.8594C23.0611 19.2961 23.281 17.6156 23.3392 15.8799H28.211C28.0746 17.9704 27.4541 19.967 26.4027 21.7389Z" fill="black"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_105_4660">
                                        <rect width="30" height="30" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg>
                                    </span>
                                    <span class="directory-contact-detail-value"><?php echo $company_link; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="directory-section">
                <div class="directory-section-left">
                        <div class="directory-section-title">Product/Services</div>
                    </div>
                    <div class="directory-section-right">
                        <div class="directory-sevices-list">
                            <?php echo the_content() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-directory-sidebar">
                <?php get_template_part('template-parts/ads/sidebar-big-small-ad', null, array('page_id' => $global_blogs_settings_page_id)) ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>