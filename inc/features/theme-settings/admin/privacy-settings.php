<?php
/**
 * Privacy Settings
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default privacy settings
function yiontech_lms_get_default_privacy_settings() {
    $defaults = [
        'enable_privacy_features' => true,
        'privacy_policy_page' => 0,
        'terms_of_service_page' => 0,
        'cookie_consent_text' => __('We use cookies to ensure you get the best experience on our website. By continuing to use this site, you consent to our use of cookies.', 'yiontech-lms'),
        'cookie_consent_button_text' => __('Accept', 'yiontech-lms'),
        'cookie_consent_learn_more_text' => __('Learn More', 'yiontech-lms'),
        'enable_data_export' => true,
        'enable_account_deletion' => true,
    ];
    return apply_filters('yiontech_lms_default_privacy_settings', $defaults);
}

// Get privacy setting with sanitization
function yiontech_lms_get_privacy_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_privacy_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'cookie_consent_text':
            return wp_kses_post($value);
        case 'cookie_consent_button_text':
        case 'cookie_consent_learn_more_text':
            return sanitize_text_field($value);
        case 'privacy_policy_page':
        case 'terms_of_service_page':
            return absint($value);
        case 'enable_privacy_features':
        case 'enable_data_export':
        case 'enable_account_deletion':
            return (bool) $value;
        default:
            return sanitize_text_field($value);
    }
}

// Register settings for privacy section
function yiontech_lms_privacy_settings_init() {
    // Privacy section
    add_settings_section(
        'yiontech_lms_privacy_section',
        __('Privacy Settings', 'yiontech-lms'),
        'yiontech_lms_privacy_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'enable_privacy_features',
        __('Enable Privacy Features', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'enable_privacy_features',
            'name' => 'yiontech_lms_theme_settings[enable_privacy_features]',
            'description' => __('Enable privacy features including cookie consent and data protection', 'yiontech-lms'),
            'label_for' => 'enable_privacy_features',
        ]
    );

    add_settings_field(
        'privacy_policy_page',
        __('Privacy Policy Page', 'yiontech-lms'),
        'yiontech_lms_page_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'privacy_policy_page',
            'name' => 'yiontech_lms_theme_settings[privacy_policy_page]',
            'description' => __('Select your privacy policy page', 'yiontech-lms'),
            'label_for' => 'privacy_policy_page',
        ]
    );

    add_settings_field(
        'terms_of_service_page',
        __('Terms of Service Page', 'yiontech-lms'),
        'yiontech_lms_page_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'terms_of_service_page',
            'name' => 'yiontech_lms_theme_settings[terms_of_service_page]',
            'description' => __('Select your terms of service page', 'yiontech-lms'),
            'label_for' => 'terms_of_service_page',
        ]
    );

    add_settings_field(
        'cookie_consent_text',
        __('Cookie Consent Text', 'yiontech-lms'),
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'cookie_consent_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_text]',
            'description' => __('Enter the text to display in the cookie consent banner', 'yiontech-lms'),
            'rows' => 3,
            'label_for' => 'cookie_consent_text',
        ]
    );

    add_settings_field(
        'cookie_consent_button_text',
        __('Cookie Consent Button Text', 'yiontech-lms'),
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'cookie_consent_button_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_button_text]',
            'description' => __('Enter the text for the cookie consent accept button', 'yiontech-lms'),
            'label_for' => 'cookie_consent_button_text',
        ]
    );

    add_settings_field(
        'cookie_consent_learn_more_text',
        __('Cookie Consent Learn More Text', 'yiontech-lms'),
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'cookie_consent_learn_more_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_learn_more_text]',
            'description' => __('Enter the text for the cookie consent learn more link', 'yiontech-lms'),
            'label_for' => 'cookie_consent_learn_more_text',
        ]
    );

    add_settings_field(
        'enable_data_export',
        __('Enable Data Export', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'enable_data_export',
            'name' => 'yiontech_lms_theme_settings[enable_data_export]',
            'description' => __('Allow users to export their data from their profile page', 'yiontech-lms'),
            'label_for' => 'enable_data_export',
        ]
    );

    add_settings_field(
        'enable_account_deletion',
        __('Enable Account Deletion', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        [
            'id' => 'enable_account_deletion',
            'name' => 'yiontech_lms_theme_settings[enable_account_deletion]',
            'description' => __('Allow users to delete their account from their profile page', 'yiontech-lms'),
            'label_for' => 'enable_account_deletion',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_privacy_settings_init');

// Section callback
function yiontech_lms_privacy_section_callback() {
    echo '<p>' . esc_html__('Configure privacy settings for GDPR compliance', 'yiontech-lms') . '</p>';
}