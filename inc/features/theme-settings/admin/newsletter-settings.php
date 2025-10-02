<?php
/**
 * Newsletter Settings
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default newsletter settings
function yiontech_lms_get_default_newsletter_settings() {
    $defaults = [
        'newsletter_enable' => false,
        'newsletter_action_url' => '',
        'newsletter_method' => 'post',
        'newsletter_email_field' => 'email',
        'newsletter_hidden_fields' => '',
        'newsletter_success_message' => __('Thank you for subscribing!', 'yiontech-lms'),
    ];
    return apply_filters('yiontech_lms_default_newsletter_settings', $defaults);
}

// Get newsletter setting with sanitization
function yiontech_lms_get_newsletter_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_newsletter_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'newsletter_action_url':
            return esc_url_raw($value);
        case 'newsletter_email_field':
        case 'newsletter_success_message':
            return sanitize_text_field($value);
        case 'newsletter_hidden_fields':
            return yiontech_lms_sanitize_hidden_fields($value);
        case 'newsletter_method':
            return in_array($value, ['post', 'get']) ? $value : $default;
        case 'newsletter_enable':
            return (bool) $value;
        default:
            return sanitize_text_field($value);
    }
}

// Sanitization functions
function yiontech_lms_sanitize_hidden_fields($input) {
    $sanitized = [];
    if (is_string($input)) {
        $lines = array_filter(array_map('trim', explode("\n", $input)));
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                [$name, $value] = array_map('trim', explode('=', $line, 2));
                $sanitized[] = [
                    'name' => sanitize_key($name),
                    'value' => sanitize_text_field($value),
                ];
            }
        }
    }
    return $sanitized;
}

// Register settings for newsletter section
function yiontech_lms_newsletter_settings_init() {
    // Newsletter section
    add_settings_section(
        'yiontech_lms_newsletter_section',
        __('Newsletter', 'yiontech-lms'),
        'yiontech_lms_newsletter_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'newsletter_enable',
        __('Enable Newsletter', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_enable',
            'name' => 'yiontech_lms_theme_settings[newsletter_enable]',
            'description' => __('Enable newsletter subscription', 'yiontech-lms'),
            'label_for' => 'newsletter_enable',
        ]
    );

    add_settings_field(
        'newsletter_action_url',
        __('Newsletter Action URL', 'yiontech-lms'),
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_action_url',
            'name' => 'yiontech_lms_theme_settings[newsletter_action_url]',
            'description' => __('Enter the form action URL (e.g., Mailchimp, ConvertKit, etc.)', 'yiontech-lms'),
            'label_for' => 'newsletter_action_url',
        ]
    );

    add_settings_field(
        'newsletter_method',
        __('Form Method', 'yiontech-lms'),
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_method',
            'name' => 'yiontech_lms_theme_settings[newsletter_method]',
            'options' => [
                'post' => __('POST', 'yiontech-lms'),
                'get' => __('GET', 'yiontech-lms'),
            ],
            'description' => __('Choose form submission method', 'yiontech-lms'),
            'label_for' => 'newsletter_method',
        ]
    );

    add_settings_field(
        'newsletter_email_field',
        __('Email Field Name', 'yiontech-lms'),
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_email_field',
            'name' => 'yiontech_lms_theme_settings[newsletter_email_field]',
            'description' => __('Enter the name attribute for the email field (e.g., EMAIL, email, etc.)', 'yiontech-lms'),
            'label_for' => 'newsletter_email_field',
        ]
    );

    add_settings_field(
        'newsletter_hidden_fields',
        __('Hidden Fields', 'yiontech-lms'),
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_hidden_fields',
            'name' => 'yiontech_lms_theme_settings[newsletter_hidden_fields]',
            'description' => __('Enter hidden fields required by your newsletter service (one per line in format: name=value)', 'yiontech-lms'),
            'rows' => 5,
            'label_for' => 'newsletter_hidden_fields',
        ]
    );

    add_settings_field(
        'newsletter_success_message',
        __('Success Message', 'yiontech-lms'),
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        [
            'id' => 'newsletter_success_message',
            'name' => 'yiontech_lms_theme_settings[newsletter_success_message]',
            'description' => __('Enter the message to show after successful subscription', 'yiontech-lms'),
            'rows' => 3,
            'label_for' => 'newsletter_success_message',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_newsletter_settings_init');

// Section callback
function yiontech_lms_newsletter_section_callback() {
    echo '<p>' . esc_html__('Newsletter configuration settings', 'yiontech-lms') . '</p>';
}