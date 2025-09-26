<?php
/**
 * Template Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get privacy policy URL
function yiontech_lms_get_privacy_policy_url() {
    $privacy_policy_page = yiontech_lms_get_theme_setting('privacy_policy_page');
    if ($privacy_policy_page) {
        return get_permalink($privacy_policy_page);
    }
    return get_privacy_policy_url();
}

// Get terms of service URL
function yiontech_lms_get_terms_of_service_url() {
    $terms_of_service_page = yiontech_lms_get_theme_setting('terms_of_service_page');
    if ($terms_of_service_page) {
        return get_permalink($terms_of_service_page);
    }
    return '';
}

// Helper function to get Elementor templates
function yiontech_lms_get_elementor_templates($template_type = '') {
    $args = array(
        'post_type' => 'elementor_library',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    
    if (!empty($template_type)) {
        $args['meta_query'] = array(
            array(
                'key' => '_elementor_template_type',
                'value' => $template_type,
            ),
        );
    }
    
    $templates = get_posts($args);
    
    $template_options = array();
    if (!empty($templates)) {
        foreach ($templates as $template) {
            $template_options[$template->ID] = $template->post_title;
        }
    }
    
    return $template_options;
}