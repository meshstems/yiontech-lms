<?php
/**
 * Yiontech LMS Custom Auth – Registration with Document Upload Integration
 * Enhanced Professional UI Version with Two-Column Layout
 *
 * Handles:
 * - Registration
 * - File uploads during registration
 * - Full registration fields, hooks, notifications, and password strength meter
 * - Professional UI matching Yiontech brand standards
 * - Two-column layout for desktop
 * - Auto-creates /register page and assigns registration-blank-template.php
 * - Ensures template include points to this module's templates/registration-blank-template.php
 */

if (!defined('ABSPATH')) exit;

/*--------------------------------------------------------------
# 1. Get Tutor Dashboard URL
--------------------------------------------------------------*/
function yiontech_get_tutor_dashboard_url() {
    if (function_exists('tutor_utils')) {
        $dashboard_page_id = (int) tutor_utils()->get_option('tutor_dashboard_page_id');
        $dashboard_slug = $dashboard_page_id ? get_post_field('post_name', $dashboard_page_id) : '';
        if ($dashboard_slug) {
            return home_url(trailingslashit($dashboard_slug));
        }
    }
    return home_url('/');
}

/*--------------------------------------------------------------
# 2. Shortcode function (define, but register on init)
--------------------------------------------------------------*/
function yiontech_lms_custom_registration_form_shortcode() {
    if (is_user_logged_in()) {
        return '<div class="flex justify-center bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-lg flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg></div><div class="ml-3"><p class="text-sm text-blue-700">You are already logged in. <a href="' . esc_url(yiontech_get_tutor_dashboard_url()) . '" class="font-medium underline hover:text-blue-800">Go to Dashboard</a></p></div></div>';
    }

    ob_start(); ?>
    <style>
      input{border: solid 2px #fcf8ff !important;}


    </style>
    <div id="tutor-registration-wrap" class="custom-auth-form w-full my-10 px-4 sm:px-6">
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
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Start Your Learning Journey</h3>
                        <p class="text-gray-600 mb-6">Join thousands of students who are advancing their careers with our expert-led courses.</p>
                        
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
                                    <h4 class="text-sm font-medium text-gray-800">Expert Instructors</h4>
                                    <p class="text-sm text-gray-600 mt-1">Learn from industry professionals with real-world experience.</p>
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
                                    <h4 class="text-sm font-medium text-gray-800">Flexible Learning</h4>
                                    <p class="text-sm text-gray-600 mt-1">Study at your own pace with our self-paced courses.</p>
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
                                    <h4 class="text-sm font-medium text-gray-800">Certification</h4>
                                    <p class="text-sm text-gray-600 mt-1">Earn certificates upon completion to showcase your skills.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 w-full">
                            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200 w-full">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Testimonial">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Sarah Johnson</p>
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
                                <p class="mt-3 text-sm text-gray-600">"The courses here transformed my career. The instructors are top-notch and the content is practical and up-to-date."</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Form -->
                <div class="p-8 w-full">
                    <form id="custom_registration_form" enctype="multipart/form-data" class="space-y-6 w-full">
                        <?php do_action('tutor_before_student_reg_form'); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr(tutor_utils()->input_old('first_name')); ?>" required autocomplete="given-name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr(tutor_utils()->input_old('last_name')); ?>" required autocomplete="family-name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="reg_username">Username</label>
                                <input type="text" name="reg_username" id="reg_username" value="<?php echo esc_attr(tutor_utils()->input_old('reg_username')); ?>" required autocomplete="username" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="reg_email">Email</label>
                                <input type="email" name="reg_email" id="reg_email" value="<?php echo esc_attr(tutor_utils()->input_old('reg_email')); ?>" required autocomplete="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                            <div>
                                <div class="password-strength-checker w-full">
                                    <div class="password-field w-full">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="tutor-new-password">Password</label>
                                        <div class="relative w-full">
                                            <input class="password-checker w-full pr-12 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" id="tutor-new-password" type="password" name="reg_password" value="" placeholder="Password" required autocomplete="new-password">
                                            <button type="button" class="show-hide-btn absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="password-strength-hint mt-3 w-full">
                                        <div class="flex justify-between gap-10 items-center mb-1 w-full">
                                            <div class="indicator flex space-x-1 w-full">
                                                <span class="weak h-1.5 w-1/4 rounded-full bg-gray-200"></span>
                                                <span class="medium h-1.5 w-1/4 rounded-full bg-gray-200"></span>
                                                <span class="strong h-1.5 w-1/4 rounded-full bg-gray-200"></span>
                                                <span class="very-strong h-1.5 w-1/4 rounded-full bg-gray-200"></span>
                                            </div>
                                            <span class="strength-text w-[100px] text-xs font-medium">Very Weak</span>
                                        </div>
                                        <div class="text text-xs text-gray-500">Use 8 or more characters with a mix of letters, numbers & symbols</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="reg_confirm_password">Confirm Password</label>
                                <input type="password" name="reg_confirm_password" id="reg_confirm_password" value="" placeholder="Confirm Password" required autocomplete="new-password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                            </div>
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="reg_documents">Upload Documents</label>
                            <div class="file-upload-area mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition duration-200 w-full">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="reg_documents" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                            <span>Upload files</span>
                                            <input id="reg_documents" name="reg_documents[]" type="file" multiple class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB each</p>
                                </div>
                            </div>
                            <div class="file-list mt-3 hidden"></div>
                        </div>

                        <?php do_action('tutor_student_reg_form_middle'); ?>
                        <?php do_action('register_form'); ?>

                        <?php
                        $tutor_toc_page_link = tutor_utils()->get_toc_page_link();
                        if ($tutor_toc_page_link) :
                        ?>
                            <div class="text-sm text-gray-600 flex items-start">
                                <input type="checkbox" id="terms" class="mt-1 mr-2 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="terms">By signing up, I agree with the website's <a target="_blank" href="<?php echo esc_url($tutor_toc_page_link); ?>" class="font-medium text-purple-600 hover:text-purple-500">Terms and Conditions</a></label>
                            </div>
                        <?php endif; ?>

                        <div class="mt-8 w-full">
                            <button type="submit" name="tutor_register_student_btn" value="register" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200">
                                Create Account
                            </button>
                        </div>

                        <?php do_action('tutor_after_register_button'); ?>
                    </form>

                    <div id="registration_result" class="mt-4 w-full"></div>
                    <p class="mt-6 text-center text-sm text-gray-600 w-full">
                        Already have an account? 
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('login'))); ?>" class="font-medium text-purple-600 hover:text-purple-500">
                            Login
                        </a>
                    </p>

                    <?php do_action('tutor_after_student_reg_form'); ?>
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
    add_shortcode('custom_registration_form', 'yiontech_lms_custom_registration_form_shortcode');
});

