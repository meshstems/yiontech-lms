<?php
/**
 * Login modifier module
 *
 * - Registers [custom_login_form] shortcode on init
 * - Handles AJAX login
 * - Auto-creates /login page and assigns login-blank-template.php
 * - Ensures template include points to this module's templates/login-blank-template.php
 */

if (!defined('ABSPATH')) exit;


/*--------------------------------------------------------------
# 2. Shortcode function (define, but register on init)
--------------------------------------------------------------*/
function yiontech_lms_custom_login_form_shortcode() {
    if (is_user_logged_in()) {
        return '<div class="flex justify-center bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-lg flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg></div><div class="ml-3"><p class="text-sm text-blue-700">You are already logged in. <a href="' . esc_url(yiontech_get_tutor_dashboard_url()) . '" class="font-medium underline hover:text-blue-800">Go to Dashboard</a></p></div></div>';
    }

    ob_start(); ?>
    <style>
      input{border: solid 2px #fcf8ff !important;}
    </style>
    <div id="tutor-login-wrap" class="custom-auth-form w-full my-10 px-4 sm:px-6">
        <div class="bg-white rounded-2xl w-full overflow-hidden shadow-xl">
            
            <!-- Two-column content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 w-full">
                <!-- Left column: Marketing section -->
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-8 lg:p-12 flex flex-col justify-center w-full">
                    <div class="max-w-md mx-auto w-full">
                        <!-- Header with brand color -->
                        <div class="py-5 px-6 relative overflow-hidden lg:-mx-10 lg:-mt-12 mb-0">
                       
                         <h1 class="text-4xl font-bold text-gray-800 mb-4"> <?php echo esc_html(get_bloginfo('name')); ?></h1>
                       
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Welcome Back</h3>
                        <p class="text-gray-600 mb-6">Sign in to access your courses and continue your learning journey.</p>
                        
                        <div class="space-y-4 w-full">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-purple-100 text-purple-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-800">Access Your Courses</h4>
                                    <p class="text-sm text-gray-600 mt-1">Continue from where you left off in your learning journey.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-purple-100 text-purple-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-800">Track Your Progress</h4>
                                    <p class="text-sm text-gray-600 mt-1">Monitor your learning progress and achievements.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="flex items-center justify-center h-6 w-6 rounded-full bg-purple-100 text-purple-600">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-800">Join Discussions</h4>
                                    <p class="text-sm text-gray-600 mt-1">Participate in course discussions and connect with peers.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 w-full">
                            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Testimonial">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Michael Chen</p>
                                        <div class="flex items-center">
                                            <div class="flex text-yellow-400">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 text-sm text-gray-600">"The learning platform has transformed how I approach professional development. The courses are top-notch!"</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Form -->
                <div class="p-8 w-full">
                    <form id="custom_login_form" method="post" class="space-y-6 w-full">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="username">Username or Email</label>
                            <input type="text" name="username" id="username" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                            <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>
                            <div class="text-sm">
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="font-medium text-purple-600 hover:text-purple-500">Forgot your password?</a>
                            </div>
                        </div>

                        <div class="mt-8 w-full">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200">
                                Sign in
                            </button>
                        </div>
                    </form>

                    <div id="login_result" class="mt-4 w-full"></div>
                    <p class="mt-6 text-center text-sm text-gray-600 w-full">
                        Don't have an account? 
                        <a href="<?php echo esc_url(get_permalink(get_option('yiontech_page_register_id'))); ?>" class="font-medium text-purple-600 hover:text-purple-500">
                            Register
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer with Yiontech branding -->
        <div class="mt-8 text-center text-gray-500 text-sm w-full">
            <p>© <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All rights reserved.</p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/*--------------------------------------------------------------
# 3. Register shortcode early (init)
--------------------------------------------------------------*/
add_action('init', function() {
    // register shortcode here so it's available before templates render
    add_shortcode('custom_login_form', 'yiontech_lms_custom_login_form_shortcode');
});

/*--------------------------------------------------------------
# 4. Enqueue login scripts (ajax)
--------------------------------------------------------------*/
function yiontech_lms_enqueue_login_scripts() {
    wp_enqueue_script('jquery');

    wp_add_inline_script('jquery', "
        jQuery(document).ready(function($){
            // Login AJAX
            $('#custom_login_form').on('submit', function(e){
                e.preventDefault();
                
                // Show loading state
                var submitBtn = $(this).find('button[type=\"submit\"]');
                var originalText = submitBtn.text();
                submitBtn.prop('disabled', true).html('<svg class=\"animate-spin -ml-1 mr-3 h-5 w-5 text-white\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\"><circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle><path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"></path></svg> Signing in...');
                
                var data = $(this).serialize() + '&action=yiontech_login';
                $.post('" . admin_url('admin-ajax.php') . "', data, function(response){
                    if(response.success){
                        $('#login_result').html('<div class=\"bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded flex\"><div class=\"flex-shrink-0\"><svg class=\"h-5 w-5 text-green-400\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\" /></svg></div><div class=\"ml-3\"><p class=\"text-sm text-green-700\">Login successful! Redirecting...</p></div></div>');
                        setTimeout(function(){
                            window.location.href = response.data.redirect;
                        }, 1500);
                    } else {
                        $('#login_result').html('<div class=\"bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded flex\"><div class=\"flex-shrink-0\"><svg class=\"h-5 w-5 text-red-400\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\" /></svg></div><div class=\"ml-3\"><p class=\"text-sm text-red-700\">'+response.data+'</p></div></div>');
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                }, 'json');
            });
        });
    ");
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_login_scripts');

/*--------------------------------------------------------------
# 5. AJAX Login Handler
--------------------------------------------------------------*/
function yiontech_lms_ajax_login() {
    $creds = [
        'user_login'    => isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '',
        'user_password' => isset($_POST['password']) ? $_POST['password'] : '',
        'remember'      => isset($_POST['remember']) ? true : false
    ];

    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        wp_send_json_error($user->get_error_message());
    } else {
        wp_send_json_success([
            'redirect' => yiontech_get_tutor_dashboard_url()
        ]);
    }
}
add_action('wp_ajax_nopriv_yiontech_login', 'yiontech_lms_ajax_login');
add_action('wp_ajax_yiontech_login', 'yiontech_lms_ajax_login');

/*--------------------------------------------------------------
# 6. Auto-create login page & assign template (init)
#    Use init so shortcode registration and filters are available.
--------------------------------------------------------------*/
add_action('init', function () {
    $slug      = 'login';
    $title     = 'Login';
    $shortcode = '[custom_login_form]';

    $page = get_page_by_path($slug);

    if (!$page) {
        $page_id = wp_insert_post([
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $shortcode,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);

        if ($page_id && !is_wp_error($page_id)) {
            update_option("yiontech_page_{$slug}_id", $page_id);
            update_post_meta($page_id, '_wp_page_template', 'login-blank-template.php');
        }
    } else {
        if (strpos($page->post_content, $shortcode) === false) {
            wp_update_post([
                'ID'           => $page->ID,
                'post_content' => $shortcode,
            ]);
            // Refresh $page variable if needed
            $page = get_post($page->ID);
        }
        update_option("yiontech_page_{$slug}_id", $page->ID);
        update_post_meta($page->ID, '_wp_page_template', 'login-blank-template.php');
    }
});

/*--------------------------------------------------------------
# 7. Register and load custom blank template from this module
--------------------------------------------------------------*/
add_filter('theme_page_templates', function ($templates) {
    // expose the template name in Page > Template dropdown (optional)
    $templates['login-blank-template.php'] = 'Blank (No Header/Footer)';
    return $templates;
});

add_filter('template_include', function ($template) {
    if (is_page_template('login-blank-template.php')) {
        $module_template = __DIR__ . '/templates/login-blank-template.php';
        if (file_exists($module_template)) {
            return $module_template;
        }
    }
    return $template;
});

/**
 * Always override Tutor LMS login URL
 * This prevents links with `#`
 */
add_filter('tutor_login_url', function($url) {
    // Redirect to our custom login template page
    return site_url('/login'); // you can change this slug
});

/**
 * Force Tutor LMS to load our custom blank login template
 */
add_action('template_redirect', function() {
    if ( function_exists('tutor_utils') && tutor_utils()->is_login_page() ) {
        $template_file = get_template_directory() . '/inc/features/login-modifier/templates/login-blank-template.php';
        if ( file_exists($template_file) ) {
            include $template_file;
            exit;
        }
    }
});