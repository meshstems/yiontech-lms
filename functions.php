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

// Theme Support
function yiontech_lms_setup_theme() {
    // Core WordPress features
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height' => 36,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-background', ['default-color' => '#ffffff']);
    add_theme_support('custom-header', ['default-image' => '', 'width' => 1200, 'height' => 300, 'flex-height' => true]);
    add_theme_support('editor-styles');
    add_theme_support('woocommerce');
    add_theme_support('automatic-feed-links');

    // Custom image sizes for performance
    add_image_size('yiontech_course_thumbnail', 600, 400, true);
    add_image_size('yiontech_post_thumbnail', 800, 600, true);

    // Load editor styles
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'yiontech_lms_setup_theme');

// Theme activation hook
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


// Add dynamic styles to head
function yiontech_lms_dynamic_styles() {
    $header_background_color = yiontech_lms_get_theme_setting('header_background_color', '#1e40af');
    $sticky_header_background_color = yiontech_lms_get_theme_setting('sticky_header_background_color', '#1e40af');
    $transparent_header = yiontech_lms_get_theme_setting('transparent_header', false);
    $footer_background_color = yiontech_lms_get_theme_setting('footer_background_color', '#111827');
    $footer_text_color = yiontech_lms_get_theme_setting('footer_text_color', '#ffffff');
    $copyright_background_color = yiontech_lms_get_theme_setting('copyright_background_color', '#0f172a');

    $css = "
        .site-header:not(.header-transparent) {
            background-color: {$header_background_color};
        }
        .site-header.sticky {
            background-color: {$sticky_header_background_color};
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        footer {
            background-color: {$footer_background_color};
            color: {$footer_text_color};
        }
        .copyright-section {
            background-color: {$copyright_background_color};
        }
        /* Gutenberg block styles (when not disabled) */
        .wp-block-quote { border-left: 4px solid {$header_background_color}; padding-left: 1rem; }
        .wp-block-button__link { background-color: {$header_background_color}; color: {$footer_text_color}; }
    ";

    wp_add_inline_style('yiontech-lms-style', $css);
}
add_action('wp_enqueue_scripts', 'yiontech_lms_dynamic_styles');

// Fix WooCommerce translation loading
function yiontech_lms_woocommerce_translation() {
    if (defined('WC_PLUGIN_FILE') && function_exists('load_plugin_textdomain')) {
        load_plugin_textdomain('woocommerce', false, dirname(plugin_basename(WC_PLUGIN_FILE)) . '/i18n/languages/');
    }
}
add_action('init', 'yiontech_lms_woocommerce_translation', 5);

// Optional Gutenberg Disable
function yiontech_lms_maybe_disable_gutenberg() {
    if (yiontech_lms_get_theme_setting('disable_gutenberg', false)) {
        add_filter('use_block_editor_for_post', '__return_false', 10);
        add_filter('use_block_editor_for_post_type', '__return_false', 10);
        add_action('wp_enqueue_scripts', 'yiontech_lms_disable_gutenberg_frontend_styles', 100);
        add_action('admin_enqueue_scripts', 'yiontech_lms_disable_gutenberg_admin_styles', 100);
        add_action('admin_enqueue_scripts', 'yiontech_lms_disable_gutenberg_admin_scripts', 100);
    }
}
add_action('init', 'yiontech_lms_maybe_disable_gutenberg');

// Remove Gutenberg CSS from frontend
function yiontech_lms_disable_gutenberg_frontend_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
}

// Remove Gutenberg editor styles from admin
function yiontech_lms_disable_gutenberg_admin_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-edit-blocks');
}

// Remove Gutenberg scripts for a cleaner admin
function yiontech_lms_disable_gutenberg_admin_scripts() {
    wp_dequeue_script('wp-blocks');
    wp_dequeue_script('wp-edit-post');
}

// Child theme support
function yiontech_lms_child_theme_styles() {
    if (is_child_theme()) {
        wp_enqueue_style('yiontech-lms-parent-style', get_template_directory_uri() . '/style.min.css', [], '1.1.0');
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_child_theme_styles', 5);

// Generate .pot file on theme update
function yiontech_lms_generate_pot_file() {
    if (current_user_can('manage_options')) {
        // Suggest running `wp i18n make-pot . languages/yiontech-lms.pot` via CLI
        // Or automate with a plugin like WP-CLI
    }
}
add_action('after_switch_theme', 'yiontech_lms_generate_pot_file');

