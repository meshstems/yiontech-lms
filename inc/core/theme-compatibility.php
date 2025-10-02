<?php
/**
 * Theme Compatibility Functions
 *
 * @package Yiontech_LMS
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fix WooCommerce translation loading
 */
function yiontech_lms_woocommerce_translation() {
    if (defined('WC_PLUGIN_FILE') && function_exists('load_plugin_textdomain')) {
        load_plugin_textdomain('woocommerce', false, dirname(plugin_basename(WC_PLUGIN_FILE)) . '/i18n/languages/');
    }
}
add_action('init', 'yiontech_lms_woocommerce_translation', 5);

/**
 * Optional Gutenberg Toggle (disable or enable via theme setting)
 */
function yiontech_lms_maybe_disable_gutenberg() {
    if (yiontech_lms_get_theme_setting('disable_gutenberg', false)) {
        // ===== CLASSIC MODE =====

        // Disable block editor for posts & CPTs
        add_filter('use_block_editor_for_post', '__return_false', 10);
        add_filter('use_block_editor_for_post_type', '__return_false', 10);

        // Disable widget block editor
        add_filter('gutenberg_use_widgets_block_editor', '__return_false');
        add_filter('use_widgets_block_editor', '__return_false');

        // Remove frontend Gutenberg styles
        add_action('wp_enqueue_scripts', 'yiontech_lms_disable_gutenberg_frontend_styles', 100);

        // Remove Gutenberg styles & scripts in admin
        add_action('admin_enqueue_scripts', 'yiontech_lms_disable_gutenberg_admin_styles', 100);
        add_action('admin_enqueue_scripts', 'yiontech_lms_disable_gutenberg_admin_scripts', 100);

        // Remove theme support for block widgets
        add_action('after_setup_theme', 'yiontech_lms_disable_gutenberg_theme_support');

        // Prevent wp-editor conflict in classic widgets/customizer
        add_action('init', 'yiontech_lms_block_wp_editor_conflict', 1);

    } else {
        // ===== GUTENBERG MODE =====

        // Ensure classic-only cleanup is removed
        remove_filter('use_block_editor_for_post', '__return_false', 10);
        remove_filter('use_block_editor_for_post_type', '__return_false', 10);
        remove_filter('gutenberg_use_widgets_block_editor', '__return_false');
        remove_filter('use_widgets_block_editor', '__return_false');

        // Enable block widget support
        add_theme_support('widgets-block-editor');

        // Prevent "wp-editor" from conflicting with block widgets
        add_action('wp_default_scripts', function($scripts) {
            global $pagenow;

            if (is_admin() && ($pagenow === 'widgets.php' || $pagenow === 'customize.php')) {
                if (isset($scripts->registered['wp-editor'])) {
                    unset($scripts->registered['wp-editor']); // fully remove
                }
                // Register dummy handle so dependencies don't break
                wp_register_script('wp-editor', false, [], null, true);
            }
        }, 1);
    }
}
add_action('init', 'yiontech_lms_maybe_disable_gutenberg');

/**
 * Remove Gutenberg CSS from frontend
 */
function yiontech_lms_disable_gutenberg_frontend_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // WooCommerce blocks
}

/**
 * Remove Gutenberg editor styles from admin
 */
function yiontech_lms_disable_gutenberg_admin_styles($hook) {
    if ($hook !== 'widgets.php' && $hook !== 'customize.php') {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-edit-blocks');
    }
}

/**
 * Remove Gutenberg scripts for a cleaner admin
 */
function yiontech_lms_disable_gutenberg_admin_scripts($hook) {
    if ($hook !== 'widgets.php' && $hook !== 'customize.php') {
        wp_dequeue_script('wp-blocks');
        wp_dequeue_script('wp-edit-post');
    }
}

/**
 * Disable block-based widgets (restore classic widgets)
 */
function yiontech_lms_disable_gutenberg_theme_support() {
    remove_theme_support('widgets-block-editor');
}

/**
 * Prevent wp-editor from loading on widgets/customizer (classic mode only)
 */
function yiontech_lms_block_wp_editor_conflict() {
    global $pagenow;

    if ($pagenow === 'widgets.php' || $pagenow === 'customize.php') {
        wp_deregister_script('wp-editor');
        wp_dequeue_script('wp-editor');
    }
}

/**
 * Child theme support
 */
function yiontech_lms_child_theme_styles() {
    if (is_child_theme()) {
        wp_enqueue_style('yiontech-lms-parent-style', get_template_directory_uri() . '/style.min.css', [], '1.1.0');
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_child_theme_styles', 5);

/**
 * Generate .pot file on theme update
 */
function yiontech_lms_generate_pot_file() {
    if (current_user_can('manage_options')) {
        // Suggest running `wp i18n make-pot . languages/yiontech-lms.pot` via CLI
    }
}
add_action('after_switch_theme', 'yiontech_lms_generate_pot_file');
