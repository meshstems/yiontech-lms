<?php
// Include theme settings
require_once get_template_directory() . '/admin/theme-settings.php';

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

// Enqueue scripts and styles
// Enqueue scripts and styles
function yiontech_lms_scripts() {
    // Get theme version for cache busting
    $theme_version = wp_get_theme()->get('Version');
    
    wp_enqueue_style('yiontech-lms-style', get_stylesheet_uri(), array(), $theme_version);
    // Enqueue Tailwind CSS via CDN
    wp_enqueue_style('yiontech-lms-tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), $theme_version);
    // Enqueue fixes CSS
    wp_enqueue_style('yiontech-lms-fixes', get_template_directory_uri() . '/css/fixes.css', array(), $theme_version);
    
    // Enqueue jQuery if it's not already loaded
    wp_enqueue_script('jquery');
    
    // Enqueue mobile menu script
    wp_enqueue_script('yiontech-lms-mobile-menu', get_template_directory_uri() . '/js/script.js', array('jquery'), $theme_version, true);
    
    // Enqueue preloader script if enabled
    $enable_preloader = yiontech_lms_get_theme_setting('enable_preloader');
    if ($enable_preloader) {
        wp_enqueue_script('yiontech-lms-preloader', get_template_directory_uri() . '/js/preloader.js', array('jquery'), $theme_version, true);
    }
    
    // Enqueue header scroll script if transparent header is enabled
    $transparent_header = yiontech_lms_get_theme_setting('transparent_header');
    $sticky_header = yiontech_lms_get_theme_setting('sticky_header');
    if ($transparent_header || $sticky_header) {
        wp_enqueue_script('yiontech-lms-header-scroll', get_template_directory_uri() . '/js/header-scroll.js', array('jquery'), $theme_version, true);
    }
    
    // Enqueue back-to-top script if enabled
    $enable_back_to_top = yiontech_lms_get_theme_setting('enable_back_to_top');
    if ($enable_back_to_top) {
        wp_enqueue_script('yiontech-lms-back-to-top', get_template_directory_uri() . '/js/back-to-top.js', array('jquery'), $theme_version, true);
    }
    
    // Enqueue newsletter script if enabled
    $newsletter_enable = yiontech_lms_get_theme_setting('newsletter_enable');
    if ($newsletter_enable) {
        wp_enqueue_script('yiontech-lms-newsletter', get_template_directory_uri() . '/js/newsletter.js', array('jquery'), $theme_version, true);
        wp_localize_script('yiontech-lms-newsletter', 'yiontech_lms_newsletter', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'success_message' => yiontech_lms_get_theme_setting('newsletter_success_message', 'Thank you for subscribing!'),
        ));
    }
    
    // Add inline script to prevent scroll jumps
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            // Store scroll position before any scripts run
            var scrollPosition = $(window).scrollTop();
            
            // Restore scroll position after all scripts are initialized
            $(window).on("load", function() {
                setTimeout(function() {
                    $(window).scrollTop(scrollPosition);
                }, 100);
            });
        });
    ');
}
add_action('wp_enqueue_scripts', 'yiontech_lms_scripts');

// Elementor compatibility
function yiontech_lms_elementor_setup() {
    // Add theme compatibility
    add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
        $elementor_theme_manager->register_location('header');
        $elementor_theme_manager->register_location('footer');
    });
}
add_action('after_setup_theme', 'yiontech_lms_elementor_setup');

// Add custom image sizes for courses
add_action('after_setup_theme', 'yiontech_lms_add_image_sizes');
function yiontech_lms_add_image_sizes() {
    add_image_size('course-thumbnail', 400, 250, true);
}

