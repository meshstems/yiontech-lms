<?php
/**
 * Theme Activation Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme activation hook
 */
function yiontech_lms_activate() {
    // Set default options if they don't exist
    if (!get_option('yiontech_lms_theme_settings')) {
        $defaults = yiontech_lms_get_default_settings();
        add_option('yiontech_lms_theme_settings', wp_kses_post_deep($defaults));
    }

    // Create front page only if it doesn't exist
    if (!get_page_by_path('front-page', OBJECT, 'page')) {
        $front_page_id = wp_insert_post([
            'post_title' => __('Front Page', 'yiontech-lms'),
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page',
            'post_name' => 'front-page',
        ]);
        update_option('page_on_front', $front_page_id);
        update_option('show_on_front', 'page');
    }

    // Flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'yiontech_lms_activate');