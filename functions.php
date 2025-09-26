<?php
/**
 * Yiontech LMS Theme Functions
 *
 * @package Yiontech_LMS
 */

// Include core functionality
require_once get_template_directory() . '/inc/core/theme-setup.php';
require_once get_template_directory() . '/inc/core/assets-loader.php';
require_once get_template_directory() . '/inc/core/template-functions.php';

// Include feature loader
require_once get_template_directory() . '/inc/features-loader.php';

// Add admin styles for theme settings
function yiontech_lms_admin_styles() {
    ?>
    <style>
        /* Improved admin styles for theme settings */
        .wrap h1 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-table {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .form-table th {
            padding: 20px;
            background: #f9f9f9;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        
        .form-table td {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .form-table tr:last-child td {
            border-bottom: none;
        }
        
        input[type="text"], 
        input[type="email"], 
        input[type="url"], 
        input[type="password"], 
        input[type="number"], 
        textarea, 
        select {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.07);
        }
        
        input[type="color"] {
            height: 40px;
            width: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="checkbox"] {
            margin-right: 10px;
        }
        
        .description {
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
        
        .button {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
        }
        
        .button-primary {
            background: #0085ba;
            color: #fff;
            border: 1px solid #0085ba;
        }
        
        .button-primary:hover {
            background: #0073a8;
            border-color: #0073a8;
        }
        
        .button-secondary {
            background: #f7f7f7;
            color: #555;
            border: 1px solid #ccc;
        }
        
        .button-secondary:hover {
            background: #f0f0f0;
            border-color: #999;
        }
        
        /* Media field styles */
        .media-field {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .media-preview {
            width: 200px;
            height: 100px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .media-preview img {
            max-width: 100%;
            max-height: 100%;
        }
        
        /* Header buttons field styles */
        .header-buttons-field, .menu-field {
            margin-top: 10px;
        }
        
        .header-buttons, .menu-items {
            margin-bottom: 10px;
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .header-button-item, .menu-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .header-button-item:last-child, .menu-item:last-child {
            margin-bottom: 0;
        }
        
        .header-button-item div, .menu-item div {
            margin-bottom: 10px;
        }
        
        .header-button-item div:last-child, .menu-item div:last-child {
            margin-bottom: 0;
        }
        
        .header-button-item label, .menu-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .remove-button, .remove-menu-item, .remove-link {
            background: #ff4d4d;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .remove-button:hover, .remove-menu-item:hover, .remove-link:hover {
            background: #ff1a1a;
        }
        
        .add-button, .add-menu-item, .add-link {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .add-button:hover, .add-menu-item:hover, .add-link:hover {
            background: #4cae4c;
        }
        
        /* Footer content field styles */
        .footer-content-field h4 {
            margin: 20px 0 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 16px;
            color: #23282d;
        }
        
        .footer-links {
            margin-bottom: 10px;
            max-height: 200px;
            overflow-y: auto;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .footer-link-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
        }
        
        .footer-link-item:last-child {
            margin-bottom: 0;
        }
        
        .footer-link-item input {
            flex: 1;
        }
        
        /* Spacing field styles */
        .spacing-field {
            display: flex;
            gap: 20px;
        }
        
        .spacing-field > div {
            flex: 1;
        }
        
        .spacing-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>
    <?php
}
add_action('admin_head', 'yiontech_lms_admin_styles');

// Debug function to check Elementor template loading
add_action('wp_footer', function() {
    $footer_elementor_template = yiontech_lms_get_theme_setting('footer_elementor_template', 0);
    
    if (defined('WP_DEBUG') && WP_DEBUG) {
        echo "<!-- Debug: Footer Elementor Template ID: " . esc_html($footer_elementor_template) . " -->\n";
        
        if ($footer_elementor_template > 0) {
            $template_post = get_post($footer_elementor_template);
            if ($template_post) {
                echo "<!-- Debug: Template Post Status: " . esc_html($template_post->post_status) . " -->\n";
                echo "<!-- Debug: Template Post Title: " . esc_html($template_post->post_title) . " -->\n";
                
                if (function_exists('\\Elementor\\Plugin')) {
                    $elementor = \Elementor\Plugin::instance();
                    $document = $elementor->documents->get($footer_elementor_template);
                    if ($document) {
                        echo "<!-- Debug: Document is built with Elementor: " . ($document->is_built_with_elementor() ? 'Yes' : 'No') . " -->\n";
                    } else {
                        echo "<!-- Debug: Document not found -->\n";
                    }
                } else {
                    echo "<!-- Debug: Elementor Plugin not available -->\n";
                }
            } else {
                echo "<!-- Debug: Template Post not found -->\n";
            }
        }
    }
}, 1); // High priority to output early

// Fix WooCommerce translation loading notice
function delay_woocommerce_translation() {
    if (function_exists('load_plugin_textdomain')) {
        load_plugin_textdomain('woocommerce', false, plugin_dir_path(WC_PLUGIN_FILE) . 'i18n/languages/');
    }
}
add_action('init', 'delay_woocommerce_translation', 5);