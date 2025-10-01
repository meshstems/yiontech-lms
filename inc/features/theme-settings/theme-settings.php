<?php
/**
 * Theme Settings Page
 *
 * @package Yiontech_LMS
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
        'header_style' => 'default',
        'transparent_header' => false,
        'sticky_header' => true,
        'header_background_color' => '#1e40af',
        'sticky_header_background_color' => '#1e40af',
        'enable_back_to_top' => true,
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
        'newsletter_enable' => false,
        'newsletter_action_url' => '',
        'newsletter_method' => 'post',
        'newsletter_email_field' => 'email',
        'newsletter_hidden_fields' => '',
        'newsletter_success_message' => __('Thank you for subscribing!', 'yiontech-lms'),
        'custom_css' => '',
        'enable_privacy_features' => true,
        'privacy_policy_page' => 0,
        'terms_of_service_page' => 0,
        'cookie_consent_text' => __('We use cookies to ensure you get the best experience on our website. By continuing to use this site, you consent to our use of cookies.', 'yiontech-lms'),
        'cookie_consent_button_text' => __('Accept', 'yiontech-lms'),
        'cookie_consent_learn_more_text' => __('Learn More', 'yiontech-lms'),
        'enable_data_export' => true,
        'enable_account_deletion' => true,
        'disable_gutenberg' => false, // Changed to false to encourage block editor support
    ];
    return apply_filters('yiontech_lms_default_settings', $defaults);
}

// Get theme setting with sanitization
function yiontech_lms_get_theme_setting($key, $default = '') {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = isset($options[$key]) ? $options[$key] : $default;

    // Sanitize based on key type
    switch ($key) {
        case 'header_background_color':
        case 'sticky_header_background_color':
        case 'footer_background_color':
        case 'footer_text_color':
        case 'copyright_background_color':
            return sanitize_hex_color($value);
        case 'site_icon':
        case 'logo_upload':
        case 'retina_logo_upload':
        case 'newsletter_action_url':
            return esc_url_raw($value);
        case 'newsletter_email_field':
        case 'newsletter_success_message':
        case 'cookie_consent_button_text':
        case 'cookie_consent_learn_more_text':
            return sanitize_text_field($value);
        case 'newsletter_hidden_fields':
            return yiontech_lms_sanitize_hidden_fields($value);
        case 'custom_css':
            return wp_strip_all_tags($value);
        case 'copyright_text':
        case 'cookie_consent_text':
            return wp_kses_post($value);
        case 'header_style':
        case 'footer_style':
        case 'newsletter_method':
            return in_array($value, ['default', 'minimal', 'centered', 'post', 'get']) ? $value : $default;
        case 'enable_preloader':
        case 'transparent_header':
        case 'sticky_header':
        case 'enable_back_to_top':
        case 'newsletter_enable':
        case 'enable_privacy_features':
        case 'enable_data_export':
        case 'enable_account_deletion':
        case 'disable_gutenberg':
            return (bool) $value;
        case 'privacy_policy_page':
        case 'terms_of_service_page':
        case 'footer_elementor_template':
            return absint($value);
        case 'header_buttons':
            return yiontech_lms_sanitize_header_buttons($value);
        case 'header_menu':
            return yiontech_lms_sanitize_header_menu($value);
        case 'footer_content':
            return yiontech_lms_sanitize_footer_content($value);
        case 'footer_padding':
            return yiontech_lms_sanitize_footer_padding($value);
        default:
            return sanitize_text_field($value);
    }
}

// Sanitization functions
function yiontech_lms_sanitize_text($input) {
    return sanitize_text_field($input);
}

function yiontech_lms_sanitize_html($input) {
    return wp_kses_post($input);
}

function yiontech_lms_sanitize_url($input) {
    return esc_url_raw($input);
}

function yiontech_lms_sanitize_color($input) {
    return sanitize_hex_color($input);
}

function yiontech_lms_sanitize_checkbox($input) {
    return (bool) $input;
}

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

function yiontech_lms_sanitize_footer_content($input) {
    $sanitized = [];
    $defaults = yiontech_lms_get_default_settings()['footer_content'];

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

// Sanitize theme settings
function yiontech_lms_sanitize_settings($input) {
    $output = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());

    $fields = [
        'enable_preloader' => 'yiontech_lms_sanitize_checkbox',
        'site_icon' => 'yiontech_lms_sanitize_url',
        'header_style' => fn($v) => in_array($v, ['default', 'minimal', 'centered']) ? $v : 'default',
        'transparent_header' => 'yiontech_lms_sanitize_checkbox',
        'sticky_header' => 'yiontech_lms_sanitize_checkbox',
        'header_background_color' => 'yiontech_lms_sanitize_color',
        'sticky_header_background_color' => 'yiontech_lms_sanitize_color',
        'enable_back_to_top' => 'yiontech_lms_sanitize_checkbox',
        'logo_upload' => 'yiontech_lms_sanitize_url',
        'retina_logo_upload' => 'yiontech_lms_sanitize_url',
        'header_buttons' => 'yiontech_lms_sanitize_header_buttons',
        'header_menu' => 'yiontech_lms_sanitize_header_menu',
        'footer_style' => fn($v) => in_array($v, ['default', 'minimal', 'centered']) ? $v : 'default',
        'footer_elementor_template' => 'absint',
        'footer_content' => 'yiontech_lms_sanitize_footer_content',
        'copyright_text' => 'yiontech_lms_sanitize_html',
        'footer_text_color' => 'yiontech_lms_sanitize_color',
        'footer_background_color' => 'yiontech_lms_sanitize_color',
        'copyright_background_color' => 'yiontech_lms_sanitize_color',
        'footer_padding' => 'yiontech_lms_sanitize_footer_padding',
        'newsletter_enable' => 'yiontech_lms_sanitize_checkbox',
        'newsletter_action_url' => 'yiontech_lms_sanitize_url',
        'newsletter_method' => fn($v) => in_array($v, ['post', 'get']) ? $v : 'post',
        'newsletter_email_field' => 'yiontech_lms_sanitize_text',
        'newsletter_hidden_fields' => 'yiontech_lms_sanitize_hidden_fields',
        'newsletter_success_message' => 'yiontech_lms_sanitize_text',
        'custom_css' => fn($v) => wp_strip_all_tags($v),
        'enable_privacy_features' => 'yiontech_lms_sanitize_checkbox',
        'privacy_policy_page' => 'absint',
        'terms_of_service_page' => 'absint',
        'cookie_consent_text' => 'yiontech_lms_sanitize_html',
        'cookie_consent_button_text' => 'yiontech_lms_sanitize_text',
        'cookie_consent_learn_more_text' => 'yiontech_lms_sanitize_text',
        'enable_data_export' => 'yiontech_lms_sanitize_checkbox',
        'enable_account_deletion' => 'yiontech_lms_sanitize_checkbox',
        'disable_gutenberg' => 'yiontech_lms_sanitize_checkbox',
    ];

    foreach ($fields as $key => $sanitize_callback) {
        if (isset($input[$key])) {
            $output[$key] = call_user_func($sanitize_callback, $input[$key]);
        }
    }

    return apply_filters('yiontech_lms_sanitized_settings', $output, $input);
}

// Register settings, sections, and fields
function yiontech_lms_theme_settings_init() {
    register_setting('yiontech_lms_theme_settings', 'yiontech_lms_theme_settings', 'yiontech_lms_sanitize_settings');

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
            'description' => __('Disable the block editor (Gutenberg) for all posts and pages', 'yiontech-lms'),
            'label_for' => 'disable_gutenberg',
        ]
    );

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
add_action('admin_init', 'yiontech_lms_theme_settings_init');

// Customizer integration
function yiontech_lms_customize_register($wp_customize) {
    $wp_customize->add_section('yiontech_lms_general', [
        'title' => __('Yiontech LMS General', 'yiontech-lms'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('yiontech_lms_theme_settings[header_background_color]', [
        'default' => '#1e40af',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yiontech_lms_theme_settings[header_background_color]', [
        'label' => __('Header Background Color', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
    ]));

    $wp_customize->add_setting('yiontech_lms_theme_settings[footer_background_color]', [
        'default' => '#111827',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yiontech_lms_theme_settings[footer_background_color]', [
        'label' => __('Footer Background Color', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
    ]));

    $wp_customize->add_setting('yiontech_lms_theme_settings[logo_upload]', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'yiontech_lms_theme_settings[logo_upload]', [
        'label' => __('Logo Upload', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
        'settings' => 'yiontech_lms_theme_settings[logo_upload]',
        'description' => __('Upload your logo (recommended 200x36px)', 'yiontech-lms'),
    ]));
}
add_action('customize_register', 'yiontech_lms_customize_register');

// Field callbacks
function yiontech_lms_checkbox_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? false;
    ?>
    <label for="<?php echo esc_attr($args['label_for']); ?>">
        <input type="checkbox" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="1" <?php checked($value, true); ?> aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        <?php echo esc_html($args['description']); ?>
    </label>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? '';
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <?php foreach ($args['options'] as $option_value => $label): ?>
            <option value="<?php echo esc_attr($option_value); ?>" <?php selected($value, $option_value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_color_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? '#ffffff';
    ?>
    <input type="color" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="yiontech-color-field" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_text_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? '';
    ?>
    <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_textarea_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? '';
    $rows  = $args['rows'] ?? 5;

    // Fix: convert array values into a readable string
    if (is_array($value)) {
        $value = implode(", ", $value); // join array items with comma and space
    }
    ?>
    <textarea 
        id="<?php echo esc_attr($args['label_for']); ?>" 
        name="<?php echo esc_attr($args['name']); ?>" 
        rows="<?php echo esc_attr($rows); ?>" 
        class="large-text" 
        aria-describedby="<?php echo esc_attr($args['id']); ?>-description"
    ><?php echo esc_textarea($value); ?></textarea>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description">
        <?php echo esc_html($args['description']); ?>
    </p>
    <?php
}

function yiontech_lms_media_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? '';
    $media_id = attachment_url_to_postid($value);
    ?>
    <div class="media-field" data-field-id="<?php echo esc_attr($args['id']); ?>">
        <input type="hidden" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        <div class="media-preview">
            <?php if ($value): ?>
                <img src="<?php echo esc_url($value); ?>" alt="<?php echo esc_attr($args['description']); ?>" style="max-width: 200px; max-height: 100px;" />
            <?php endif; ?>
        </div>
        <button type="button" class="button media-upload-button"><?php _e('Upload', 'yiontech-lms'); ?></button>
        <button type="button" class="button media-remove-button" style="<?php echo $value ? '' : 'display:none;'; ?>"><?php _e('Remove', 'yiontech-lms'); ?></button>
        <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

function yiontech_lms_spacing_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? ['top' => 48, 'bottom' => 48];
    $top = $value['top'] ?? 48;
    $bottom = $value['bottom'] ?? 48;
    ?>
    <div class="spacing-field">
        <div>
            <label for="<?php echo esc_attr($args['label_for']); ?>"><?php _e('Top (px):', 'yiontech-lms'); ?></label>
            <input type="number" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>[top]" value="<?php echo esc_attr($top); ?>" min="0" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id']); ?>_bottom"><?php _e('Bottom (px):', 'yiontech-lms'); ?></label>
            <input type="number" id="<?php echo esc_attr($args['id']); ?>_bottom" name="<?php echo esc_attr($args['name']); ?>[bottom]" value="<?php echo esc_attr($bottom); ?>" min="0" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        </div>
    </div>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_header_buttons_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $buttons = $options[$args['id']] ?? [];
    ?>
    <div class="header-buttons-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="header-buttons">
            <?php foreach ($buttons as $index => $button): ?>
                <div class="header-button-item" data-index="<?php echo esc_attr($index); ?>">
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>"><?php _e('Button Text:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($button['text']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>"><?php _e('Button URL:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($button['url']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-style'); ?>"><?php _e('Button Style:', 'yiontech-lms'); ?></label>
                        <select id="<?php echo esc_attr($args['id'] . '-' . $index . '-style'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][style]">
                            <option value="solid" <?php selected($button['style'], 'solid'); ?>><?php _e('Solid', 'yiontech-lms'); ?></option>
                            <option value="outline" <?php selected($button['style'], 'outline'); ?>><?php _e('Outline', 'yiontech-lms'); ?></option>
                        </select>
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-show-desktop'); ?>">
                            <input type="checkbox" id="<?php echo esc_attr($args['id'] . '-' . $index . '-show-desktop'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_desktop]" value="1" <?php checked($button['show_desktop'] ?? true, true); ?> />
                            <?php _e('Show on Desktop', 'yiontech-lms'); ?>
                        </label>
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-show-mobile'); ?>">
                            <input type="checkbox" id="<?php echo esc_attr($args['id'] . '-' . $index . '-show-mobile'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_mobile]" value="1" <?php checked($button['show_mobile'] ?? true, true); ?> />
                            <?php _e('Show on Mobile', 'yiontech-lms'); ?>
                        </label>
                    </div>
                    <button type="button" class="button remove-button"><?php _e('Remove Button', 'yiontech-lms'); ?></button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button add-button"><?php _e('Add Button', 'yiontech-lms'); ?></button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($buttons)); ?>" />
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

function yiontech_lms_menu_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $menu_items = $options[$args['id']] ?? [];
    ?>
    <div class="menu-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="menu-items">
            <?php foreach ($menu_items as $index => $item): ?>
                <div class="menu-item" data-index="<?php echo esc_attr($index); ?>">
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>"><?php _e('Menu Text:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($item['text']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>"><?php _e('Menu URL:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($item['url']); ?>" class="regular-text" />
                    </div>
                    <button type="button" class="button remove-menu-item"><?php _e('Remove', 'yiontech-lms'); ?></button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button add-menu-item"><?php _e('Add Menu Item', 'yiontech-lms'); ?></button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($menu_items)); ?>" />
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

function yiontech_lms_elementor_template_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? 0;

    $all_templates = [];
    if (did_action('elementor/loaded')) {
        $all_templates = get_posts([
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    $theme_builder_templates = [];
    $regular_templates = [];
    foreach ($all_templates as $template) {
        $template_type = get_post_meta($template->ID, '_elementor_template_type', true);
        if ($template_type === 'footer') {
            $theme_builder_templates[] = $template;
        } else {
            $regular_templates[] = $template;
        }
    }
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <option value="0"><?php _e('— Default Theme Footer —', 'yiontech-lms'); ?></option>
        <?php if (!empty($theme_builder_templates)): ?>
            <optgroup label="<?php esc_attr_e('Theme Builder Footer Templates', 'yiontech-lms'); ?>">
                <?php foreach ($theme_builder_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
        <?php if (!empty($regular_templates)): ?>
            <optgroup label="<?php esc_attr_e('Other Elementor Templates', 'yiontech-lms'); ?>">
                <?php foreach ($regular_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php if (empty($all_templates)): ?>
        <p class="description"><?php _e('No templates found. Create templates in Elementor > Templates.', 'yiontech-lms'); ?></p>
    <?php else: ?>
        <p class="description"><?php _e('Create templates in Elementor > Templates or Elementor > Theme Builder.', 'yiontech-lms'); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_footer_content_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $footer_content = $options[$args['id']] ?? yiontech_lms_get_default_settings()['footer_content'];
    ?>
    <div class="footer-content-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <!-- Column 1 -->
        <h4><?php _e('Column 1', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column1-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column1-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column1][title]" value="<?php echo esc_attr($footer_content['column1']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column1-content'); ?>"><?php _e('Content:', 'yiontech-lms'); ?></label>
            <textarea id="<?php echo esc_attr($args['id'] . '-column1-content'); ?>" name="<?php echo esc_attr($args['name']); ?>[column1][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column1']['content'] ?? ''); ?></textarea>
        </div>

        <!-- Column 2 -->
        <h4><?php _e('Column 2', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column2-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column2-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column2][title]" value="<?php echo esc_attr($footer_content['column2']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column2">
                <?php foreach ($footer_content['column2']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column2"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column2" value="<?php echo esc_attr(count($footer_content['column2']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 3 -->
        <h4><?php _e('Column 3', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column3-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column3-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column3][title]" value="<?php echo esc_attr($footer_content['column3']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column3">
                <?php foreach ($footer_content['column3']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column3"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column3" value="<?php echo esc_attr(count($footer_content['column3']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 4 -->
        <h4><?php _e('Column 4', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column4-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column4-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column4][title]" value="<?php echo esc_attr($footer_content['column4']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column4">
                <?php foreach ($footer_content['column4']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column4"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column4" value="<?php echo esc_attr(count($footer_content['column4']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 5 -->
        <h4><?php _e('Column 5', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column5-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][title]" value="<?php echo esc_attr($footer_content['column5']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-content'); ?>"><?php _e('Content:', 'yiontech-lms'); ?></label>
            <textarea id="<?php echo esc_attr($args['id'] . '-column5-content'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column5']['content'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-email'); ?>"><?php _e('Email:', 'yiontech-lms'); ?></label>
            <input type="email" id="<?php echo esc_attr($args['id'] . '-column5-email'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][email]" value="<?php echo esc_attr($footer_content['column5']['email'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-phone'); ?>"><?php _e('Phone:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column5-phone'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][phone]" value="<?php echo esc_attr($footer_content['column5']['phone'] ?? ''); ?>" class="regular-text" />
        </div>
    </div>
    <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

function yiontech_lms_page_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    $value = $options[$args['id']] ?? 0;
    $pages = get_pages();
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <option value="0"><?php _e('— Select —', 'yiontech-lms'); ?></option>
        <?php foreach ($pages as $page): ?>
            <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($value, $page->ID); ?>><?php echo esc_html($page->post_title); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Section callbacks
function yiontech_lms_general_section_callback() {
    echo '<p>' . esc_html__('General theme settings', 'yiontech-lms') . '</p>';
}

function yiontech_lms_header_section_callback() {
    echo '<p>' . esc_html__('Configure your website header', 'yiontech-lms') . '</p>';
}

function yiontech_lms_footer_section_callback() {
    echo '<p>' . esc_html__('Configure your website footer', 'yiontech-lms') . '</p>';
}

function yiontech_lms_newsletter_section_callback() {
    echo '<p>' . esc_html__('Newsletter configuration settings', 'yiontech-lms') . '</p>';
}

function yiontech_lms_privacy_section_callback() {
    echo '<p>' . esc_html__('Configure privacy settings for GDPR compliance', 'yiontech-lms') . '</p>';
}

function yiontech_lms_css_editor_section_callback() {
    echo '<p>' . esc_html__('Add custom CSS to your theme', 'yiontech-lms') . '</p>';
}

// Add theme settings page to admin menu
function yiontech_lms_add_theme_settings_page() {
    add_menu_page(
        __('Yiontech LMS Settings', 'yiontech-lms'),
        __('Yiontech LMS', 'yiontech-lms'),
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page',
        'dashicons-admin-settings',
        5
    );

    add_submenu_page(
        'theme-settings-general',
        __('General Settings', 'yiontech-lms'),
        __('General', 'yiontech-lms'),
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Header Settings', 'yiontech-lms'),
        __('Header', 'yiontech-lms'),
        'manage_options',
        'theme-settings-header',
        'yiontech_lms_header_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Footer Settings', 'yiontech-lms'),
        __('Footer', 'yiontech-lms'),
        'manage_options',
        'theme-settings-footer',
        'yiontech_lms_footer_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Newsletter Settings', 'yiontech-lms'),
        __('Newsletter', 'yiontech-lms'),
        'manage_options',
        'theme-settings-newsletter',
        'yiontech_lms_newsletter_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Privacy Settings', 'yiontech-lms'),
        __('Privacy', 'yiontech-lms'),
        'manage_options',
        'theme-settings-privacy',
        'yiontech_lms_privacy_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('CSS Editor', 'yiontech-lms'),
        __('CSS Editor', 'yiontech-lms'),
        'manage_options',
        'theme-settings-css',
        'yiontech_lms_css_settings_page'
    );
}
add_action('admin_menu', 'yiontech_lms_add_theme_settings_page');

// Helper function to output hidden fields for preserving settings
function yiontech_lms_output_hidden_fields($exclude_fields = []) {
    $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    foreach ($options as $key => $value) {
        if (!in_array($key, $exclude_fields)) {
            if (is_array($value)) {
                $value = wp_json_encode($value, JSON_UNESCAPED_SLASHES);
            }
            ?>
            <input type="hidden" name="yiontech_lms_theme_settings[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>" />
            <?php
        }
    }
}

// General settings page
function yiontech_lms_general_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Yiontech LMS Theme Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['enable_preloader', 'site_icon', 'enable_back_to_top', 'disable_gutenberg']);
                yiontech_lms_output_settings_section('yiontech_lms_general_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Header settings page
function yiontech_lms_header_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Header Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['header_style', 'transparent_header', 'sticky_header', 'header_background_color', 'sticky_header_background_color', 'logo_upload', 'retina_logo_upload', 'header_buttons', 'header_menu']);
                yiontech_lms_output_settings_section('yiontech_lms_header_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Footer settings page
function yiontech_lms_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Footer Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['footer_style', 'footer_elementor_template', 'footer_content', 'copyright_text', 'footer_text_color', 'footer_background_color', 'copyright_background_color', 'footer_padding']);
                yiontech_lms_output_settings_section('yiontech_lms_footer_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Newsletter settings page
function yiontech_lms_newsletter_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Newsletter Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['newsletter_enable', 'newsletter_action_url', 'newsletter_method', 'newsletter_email_field', 'newsletter_hidden_fields', 'newsletter_success_message']);
                yiontech_lms_output_settings_section('yiontech_lms_newsletter_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Privacy settings page
function yiontech_lms_privacy_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Privacy Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['enable_privacy_features', 'privacy_policy_page', 'terms_of_service_page', 'cookie_consent_text', 'cookie_consent_button_text', 'cookie_consent_learn_more_text', 'enable_data_export', 'enable_account_deletion']);
                yiontech_lms_output_settings_section('yiontech_lms_privacy_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// CSS settings page
function yiontech_lms_css_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('CSS Editor', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['custom_css']);
                yiontech_lms_output_settings_section('yiontech_lms_css_editor_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Helper function to output a specific settings section
function yiontech_lms_output_settings_section($section_id) {
    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections['yiontech_lms_theme_settings'][$section_id])) {
        return;
    }

    $section = $wp_settings_sections['yiontech_lms_theme_settings'][$section_id];
    ?>
    <div class="settings-section">
        <h2><?php echo esc_html($section['title']); ?></h2>
        <?php
        if (!empty($section['callback']) && is_callable($section['callback'])) {
            call_user_func($section['callback'], $section);
        }

        if (isset($wp_settings_fields['yiontech_lms_theme_settings'][$section_id])) {
            ?>
            <table class="form-table" role="presentation">
                <?php
                foreach ((array) $wp_settings_fields['yiontech_lms_theme_settings'][$section_id] as $field) {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php if (!empty($field['args']['label_for'])): ?>
                                <label for="<?php echo esc_attr($field['args']['label_for']); ?>"><?php echo esc_html($field['title']); ?></label>
                            <?php else: ?>
                                <?php echo esc_html($field['title']); ?>
                            <?php endif; ?>
                        </th>
                        <td>
                            <?php call_user_func($field['callback'], $field['args']); ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        ?>
    </div>
    <?php
}

// Enqueue admin scripts and styles
function yiontech_lms_admin_enqueue_scripts($hook) {
    if (strpos($hook, 'theme-settings') === false) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_script(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/js/admin.js',
        ['jquery', 'wp-color-picker'],
        '1.0.1',
        true
    );

    wp_enqueue_style(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/css/admin.css',
        ['wp-color-picker'],
        '1.0.1'
    );

    wp_localize_script('yiontech-lms-admin', 'yiontech_lms_admin', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('yiontech_lms_admin_nonce'),
        'i18n' => [
            'upload' => __('Upload', 'yiontech-lms'),
            'remove' => __('Remove', 'yiontech-lms'),
            'add_button' => __('Add Button', 'yiontech-lms'),
            'remove_button' => __('Remove Button', 'yiontech-lms'),
            'add_menu_item' => __('Add Menu Item', 'yiontech-lms'),
            'remove_menu_item' => __('Remove', 'yiontech-lms'),
            'add_link' => __('Add Link', 'yiontech-lms'),
            'remove_link' => __('Remove', 'yiontech-lms'),
        ],
    ]);
}
add_action('admin_enqueue_scripts', 'yiontech_lms_admin_enqueue_scripts');

// Output custom CSS
function yiontech_lms_output_custom_css() {
    $custom_css = yiontech_lms_get_theme_setting('custom_css');
    if (!empty($custom_css)) {
        // Minify CSS (basic minification, consider a library like CSSMin for production)
        $custom_css = preg_replace('/\s+/', ' ', $custom_css);
        $custom_css = trim($custom_css);
        ?>
        <style id="yiontech-lms-custom-css">
            .yiontech-lms { <?php echo esc_html($custom_css); ?> }
        </style>
        <?php
    }
}
add_action('wp_head', 'yiontech_lms_output_custom_css', 100);

// Gutenberg support
function yiontech_lms_gutenberg_support() {
    if (!yiontech_lms_get_theme_setting('disable_gutenberg')) {
        add_theme_support('align-wide');
        add_theme_support('block-template-parts');
        add_theme_support('wp-block-styles');
    }
}
add_action('after_setup_theme', 'yiontech_lms_gutenberg_support');
?>