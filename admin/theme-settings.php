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
    return array(
        'enable_preloader' => 1,
        'site_icon' => '',
        'header_style' => 'default',
        'transparent_header' => 0,
        'sticky_header' => 1,
        'header_background_color' => '#1e40af',
        'sticky_header_background_color' => '#1e40af',
        'enable_back_to_top' => 1,
        'logo_upload' => '',
        'retina_logo_upload' => '',
        'header_buttons' => array(
            array(
                'text' => 'Login',
                'url' => '/login',
                'style' => 'outline',
                'show_desktop' => true,
                'show_mobile' => false,
            ),
            array(
                'text' => 'Enquire Now',
                'url' => '/contact',
                'style' => 'solid',
                'show_desktop' => true,
                'show_mobile' => true,
            ),
        ),
        'header_menu' => array(
            array('text' => 'Home', 'url' => '/'),
            array('text' => 'Courses', 'url' => '/courses'),
            array('text' => 'About', 'url' => '/about'),
            array('text' => 'Contact', 'url' => '/contact'),
        ),
        'footer_style' => 'default',
        'footer_content' => array(
            'column1' => array(
                'title' => 'About Us',
                'content' => 'A powerful learning management system designed for educators and students.',
            ),
            'column2' => array(
                'title' => 'Quick Links',
                'links' => array(
                    array('text' => 'Home', 'url' => '/'),
                    array('text' => 'Courses', 'url' => '/courses'),
                    array('text' => 'About', 'url' => '/about'),
                    array('text' => 'Contact', 'url' => '/contact'),
                ),
            ),
            'column3' => array(
                'title' => 'Company',
                'links' => array(
                    array('text' => 'About Us', 'url' => '/about'),
                    array('text' => 'Our Team', 'url' => '/team'),
                    array('text' => 'Careers', 'url' => '/careers'),
                    array('text' => 'Blog', 'url' => '/blog'),
                ),
            ),
            'column4' => array(
                'title' => 'User Portal',
                'links' => array(
                    array('text' => 'Login', 'url' => '/login'),
                    array('text' => 'Register', 'url' => '/register'),
                    array('text' => 'Dashboard', 'url' => '/dashboard'),
                    array('text' => 'Profile', 'url' => '/profile'),
                ),
            ),
            'column5' => array(
                'title' => 'Newsletter',
                'content' => 'Get the latest news and updates delivered right to your inbox.',
                'email' => 'info@yiontech.com',
                'phone' => '+1 (555) 123-4567',
            ),
        ),
        'copyright_text' => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.',
        'footer_text_color' => '#ffffff',
        'footer_background_color' => '#111827',
        'copyright_background_color' => '#0f172a',
        'footer_padding' => array('top' => 48, 'bottom' => 48),
        'newsletter_enable' => 0,
        'newsletter_action_url' => '',
        'newsletter_method' => 'post',
        'newsletter_email_field' => 'email',
        'newsletter_hidden_fields' => '',
        'newsletter_success_message' => 'Thank you for subscribing!',
        'custom_css' => '',
        // Privacy Settings
        'enable_privacy_features' => 1,
        'privacy_policy_page' => 0,
        'terms_of_service_page' => 0,
        'cookie_consent_text' => 'We use cookies to ensure you get the best experience on our website. By continuing to use this site, you consent to our use of cookies.',
        'cookie_consent_button_text' => 'Accept',
        'cookie_consent_learn_more_text' => 'Learn More',
        'enable_data_export' => 1,
        'enable_account_deletion' => 1,
    );
}

// Get theme setting with default fallback
function yiontech_lms_get_theme_setting($key, $default = '') {
    $defaults = yiontech_lms_get_default_settings();
    $options = get_option('yiontech_lms_theme_settings', $defaults);
    
    // Debug: Log the options
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('yiontech_lms_theme_settings: ' . print_r($options, true));
    }
    
    // If key exists in options, return it
    if (isset($options[$key])) {
        return $options[$key];
    }
    
    // Otherwise, return default from defaults array
    if (isset($defaults[$key])) {
        return $defaults[$key];
    }
    
    // Finally, return the provided default
    return $default;
}