/*--------------------------------------------------------------
# 4. Enqueue registration scripts (ajax)
--------------------------------------------------------------*/
function yiontech_lms_enqueue_registration_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_media();

    wp_add_inline_script('jquery', "
        jQuery(document).ready(function($){
            // Registration AJAX
            $('#custom_registration_form').on('submit', function(e){
                e.preventDefault();
                
                // Show loading state
                var submitBtn = $(this).find('button[type=\"submit\"]');
                var originalText = submitBtn.text();
                submitBtn.prop('disabled', true).html('<svg class=\"animate-spin -ml-1 mr-3 h-5 w-5 text-white\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\"><circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle><path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"></path></svg> Creating Account...');
                
                var formData = new FormData(this);
                formData.append('action', 'yiontech_register');
                $.ajax({
                    url: '" . admin_url('admin-ajax.php') . "',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            $('#registration_result').html('<div class=\"bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded flex\"><div class=\"flex-shrink-0\"><svg class=\"h-5 w-5 text-green-400\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z\" clip-rule=\"evenodd\" /></svg></div><div class=\"ml-3\"><p class=\"text-sm text-green-700\">Registration successful! Redirecting...</p></div></div>');
                            setTimeout(function(){
                                window.location.href = response.data.redirect;
                            }, 1500);
                        } else {
                            $('#registration_result').html('<div class=\"bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded flex\"><div class=\"flex-shrink-0\"><svg class=\"h-5 w-5 text-red-400\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\" /></svg></div><div class=\"ml-3\"><p class=\"text-sm text-red-700\">'+response.data+'</p></div></div>');
                            submitBtn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(){
                        $('#registration_result').html('<div class=\"bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded flex\"><div class=\"flex-shrink-0\"><svg class=\"h-5 w-5 text-red-400\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z\" clip-rule=\"evenodd\" /></svg></div><div class=\"ml-3\"><p class=\"text-sm text-red-700\">An unexpected error occurred. Please try again.</p></div></div>');
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                var strength = 0;
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]+/)) strength++;
                if (password.match(/[A-Z]+/)) strength++;
                if (password.match(/[0-9]+/)) strength++;
                if (password.match(/[\\W]+/)) strength++;
                return strength;
            }

            $('#tutor-new-password').on('input', function(){
                var strength = checkPasswordStrength($(this).val());
                var indicators = $(this).closest('.password-strength-checker').find('.indicator span');
                var strengthText = $(this).closest('.password-strength-checker').find('.strength-text');
                
                indicators.removeClass('active bg-red-500 bg-yellow-500 bg-green-500');
                strengthText.removeClass('text-red-500 text-yellow-500 text-green-500');
                
                if (strength === 0) {
                    strengthText.text('Very Weak').addClass('text-red-500');
                } else if (strength === 1) {
                    strengthText.text('Weak').addClass('text-red-500');
                    indicators.eq(0).addClass('active bg-red-500');
                } else if (strength === 2) {
                    strengthText.text('Fair').addClass('text-yellow-500');
                    for(var i=0; i<2; i++) {
                        indicators.eq(i).addClass('active bg-yellow-500');
                    }
                } else if (strength === 3) {
                    strengthText.text('Good').addClass('text-yellow-500');
                    for(var i=0; i<3; i++) {
                        indicators.eq(i).addClass('active bg-yellow-500');
                    }
                } else if (strength === 4) {
                    strengthText.text('Strong').addClass('text-green-500');
                    for(var i=0; i<4; i++) {
                        indicators.eq(i).addClass('active bg-green-500');
                    }
                } else if (strength === 5) {
                    strengthText.text('Very Strong').addClass('text-green-500');
                    for(var i=0; i<4; i++) {
                        indicators.eq(i).addClass('active bg-green-500');
                    }
                }
            });
            
            // Show/hide password
            $('.show-hide-btn').on('click', function(){
                var passwordField = $(this).closest('.password-field').find('input');
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('svg').html('<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21\" />');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('svg').html('<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\" /><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\" />');
                }
            });
            
            // File upload area interaction
            var fileUploadArea = $('.file-upload-area');
            var fileInput = $('#reg_documents');
            
            fileUploadArea.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('border-purple-500 bg-purple-50');
            });
            
            fileUploadArea.on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('border-purple-500 bg-purple-50');
            });
            
            fileUploadArea.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('border-purple-500 bg-purple-50');
                
                var files = e.originalEvent.dataTransfer.files;
                fileInput.prop('files', files);
                
                // Display selected files
                displaySelectedFiles(files);
            });
            
            fileInput.on('change', function() {
                displaySelectedFiles(this.files);
            });
            
            function displaySelectedFiles(files) {
                var fileList = $('.file-list');
                fileList.empty();
                
                if (files.length > 0) {
                    fileList.append('<h4 class=\"text-sm font-medium text-gray-700 mb-2\">Selected Files:</h4>');
                    fileList.append('<ul class=\"space-y-1\">');
                    
                    for (var i = 0; i < files.length; i++) {
                        var fileName = files[i].name;
                        var fileSize = (files[i].size / 1024).toFixed(2) + ' KB';
                        
                        fileList.find('ul').append(
                            '<li class=\"flex items-center justify-between text-sm text-gray-600 py-1 px-2 bg-gray-50 rounded\">' +
                            '<span class=\"truncate max-w-xs\">' + fileName + '</span>' +
                            '<span class=\"text-xs text-gray-500\">' + fileSize + '</span>' +
                            '</li>'
                        );
                    }
                    
                    fileList.append('</ul>');
                    fileList.show();
                } else {
                    fileList.hide();
                }
            }
        });
    ");
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_registration_scripts');

