<?php
/**
 * Settings Pages
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Add theme settings page to admin menu
function yiontech_lms_add_theme_settings_page() {
    add_menu_page(
        __('Yiontech LMS Settings', 'yiontech-lms'),
        __('Yiontech LMS', 'yiontech-lms'),
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page',
        'dashicons-admin-settings',
        5
    );

    add_submenu_page(
        'theme-settings-general',
        __('General Settings', 'yiontech-lms'),
        __('General', 'yiontech-lms'),
        'manage_options',
        'theme-settings-general',
        'yiontech_lms_general_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Header Settings', 'yiontech-lms'),
        __('Header', 'yiontech-lms'),
        'manage_options',
        'theme-settings-header',
        'yiontech_lms_header_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Footer Settings', 'yiontech-lms'),
        __('Footer', 'yiontech-lms'),
        'manage_options',
        'theme-settings-footer',
        'yiontech_lms_footer_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Newsletter Settings', 'yiontech-lms'),
        __('Newsletter', 'yiontech-lms'),
        'manage_options',
        'theme-settings-newsletter',
        'yiontech_lms_newsletter_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('Privacy Settings', 'yiontech-lms'),
        __('Privacy', 'yiontech-lms'),
        'manage_options',
        'theme-settings-privacy',
        'yiontech_lms_privacy_settings_page'
    );

    add_submenu_page(
        'theme-settings-general',
        __('CSS Editor', 'yiontech-lms'),
        __('CSS Editor', 'yiontech-lms'),
        'manage_options',
        'theme-settings-css',
        'yiontech_lms_css_settings_page'
    );
}

// Helper function to output hidden fields for preserving settings
function yiontech_lms_output_hidden_fields($exclude_fields = []) {
    $options = get_option('yiontech_lms_theme_settings', []);
    foreach ($options as $key => $value) {
        if (!in_array($key, $exclude_fields)) {
            if (is_array($value)) {
                $value = wp_json_encode($value, JSON_UNESCAPED_SLASHES);
            }
            ?>
            <input type="hidden" name="yiontech_lms_theme_settings[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>" />
            <?php
        }
    }
}

// General settings page
function yiontech_lms_general_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Yiontech LMS Theme Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['enable_preloader', 'site_icon', 'enable_back_to_top', 'disable_gutenberg']);
                yiontech_lms_output_settings_section('yiontech_lms_general_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Header settings page
function yiontech_lms_header_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Header Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['header_style', 'transparent_header', 'sticky_header', 'header_background_color', 'sticky_header_background_color', 'logo_upload', 'retina_logo_upload', 'header_buttons', 'header_menu', 'header_elementor_template']);
                yiontech_lms_output_settings_section('yiontech_lms_header_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Footer settings page
function yiontech_lms_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Footer Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['footer_style', 'footer_elementor_template', 'footer_content', 'copyright_text', 'footer_text_color', 'footer_background_color', 'copyright_background_color', 'footer_padding']);
                yiontech_lms_output_settings_section('yiontech_lms_footer_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Newsletter settings page
function yiontech_lms_newsletter_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Newsletter Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['newsletter_enable', 'newsletter_action_url', 'newsletter_method', 'newsletter_email_field', 'newsletter_hidden_fields', 'newsletter_success_message']);
                yiontech_lms_output_settings_section('yiontech_lms_newsletter_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Privacy settings page
function yiontech_lms_privacy_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Privacy Settings', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['enable_privacy_features', 'privacy_policy_page', 'terms_of_service_page', 'cookie_consent_text', 'cookie_consent_button_text', 'cookie_consent_learn_more_text', 'enable_data_export', 'enable_account_deletion']);
                yiontech_lms_output_settings_section('yiontech_lms_privacy_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// CSS settings page
function yiontech_lms_css_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('CSS Editor', 'yiontech-lms'); ?></h1>
        <div class="settings-container">
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('yiontech_lms_settings_save', 'yiontech_lms_nonce');
                settings_fields('yiontech_lms_theme_settings');
                yiontech_lms_output_hidden_fields(['custom_css']);
                yiontech_lms_output_settings_section('yiontech_lms_css_editor_section');
                submit_button();
                ?>
            </form>
        </div>
    </div>
    <?php
}

// Helper function to output a specific settings section
function yiontech_lms_output_settings_section($section_id) {
    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections['yiontech_lms_theme_settings'][$section_id])) {
        return;
    }

    $section = $wp_settings_sections['yiontech_lms_theme_settings'][$section_id];
    ?>
    <div class="settings-section">
        <h2><?php echo esc_html($section['title']); ?></h2>
        <?php
        if (!empty($section['callback']) && is_callable($section['callback'])) {
            call_user_func($section['callback'], $section);
        }

        if (isset($wp_settings_fields['yiontech_lms_theme_settings'][$section_id])) {
            ?>
            <table class="form-table" role="presentation">
                <?php
                foreach ((array) $wp_settings_fields['yiontech_lms_theme_settings'][$section_id] as $field) {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php if (!empty($field['args']['label_for'])): ?>
                                <label for="<?php echo esc_attr($field['args']['label_for']); ?>"><?php echo esc_html($field['title']); ?></label>
                            <?php else: ?>
                                <?php echo esc_html($field['title']); ?>
                            <?php endif; ?>
                        </th>
                        <td>
                            <?php call_user_func($field['callback'], $field['args']); ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        ?>
    </div>
    <?php
}