<?php
/**
 * Blank Template (No Header/Footer) for Login
 */
if (!defined('ABSPATH')) exit;

// Get your login page
$login_page = get_page_by_path('login'); // change 'login' if needed
$login_page_id = $login_page ? $login_page->ID : 0;

// If user is not logged in AND not already on the login page → redirect
if ( ! is_user_logged_in() && ! is_page($login_page_id) ) {
    if ($login_page) {
        // Preserve current URL
        $redirect_to = urlencode( home_url( add_query_arg( null, null ) ) );
        wp_redirect( add_query_arg( 'redirect_to', $redirect_to, get_permalink($login_page) ) );
        exit;
    } else {
        // fallback to default WordPress login
        auth_redirect();
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .site-content {
            max-width: 100% !important;
            width: 100% !important;
        }
        .form-wrapper {
            max-width: 100% !important;
            width: 100% !important;
            background: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #tutor-login-wrap {
            max-width: 100% !important;
            width: 100% !important;
        }
        input {
            border: solid 2px #fcf8ff !important;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class('blank-template login-page bg-gray-50'); ?>>

<div class="site-content w-full flex items-center justify-center min-h-screen bg-gray-50">
    <div class="form-wrapper w-full">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                // If you’re using Tutor’s [custom_login_form], make sure it respects redirect_to
                // If not, you can swap it with wp_login_form like this:
                if (has_shortcode(get_the_content(), 'custom_login_form')) {
                    the_content();
                } else {
                    wp_login_form([
                        'redirect' => isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : home_url(),
                    ]);
                }
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