// Sanitize theme settings
function yiontech_lms_sanitize_settings($input) {
    // Get current settings to preserve values not being updated
    $current_options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    
    // Start with current options
    $output = $current_options;
    
    // Sanitize individual fields only if they exist in input
    if (isset($input['enable_preloader'])) {
        $output['enable_preloader'] = $input['enable_preloader'] ? 1 : 0;
    }
    
    if (isset($input['site_icon'])) {
        $output['site_icon'] = esc_url_raw($input['site_icon']);
    }
    
    if (isset($input['header_style'])) {
        $output['header_style'] = in_array($input['header_style'], array('default', 'minimal', 'centered')) ? $input['header_style'] : $current_options['header_style'];
    }
    
    if (isset($input['transparent_header'])) {
        $output['transparent_header'] = $input['transparent_header'] ? 1 : 0;
    }
    
    if (isset($input['sticky_header'])) {
        $output['sticky_header'] = $input['sticky_header'] ? 1 : 0;
    }
    
    if (isset($input['header_background_color'])) {
        $output['header_background_color'] = sanitize_hex_color($input['header_background_color']);
    }
    
    if (isset($input['sticky_header_background_color'])) {
        $output['sticky_header_background_color'] = sanitize_hex_color($input['sticky_header_background_color']);
    }
    
    if (isset($input['enable_back_to_top'])) {
        $output['enable_back_to_top'] = $input['enable_back_to_top'] ? 1 : 0;
    }
    
    if (isset($input['logo_upload'])) {
        $output['logo_upload'] = esc_url_raw($input['logo_upload']);
    }
    
    if (isset($input['retina_logo_upload'])) {
        $output['retina_logo_upload'] = esc_url_raw($input['retina_logo_upload']);
    }
    
    // Sanitize header buttons
    if (isset($input['header_buttons']) && is_array($input['header_buttons'])) {
        $output['header_buttons'] = array();
        foreach ($input['header_buttons'] as $button) {
            if (!empty($button['text']) && !empty($button['url'])) {
                $output['header_buttons'][] = array(
                    'text' => sanitize_text_field($button['text']),
                    'url' => esc_url_raw($button['url']),
                    'style' => isset($button['style']) && in_array($button['style'], array('solid', 'outline')) ? $button['style'] : 'solid',
                    'show_desktop' => isset($button['show_desktop']) ? 1 : 0,
                    'show_mobile' => isset($button['show_mobile']) ? 1 : 0,
                );
            }
        }
    }
    
    // Sanitize header menu
    if (isset($input['header_menu']) && is_array($input['header_menu'])) {
        $output['header_menu'] = array();
        foreach ($input['header_menu'] as $item) {
            if (!empty($item['text']) && !empty($item['url'])) {
                $output['header_menu'][] = array(
                    'text' => sanitize_text_field($item['text']),
                    'url' => esc_url_raw($item['url']),
                );
            }
        }
    }
    
    // Sanitize footer settings
    if (isset($input['footer_style'])) {
        $output['footer_style'] = in_array($input['footer_style'], array('default', 'minimal', 'centered')) ? $input['footer_style'] : $current_options['footer_style'];
    }
    
    if (isset($input['copyright_text'])) {
        $output['copyright_text'] = wp_kses_post($input['copyright_text']);
    }
    
    if (isset($input['footer_text_color'])) {
        $output['footer_text_color'] = sanitize_hex_color($input['footer_text_color']);
    }
    
    if (isset($input['footer_background_color'])) {
        $output['footer_background_color'] = sanitize_hex_color($input['footer_background_color']);
    }
    
    if (isset($input['copyright_background_color'])) {
        $output['copyright_background_color'] = sanitize_hex_color($input['copyright_background_color']);
    }
    
    // Sanitize footer padding
    if (isset($input['footer_padding']) && is_array($input['footer_padding'])) {
        $output['footer_padding'] = array(
            'top' => isset($input['footer_padding']['top']) ? absint($input['footer_padding']['top']) : $current_options['footer_padding']['top'],
            'bottom' => isset($input['footer_padding']['bottom']) ? absint($input['footer_padding']['bottom']) : $current_options['footer_padding']['bottom'],
        );
    }
    
    // Sanitize footer content
    if (isset($input['footer_content']) && is_array($input['footer_content'])) {
        // Column 1
        if (isset($input['footer_content']['column1'])) {
            $output['footer_content']['column1'] = array(
                'title' => isset($input['footer_content']['column1']['title']) ? sanitize_text_field($input['footer_content']['column1']['title']) : $current_options['footer_content']['column1']['title'],
                'content' => isset($input['footer_content']['column1']['content']) ? wp_kses_post($input['footer_content']['column1']['content']) : $current_options['footer_content']['column1']['content'],
            );
        }
        
        // Columns 2-4 with links
        for ($i = 2; $i <= 4; $i++) {
            $column_key = 'column' . $i;
            if (isset($input['footer_content'][$column_key]) && isset($input['footer_content'][$column_key]['links']) && is_array($input['footer_content'][$column_key]['links'])) {
                $output['footer_content'][$column_key] = array(
                    'title' => isset($input['footer_content'][$column_key]['title']) ? sanitize_text_field($input['footer_content'][$column_key]['title']) : $current_options['footer_content'][$column_key]['title'],
                    'links' => array(),
                );
                
                foreach ($input['footer_content'][$column_key]['links'] as $link) {
                    if (!empty($link['text']) && !empty($link['url'])) {
                        $output['footer_content'][$column_key]['links'][] = array(
                            'text' => sanitize_text_field($link['text']),
                            'url' => esc_url_raw($link['url']),
                        );
                    }
                }
            }
        }
        
        // Column 5
        if (isset($input['footer_content']['column5'])) {
            $output['footer_content']['column5'] = array(
                'title' => isset($input['footer_content']['column5']['title']) ? sanitize_text_field($input['footer_content']['column5']['title']) : $current_options['footer_content']['column5']['title'],
                'content' => isset($input['footer_content']['column5']['content']) ? wp_kses_post($input['footer_content']['column5']['content']) : $current_options['footer_content']['column5']['content'],
                'email' => isset($input['footer_content']['column5']['email']) ? sanitize_email($input['footer_content']['column5']['email']) : $current_options['footer_content']['column5']['email'],
                'phone' => isset($input['footer_content']['column5']['phone']) ? sanitize_text_field($input['footer_content']['column5']['phone']) : $current_options['footer_content']['column5']['phone'],
            );
        }
    }
    
    // Sanitize newsletter settings
    if (isset($input['newsletter_enable'])) {
        $output['newsletter_enable'] = $input['newsletter_enable'] ? 1 : 0;
    }
    
    if (isset($input['newsletter_action_url'])) {
        $output['newsletter_action_url'] = esc_url_raw($input['newsletter_action_url']);
    }
    
    if (isset($input['newsletter_method'])) {
        $output['newsletter_method'] = in_array($input['newsletter_method'], array('post', 'get')) ? $input['newsletter_method'] : $current_options['newsletter_method'];
    }
    
    if (isset($input['newsletter_email_field'])) {
        $output['newsletter_email_field'] = sanitize_text_field($input['newsletter_email_field']);
    }
    
    if (isset($input['newsletter_hidden_fields'])) {
        $output['newsletter_hidden_fields'] = sanitize_textarea_field($input['newsletter_hidden_fields']);
    }
    
    if (isset($input['newsletter_success_message'])) {
        $output['newsletter_success_message'] = sanitize_textarea_field($input['newsletter_success_message']);
    }
    
    // Sanitize custom CSS
    if (isset($input['custom_css'])) {
        $output['custom_css'] = wp_strip_all_tags($input['custom_css']);
    }
    
    // Sanitize privacy settings
    if (isset($input['enable_privacy_features'])) {
        $output['enable_privacy_features'] = $input['enable_privacy_features'] ? 1 : 0;
    }
    
    if (isset($input['privacy_policy_page'])) {
        $output['privacy_policy_page'] = absint($input['privacy_policy_page']);
    }
    
    if (isset($input['terms_of_service_page'])) {
        $output['terms_of_service_page'] = absint($input['terms_of_service_page']);
    }
    
    if (isset($input['cookie_consent_text'])) {
        $output['cookie_consent_text'] = wp_kses_post($input['cookie_consent_text']);
    }
    
    if (isset($input['cookie_consent_button_text'])) {
        $output['cookie_consent_button_text'] = sanitize_text_field($input['cookie_consent_button_text']);
    }
    
    if (isset($input['cookie_consent_learn_more_text'])) {
        $output['cookie_consent_learn_more_text'] = sanitize_text_field($input['cookie_consent_learn_more_text']);
    }
    
    if (isset($input['enable_data_export'])) {
        $output['enable_data_export'] = $input['enable_data_export'] ? 1 : 0;
    }
    
    if (isset($input['enable_account_deletion'])) {
        $output['enable_account_deletion'] = $input['enable_account_deletion'] ? 1 : 0;
    }
    
    return $output;
}

