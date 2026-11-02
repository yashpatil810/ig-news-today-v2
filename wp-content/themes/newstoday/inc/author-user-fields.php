<?php
/**
 * Author User Fields
 *
 * Adds custom "Job Title", "LinkedIn URL", "Twitter/X URL", and a native
 * "Profile Photo / Avatar Upload" field to the WordPress Admin user profile
 * and edit-user pages.
 *
 * Automatically overrides WordPress get_avatar() with the uploaded custom image
 * across all theme templates (About Us, Author Page, Single Author Box, etc.).
 *
 * @package NewsToday
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---------------------------------------------------------------------------
// 1. Enqueue WordPress Media Uploader scripts on User Profile / Edit pages.
// ---------------------------------------------------------------------------
add_action( 'admin_enqueue_scripts', 'newstoday_author_fields_admin_scripts' );
function newstoday_author_fields_admin_scripts( $hook_suffix ) {
    if ( in_array( $hook_suffix, array( 'profile.php', 'user-edit.php' ), true ) ) {
        wp_enqueue_media();
    }
}

// ---------------------------------------------------------------------------
// 2. Display the fields on "Your Profile" (own profile) & "Edit User" pages.
// ---------------------------------------------------------------------------
add_action( 'show_user_profile', 'newstoday_author_extra_fields' );
add_action( 'edit_user_profile', 'newstoday_author_extra_fields' );

/**
 * Render the custom author fields section.
 *
 * @param WP_User $user  The user object being edited.
 */
function newstoday_author_extra_fields( WP_User $user ) {
    // Only show for admins or the user editing their own profile.
    if ( ! current_user_can( 'edit_user', $user->ID ) ) {
        return;
    }

    $avatar_id  = get_user_meta( $user->ID, 'author_custom_avatar', true );
    $avatar_url = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'thumbnail' ) : '';
    ?>
    <h2><?php esc_html_e( 'Author Profile & Photo Settings', 'newstoday' ); ?></h2>
    <table class="form-table" role="presentation">

        <!-- Custom Profile Photo -->
        <tr>
            <th>
                <label for="author_custom_avatar">
                    <?php esc_html_e( 'Profile Photo', 'newstoday' ); ?>
                </label>
            </th>
            <td>
                <div class="author-avatar-upload-box" style="display: flex; align-items: center; gap: 20px;">
                    <div id="author-avatar-preview" style="width: 96px; height: 96px; border-radius: 50%; overflow: hidden; background: #e5e5e5; border: 2px solid #ccd0d4; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <?php if ( ! empty( $avatar_url ) ) : ?>
                            <img src="<?php echo esc_url( $avatar_url ); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="" />
                        <?php else : ?>
                            <?php echo get_avatar( $user->ID, 96 ); ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="hidden" name="author_custom_avatar" id="author_custom_avatar" value="<?php echo esc_attr( $avatar_id ); ?>" />
                        <button type="button" class="button button-primary" id="author_avatar_upload_btn">
                            <?php esc_html_e( 'Upload / Change Photo', 'newstoday' ); ?>
                        </button>
                        <button type="button" class="button button-secondary" id="author_avatar_remove_btn" style="<?php echo empty( $avatar_id ) ? 'display: none;' : ''; ?> margin-left: 8px;">
                            <?php esc_html_e( 'Remove Photo', 'newstoday' ); ?>
                        </button>
                        <p class="description" style="margin-top: 8px;">
                            <?php esc_html_e( 'Upload a photo directly from your computer or media library. This will be used as the author image everywhere on the site (About Us, Author Card, Single Post, etc.).', 'newstoday' ); ?>
                        </p>
                    </div>
                </div>

                <script>
                jQuery(document).ready(function($) {
                    var frame;
                    var uploadBtn = $('#author_avatar_upload_btn');
                    var removeBtn = $('#author_avatar_remove_btn');
                    var inputField = $('#author_custom_avatar');
                    var previewBox = $('#author-avatar-preview');

                    uploadBtn.on('click', function(e) {
                        e.preventDefault();
                        if (frame) {
                            frame.open();
                            return;
                        }
                        frame = wp.media({
                            title: '<?php echo esc_js( __( 'Select or Upload Profile Photo', 'newstoday' ) ); ?>',
                            button: { text: '<?php echo esc_js( __( 'Use as Profile Photo', 'newstoday' ) ); ?>' },
                            multiple: false,
                            library: { type: 'image' }
                        });

                        frame.on('select', function() {
                            var attachment = frame.state().get('selection').first().toJSON();
                            var imgUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                            inputField.val(attachment.id);
                            previewBox.html('<img src="' + imgUrl + '" style="width: 100%; height: 100%; object-fit: cover;" alt="" />');
                            removeBtn.show();
                        });

                        frame.open();
                    });

                    removeBtn.on('click', function(e) {
                        e.preventDefault();
                        inputField.val('');
                        previewBox.html('<?php echo addslashes( get_avatar( 0, 96 ) ); ?>');
                        removeBtn.hide();
                    });
                });
                </script>
            </td>
        </tr>

        <!-- Job Title -->
        <tr>
            <th>
                <label for="author_job_title">
                    <?php esc_html_e( 'Job Title', 'newstoday' ); ?>
                </label>
            </th>
            <td>
                <input
                    type="text"
                    id="author_job_title"
                    name="author_job_title"
                    value="<?php echo esc_attr( get_user_meta( $user->ID, 'author_job_title', true ) ); ?>"
                    class="regular-text"
                    placeholder="<?php esc_attr_e( 'e.g. iGaming Journalist', 'newstoday' ); ?>"
                />
                <p class="description">
                    <?php esc_html_e( 'Displayed below the author\'s name on the About Us page.', 'newstoday' ); ?>
                </p>
            </td>
        </tr>

        <!-- LinkedIn URL -->
        <tr>
            <th>
                <label for="author_linkedin">
                    <?php esc_html_e( 'LinkedIn URL', 'newstoday' ); ?>
                </label>
            </th>
            <td>
                <input
                    type="url"
                    id="author_linkedin"
                    name="author_linkedin"
                    value="<?php echo esc_attr( get_user_meta( $user->ID, 'author_linkedin', true ) ); ?>"
                    class="regular-text"
                    placeholder="https://www.linkedin.com/in/username"
                />
                <p class="description">
                    <?php esc_html_e( 'If filled in, an "in" LinkedIn icon will appear on the About Us author card. Leave blank to hide it.', 'newstoday' ); ?>
                </p>
            </td>
        </tr>

        <!-- Twitter/X URL -->
        <tr>
            <th>
                <label for="author_twitter">
                    <?php esc_html_e( 'Twitter/X URL', 'newstoday' ); ?>
                </label>
            </th>
            <td>
                <input
                    type="url"
                    id="author_twitter"
                    name="author_twitter"
                    value="<?php echo esc_attr( get_user_meta( $user->ID, 'author_twitter', true ) ); ?>"
                    class="regular-text"
                    placeholder="https://x.com/username"
                />
                <p class="description">
                    <?php esc_html_e( 'If filled in, a Twitter/X icon will appear on the author profile card. Leave blank to hide it.', 'newstoday' ); ?>
                </p>
            </td>
        </tr>

    </table>
    <?php
}

