<?php
/**
 * Header Scroll Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue header scroll script if enabled
function yiontech_lms_enqueue_header_scroll_script() {
    $transparent_header = yiontech_lms_get_theme_setting('transparent_header');
    $sticky_header = yiontech_lms_get_theme_setting('sticky_header');
    if ($transparent_header || $sticky_header) {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('yiontech-lms-header-scroll', get_template_directory_uri() . '/inc/features/header-scroll/header-scroll.js', array('jquery'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_header_scroll_script');