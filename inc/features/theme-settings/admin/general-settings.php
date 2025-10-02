<?php
/**
 * General Settings
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default theme settings
function yiontech_lms_get_default_settings() {
    $defaults = [
        'enable_preloader' => true,
        'site_icon' => '',
        'enable_back_to_top' => true,
        'disable_gutenberg' => false,
    ];
    return apply_filters('yiontech_lms_default_settings', $defaults);
}

// Get theme setting with sanitization
function yiontech_lms_get_theme_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'site_icon':
            return esc_url_raw($value);
        case 'enable_preloader':
        case 'enable_back_to_top':
        case 'disable_gutenberg':
            return (bool) $value;
        default:
            return sanitize_text_field($value);
    }
}

// Sanitization functions
function yiontech_lms_sanitize_checkbox($input) {
    return (bool) $input;
}

function yiontech_lms_sanitize_url($input) {
    return esc_url_raw($input);
}

function yiontech_lms_sanitize_text($input) {
    return sanitize_text_field($input);
}

// Register settings for general section
function yiontech_lms_general_settings_init() {
    // General section
    add_settings_section(
        'yiontech_lms_general_section',
        __('General', 'yiontech-lms'),
        'yiontech_lms_general_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'enable_preloader',
        __('Enable Preloader', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        [
            'id' => 'enable_preloader',
            'name' => 'yiontech_lms_theme_settings[enable_preloader]',
            'description' => __('Enable preloader for the site', 'yiontech-lms'),
            'label_for' => 'enable_preloader',
        ]
    );

    add_settings_field(
        'site_icon',
        __('Site Icon (Favicon)', 'yiontech-lms'),
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        [
            'id' => 'site_icon',
            'name' => 'yiontech_lms_theme_settings[site_icon]',
            'description' => __('Upload site icon for browser tab (recommended 32x32px)', 'yiontech-lms'),
            'label_for' => 'site_icon',
        ]
    );

    add_settings_field(
        'enable_back_to_top',
        __('Enable Back to Top Button', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        [
            'id' => 'enable_back_to_top',
            'name' => 'yiontech_lms_theme_settings[enable_back_to_top]',
            'description' => __('Enable back to top button', 'yiontech-lms'),
            'label_for' => 'enable_back_to_top',
        ]
    );

    add_settings_field(
        'disable_gutenberg',
        __('Disable Gutenberg Editor', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        [
            'id' => 'disable_gutenberg',
            'name' => 'yiontech_lms_theme_settings[disable_gutenberg]',
            'description' => __('Disable the block editor (Gutenberg) for all posts and pages. Also disable block-based widgets for full classic editing experience', 'yiontech-lms'),
            'label_for' => 'disable_gutenberg',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_general_settings_init');

// Section callback
function yiontech_lms_general_section_callback() {
    echo '<p>' . esc_html__('General theme settings', 'yiontech-lms') . '</p>';
}