// Full width for Elementor pages with Tailwind container width - CORRECTED VERSION
function yiontech_lms_elementor_full_width() {
    if (function_exists('\\Elementor\\Plugin')) {
        $document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
        if ($document && $document->is_built_with_elementor()) {
            ?>
            <style>
                /* Only remove theme container constraints for Elementor pages */
                body.elementor-page .site-content > .container,
                body.elementor-page .site-content > .container > .flex,
                body.elementor-page .site-content > .container > .flex > div:first-child {
                    max-width: 100% !important;
                    width: 100% !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }
                
                /* But preserve Elementor's own container settings */
                body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                    max-width: 1140px;
                    width: 100%;
                    padding-left: 15px;
                    padding-right: 15px;
                    margin-left: auto;
                    margin-right: auto;
                }
                
                /* Full width sections should remain full width */
                body.elementor-page .elementor-section.elementor-section-full_width > .elementor-container {
                    max-width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                
                /* Responsive adjustments */
                @media (min-width: 768px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 720px;
                    }
                }
                
                @media (min-width: 992px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 960px;
                    }
                }
                
                @media (min-width: 1200px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 1140px;
                    }
                }
            </style>
            <?php
        }
    }
}
add_action('wp_head', 'yiontech_lms_elementor_full_width');

// Add admin styles for theme settings
function yiontech_lms_admin_styles() {
    ?>
    <style>
        /* Improved admin styles for theme settings */
        .wrap h1 {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-table {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .form-table th {
            padding: 20px;
            background: #f9f9f9;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        
        .form-table td {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .form-table tr:last-child td {
            border-bottom: none;
        }
        
        input[type="text"], 
        input[type="email"], 
        input[type="url"], 
        input[type="password"], 
        input[type="number"], 
        textarea, 
        select {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.07);
        }
        
        input[type="color"] {
            height: 40px;
            width: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="checkbox"] {
            margin-right: 10px;
        }
        
        .description {
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
        
        .button {
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
        }
        
        .button-primary {
            background: #0085ba;
            color: #fff;
            border: 1px solid #0085ba;
        }
        
        .button-primary:hover {
            background: #0073a8;
            border-color: #0073a8;
        }
        
        .button-secondary {
            background: #f7f7f7;
            color: #555;
            border: 1px solid #ccc;
        }
        
        .button-secondary:hover {
            background: #f0f0f0;
            border-color: #999;
        }
        
        /* Media field styles */
        .media-field {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .media-preview {
            width: 200px;
            height: 100px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .media-preview img {
            max-width: 100%;
            max-height: 100%;
        }
        
        /* Header buttons field styles */
        .header-buttons-field, .menu-field {
            margin-top: 10px;
        }
        
        .header-buttons, .menu-items {
            margin-bottom: 10px;
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .header-button-item, .menu-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        .header-button-item:last-child, .menu-item:last-child {
            margin-bottom: 0;
        }
        
        .header-button-item div, .menu-item div {
            margin-bottom: 10px;
        }
        
        .header-button-item div:last-child, .menu-item div:last-child {
            margin-bottom: 0;
        }
        
        .header-button-item label, .menu-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .remove-button, .remove-menu-item, .remove-link {
            background: #ff4d4d;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .remove-button:hover, .remove-menu-item:hover, .remove-link:hover {
            background: #ff1a1a;
        }
        
        .add-button, .add-menu-item, .add-link {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .add-button:hover, .add-menu-item:hover, .add-link:hover {
            background: #4cae4c;
        }
        
        /* Footer content field styles */
        .footer-content-field h4 {
            margin: 20px 0 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-size: 16px;
            color: #23282d;
        }
        
        .footer-links {
            margin-bottom: 10px;
            max-height: 200px;
            overflow-y: auto;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            border-radius: 4px;
        }
        
        .footer-link-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 4px;
        }
        
        .footer-link-item:last-child {
            margin-bottom: 0;
        }
        
        .footer-link-item input {
            flex: 1;
        }
        
        /* Spacing field styles */
        .spacing-field {
            display: flex;
            gap: 20px;
        }
        
        .spacing-field > div {
            flex: 1;
        }
        
        .spacing-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>
    <?php
}
add_action('admin_head', 'yiontech_lms_admin_styles');

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

// Create custom login and registration pages
function yiontech_lms_create_custom_auth_pages() {
    // Check if pages already exist
    $login_page = get_page_by_path('login');
    $register_page = get_page_by_path('register');
    $profile_page = get_page_by_path('profile');
    
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
            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="button button-secondary">Logout</a>
        </div>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            border: 1px solid #ddd;
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
        
        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #1e40af;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: #1e3a8a;
        }
    </style>
    <?php
}
add_action('wp_head', 'yiontech_lms_auth_form_styles');