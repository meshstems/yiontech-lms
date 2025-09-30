<?php
/**
 * Feature Loader
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Array of features to load. To disable a feature, comment it out.
 $features = array(
    'theme-settings',
    'login-modifier',
    'registration-modifier',
    'document-upload',
    'newsletter',
    'cookie-consent',
    'preloader',
    'back-to-top',
    'header-scroll',
    'elementor-integration',
    // Add more features here
);

// Load each feature
foreach ($features as $feature) {
    $feature_file = get_template_directory() . "/inc/features/{$feature}/{$feature}.php";
    if (file_exists($feature_file)) {
        require_once $feature_file;
    }
}