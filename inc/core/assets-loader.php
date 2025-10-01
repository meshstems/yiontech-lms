<?php
/**
 * Optimized Assets Loader
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function yiontech_lms_scripts() {
    $theme_version = wp_get_theme()->get('Version');
    
    // Main styles
    wp_enqueue_style('yiontech-lms-style', get_stylesheet_uri(), array(), $theme_version);
    
    // Local Tailwind CSS (only load if not using Elementor)
    // Only load Tailwind if not using Elementor
    if (!function_exists('\\Elementor\\Plugin') || !\Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        wp_enqueue_style('yiontech-lms-tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), $theme_version);
    }
    
    
    // Load jQuery conditionally
    $jquery_needed = false;
    
    // Check if any feature requires jQuery
    $enable_preloader = yiontech_lms_get_theme_setting('enable_preloader');
    $enable_back_to_top = yiontech_lms_get_theme_setting('enable_back_to_top');
    $newsletter_enable = yiontech_lms_get_theme_setting('newsletter_enable');
    $enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
    
    if ($enable_preloader || $enable_back_to_top || $newsletter_enable || $enable_privacy_features) {
        $jquery_needed = true;
    }
    
    if ($jquery_needed) {
        wp_enqueue_script('jquery');
        wp_script_add_data('jquery', 'defer', true);
    }
    
    // Main combined script (always needed)
    wp_enqueue_script('yiontech-lms-main', get_template_directory_uri() . '/js/main.js', array(), $theme_version, true);
    wp_script_add_data('yiontech-lms-main', 'defer', true);
    
    // Conditional scripts
    if ($enable_preloader && (!function_exists('\\Elementor\\Plugin') || !\Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor())) {
        wp_enqueue_script('yiontech-lms-preloader', get_template_directory_uri() . '/inc/features/preloader/preloader.js', array(), $theme_version, true);
        wp_script_add_data('yiontech-lms-preloader', 'defer', true);
    }
    
    // Admin scripts
    if (is_admin()) {
        wp_enqueue_style('yiontech-lms-admin', get_template_directory_uri() . '/css/admin.css', array(), $theme_version);
        wp_enqueue_script('yiontech-lms-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'wp-color-picker'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_scripts');

// Add async/defer attributes to scripts
function yiontech_lms_script_loader_tag($tag, $handle, $src) {
    // Add defer to main scripts
    if (in_array($handle, array('yiontech-lms-main', 'yiontech-lms-preloader', 'yiontech-lms-user-main'))) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    // Add async to non-critical scripts
    if (in_array($handle, array('yiontech-lms-admin'))) {
        return str_replace(' src', ' async src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'yiontech_lms_script_loader_tag', 10, 3);

// Preload critical fonts
function yiontech_lms_preload_fonts() {
    ?>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>
    <?php
}
add_action('wp_head', 'yiontech_lms_preload_fonts', 1);

// Remove jQuery Migrate (not needed for most themes)
function yiontech_lms_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
    return $scripts;
}
add_filter('wp_default_scripts', 'yiontech_lms_remove_jquery_migrate');