<?php
/**
 * Newsletter Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Newsletter AJAX handler
function yiontech_lms_newsletter_handler() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yiontech_lms_newsletter_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Get newsletter settings
    $action_url = yiontech_lms_get_theme_setting('newsletter_action_url');
    $method = yiontech_lms_get_theme_setting('newsletter_method', 'post');
    $email_field = yiontech_lms_get_theme_setting('newsletter_email_field', 'email');
    $hidden_fields = yiontech_lms_get_theme_setting('newsletter_hidden_fields', '');
    
    // Get email from form
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    
    if (empty($email)) {
        wp_send_json_error('Please enter a valid email address');
    }
    
    // Prepare data
    $data = array($email_field => $email);
    
    // Add hidden fields
    if (!empty($hidden_fields)) {
        $lines = explode("\n", $hidden_fields);
        foreach ($lines as $line) {
            $parts = explode('=', $line, 2);
            if (count($parts) == 2) {
                $data[trim($parts[0])] = trim($parts[1]);
            }
        }
    }
    
    // Send request
    $response = wp_remote_post($action_url, array(
        'method' => strtoupper($method),
        'body' => $data,
    ));
    
    // Check for errors
    if (is_wp_error($response)) {
        wp_send_json_error('Subscription failed. Please try again.');
    }
    
    // Get response code
    $response_code = wp_remote_retrieve_response_code($response);
    
    // Check response code
    if ($response_code >= 200 && $response_code < 300) {
        wp_send_json_success('Subscription successful');
    } else {
        wp_send_json_error('Subscription failed. Please try again.');
    }
}
add_action('wp_ajax_yiontech_lms_newsletter', 'yiontech_lms_newsletter_handler');
add_action('wp_ajax_nopriv_yiontech_lms_newsletter', 'yiontech_lms_newsletter_handler');

// Enqueue newsletter script if enabled
function yiontech_lms_enqueue_newsletter_script() {
    $newsletter_enable = yiontech_lms_get_theme_setting('newsletter_enable');
    if ($newsletter_enable) {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('yiontech-lms-newsletter', get_template_directory_uri() . '/inc/features/newsletter/newsletter.js', array('jquery'), $theme_version, true);
        wp_localize_script('yiontech-lms-newsletter', 'yiontech_lms_newsletter', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'success_message' => yiontech_lms_get_theme_setting('newsletter_success_message', 'Thank you for subscribing!'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_newsletter_script');