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
require_once get_template_directory() . '/inc/core/theme-activation.php';
require_once get_template_directory() . '/inc/core/theme-styles.php';
require_once get_template_directory() . '/inc/core/theme-compatibility.php';
require_once get_template_directory() . '/inc/core/theme-debug.php';

// Include feature loader
require_once get_template_directory() . '/inc/features-loader.php';

// Include authentication functions
require_once get_template_directory() . '/inc/features/auth/auth-functions.php';

