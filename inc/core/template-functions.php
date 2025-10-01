<?php
/**
 * Template Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load template function
function yiontech_lms_load_template( $template_path ) {
    // Ensure the template path starts with a slash
    $template_path = ltrim($template_path, '/');
    
    // Prefer child theme override first
    $template_file = locate_template( $template_path );
    if ( $template_file && file_exists( $template_file ) ) {
        require $template_file;
        return;
    }

    // Fallback to parent theme folder
    $fallback_path = get_template_directory() . '/' . $template_path;
    if ( file_exists( $fallback_path ) ) {
        require $fallback_path;
        return;
    }

    // Template missing: show a generic message to users, and log when WP_DEBUG is true
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( '[Yiontech_LMS] Template missing: ' . $template_path );
    }

    echo '<div class="tutor-alert tutor-danger">' . esc_html__( 'Template missing. Please check your theme installation.', 'yiontech-lms' ) . '</div>';
}

// Get privacy policy URL
function yiontech_lms_get_privacy_policy_url() {
    $privacy_policy_page = yiontech_lms_get_theme_setting( 'privacy_policy_page' );
    if ( $privacy_policy_page ) {
        $url = get_permalink( $privacy_policy_page );
        if ( $url ) {
            return $url;
        }
    }
    return get_privacy_policy_url();
}

// Get terms of service URL
function yiontech_lms_get_terms_of_service_url() {
    $terms_of_service_page = yiontech_lms_get_theme_setting( 'terms_of_service_page' );
    if ( $terms_of_service_page ) {
        $url = get_permalink( $terms_of_service_page );
        if ( $url ) {
            return $url;
        }
    }
    return '';
}

// Helper function to get Elementor templates
function yiontech_lms_get_elementor_templates( $template_type = '' ) {
    $args = array(
        'post_type'      => 'elementor_library',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );

    if ( ! empty( $template_type ) ) {
        $args['meta_query'] = array(
            array(
                'key'   => '_elementor_template_type',
                'value' => $template_type,
            ),
        );
    }

    $templates = get_posts( $args );

    $template_options = array();
    if ( ! empty( $templates ) ) {
        foreach ( $templates as $template ) {
            $template_options[ $template->ID ] = $template->post_title;
        }
    }

    return $template_options;
}