/*--------------------------------------------------------------
# 5. AJAX Registration Handler
--------------------------------------------------------------*/
function yiontech_lms_ajax_register() {
    $username   = sanitize_user($_POST['reg_username']);
    $email      = sanitize_email($_POST['reg_email']);
    $password   = $_POST['reg_password'];
    $confirm    = $_POST['reg_confirm_password'];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name  = sanitize_text_field($_POST['last_name']);

    if (!defined('USER_DOC_META_KEY')) define('USER_DOC_META_KEY', 'yiontech_user_documents');
    if (!defined('PRIVATE_UPLOAD_DIR_ROOT')) define('PRIVATE_UPLOAD_DIR_ROOT', WP_CONTENT_DIR . '/uploads/yiontech-lms-private/');

    if ($password !== $confirm) wp_send_json_error('Passwords do not match.');
    if (username_exists($username) || email_exists($email)) wp_send_json_error('Username or email already exists.');

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) wp_send_json_error($user_id->get_error_message());

    wp_update_user([
        'ID'         => $user_id,
        'first_name' => $first_name,
        'last_name'  => $last_name
    ]);

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    // File uploads
    $uploaded_files = [];
    if (!empty($_FILES['reg_documents']['name'][0])) {
        $user_dir = PRIVATE_UPLOAD_DIR_ROOT . $user_id . '/';
        if (!is_dir($user_dir)) wp_mkdir_p($user_dir);

        foreach ($_FILES['reg_documents']['name'] as $key => $name) {
            if ($_FILES['reg_documents']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name   = sanitize_file_name($name);
                $target_path = $user_dir . $file_name;
                if (move_uploaded_file($_FILES['reg_documents']['tmp_name'][$key], $target_path)) {
                    $uploaded_files[] = [
                        'filename'    => $file_name,
                        'path'        => $target_path,
                        'uploaded_on' => current_time('mysql'),
                        'size'        => filesize($target_path),
                        'type'        => 'file',
                    ];
                }
            }
        }
    }
    update_user_meta($user_id, USER_DOC_META_KEY, $uploaded_files);
    update_user_meta($user_id, 'yiontech_first_login', 1);

    // Trigger Tutor registration hooks & notifications
    do_action('tutor_student_registered', $user_id);

    wp_send_json_success(['redirect' => yiontech_get_tutor_dashboard_url()]);
}
add_action('wp_ajax_nopriv_yiontech_register', 'yiontech_lms_ajax_register');
add_action('wp_ajax_yiontech_register', 'yiontech_lms_ajax_register');

/*--------------------------------------------------------------
# 6. Auto-create register page & assign template (init)
#    Use init so shortcode registration and filters are available.
--------------------------------------------------------------*/
add_action('init', function () {
    $slug      = 'register';
    $title     = 'Register';
    $shortcode = '[custom_registration_form]';
    $template  = 'registration-blank-template.php'; // Changed to use registration-specific template

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
            update_post_meta($page_id, '_wp_page_template', $template);
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
        update_post_meta($page->ID, '_wp_page_template', $template);
    }
});

/*--------------------------------------------------------------
# 7. Register and load custom blank template from this module
--------------------------------------------------------------*/
add_filter('theme_page_templates', function ($templates) {
    // expose the template name in Page > Template dropdown (optional)
    $templates['registration-blank-template.php'] = 'Registration Blank (No Header/Footer)';
    return $templates;
});

add_filter('template_include', function ($template) {
    if (is_page_template('registration-blank-template.php')) {
        $module_template = __DIR__ . '/templates/registration-blank-template.php';
        if (file_exists($module_template)) {
            return $module_template;
        }
    }
    return $template;
});