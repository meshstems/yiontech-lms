<?php
/**
 * Blank Template (No Header/Footer) for Registration
 */
if (!defined('ABSPATH')) exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Remove any default max-width constraints */
        .site-content {
            max-width: 100% !important;
            width: 100% !important;
        }
        .form-wrapper {
            max-width: 100% !important;
            width: 100% !important;
        }
        /* Make sure the form takes full width */
        #tutor-registration-wrap {
            max-width: 100% !important;
            width: 100% !important;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class('blank-template register-page bg-gray-50'); ?>>

<div class="site-content w-full" style="display:flex;align-items:center;justify-content:center;min-height:100vh;background:#f9fafb;">
    <div class="form-wrapper w-full" style="background:#fff;padding:0;border-radius:0;box-shadow:none;max-width:100%;">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content(); // Renders [custom_registration_form]
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>