// Register settings, sections, and fields
function yiontech_lms_theme_settings_init() {
    // Register settings with sanitization
    register_setting('yiontech_lms_theme_settings', 'yiontech_lms_theme_settings', 'yiontech_lms_sanitize_settings');

    // General section
    add_settings_section(
        'yiontech_lms_general_section',
        'General',
        'yiontech_lms_general_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Preloader
    add_settings_field(
        'enable_preloader',
        'Enable Preloader',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        array(
            'id' => 'enable_preloader',
            'name' => 'yiontech_lms_theme_settings[enable_preloader]',
            'description' => 'Enable preloader for the site',
        )
    );

    // Site Icon
    add_settings_field(
        'site_icon',
        'Site Icon (Favicon)',
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        array(
            'id' => 'site_icon',
            'name' => 'yiontech_lms_theme_settings[site_icon]',
            'description' => 'Upload site icon for browser tab',
        )
    );

    // Enable Back to Top (moved to general section)
    add_settings_field(
        'enable_back_to_top',
        'Enable Back to Top Button',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_general_section',
        array(
            'id' => 'enable_back_to_top',
            'name' => 'yiontech_lms_theme_settings[enable_back_to_top]',
            'description' => 'Enable back to top button',
        )
    );

    // Header section
    add_settings_section(
        'yiontech_lms_header_section',
        'Header',
        'yiontech_lms_header_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Header Style
    add_settings_field(
        'header_style',
        'Select Header Style',
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'header_style',
            'name' => 'yiontech_lms_theme_settings[header_style]',
            'options' => array(
                'default' => 'Default Header',
                'minimal' => 'Minimal Header',
                'centered' => 'Centered Logo Header',
            ),
            'description' => 'Choose header style',
        )
    );

    // Transparent Header
    add_settings_field(
        'transparent_header',
        'Transparent Header',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'transparent_header',
            'name' => 'yiontech_lms_theme_settings[transparent_header]',
            'description' => 'Make header transparent on homepage',
        )
    );

    // Sticky Header
    add_settings_field(
        'sticky_header',
        'Sticky Header On/Off',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'sticky_header',
            'name' => 'yiontech_lms_theme_settings[sticky_header]',
            'description' => 'Enable sticky header',
        )
    );

    // Header Background Color
    add_settings_field(
        'header_background_color',
        'Header Background Color',
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'header_background_color',
            'name' => 'yiontech_lms_theme_settings[header_background_color]',
            'description' => 'Choose header background color',
        )
    );

    // Sticky Header Background Color
    add_settings_field(
        'sticky_header_background_color',
        'Sticky Header Background Color',
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'sticky_header_background_color',
            'name' => 'yiontech_lms_theme_settings[sticky_header_background_color]',
            'description' => 'Choose sticky header background color',
        )
    );

    // Logo Upload
    add_settings_field(
        'logo_upload',
        'Logo Upload',
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'logo_upload',
            'name' => 'yiontech_lms_theme_settings[logo_upload]',
            'description' => 'Upload your logo',
        )
    );

    // Retina Logo Upload
    add_settings_field(
        'retina_logo_upload',
        'Retina Logo Upload @2x',
        'yiontech_lms_media_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'retina_logo_upload',
            'name' => 'yiontech_lms_theme_settings[retina_logo_upload]',
            'description' => 'Upload retina version of your logo (2x size)',
        )
    );

    // Header Buttons
    add_settings_field(
        'header_buttons',
        'Header Buttons',
        'yiontech_lms_header_buttons_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'header_buttons',
            'name' => 'yiontech_lms_theme_settings[header_buttons]',
            'description' => 'Configure header buttons',
        )
    );

    // Header Menu
    add_settings_field(
        'header_menu',
        'Header Menu',
        'yiontech_lms_menu_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_header_section',
        array(
            'id' => 'header_menu',
            'name' => 'yiontech_lms_theme_settings[header_menu]',
            'description' => 'Configure header menu items',
        )
    );

    // Footer section
    add_settings_section(
        'yiontech_lms_footer_section',
        'Footer',
        'yiontech_lms_footer_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Footer Style
    add_settings_field(
        'footer_style',
        'Select Footer Style',
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'footer_style',
            'name' => 'yiontech_lms_theme_settings[footer_style]',
            'options' => array(
                'default' => 'Default Footer',
                'minimal' => 'Minimal Footer',
                'centered' => 'Centered Footer',
            ),
            'description' => 'Choose footer style',
        )
    );

    // Footer Content
    add_settings_field(
        'footer_content',
        'Footer Content',
        'yiontech_lms_footer_content_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'footer_content',
            'name' => 'yiontech_lms_theme_settings[footer_content]',
            'description' => 'Configure footer columns and content',
        )
    );

    // Copyright Text
    add_settings_field(
        'copyright_text',
        'Copyright Text',
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'copyright_text',
            'name' => 'yiontech_lms_theme_settings[copyright_text]',
            'description' => 'Enter copyright text',
        )
    );

    // Footer Text Color
    add_settings_field(
        'footer_text_color',
        'Footer Text Color',
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'footer_text_color',
            'name' => 'yiontech_lms_theme_settings[footer_text_color]',
            'description' => 'Choose footer text color',
        )
    );

    // Footer Background Color
    add_settings_field(
        'footer_background_color',
        'Footer Background Color',
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'footer_background_color',
            'name' => 'yiontech_lms_theme_settings[footer_background_color]',
            'description' => 'Choose footer background color',
        )
    );

    // Copyright Background Color
    add_settings_field(
        'copyright_background_color',
        'Copyright Background Color',
        'yiontech_lms_color_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'copyright_background_color',
            'name' => 'yiontech_lms_theme_settings[copyright_background_color]',
            'description' => 'Choose copyright section background color',
        )
    );

    // Footer Padding
    add_settings_field(
        'footer_padding',
        'Padding Top/Bottom',
        'yiontech_lms_spacing_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_footer_section',
        array(
            'id' => 'footer_padding',
            'name' => 'yiontech_lms_theme_settings[footer_padding]',
            'description' => 'Set footer padding top and bottom (in pixels)',
        )
    );

    // Newsletter section
    add_settings_section(
        'yiontech_lms_newsletter_section',
        'Newsletter',
        'yiontech_lms_newsletter_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Newsletter Enable
    add_settings_field(
        'newsletter_enable',
        'Enable Newsletter',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_enable',
            'name' => 'yiontech_lms_theme_settings[newsletter_enable]',
            'description' => 'Enable newsletter subscription',
        )
    );

    // Newsletter Action URL
    add_settings_field(
        'newsletter_action_url',
        'Newsletter Action URL',
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_action_url',
            'name' => 'yiontech_lms_theme_settings[newsletter_action_url]',
            'description' => 'Enter the form action URL (e.g., Mailchimp, ConvertKit, etc.)',
        )
    );

    // Newsletter Method
    add_settings_field(
        'newsletter_method',
        'Form Method',
        'yiontech_lms_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_method',
            'name' => 'yiontech_lms_theme_settings[newsletter_method]',
            'options' => array(
                'post' => 'POST',
                'get' => 'GET',
            ),
            'description' => 'Choose form submission method',
        )
    );

    // Newsletter Email Field Name
    add_settings_field(
        'newsletter_email_field',
        'Email Field Name',
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_email_field',
            'name' => 'yiontech_lms_theme_settings[newsletter_email_field]',
            'description' => 'Enter the name attribute for the email field (e.g., EMAIL, email, etc.)',
        )
    );

    // Newsletter Hidden Fields
    add_settings_field(
        'newsletter_hidden_fields',
        'Hidden Fields',
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_hidden_fields',
            'name' => 'yiontech_lms_theme_settings[newsletter_hidden_fields]',
            'description' => 'Enter any hidden fields required by your newsletter service (one per line in format: name=value)',
            'rows' => 5,
        )
    );

    // Newsletter Success Message
    add_settings_field(
        'newsletter_success_message',
        'Success Message',
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_newsletter_section',
        array(
            'id' => 'newsletter_success_message',
            'name' => 'yiontech_lms_theme_settings[newsletter_success_message]',
            'description' => 'Enter the message to show after successful subscription',
            'rows' => 3,
        )
    );

    // Privacy section
    add_settings_section(
        'yiontech_lms_privacy_section',
        'Privacy Settings',
        'yiontech_lms_privacy_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Enable Privacy Features
    add_settings_field(
        'enable_privacy_features',
        'Enable Privacy Features',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'enable_privacy_features',
            'name' => 'yiontech_lms_theme_settings[enable_privacy_features]',
            'description' => 'Enable privacy features including cookie consent and data protection',
        )
    );

    // Privacy Policy Page
    add_settings_field(
        'privacy_policy_page',
        'Privacy Policy Page',
        'yiontech_lms_page_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'privacy_policy_page',
            'name' => 'yiontech_lms_theme_settings[privacy_policy_page]',
            'description' => 'Select your privacy policy page',
        )
    );

    // Terms of Service Page
    add_settings_field(
        'terms_of_service_page',
        'Terms of Service Page',
        'yiontech_lms_page_select_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'terms_of_service_page',
            'name' => 'yiontech_lms_theme_settings[terms_of_service_page]',
            'description' => 'Select your terms of service page',
        )
    );

    // Cookie Consent Text
    add_settings_field(
        'cookie_consent_text',
        'Cookie Consent Text',
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'cookie_consent_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_text]',
            'description' => 'Enter the text to display in the cookie consent banner',
            'rows' => 3,
        )
    );

    // Cookie Consent Button Text
    add_settings_field(
        'cookie_consent_button_text',
        'Cookie Consent Button Text',
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'cookie_consent_button_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_button_text]',
            'description' => 'Enter the text for the cookie consent accept button',
        )
    );

    // Cookie Consent Learn More Text
    add_settings_field(
        'cookie_consent_learn_more_text',
        'Cookie Consent Learn More Text',
        'yiontech_lms_text_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'cookie_consent_learn_more_text',
            'name' => 'yiontech_lms_theme_settings[cookie_consent_learn_more_text]',
            'description' => 'Enter the text for the cookie consent learn more link',
        )
    );

    // Enable Data Export
    add_settings_field(
        'enable_data_export',
        'Enable Data Export',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'enable_data_export',
            'name' => 'yiontech_lms_theme_settings[enable_data_export]',
            'description' => 'Allow users to export their data from their profile page',
        )
    );

    // Enable Account Deletion
    add_settings_field(
        'enable_account_deletion',
        'Enable Account Deletion',
        'yiontech_lms_checkbox_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_privacy_section',
        array(
            'id' => 'enable_account_deletion',
            'name' => 'yiontech_lms_theme_settings[enable_account_deletion]',
            'description' => 'Allow users to delete their account from their profile page',
        )
    );

    // CSS Editor section
    add_settings_section(
        'yiontech_lms_css_editor_section',
        'CSS Editor',
        'yiontech_lms_css_editor_section_callback',
        'yiontech_lms_theme_settings'
    );

    // Custom CSS
    add_settings_field(
        'custom_css',
        'Custom CSS',
        'yiontech_lms_textarea_field',
        'yiontech_lms_theme_settings',
        'yiontech_lms_css_editor_section',
        array(
            'id' => 'custom_css',
            'name' => 'yiontech_lms_theme_settings[custom_css]',
            'description' => 'Add your custom CSS here',
            'rows' => 20,
        )
    );
}
add_action('admin_init', 'yiontech_lms_theme_settings_init');

