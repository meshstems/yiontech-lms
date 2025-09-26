<?php
/**
 * Template Name: Custom Login Page
 *
 * @package Yiontech_LMS
 */

// Add custom body class
add_filter('body_class', function($classes) {
    $classes[] = 'login-page';
    return $classes;
});

// Output minimal HTML structure for login page
get_header();
?>

<div class="site-content">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3">
                <?php echo do_shortcode('[custom_login_form]'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>