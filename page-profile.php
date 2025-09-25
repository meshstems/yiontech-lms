<?php
/**
 * Template Name: User Profile Page
 *
 * @package Yiontech_LMS
 */

get_header();
?>

<div class="site-content">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-center">
            <div class="w-full md:w-3/4">
                <?php echo do_shortcode('[user_profile]'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>