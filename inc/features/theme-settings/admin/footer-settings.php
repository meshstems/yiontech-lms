<?php
/**
 * Footer Settings
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Default footer settings
function yiontech_lms_get_default_footer_settings() {
    $defaults = [
        'footer_style' => 'default',
        'footer_elementor_template' => 0,
        'footer_content' => [
            'column1' => [
                'title' => __('About Us', 'yiontech-lms'),
                'content' => __('A powerful learning management system designed for educators and students.', 'yiontech-lms'),
            ],
            'column2' => [
                'title' => __('Quick Links', 'yiontech-lms'),
                'links' => [
                    ['text' => __('Home', 'yiontech-lms'), 'url' => '/'],
                    ['text' => __('Courses', 'yiontech-lms'), 'url' => '/courses'],
                    ['text' => __('About', 'yiontech-lms'), 'url' => '/about'],
                    ['text' => __('Contact', 'yiontech-lms'), 'url' => '/contact'],
                ],
            ],
            'column3' => [
                'title' => __('Company', 'yiontech-lms'),
                'links' => [
                    ['text' => __('About Us', 'yiontech-lms'), 'url' => '/about'],
                    ['text' => __('Our Team', 'yiontech-lms'), 'url' => '/team'],
                    ['text' => __('Careers', 'yiontech-lms'), 'url' => '/careers'],
                    ['text' => __('Blog', 'yiontech-lms'), 'url' => '/blog'],
                ],
            ],
            'column4' => [
                'title' => __('User Portal', 'yiontech-lms'),
                'links' => [
                    ['text' => __('Login', 'yiontech-lms'), 'url' => '/login'],
                    ['text' => __('Register', 'yiontech-lms'), 'url' => '/register'],
                    ['text' => __('Dashboard', 'yiontech-lms'), 'url' => '/dashboard'],
                    ['text' => __('Profile', 'yiontech-lms'), 'url' => '/profile'],
                ],
            ],
            'column5' => [
                'title' => __('Newsletter', 'yiontech-lms'),
                'content' => __('Get the latest news and updates delivered right to your inbox.', 'yiontech-lms'),
                'email' => 'info@yiontech.com',
                'phone' => '+1 (555) 123-4567',
            ],
        ],
        'copyright_text' => sprintf(__('&copy; %s %s. All rights reserved.', 'yiontech-lms'), date('Y'), get_bloginfo('name')),
        'footer_text_color' => '#ffffff',
        'footer_background_color' => '#111827',
        'copyright_background_color' => '#0f172a',
        'footer_padding' => ['top' => 48, 'bottom' => 48],
    ];
    return apply_filters('yiontech_lms_default_footer_settings', $defaults);
}

// Get footer setting with sanitization
function yiontech_lms_get_footer_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_footer_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'footer_text_color':
        case 'footer_background_color':
        case 'copyright_background_color':
            return sanitize_hex_color($value);
        case 'copyright_text':
            return wp_kses_post($value);
        case 'footer_style':
            return in_array($value, ['default', 'minimal', 'centered']) ? $value : $default;
        case 'footer_elementor_template':
            return absint($value);
        case 'footer_content':
            return yiontech_lms_sanitize_footer_content($value);
        case 'footer_padding':
            return yiontech_lms_sanitize_footer_padding($value);
        default:
            return sanitize_text_field($value);
    }
}

// Sanitization functions
function yiontech_lms_sanitize_footer_content($input) {
    $sanitized = [];
    $defaults = yiontech_lms_get_default_footer_settings()['footer_content'];

    foreach (['column1', 'column2', 'column3', 'column4', 'column5'] as $col) {
        if (isset($input[$col])) {
            $sanitized[$col] = $input[$col];
        } else {
            $sanitized[$col] = $defaults[$col];
        }
    }

    $sanitized['column1'] = [
        'title' => sanitize_text_field($sanitized['column1']['title'] ?? ''),
        'content' => wp_kses_post($sanitized['column1']['content'] ?? ''),
    ];
    $sanitized['column2'] = [
        'title' => sanitize_text_field($sanitized['column2']['title'] ?? ''),
        'links' => yiontech_lms_sanitize_footer_links($sanitized['column2']['links'] ?? []),
    ];
    $sanitized['column3'] = [
        'title' => sanitize_text_field($sanitized['column3']['title'] ?? ''),
        'links' => yiontech_lms_sanitize_footer_links($sanitized['column3']['links'] ?? []),
    ];
    $sanitized['column4'] = [
        'title' => sanitize_text_field($sanitized['column4']['title'] ?? ''),
        'links' => yiontech_lms_sanitize_footer_links($sanitized['column4']['links'] ?? []),
    ];
    $sanitized['column5'] = [
        'title' => sanitize_text_field($sanitized['column5']['title'] ?? ''),
        'content' => wp_kses_post($sanitized['column5']['content'] ?? ''),
        'email' => sanitize_email($sanitized['column5']['email'] ?? ''),
        'phone' => sanitize_text_field($sanitized['column5']['phone'] ?? ''),
    ];

    return $sanitized;
}

function yiontech_lms_sanitize_footer_links($input) {
    $sanitized = [];
    if (is_array($input)) {
        foreach ($input as $link) {
            $sanitized[] = [
                'text' => sanitize_text_field($link['text'] ?? ''),
                'url' => esc_url_raw($link['url'] ?? ''),
            ];
        }
    }
    return $sanitized;
}

function yiontech_lms_sanitize_footer_padding($input) {
    return [
        'top' => absint($input['top'] ?? 48),
        'bottom' => absint($input['bottom'] ?? 48),
    ];
}

// Register settings for footer section
function yiontech_lms_footer_settings_init() {
    // Footer section
    add_settings_section(
        'yiontech_lms_footer_section',
        __('Footer', 'yiontech-lms'),
        'yiontech_lms_footer_section_callback',
        'yiontech_lms_theme_settings'
    );

    add_settings_field(
        'footer_style',
        __('Select Footer Style', 'yiontech-lms'),
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_style',
            'name' => 'yiontech_lms_theme_settings[footer_style]',
            'options' => [
                'default' => __('Default Footer', 'yiontech-lms'),
                'minimal' => __('Minimal Footer', 'yiontech-lms'),
                'centered' => __('Centered Footer', 'yiontech-lms'),
            ],
            'description' => __('Choose footer style', 'yiontech-lms'),
            'label_for' => 'footer_style',
        ]
    );

    add_settings_field(
        'footer_elementor_template',
        __('Footer Elementor Template', 'yiontech-lms'),
        'yiontech_lms_elementor_template_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_elementor_template',
            'name' => 'yiontech_lms_theme_settings[footer_elementor_template]',
            'description' => __('Select an Elementor template for the footer. Leave empty to use the default theme footer.', 'yiontech-lms'),
            'label_for' => 'footer_elementor_template',
        ]
    );

    add_settings_field(
        'footer_content',
        __('Footer Content', 'yiontech-lms'),
        'yiontech_lms_footer_content_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_content',
            'name' => 'yiontech_lms_theme_settings[footer_content]',
            'description' => __('Configure footer columns and content', 'yiontech-lms'),
        ]
    );

    add_settings_field(
        'copyright_text',
        __('Copyright Text', 'yiontech-lms'),
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'copyright_text',
            'name' => 'yiontech_lms_theme_settings[copyright_text]',
            'description' => __('Enter copyright text', 'yiontech-lms'),
            'label_for' => 'copyright_text',
            'rows' => 3,
        ]
    );

    add_settings_field(
        'footer_text_color',
        __('Footer Text Color', 'yiontech-lms'),
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_text_color',
            'name' => 'yiontech_lms_theme_settings[footer_text_color]',
            'description' => __('Choose footer text color', 'yiontech-lms'),
            'label_for' => 'footer_text_color',
        ]
    );

    add_settings_field(
        'footer_background_color',
        __('Footer Background Color', 'yiontech-lms'),
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_background_color',
            'name' => 'yiontech_lms_theme_settings[footer_background_color]',
            'description' => __('Choose footer background color', 'yiontech-lms'),
            'label_for' => 'footer_background_color',
        ]
    );

    add_settings_field(
        'copyright_background_color',
        __('Copyright Background Color', 'yiontech-lms'),
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'copyright_background_color',
            'name' => 'yiontech_lms_theme_settings[copyright_background_color]',
            'description' => __('Choose copyright section background color', 'yiontech-lms'),
            'label_for' => 'copyright_background_color',
        ]
    );

    add_settings_field(
        'footer_padding',
        __('Padding Top/Bottom', 'yiontech-lms'),
        'yiontech_lms_spacing_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        [
            'id' => 'footer_padding',
            'name' => 'yiontech_lms_theme_settings[footer_padding]',
            'description' => __('Set footer padding top and bottom (in pixels)', 'yiontech-lms'),
            'label_for' => 'footer_padding_top',
        ]
    );
}
add_action('admin_init', 'yiontech_lms_footer_settings_init');

// Section callback
function yiontech_lms_footer_section_callback() {
    echo '<p>' . esc_html__('Configure your website footer', 'yiontech-lms') . '</p>';
}