// Enqueue admin scripts and styles
function yiontech_lms_admin_enqueue_scripts($hook) {
    // Only load on theme settings pages
    if (strpos($hook, 'theme-settings') === false) {
        return;
    }
    
    // Enqueue WordPress media scripts
    wp_enqueue_media();
    
    // Enqueue custom admin script
    wp_enqueue_script(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/js/admin.js',
        array('jquery', 'wp-color-picker'),
        '1.0.0',
        true
    );
    
    // Enqueue custom admin styles
    wp_enqueue_style(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/css/admin.css',
        array('wp-color-picker'),
        '1.0.0'
    );
    
    // Pass data to our script
    wp_localize_script('yiontech-lms-admin', 'yiontech_lms_admin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('yiontech_lms_admin_nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'yiontech_lms_admin_enqueue_scripts');

// Add theme settings page to admin menu
function yiontech_lms_add_theme_settings_page() {
    add_menu_page(
        'Yiontech LMS Settings',
        'Yiontech LMS',
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page',
        'dashicons-admin-settings',
        5 // Position below Posts
    );
    
    // Add submenus
    add_submenu_page(
        'theme-settings-general',
        'General Settings',
        'General',
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page'
    );
    
    add_submenu_page(
        'theme-settings-general',
        'Header Settings',
        'Header',
        'manage_options',
        'theme-settings-header',
        'yiontech_lms_header_settings_page'
    );
    
    add_submenu_page(
        'theme-settings-general',
        'Footer Settings',
        'Footer',
        'manage_options',
        'theme-settings-footer',
        'yiontech_lms_footer_settings_page'
    );
    
    add_submenu_page(
        'theme-settings-general',
        'Newsletter Settings',
        'Newsletter',
        'manage_options',
        'theme-settings-newsletter',
        'yiontech_lms_newsletter_settings_page'
    );
    
    add_submenu_page(
        'theme-settings-general',
        'Privacy Settings',
        'Privacy',
        'manage_options',
        'theme-settings-privacy',
        'yiontech_lms_privacy_settings_page'
    );
    
    add_submenu_page(
        'theme-settings-general',
        'CSS Editor',
        'CSS Editor',
        'manage_options',
        'theme-settings-css',
        'yiontech_lms_css_settings_page'
    );
}
add_action('admin_menu', 'yiontech_lms_add_theme_settings_page');

// Helper function to output hidden fields for preserving settings
function yiontech_lms_output_hidden_fields($exclude_fields = array()) {
    // Get all current settings
    $all_settings = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
    
    // Output hidden fields for all settings not in the exclude list
    foreach ($all_settings as $key => $value) {
        if (!in_array($key, $exclude_fields)) {
            if (is_array($value)) {
                // For array values, encode as JSON
                echo '<input type="hidden" name="yiontech_lms_theme_settings[' . esc_attr($key) . ']" value="' . esc_attr(json_encode($value)) . '" />';
            } else {
                // For scalar values
                echo '<input type="hidden" name="yiontech_lms_theme_settings[' . esc_attr($key) . ']" value="' . esc_attr($value) . '" />';
            }
        }
    }
}

// General settings page
function yiontech_lms_general_settings_page() {
    ?>
    <div class="wrap">
        <h1>Yiontech LMS Theme Settings</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('enable_preloader', 'site_icon', 'enable_back_to_top'));
                
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
        <h1>Header Settings</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('header_style', 'transparent_header', 'sticky_header', 'header_background_color', 'sticky_header_background_color', 'logo_upload', 'retina_logo_upload', 'header_buttons', 'header_menu'));
                
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
        <h1>Footer Settings</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('footer_style', 'footer_content', 'copyright_text', 'footer_text_color', 'footer_background_color', 'copyright_background_color', 'footer_padding'));
                
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
        <h1>Newsletter Settings</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('newsletter_enable', 'newsletter_action_url', 'newsletter_method', 'newsletter_email_field', 'newsletter_hidden_fields', 'newsletter_success_message'));
                
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
        <h1>Privacy Settings</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('enable_privacy_features', 'privacy_policy_page', 'terms_of_service_page', 'cookie_consent_text', 'cookie_consent_button_text', 'cookie_consent_learn_more_text', 'enable_data_export', 'enable_account_deletion'));
                
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
        <h1>CSS Editor</h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                settings_fields('yiontech_lms_theme_settings');
                
                // Output hidden fields for all settings not in this section
                yiontech_lms_output_hidden_fields(array('custom_css'));
                
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
    
    // Output section heading
    echo '<div class="settings-section">';
    echo '<h2>' . esc_html($section['title']) . '</h2>';
    
    // Output section description if callback exists
    if (!empty($section['callback']) && is_callable($section['callback'])) {
        call_user_func($section['callback']);
    }
    
    // Output section fields
    if (isset($wp_settings_fields['yiontech_lms_theme_settings'][$section_id])) {
        echo '<table class="form-table" role="presentation">';
        foreach ((array) $wp_settings_fields['yiontech_lms_theme_settings'][$section_id] as $field) {
            echo '<tr>';
            if (!empty($field['args']['label_for'])) {
                echo '<th scope="row"><label for="' . esc_attr($field['args']['label_for']) . '">' . $field['title'] . '</label></th>';
            } else {
                echo '<th scope="row">' . $field['title'] . '</th>';
            }
            echo '<td>';
            call_user_func($field['callback'], $field['args']);
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    
    echo '</div>';
}

// Section callbacks
function yiontech_lms_general_section_callback() {
    echo '<p>General theme settings</p>';
}

function yiontech_lms_header_section_callback() {
    echo '<p>Configure your website header</p>';
}

function yiontech_lms_footer_section_callback() {
    echo '<p>Configure your website footer</p>';
}

function yiontech_lms_newsletter_section_callback() {
    echo '<p>Newsletter configuration settings</p>';
}

function yiontech_lms_privacy_section_callback() {
    echo '<p>Configure privacy settings for GDPR compliance</p>';
}

function yiontech_lms_css_editor_section_callback() {
    echo '<p>Add custom CSS to your theme</p>';
}

// Field callbacks
function yiontech_lms_checkbox_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    $checked = $value ? 'checked="checked"' : '';
    ?>
    <label>
        <input type="checkbox" name="<?php echo esc_attr($args['name']); ?>" value="1" <?php echo $checked; ?> />
        <?php echo esc_html($args['description']); ?>
    </label>
    <?php
}

