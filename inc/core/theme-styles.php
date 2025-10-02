<?php
/**
 * Theme Styles Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add dynamic styles to head
 */
function yiontech_lms_dynamic_styles() {
    $header_background_color = yiontech_lms_get_theme_setting('header_background_color', '#1e40af');
    $sticky_header_background_color = yiontech_lms_get_theme_setting('sticky_header_background_color', '#1e40af');
    $transparent_header = yiontech_lms_get_theme_setting('transparent_header', false);
    $footer_background_color = yiontech_lms_get_theme_setting('footer_background_color', '#111827');
    $footer_text_color = yiontech_lms_get_theme_setting('footer_text_color', '#ffffff');
    $copyright_background_color = yiontech_lms_get_theme_setting('copyright_background_color', '#0f172a');

    $css = "
        .site-header:not(.header-transparent) {
            background-color: {$header_background_color};
        }
        .site-header.sticky {
            background-color: {$sticky_header_background_color};
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        footer {
            background-color: {$footer_background_color};
            color: {$footer_text_color};
        }
        .copyright-section {
            background-color: {$copyright_background_color};
        }
        /* Gutenberg block styles (when not disabled) */
        .wp-block-quote { border-left: 4px solid {$header_background_color}; padding-left: 1rem; }
        .wp-block-button__link { background-color: {$header_background_color}; color: {$footer_text_color}; }
    ";

    wp_add_inline_style('yiontech-lms-style', $css);
}
add_action('wp_enqueue_scripts', 'yiontech_lms_dynamic_styles');