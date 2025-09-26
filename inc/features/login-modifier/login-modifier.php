<?php
/**
 * Login Modifier Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Create custom login and registration pages
function yiontech_lms_create_custom_auth_pages() {
    // Check if pages already exist
    $login_page = get_page_by_path('login');
    $register_page = get_page_by_path('register');
    $profile_page = get_page_by_path('profile');
    $privacy_page = get_page_by_path('privacy-policy');
    $terms_page = get_page_by_path('terms-of-service');
    
    // Create login page if it doesn't exist
    if (!$login_page) {
        $login_page = array(
            'post_title'    => 'Login',
            'post_content'  => '[custom_login_form]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'login'
        );
        wp_insert_post($login_page);
    }
    
    // Create registration page if it doesn't exist
    if (!$register_page) {
        $register_page = array(
            'post_title'    => 'Register',
            'post_content'  => '[custom_registration_form]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'register'
        );
        wp_insert_post($register_page);
    }
    
    // Create profile page if it doesn't exist
    if (!$profile_page) {
        $profile_page = array(
            'post_title'    => 'Profile',
            'post_content'  => '[user_profile]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'profile'
        );
        wp_insert_post($profile_page);
    }
    
    // Create privacy policy page if it doesn't exist
    if (!$privacy_page) {
        $privacy_page = array(
            'post_title'    => 'Privacy Policy',
            'post_content'  => 'This is the privacy policy page. Please update this content with your actual privacy policy.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'privacy-policy'
        );
        $privacy_id = wp_insert_post($privacy_page);
        
        // Update privacy policy page setting
        $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
        $options['privacy_policy_page'] = $privacy_id;
        update_option('yiontech_lms_theme_settings', $options);
    }
    
    // Create terms of service page if it doesn't exist
    if (!$terms_page) {
        $terms_page = array(
            'post_title'    => 'Terms of Service',
            'post_content'  => 'This is the terms of service page. Please update this content with your actual terms of service.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => 'terms-of-service'
        );
        $terms_id = wp_insert_post($terms_page);
        
        // Update terms of service page setting
        $options = get_option('yiontech_lms_theme_settings', yiontech_lms_get_default_settings());
        $options['terms_of_service_page'] = $terms_id;
        update_option('yiontech_lms_theme_settings', $options);
    }
}
add_action('after_setup_theme', 'yiontech_lms_create_custom_auth_pages');

// Shortcode for custom login form
function yiontech_lms_custom_login_form_shortcode() {
    if (is_user_logged_in()) {
        return '<p>You are already logged in.</p>';
    }
    
    ob_start();
    ?>
    <div class="custom-auth-form">
        <h2>Login to Your Account</h2>
        <form id="custom_login_form" class="auth-form" method="post">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>
            <div class="form-group">
                <input type="submit" name="login_submit" value="Login" class="button button-primary">
            </div>
            <p class="auth-links">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>">Forgot Password?</a> | 
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('register'))); ?>">Create Account</a>
            </p>
            <?php wp_nonce_field('custom_login_nonce', 'login_nonce'); ?>
        </form>
        <div id="login_message" class="auth-message"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_login_form', 'yiontech_lms_custom_login_form_shortcode');

// Shortcode for custom registration form
function yiontech_lms_custom_registration_form_shortcode() {
    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }
    
    // Get privacy settings
    $enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
    $privacy_policy_page = yiontech_lms_get_theme_setting('privacy_policy_page');
    $terms_of_service_page = yiontech_lms_get_theme_setting('terms_of_service_page');
    
    $privacy_policy_url = $privacy_policy_page ? get_permalink($privacy_policy_page) : '';
    $terms_of_service_url = $terms_of_service_page ? get_permalink($terms_of_service_page) : '';
    
    ob_start();
    ?>
    <div class="custom-auth-form">
        <h2>Create Your Account</h2>
        <form id="custom_registration_form" class="auth-form" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="reg_username">Username</label>
                <input type="text" name="reg_username" id="reg_username" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Email</label>
                <input type="email" name="reg_email" id="reg_email" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Password</label>
                <input type="password" name="reg_password" id="reg_password" required>
            </div>
            <div class="form-group">
                <label for="reg_confirm_password">Confirm Password</label>
                <input type="password" name="reg_confirm_password" id="reg_confirm_password" required>
            </div>
            <div class="form-group">
                <label for="reg_first_name">First Name</label>
                <input type="text" name="reg_first_name" id="reg_first_name">
            </div>
            <div class="form-group">
                <label for="reg_last_name">Last Name</label>
                <input type="text" name="reg_last_name" id="reg_last_name">
            </div>
            <div class="form-group">
                <label for="reg_phone">Phone Number</label>
                <input type="tel" name="reg_phone" id="reg_phone">
            </div>
            <div class="form-group">
                <label for="reg_bio">Bio</label>
                <textarea name="reg_bio" id="reg_bio" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="reg_profile_image">Profile Image</label>
                <input type="file" name="reg_profile_image" id="reg_profile_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="reg_documents">Documents</label>
                <input type="file" name="reg_documents[]" id="reg_documents" multiple accept=".pdf,.doc,.docx,.txt">
            </div>
            
            <?php if ($enable_privacy_features && ($privacy_policy_url || $terms_of_service_url)) : ?>
                <div class="form-group privacy-consent">
                    <?php if ($privacy_policy_url && $terms_of_service_url) : ?>
                        <input type="checkbox" name="privacy_consent" id="privacy_consent" required>
                        <label for="privacy_consent">I agree to the <a href="<?php echo esc_url($privacy_policy_url); ?>" target="_blank">Privacy Policy</a> and <a href="<?php echo esc_url($terms_of_service_url); ?>" target="_blank">Terms of Service</a></label>
                    <?php elseif ($privacy_policy_url) : ?>
                        <input type="checkbox" name="privacy_consent" id="privacy_consent" required>
                        <label for="privacy_consent">I agree to the <a href="<?php echo esc_url($privacy_policy_url); ?>" target="_blank">Privacy Policy</a></label>
                    <?php elseif ($terms_of_service_url) : ?>
                        <input type="checkbox" name="privacy_consent" id="privacy_consent" required>
                        <label for="privacy_consent">I agree to the <a href="<?php echo esc_url($terms_of_service_url); ?>" target="_blank">Terms of Service</a></label>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="submit" name="register_submit" value="Register" class="button button-primary">
            </div>
            <p class="auth-links">
                Already have an account? <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>">Login</a>
            </p>
            <?php wp_nonce_field('custom_registration_nonce', 'registration_nonce'); ?>
        </form>
        <div id="registration_message" class="auth-message"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration_form', 'yiontech_lms_custom_registration_form_shortcode');

// Shortcode for user profile
function yiontech_lms_user_profile_shortcode() {
    if (!is_user_logged_in()) {
        return '<p>You need to login to view your profile.</p>';
    }
    
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Get user meta
    $phone = get_user_meta($user_id, 'phone', true);
    $bio = get_user_meta($user_id, 'bio', true);
    $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
    $profile_image_url = $profile_image_id ? wp_get_attachment_url($profile_image_id) : '';
    $documents = get_user_meta($user_id, 'documents', true);
    $documents = is_array($documents) ? $documents : array();
    
    // Get privacy settings
    $enable_data_export = yiontech_lms_get_theme_setting('enable_data_export');
    $enable_account_deletion = yiontech_lms_get_theme_setting('enable_account_deletion');
    
    ob_start();
    ?>
    <div class="user-profile">
        <h2>Your Profile</h2>
        <div class="profile-info">
            <div class="profile-image">
                <?php if ($profile_image_url) : ?>
                    <img src="<?php echo esc_url($profile_image_url); ?>" alt="Profile Image">
                <?php else : ?>
                    <div class="placeholder-image">No Image</div>
                <?php endif; ?>
            </div>
            <div class="profile-details">
                <h3><?php echo esc_html($current_user->display_name); ?></h3>
                <p><strong>Email:</strong> <?php echo esc_html($current_user->user_email); ?></p>
                <?php if ($phone) : ?>
                    <p><strong>Phone:</strong> <?php echo esc_html($phone); ?></p>
                <?php endif; ?>
                <?php if ($bio) : ?>
                    <p><strong>Bio:</strong> <?php echo esc_html($bio); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($documents)) : ?>
            <div class="user-documents">
                <h3>Your Documents</h3>
                <ul>
                    <?php foreach ($documents as $document_id) : 
                        $document_url = wp_get_attachment_url($document_id);
                        $document_title = get_the_title($document_id);
                        $document_type = get_post_mime_type($document_id);
                        ?>
                        <li>
                            <a href="<?php echo esc_url($document_url); ?>" target="_blank">
                                <?php echo esc_html($document_title); ?>
                                <span class="document-type">(<?php echo esc_html($document_type); ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="profile-actions">
            <?php if ($enable_data_export) : ?>
                <button id="export-data" class="button button-secondary">Export My Data</button>
            <?php endif; ?>
            
            <?php if ($enable_account_deletion) : ?>
                <button id="delete-account" class="button" style="background-color: #dc3545; color: white;">Delete My Account</button>
            <?php endif; ?>
            
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="button button-secondary">Logout</a>
        </div>
        
        <div id="profile-message" class="auth-message"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_profile', 'yiontech_lms_user_profile_shortcode');

// Handle custom login
function yiontech_lms_handle_custom_login() {
    if (isset($_POST['login_submit']) && isset($_POST['login_nonce']) && wp_verify_nonce($_POST['login_nonce'], 'custom_login_nonce')) {
        $username = sanitize_user($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? true : false;
        
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember
        );
        
        $user = wp_signon($creds, false);
        
        if (is_wp_error($user)) {
            wp_redirect(add_query_arg('login', 'failed', get_permalink(get_page_by_path('login'))));
            exit;
        } else {
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'yiontech_lms_handle_custom_login');

// Handle custom registration
function yiontech_lms_handle_custom_registration() {
    if (isset($_POST['register_submit']) && isset($_POST['registration_nonce']) && wp_verify_nonce($_POST['registration_nonce'], 'custom_registration_nonce')) {
        $username = sanitize_user($_POST['reg_username']);
        $email = sanitize_email($_POST['reg_email']);
        $password = $_POST['reg_password'];
        $confirm_password = $_POST['reg_confirm_password'];
        $first_name = sanitize_text_field($_POST['reg_first_name']);
        $last_name = sanitize_text_field($_POST['reg_last_name']);
        $phone = sanitize_text_field($_POST['reg_phone']);
        $bio = sanitize_textarea_field($_POST['reg_bio']);
        
        // Validate passwords match
        if ($password !== $confirm_password) {
            wp_redirect(add_query_arg('registration', 'password_mismatch', get_permalink(get_page_by_path('register'))));
            exit;
        }
        
        // Create user
        $user_id = wp_create_user($username, $password, $email);
        
        if (is_wp_error($user_id)) {
            wp_redirect(add_query_arg('registration', 'failed', get_permalink(get_page_by_path('register'))));
            exit;
        }
        
        // Update user meta
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);
        update_user_meta($user_id, 'phone', $phone);
        update_user_meta($user_id, 'bio', $bio);
        
        // Handle profile image upload
        if (!empty($_FILES['reg_profile_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $attachment_id = media_handle_upload('reg_profile_image', 0);
            if (!is_wp_error($attachment_id)) {
                update_user_meta($user_id, 'profile_image_id', $attachment_id);
            }
        }
        
        // Handle documents upload
        if (!empty($_FILES['reg_documents']['name'][0])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $documents = array();
            foreach ($_FILES['reg_documents']['name'] as $key => $value) {
                if ($_FILES['reg_documents']['name'][$key]) {
                    $file = array(
                        'name'     => $_FILES['reg_documents']['name'][$key],
                        'type'     => $_FILES['reg_documents']['type'][$key],
                        'tmp_name' => $_FILES['reg_documents']['tmp_name'][$key],
                        'error'    => $_FILES['reg_documents']['error'][$key],
                        'size'     => $_FILES['reg_documents']['size'][$key]
                    );
                    
                    $_FILES = array('reg_document' => $file);
                    $attachment_id = media_handle_upload('reg_document', 0);
                    
                    if (!is_wp_error($attachment_id)) {
                        $documents[] = $attachment_id;
                    }
                }
            }
            
            if (!empty($documents)) {
                update_user_meta($user_id, 'documents', $documents);
            }
        }
        
        // Log user in
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true
        );
        
        wp_signon($creds, false);
        
        wp_redirect(get_permalink(get_page_by_path('profile')));
        exit;
    }
}
add_action('init', 'yiontech_lms_handle_custom_registration');

// Show login/registration messages
function yiontech_lms_show_auth_messages() {
    if (isset($_GET['login']) && $_GET['login'] == 'failed') {
        echo '<div class="error-message">Invalid username or password. Please try again.</div>';
    }
    
    if (isset($_GET['registration'])) {
        if ($_GET['registration'] == 'password_mismatch') {
            echo '<div class="error-message">Passwords do not match. Please try again.</div>';
        } elseif ($_GET['registration'] == 'failed') {
            echo '<div class="error-message">Registration failed. Please try again.</div>';
        }
    }
}
add_action('wp_footer', 'yiontech_lms_show_auth_messages');

// Export user data
function yiontech_lms_export_user_data() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yiontech_lms_user_profile_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to export your data');
    }
    
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Get user data
    $user_data = get_userdata($user_id);
    
    // Get user meta
    $user_meta = get_user_meta($user_id);
    
    // Prepare data for export
    $export_data = array(
        'user_data' => array(
            'ID' => $user_data->ID,
            'user_login' => $user_data->user_login,
            'user_nicename' => $user_data->user_nicename,
            'user_email' => $user_data->user_email,
            'user_url' => $user_data->user_url,
            'user_registered' => $user_data->user_registered,
            'display_name' => $user_data->display_name,
        ),
        'user_meta' => array()
    );
    
    // Sanitize user meta data
    foreach ($user_meta as $key => $value) {
        // Skip sensitive data
        if (in_array($key, array('user_pass', 'user_activation_key', 'session_tokens'))) {
            continue;
        }
        
        // Handle arrays
        if (is_array($value) && isset($value[0])) {
            $export_data['user_meta'][$key] = maybe_unserialize($value[0]);
        } else {
            $export_data['user_meta'][$key] = $value;
        }
    }
    
    wp_send_json_success($export_data);
}
add_action('wp_ajax_yiontech_lms_export_user_data', 'yiontech_lms_export_user_data');

// Delete user account
function yiontech_lms_delete_user_account() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'yiontech_lms_user_profile_nonce')) {
        wp_send_json_error('Security check failed');
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to delete your account');
    }
    
    // Check if account deletion is enabled
    $enable_account_deletion = yiontech_lms_get_theme_setting('enable_account_deletion');
    if (!$enable_account_deletion) {
        wp_send_json_error('Account deletion is currently disabled');
    }
    
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    
    // Delete user
    require_once(ABSPATH . 'wp-admin/includes/user.php');
    $result = wp_delete_user($user_id);
    
    if ($result) {
        wp_send_json_success('Your account has been successfully deleted');
    } else {
        wp_send_json_error('Failed to delete your account');
    }
}
add_action('wp_ajax_yiontech_lms_delete_user_account', 'yiontech_lms_delete_user_account');

// Add custom styles for auth forms
function yiontech_lms_auth_form_styles() {
    ?>
    <style>
        
        .custom-auth-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }
        
        .custom-auth-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .auth-form .form-group {
            margin-bottom: 15px;
        }
        
        .auth-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .auth-form input[type="text"],
        .auth-form input[type="email"],
        .auth-form input[type="password"],
        .auth-form input[type="tel"],
        .auth-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd !important;
            border-radius: 4px;
        }
        
        .auth-form input[type="checkbox"] {
            margin-right: 5px;
        }
        
        .auth-form .button {
            display: inline-block;
            padding: 10px 20px;
            background: #1e40af;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .auth-form .button:hover {
            background: #1e3a8a;
        }
        
        .auth-links {
            margin-top: 20px;
            text-align: center;
        }
        
        .auth-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        
        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 20px auto;
            max-width: 500px;
            border-radius: 4px;
            text-align: center;
        }
        
        .user-profile {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .profile-info {
            display: flex;
            margin-bottom: 30px;
        }
        
        .profile-image {
            flex: 0 0 150px;
            margin-right: 30px;
        }
        
        .profile-image img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .placeholder-image {
            width: 150px;
            height: 150px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        
        .profile-details {
            flex: 1;
        }
        
        .profile-details h3 {
            margin-bottom: 15px;
        }
        
        .profile-details p {
            margin-bottom: 10px;
        }
        
        .user-documents {
            margin-bottom: 30px;
        }
        
        .user-documents ul {
            list-style: none;
            padding: 0;
        }
        
        .user-documents li {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .user-documents li:last-child {
            border-bottom: none;
        }
        
        .document-type {
            color: #666;
            font-size: 0.9em;
        }
        
        .profile-actions {
            text-align: center;
        }
        
        .profile-actions .button {
            margin: 0 5px;
        }
        
        /* Privacy consent checkbox */
        .privacy-consent {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .privacy-consent input[type="checkbox"] {
            margin-right: 10px;
        }
        
        .privacy-consent label {
            display: inline !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'yiontech_lms_auth_form_styles');