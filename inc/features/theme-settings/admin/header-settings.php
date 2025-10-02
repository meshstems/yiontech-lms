<?php
/**
 * Header Settings
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default header settings
function yiontech_lms_get_default_header_settings() {
    $defaults = [
        'header_style' => 'default',
        'transparent_header' => false,
        'sticky_header' => true,
        'header_background_color' => '#1e40af',
        'sticky_header_background_color' => '#1e40af',
        'logo_upload' => '',
        'retina_logo_upload' => '',
        'header_buttons' => [
            [
                'text' => __('Login', 'yiontech-lms'),
                'url' => '/login',
                'style' => 'outline',
                'show_desktop' => true,
                'show_mobile' => false,
            ],
            [
                'text' => __('Enquire Now', 'yiontech-lms'),
                'url' => '/contact',
                'style' => 'solid',
                'show_desktop' => true,
                'show_mobile' => true,
            ],
        ],
        'header_menu' => [
            ['text' => __('Home', 'yiontech-lms'), 'url' => '/'],
            ['text' => __('Courses', 'yiontech-lms'), 'url' => '/courses'],
            ['text' => __('About', 'yiontech-lms'), 'url' => '/about'],
            ['text' => __('Contact', 'yiontech-lms'), 'url' => '/contact'],
        ],
        'header_elementor_template' => 0,
    ];
    return apply_filters('yiontech_lms_default_header_settings', $defaults);
}

// Get header setting with sanitization
function yiontech_lms_get_header_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_header_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'header_background_color':
        case 'sticky_header_background_color':
            return sanitize_hex_color($value);
        case 'logo_upload':
        case 'retina_logo_upload':
            return esc_url_raw($value);
        case 'header_style':
            return in_array($value, ['default', 'minimal', 'centered']) ? $value : $default;
        case 'transparent_header':
        case 'sticky_header':
            return (bool) $value;
        case 'header_elementor_template':
            return absint($value);
        case 'header_buttons':
            return yiontech_lms_sanitize_header_buttons($value);
        case 'header_menu':
            return yiontech_lms_sanitize_header_menu($value);
        default:
            return sanitize_text_field($value);
    }
}

// Sanitization functions
function yiontech_lms_sanitize_color($input) {
    return sanitize_hex_color($input);
}

function yiontech_lms_sanitize_header_buttons($input) {
    $sanitized = [];
    if (is_array($input)) {
        foreach ($input as $button) {
            $sanitized[] = [
                'text' => sanitize_text_field($button['text'] ?? ''),
                'url' => esc_url_raw($button['url'] ?? ''),
                'style' => in_array($button['style'] ?? '', ['solid', 'outline']) ? $button['style'] : 'solid',
                'show_desktop' => (bool) ($button['show_desktop'] ?? true),
                'show_mobile' => (bool) ($button['show_mobile'] ?? true),
            ];
        }
    }
    return $sanitized;
}

function yiontech_lms_sanitize_header_menu($input) {
    $sanitized = [];
    if (is_array($input)) {
        foreach ($input as $item) {
            $sanitized[] = [
                'text' => sanitize_text_field($item['text'] ?? ''),
                'url' => esc_url_raw($item['url'] ?? ''),
            ];
        }
    }
    return $sanitized;
}

// Register settings for header section
function yiontech_lms_header_settings_init() {
    // Header section
    add_settings_section(
        'yiontech_lms_header_section',
        __('Header', 'yiontech-lms'),
        'yiontech_lms_header_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'header_style',
        __('Select Header Style', 'yiontech-lms'),
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'header_style',
            'name' => 'yiontech_lms_theme_settings[header_style]',
            'options' => [
                'default' => __('Default Header', 'yiontech-lms'),
                'minimal' => __('Minimal Header', 'yiontech-lms'),
                'centered' => __('Centered Logo Header', 'yiontech-lms'),
            ],
            'description' => __('Choose header style', 'yiontech-lms'),
            'label_for' => 'header_style',
        ]
    );

    add_settings_field(
        'transparent_header',
        __('Transparent Header', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'transparent_header',
            'name' => 'yiontech_lms_theme_settings[transparent_header]',
            'description' => __('Make header transparent on homepage', 'yiontech-lms'),
            'label_for' => 'transparent_header',
        ]
    );

    add_settings_field(
        'sticky_header',
        __('Sticky Header On/Off', 'yiontech-lms'),
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'sticky_header',
            'name' => 'yiontech_lms_theme_settings[sticky_header]',
            'description' => __('Enable sticky header', 'yiontech-lms'),
            'label_for' => 'sticky_header',
        ]
    );

    add_settings_field(
        'header_background_color',
        __('Header Background Color', 'yiontech-lms'),
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'header_background_color',
            'name' => 'yiontech_lms_theme_settings[header_background_color]',
            'description' => __('Choose header background color', 'yiontech-lms'),
            'label_for' => 'header_background_color',
        ]
    );

    add_settings_field(
        'sticky_header_background_color',
        __('Sticky Header Background Color', 'yiontech-lms'),
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'sticky_header_background_color',
            'name' => 'yiontech_lms_theme_settings[sticky_header_background_color]',
            'description' => __('Choose sticky header background color', 'yiontech-lms'),
            'label_for' => 'sticky_header_background_color',
        ]
    );

    add_settings_field(
        'logo_upload',
        __('Logo Upload', 'yiontech-lms'),
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'logo_upload',
            'name' => 'yiontech_lms_theme_settings[logo_upload]',
            'description' => __('Upload your logo (recommended 200x36px)', 'yiontech-lms'),
            'label_for' => 'logo_upload',
        ]
    );

    add_settings_field(
        'retina_logo_upload',
        __('Retina Logo Upload @2x', 'yiontech-lms'),
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'retina_logo_upload',
            'name' => 'yiontech_lms_theme_settings[retina_logo_upload]',
            'description' => __('Upload retina version of your logo (2x size, recommended 400x72px)', 'yiontech-lms'),
            'label_for' => 'retina_logo_upload',
        ]
    );

    add_settings_field(
        'header_buttons',
        __('Header Buttons', 'yiontech-lms'),
        'yiontech_lms_header_buttons_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'header_buttons',
            'name' => 'yiontech_lms_theme_settings[header_buttons]',
            'description' => __('Configure header buttons', 'yiontech-lms'),
        ]
    );

    add_settings_field(
        'header_menu',
        __('Header Menu', 'yiontech-lms'),
        'yiontech_lms_menu_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'header_menu',
            'name' => 'yiontech_lms_theme_settings[header_menu]',
            'description' => __('Configure header menu items', 'yiontech-lms'),
        ]
    );

    add_settings_field(
        'header_elementor_template',
        __('Header Elementor Template', 'yiontech-lms'),
        'yiontech_lms_elementor_header_template_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        [
            'id' => 'header_elementor_template',
            'name' => 'yiontech_lms_theme_settings[header_elementor_template]',
            'description' => __('Select an Elementor template for the header. Leave empty to use the default theme header.', 'yiontech-lms'),
            'label_for' => 'header_elementor_template',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_header_settings_init');

// Section callback
function yiontech_lms_header_section_callback() {
    echo '<p>' . esc_html__('Configure your website header', 'yiontech-lms') . '</p>';
}