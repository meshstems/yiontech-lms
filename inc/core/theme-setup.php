<?php
/**
 * Core Theme Setup
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function yiontech_lms_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 36,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'yiontech-lms'),
        'footer' => __('Footer Menu', 'yiontech-lms'),
        'footer-quick-links' => __('Footer Quick Links Menu', 'yiontech-lms'),
        'footer-company' => __('Footer Company Menu', 'yiontech-lms'),
        'footer-user-portal' => __('Footer User Portal Menu', 'yiontech-lms'),
    ));
    
    // Register sidebar
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'yiontech-lms'),
        'id'            => 'main-sidebar',
        'description'   => __('Add widgets here.', 'yiontech-lms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6 bg-white p-4 rounded-lg shadow">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title text-xl font-bold mb-3">',
        'after_title'   => '</h2>',
    ));
}
add_action('after_setup_theme', 'yiontech_lms_setup');

// Create front page on theme activation
add_action('after_switch_theme', 'yiontech_lms_create_front_page');
function yiontech_lms_create_front_page() {
    $front_page = get_page_by_path('front-page');
    if (!$front_page) {
        $front_page_id = wp_insert_post(array(
            'post_title'    => 'Front Page',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'front-page'
        ));
        update_option('page_on_front', $front_page_id);
        update_option('show_on_front', 'page');
    }
}

// Add custom image sizes for courses
add_action('after_setup_theme', 'yiontech_lms_add_image_sizes');
function yiontech_lms_add_image_sizes() {
    add_image_size('course-thumbnail', 400, 250, true);
}