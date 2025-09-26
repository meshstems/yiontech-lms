<?php
/**
 * Cookie Consent Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Cookie consent AJAX handler
function yiontech_lms_cookie_consent_handler() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yiontech_lms_cookie_consent_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Set cookie consent for 1 year
    $expiry = time() + YEAR_IN_SECONDS;
    setcookie('yiontech_lms_cookie_consent', 'accepted', $expiry, '/');
    
    wp_send_json_success('Cookie consent accepted');
}
add_action('wp_ajax_yiontech_lms_cookie_consent', 'yiontech_lms_cookie_consent_handler');
add_action('wp_ajax_nopriv_yiontech_lms_cookie_consent', 'yiontech_lms_cookie_consent_handler');

// Add cookie consent banner to footer
function yiontech_lms_cookie_consent_banner() {
    $enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
    
    if ($enable_privacy_features && !isset($_COOKIE['yiontech_lms_cookie_consent'])) {
        $privacy_policy_url = yiontech_lms_get_privacy_policy_url();
        ?>
        <div id="cookie-consent-banner" class="cookie-consent-banner">
            <div class="cookie-consent-content">
                <?php echo wp_kses_post(yiontech_lms_get_theme_setting('cookie_consent_text', 'We use cookies to ensure you get the best experience on our website. By continuing to use this site, you consent to our use of cookies.')); ?>
            </div>
            <div class="cookie-consent-buttons">
                <?php if ($privacy_policy_url) : ?>
                    <a href="<?php echo esc_url($privacy_policy_url); ?>" class="button cookie-consent-learn" target="_blank">
                        <?php echo esc_html(yiontech_lms_get_theme_setting('cookie_consent_learn_more_text', 'Learn More')); ?>
                    </a>
                <?php endif; ?>
                <button id="cookie-consent-accept" class="button cookie-consent-accept">
                    <?php echo esc_html(yiontech_lms_get_theme_setting('cookie_consent_button_text', 'Accept')); ?>
                </button>
            </div>
        </div>
        <?php
    }
}
add_action('wp_footer', 'yiontech_lms_cookie_consent_banner');

// Enqueue cookie consent script if privacy features are enabled
function yiontech_lms_enqueue_cookie_consent_script() {
    $enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
    if ($enable_privacy_features) {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('yiontech-lms-cookie-consent', get_template_directory_uri() . '/inc/features/cookie-consent/cookie-consent.js', array('jquery'), $theme_version, true);
        wp_localize_script('yiontech-lms-cookie-consent', 'yiontech_lms_cookie_consent', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yiontech_lms_cookie_consent_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_cookie_consent_script');