// ---------------------------------------------------------------------------
// 3. Save when "Your Profile" or "Edit User" is updated.
// ---------------------------------------------------------------------------
add_action( 'personal_options_update', 'newstoday_save_author_extra_fields' );
add_action( 'edit_user_profile_update', 'newstoday_save_author_extra_fields' );

/**
 * Sanitise and persist the custom author fields.
 *
 * @param int $user_id  ID of the user being saved.
 */
function newstoday_save_author_extra_fields( int $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }

    // --- Custom Profile Photo ---
    if ( isset( $_POST['author_custom_avatar'] ) ) {
        $avatar_id = absint( $_POST['author_custom_avatar'] );
        if ( $avatar_id > 0 ) {
            update_user_meta( $user_id, 'author_custom_avatar', $avatar_id );
        } else {
            delete_user_meta( $user_id, 'author_custom_avatar' );
        }
    }

    // --- Job Title ---
    if ( isset( $_POST['author_job_title'] ) ) {
        update_user_meta(
            $user_id,
            'author_job_title',
            sanitize_text_field( wp_unslash( $_POST['author_job_title'] ) )
        );
    }

    // --- LinkedIn URL ---
    if ( isset( $_POST['author_linkedin'] ) ) {
        $linkedin_url = esc_url_raw( wp_unslash( $_POST['author_linkedin'] ) );
        update_user_meta( $user_id, 'author_linkedin', $linkedin_url );
    }

    // --- Twitter/X URL ---
    if ( isset( $_POST['author_twitter'] ) ) {
        $twitter_url = esc_url_raw( wp_unslash( $_POST['author_twitter'] ) );
        update_user_meta( $user_id, 'author_twitter', $twitter_url );
    }
}

// ---------------------------------------------------------------------------
// 4. Override WordPress get_avatar() to use our uploaded custom photo.
// ---------------------------------------------------------------------------
add_filter( 'pre_get_avatar_data', 'newstoday_custom_avatar_data', 10, 2 );

/**
 * Replace gravatar URL with custom uploaded avatar image URL.
 *
 * @param array $args         Avatar args.
 * @param mixed $id_or_email  User ID, email, or WP_User object.
 * @return array
 */
function newstoday_custom_avatar_data( $args, $id_or_email ) {
    $user_id = 0;

    if ( is_numeric( $id_or_email ) ) {
        $user_id = (int) $id_or_email;
    } elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
        $user_id = $user->ID;
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $user_id = (int) $id_or_email->user_id;
        } elseif ( ! empty( $id_or_email->ID ) ) {
            $user_id = (int) $id_or_email->ID;
        }
    }

    if ( $user_id > 0 ) {
        $avatar_id = get_user_meta( $user_id, 'author_custom_avatar', true );
        if ( $avatar_id ) {
            $size = isset( $args['size'] ) ? (int) $args['size'] : 96;
            $img_size = $size > 150 ? 'medium' : 'thumbnail';
            $avatar_url = wp_get_attachment_image_url( (int) $avatar_id, $img_size );
            if ( $avatar_url ) {
                $args['url'] = $avatar_url;
            }
        }
    }

    return $args;
}
