<?php
/**
 * Author User Fields
 *
 * Adds custom "Job Title" and "LinkedIn URL" fields to the WordPress
 * Admin user profile / edit-user page.
 *
 * Data is stored in wp_usermeta (meta keys: author_job_title, author_linkedin)
 * which is exactly what the About Us template already reads via get_user_meta().
 *
 * @package NewsToday
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---------------------------------------------------------------------------
// 1. Display the fields on "Your Profile" (own profile) page.
// ---------------------------------------------------------------------------
add_action( 'show_user_profile', 'newstoday_author_extra_fields' );

// ---------------------------------------------------------------------------
// 2. Display the fields on "Edit User" (admin editing another user) page.
// ---------------------------------------------------------------------------
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
    ?>
    <h2><?php esc_html_e( 'Author Profile Fields', 'newstoday' ); ?></h2>
    <table class="form-table" role="presentation">

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
// 3. Save when "Your Profile" is updated (own profile).
// ---------------------------------------------------------------------------
add_action( 'personal_options_update', 'newstoday_save_author_extra_fields' );

// ---------------------------------------------------------------------------
// 4. Save when an admin updates another user's profile.
// ---------------------------------------------------------------------------
add_action( 'edit_user_profile_update', 'newstoday_save_author_extra_fields' );

/**
 * Sanitise and persist the custom author fields.
 *
 * @param int $user_id  ID of the user being saved.
 */
function newstoday_save_author_extra_fields( int $user_id ) {
    // Verify the current user has permission to edit this user.
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }

    // Verify nonce (WordPress core already checks nonce for user profile saves,
    // but we add an extra capability check above for safety).

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