function yiontech_lms_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <select name="<?php echo esc_attr($args['name']); ?>">
        <?php foreach ($args['options'] as $option_value => $label) : ?>
            <option value="<?php echo esc_attr($option_value); ?>" <?php selected($value, $option_value); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_color_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <input type="color" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="yiontech-color-field" />
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_text_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <input type="text" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" />
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_media_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    $media_id = attachment_url_to_postid($value);
    ?>
    <div class="media-field" data-field-id="<?php echo esc_attr($args['id']); ?>">
        <input type="hidden" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['id']); ?>" value="<?php echo esc_attr($value); ?>" />
        <div class="media-preview">
            <?php if ($value) : ?>
                <img src="<?php echo esc_url($value); ?>" alt="" style="max-width: 200px; max-height: 100px;" />
            <?php endif; ?>
        </div>
        <button type="button" class="button media-upload-button">Upload</button>
        <button type="button" class="button media-remove-button" style="<?php echo $value ? '' : 'display:none;'; ?>">Remove</button>
        <?php if (isset($args['description'])) : ?>
            <p class="description"><?php echo esc_html($args['description']); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

function yiontech_lms_textarea_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    $rows = isset($args['rows']) ? $args['rows'] : 5;
    ?>
    <textarea name="<?php echo esc_attr($args['name']); ?>" rows="<?php echo esc_attr($rows); ?>" class="large-text"><?php echo esc_textarea($value); ?></textarea>
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_spacing_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    $top = isset($value['top']) ? $value['top'] : 48;
    $bottom = isset($value['bottom']) ? $value['bottom'] : 48;
    ?>
    <div class="spacing-field">
        <div>
            <label for="<?php echo esc_attr($args['id']); ?>_top">Top (px):</label>
            <input type="number" name="<?php echo esc_attr($args['name']); ?>[top]" id="<?php echo esc_attr($args['id']); ?>_top" value="<?php echo esc_attr($top); ?>" min="0" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id']); ?>_bottom">Bottom (px):</label>
            <input type="number" name="<?php echo esc_attr($args['name']); ?>[bottom]" id="<?php echo esc_attr($args['id']); ?>_bottom" value="<?php echo esc_attr($bottom); ?>" min="0" />
        </div>
    </div>
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_header_buttons_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $buttons = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <div class="header-buttons-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="header-buttons">
            <?php
            if (!empty($buttons)) {
                foreach ($buttons as $index => $button) {
                    $show_desktop = isset($button['show_desktop']) ? $button['show_desktop'] : true;
                    $show_mobile = isset($button['show_mobile']) ? $button['show_mobile'] : true;
                    ?>
                    <div class="header-button-item" data-index="<?php echo esc_attr($index); ?>">
                        <div>
                            <label>Button Text:</label>
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($button['text']); ?>" class="regular-text" />
                        </div>
                        <div>
                            <label>Button URL:</label>
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($button['url']); ?>" class="regular-text" />
                        </div>
                        <div>
                            <label>Button Style:</label>
                            <select name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][style]">
                                <option value="solid" <?php selected($button['style'], 'solid'); ?>>Solid</option>
                                <option value="outline" <?php selected($button['style'], 'outline'); ?>>Outline</option>
                            </select>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_desktop]" value="1" <?php checked($show_desktop, true); ?> />
                                Show on Desktop
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_mobile]" value="1" <?php checked($show_mobile, true); ?> />
                                Show on Mobile
                            </label>
                        </div>
                        <button type="button" class="button remove-button">Remove Button</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" class="button add-button">Add Button</button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($buttons)); ?>" />
    </div>
    
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_menu_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $menu_items = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <div class="menu-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="menu-items">
            <?php
            if (!empty($menu_items)) {
                foreach ($menu_items as $index => $item) {
                    ?>
                    <div class="menu-item" data-index="<?php echo esc_attr($index); ?>">
                        <div>
                            <label>Menu Text:</label>
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($item['text']); ?>" class="regular-text" />
                        </div>
                        <div>
                            <label>Menu URL:</label>
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($item['url']); ?>" class="regular-text" />
                        </div>
                        <button type="button" class="button remove-menu-item">Remove</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" class="button add-menu-item">Add Menu Item</button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($menu_items)); ?>" />
    </div>
    
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

function yiontech_lms_footer_content_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $footer_content = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    ?>
    <div class="footer-content-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <h4>Column 1</h4>
        <div>
            <label>Title:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column1][title]" value="<?php echo esc_attr($footer_content['column1']['title']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Content:</label>
            <textarea name="<?php echo esc_attr($args['name']); ?>[column1][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column1']['content']); ?></textarea>
        </div>
        
        <h4>Column 2</h4>
        <div>
            <label>Title:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][title]" value="<?php echo esc_attr($footer_content['column2']['title']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Links:</label>
            <div class="footer-links" data-column="column2">
                <?php
                if (!empty($footer_content['column2']['links'])) {
                    foreach ($footer_content['column2']['links'] as $index => $link) {
                        ?>
                        <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text']); ?>" placeholder="Link Text" class="regular-text" />
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="Link URL" class="regular-text" />
                            <button type="button" class="button remove-link">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button add-link" data-column="column2">Add Link</button>
            <input type="hidden" class="item-counter" data-column="column2" value="<?php echo esc_attr(count($footer_content['column2']['links'])); ?>" />
        </div>
        
        <h4>Column 3</h4>
        <div>
            <label>Title:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][title]" value="<?php echo esc_attr($footer_content['column3']['title']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Links:</label>
            <div class="footer-links" data-column="column3">
                <?php
                if (!empty($footer_content['column3']['links'])) {
                    foreach ($footer_content['column3']['links'] as $index => $link) {
                        ?>
                        <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text']); ?>" placeholder="Link Text" class="regular-text" />
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="Link URL" class="regular-text" />
                            <button type="button" class="button remove-link">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button add-link" data-column="column3">Add Link</button>
            <input type="hidden" class="item-counter" data-column="column3" value="<?php echo esc_attr(count($footer_content['column3']['links'])); ?>" />
        </div>
        
        <h4>Column 4</h4>
        <div>
            <label>Title:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][title]" value="<?php echo esc_attr($footer_content['column4']['title']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Links:</label>
            <div class="footer-links" data-column="column4">
                <?php
                if (!empty($footer_content['column4']['links'])) {
                    foreach ($footer_content['column4']['links'] as $index => $link) {
                        ?>
                        <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text']); ?>" placeholder="Link Text" class="regular-text" />
                            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="Link URL" class="regular-text" />
                            <button type="button" class="button remove-link">Remove</button>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <button type="button" class="button add-link" data-column="column4">Add Link</button>
            <input type="hidden" class="item-counter" data-column="column4" value="<?php echo esc_attr(count($footer_content['column4']['links'])); ?>" />
        </div>
        
        <h4>Column 5</h4>
        <div>
            <label>Title:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column5][title]" value="<?php echo esc_attr($footer_content['column5']['title']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Content:</label>
            <textarea name="<?php echo esc_attr($args['name']); ?>[column5][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column5']['content']); ?></textarea>
        </div>
        <div>
            <label>Email:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column5][email]" value="<?php echo esc_attr($footer_content['column5']['email']); ?>" class="regular-text" />
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="<?php echo esc_attr($args['name']); ?>[column5][phone]" value="<?php echo esc_attr($footer_content['column5']['phone']); ?>" class="regular-text" />
        </div>
    </div>
    
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}

// Page select field callback
function yiontech_lms_page_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings');
    $defaults = yiontech_lms_get_default_settings();
    $value = isset($options[$args['id']]) ? $options[$args['id']] : $defaults[$args['id']];
    
    // Get all pages
    $pages = get_pages();
    
    ?>
    <select name="<?php echo esc_attr($args['name']); ?>">
        <option value="0"><?php _e('— Select —', 'yiontech-lms'); ?></option>
        <?php foreach ($pages as $page) : ?>
            <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($value, $page->ID); ?>>
                <?php echo esc_html($page->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($args['description'])) : ?>
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php endif; ?>
    <?php
}