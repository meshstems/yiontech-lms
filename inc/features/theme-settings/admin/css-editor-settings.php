<?php
/**
 * CSS Editor Settings
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default CSS settings
function yiontech_lms_get_default_css_settings() {
    $defaults = [
        'custom_css' => '',
    ];
    return apply_filters('yiontech_lms_default_css_settings', $defaults);
}

// Get CSS setting with sanitization
function yiontech_lms_get_css_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_css_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'custom_css':
            return wp_strip_all_tags($value);
        default:
            return sanitize_text_field($value);
    }
}

// Register settings for CSS editor section
function yiontech_lms_css_editor_settings_init() {
    // CSS Editor section
    add_settings_section(
        'yiontech_lms_css_editor_section',
        __('CSS Editor', 'yiontech-lms'),
        'yiontech_lms_css_editor_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'custom_css',
        __('Custom CSS', 'yiontech-lms'),
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_css_editor_section',
        [
            'id' => 'custom_css',
            'name' => 'yiontech_lms_theme_settings[custom_css]',
            'description' => __('Add your custom CSS here (will be minified and scoped to .yiontech-lms)', 'yiontech-lms'),
            'rows' => 20,
            'label_for' => 'custom_css',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_css_editor_settings_init');

// Section callback
function yiontech_lms_css_editor_section_callback() {
    echo '<p>' . esc_html__('Add custom CSS to your theme', 'yiontech-lms') . '</p>';
}