<?php
/**
 * SVG Support
 * 
 * Enable SVG upload support with security measures
 *
 * @package NewsToday
 */

/**
 * Enable SVG uploads
 */
function newstoday_mime_types( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'newstoday_mime_types' );

/**
 * Check SVG file content for security
 */
function newstoday_check_svg( $file ) {
    // Check if it's an SVG file
    if ( $file['type'] === 'image/svg+xml' ) {
        $svg_content = file_get_contents( $file['tmp_name'] );
        
        // Basic security check - reject if contains script tags or javascript
        if ( 
            stripos( $svg_content, '<script' ) !== false ||
            stripos( $svg_content, 'javascript:' ) !== false ||
            stripos( $svg_content, 'onload=' ) !== false ||
            stripos( $svg_content, 'onerror=' ) !== false
        ) {
            $file['error'] = __( 'Sorry, this SVG file contains potentially harmful code and cannot be uploaded.', 'newstoday' );
        }
    }
    
    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'newstoday_check_svg' );

/**
 * Fix SVG thumbnails in media library
 */
function newstoday_fix_svg_thumb_display() {
    echo '<style>
        .attachment-266x266, 
        .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
        
        .media-icon img[src$=".svg"] {
            width: 100%;
            height: auto;
        }
        
        img[src$=".svg"] {
            max-width: 100%;
            height: auto;
        }
    </style>';
}
add_action( 'admin_head', 'newstoday_fix_svg_thumb_display' );

/**
 * Display SVG properly in media library
 */
function newstoday_svg_media_thumbnails( $response, $attachment, $meta ) {
    if ( $response['mime'] === 'image/svg+xml' && empty( $response['sizes'] ) ) {
        $svg_path = get_attached_file( $attachment->ID );
        
        if ( file_exists( $svg_path ) ) {
            $response['sizes'] = array(
                'full' => array(
                    'url' => $response['url'],
                ),
            );
        }
    }
    
    return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'newstoday_svg_media_thumbnails', 10, 3 );

/**
 * Allow SVG in customizer (for logo upload)
 */
function newstoday_svg_allowed_in_customizer( $checked, $file, $filename, $mimes ) {
    if ( ! $checked['type'] ) {
        $check_filetype     = wp_check_filetype( $filename, $mimes );
        $ext                = $check_filetype['ext'];
        $type               = $check_filetype['type'];
        $proper_filename    = $filename;

        if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
            $ext  = false;
            $type = false;
        }

        $checked = compact( 'ext', 'type', 'proper_filename' );
    }

    return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'newstoday_svg_allowed_in_customizer', 10, 4 );

