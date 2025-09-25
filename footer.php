<?php
/**
 * Footer template for Yiontech LMS
 */

// Check if this is a login or register page
$is_auth_page = is_page_template('page-login.php') || is_page_template('page-register.php');

// Don't load footer for auth pages
if ($is_auth_page) {
    wp_footer();
    echo '</body></html>';
    return;
}
?>
<?php
$footer_style = yiontech_lms_get_theme_setting('footer_style', 'default');
$footer_content = yiontech_lms_get_theme_setting('footer_content');
$copyright_text = yiontech_lms_get_theme_setting('copyright_text', '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.');
$footer_text_color = yiontech_lms_get_theme_setting('footer_text_color', '#ffffff');
$footer_background_color = yiontech_lms_get_theme_setting('footer_background_color', '#111827');
$copyright_background_color = yiontech_lms_get_theme_setting('copyright_background_color', '#0f172a');
$footer_padding = yiontech_lms_get_theme_setting('footer_padding', array('top' => 48, 'bottom' => 48));
$padding_top = isset($footer_padding['top']) ? $footer_padding['top'] : 48;
$padding_bottom = isset($footer_padding['bottom']) ? $footer_padding['bottom'] : 48;
$logo = yiontech_lms_get_theme_setting('logo_upload');
$newsletter_enable = yiontech_lms_get_theme_setting('newsletter_enable');
$enable_back_to_top = yiontech_lms_get_theme_setting('enable_back_to_top');

// Get privacy settings
$enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
$privacy_policy_url = yiontech_lms_get_privacy_policy_url();
$terms_of_service_url = yiontech_lms_get_terms_of_service_url();

// Ensure footer_content is an array
if (!is_array($footer_content)) {
    $footer_content = array(
        'column1' => array(
            'title' => 'About Us',
            'content' => 'A powerful learning management system designed for educators and students.',
        ),
        'column2' => array(
            'title' => 'Quick Links',
            'links' => array(
                array('text' => 'Home', 'url' => '/'),
                array('text' => 'Courses', 'url' => '/courses'),
                array('text' => 'About', 'url' => '/about'),
                array('text' => 'Contact', 'url' => '/contact'),
            ),
        ),
        'column3' => array(
            'title' => 'Company',
            'links' => array(
                array('text' => 'About Us', 'url' => '/about'),
                array('text' => 'Our Team', 'url' => '/team'),
                array('text' => 'Careers', 'url' => '/careers'),
                array('text' => 'Blog', 'url' => '/blog'),
            ),
        ),
        'column4' => array(
            'title' => 'User Portal',
            'links' => array(
                array('text' => 'Login', 'url' => '/login'),
                array('text' => 'Register', 'url' => '/register'),
                array('text' => 'Dashboard', 'url' => '/dashboard'),
                array('text' => 'Profile', 'url' => '/profile'),
            ),
        ),
        'column5' => array(
            'title' => 'Newsletter',
            'content' => 'Get the latest news and updates delivered right to your inbox.',
            'email' => 'info@yiontech.com',
            'phone' => '+1 (555) 123-4567',
        ),
    );
}

// Ensure each column exists and has proper structure
$columns = array('column1', 'column2', 'column3', 'column4', 'column5');
foreach ($columns as $column) {
    if (!isset($footer_content[$column])) {
        $footer_content[$column] = array();
    }
    
    // Ensure title exists for each column
    if (!isset($footer_content[$column]['title'])) {
        $footer_content[$column]['title'] = '';
    }
    
    // Ensure content exists for column1 and column5
    if (($column === 'column1' || $column === 'column5') && !isset($footer_content[$column]['content'])) {
        $footer_content[$column]['content'] = '';
    }
    
    // Ensure links exist for column2, column3, and column4
    if (in_array($column, array('column2', 'column3', 'column4'))) {
        if (!isset($footer_content[$column]['links']) || !is_array($footer_content[$column]['links'])) {
            $footer_content[$column]['links'] = array();
        }
    }
    
    // Ensure email and phone exist for column5
    if ($column === 'column5') {
        if (!isset($footer_content[$column]['email'])) {
            $footer_content[$column]['email'] = '';
        }
        if (!isset($footer_content[$column]['phone'])) {
            $footer_content[$column]['phone'] = '';
        }
    }
}
?>
<?php if ($footer_style == 'default') : ?>
<footer class="text-white" style="background-color: <?php echo esc_attr($footer_background_color); ?>; color: <?php echo esc_attr($footer_text_color); ?>; ">
    <?php 
    if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
        // Elementor footer
    } else {
        // Default theme footer
        ?>
        <div class="max-w-7xl  mx-auto px-4" style="padding-top: <?php echo esc_attr($padding_top); ?>px; padding-bottom: <?php echo esc_attr($padding_bottom); ?>px;">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Column 1: Logo and Description -->
                <div>
                    <?php if ($logo) : ?>
                        <div class="mb-4">
                            <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" style="max-height: 36px; width: auto;">
                        </div>
                    <?php elseif ( has_custom_logo() ) : ?>
                        <div class="mb-4">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h3 class="text-xl font-bold mb-4"><?php bloginfo( 'name' ); ?></h3>
                    <?php endif; ?>
                    <p class="text-gray-400 mb-4"><?php echo esc_html($footer_content['column1']['content']); ?></p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php echo esc_html($footer_content['column2']['title']); ?></h3>
                    <ul class="space-y-2">
                        <?php if (!empty($footer_content['column2']['links']) && is_array($footer_content['column2']['links'])) : ?>
                            <?php foreach ($footer_content['column2']['links'] as $link) : ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="text-gray-400 hover:text-white transition">
                                        <?php echo esc_html($link['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Add privacy links if enabled -->
                        <?php if ($enable_privacy_features && $privacy_policy_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($privacy_policy_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Privacy Policy
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($enable_privacy_features && $terms_of_service_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($terms_of_service_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Terms of Service
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Column 3: Company -->
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php echo esc_html($footer_content['column3']['title']); ?></h3>
                    <ul class="space-y-2">
                        <?php if (!empty($footer_content['column3']['links']) && is_array($footer_content['column3']['links'])) : ?>
                            <?php foreach ($footer_content['column3']['links'] as $link) : ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="text-gray-400 hover:text-white transition">
                                        <?php echo esc_html($link['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Column 4: User Portal -->
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php echo esc_html($footer_content['column4']['title']); ?></h3>
                    <ul class="space-y-2">
                        <?php if (!empty($footer_content['column4']['links']) && is_array($footer_content['column4']['links'])) : ?>
                            <?php foreach ($footer_content['column4']['links'] as $link) : ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="text-gray-400 hover:text-white transition">
                                        <?php echo esc_html($link['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Column 5: Newsletter -->
                <div>
                    <h3 class="text-xl font-bold mb-4"><?php echo esc_html($footer_content['column5']['title']); ?></h3>
                    <p class="text-gray-400 mb-4"><?php echo esc_html($footer_content['column5']['content']); ?></p>
                    <?php if ($newsletter_enable) : ?>
                        <?php get_template_part('template-parts/newsletter-form'); ?>
                    <?php endif; ?>
                    
                    <div class="mt-6">
                        <h4 class="text-lg font-medium mb-2">Contact Us</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span><?php echo esc_html($footer_content['column5']['email']); ?></span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span><?php echo esc_html($footer_content['column5']['phone']); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    
    <!-- Copyright -->
    <div class="mt-0  text-center text-gray-400" style="background-color: <?php echo esc_attr($copyright_background_color); ?>;">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <p><?php echo $copyright_text; ?></p>
            
            <!-- Add privacy links if enabled -->
            <?php if ($enable_privacy_features && ($privacy_policy_url || $terms_of_service_url)) : ?>
                <p class="mt-2 text-sm">
                    <?php if ($privacy_policy_url) : ?>
                        <a href="<?php echo esc_url($privacy_policy_url); ?>" class="text-gray-400 hover:text-white transition">
                            Privacy Policy
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($privacy_policy_url && $terms_of_service_url) : ?>
                        <span class="mx-2">|</span>
                    <?php endif; ?>
                    
                    <?php if ($terms_of_service_url) : ?>
                        <a href="<?php echo esc_url($terms_of_service_url); ?>" class="text-gray-400 hover:text-white transition">
                            Terms of Service
                        </a>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php elseif ($footer_style == 'minimal') : ?>
<footer class="text-white" style="background-color: <?php echo esc_attr($footer_background_color); ?>; color: <?php echo esc_attr($footer_text_color); ?>; padding-top: <?php echo esc_attr($padding_top); ?>px; padding-bottom: <?php echo esc_attr($padding_bottom); ?>px;">
    <?php 
    if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
        // Elementor footer
    } else {
        // Minimal theme footer
        ?>
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Logo and Copyright -->
                <div class="mb-4 md:mb-0">
                    <?php if ($logo) : ?>
                        <div class="mb-2">
                            <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" style="max-height: 36px; width: auto;">
                        </div>
                    <?php elseif ( has_custom_logo() ) : ?>
                        <div class="mb-2">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h3 class="text-xl font-bold mb-2"><?php bloginfo( 'name' ); ?></h3>
                    <?php endif; ?>
                    <p class="text-gray-400 text-sm"><?php echo $copyright_text; ?></p>
                </div>
                
                <!-- Quick Links -->
                <div class="mb-4 md:mb-0">
                    <ul class="flex flex-wrap justify-center gap-4">
                        <?php if (!empty($footer_content['column2']['links']) && is_array($footer_content['column2']['links'])) : ?>
                            <?php foreach ($footer_content['column2']['links'] as $link) : ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="text-gray-400 hover:text-white transition">
                                        <?php echo esc_html($link['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Add privacy links if enabled -->
                        <?php if ($enable_privacy_features && $privacy_policy_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($privacy_policy_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Privacy Policy
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($enable_privacy_features && $terms_of_service_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($terms_of_service_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Terms of Service
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Social Media -->
                <div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</footer>
<?php elseif ($footer_style == 'centered') : ?>
<footer class="text-white" style="background-color: <?php echo esc_attr($footer_background_color); ?>; color: <?php echo esc_attr($footer_text_color); ?>; padding-top: <?php echo esc_attr($padding_top); ?>px; padding-bottom: <?php echo esc_attr($padding_bottom); ?>px;">
    <?php 
    if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
        // Elementor footer
    } else {
        // Centered theme footer
        ?>
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center">
                <!-- Logo -->
                <div class="mb-6">
                    <?php if ($logo) : ?>
                        <img src="<?php echo esc_url($logo); ?>" class="custom-logo mx-auto" alt="<?php bloginfo('name'); ?>" style="max-height: 36px; width: auto;">
                    <?php elseif ( has_custom_logo() ) : ?>
                        <div class="flex justify-center">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h3 class="text-xl font-bold mb-4"><?php bloginfo( 'name' ); ?></h3>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <p class="text-gray-400 max-w-2xl mx-auto mb-6"><?php echo esc_html($footer_content['column1']['content']); ?></p>
                
                <!-- Quick Links -->
                <div class="mb-6">
                    <ul class="flex flex-wrap justify-center gap-6">
                        <?php if (!empty($footer_content['column2']['links']) && is_array($footer_content['column2']['links'])) : ?>
                            <?php foreach ($footer_content['column2']['links'] as $link) : ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="text-gray-400 hover:text-white transition">
                                        <?php echo esc_html($link['text']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Add privacy links if enabled -->
                        <?php if ($enable_privacy_features && $privacy_policy_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($privacy_policy_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Privacy Policy
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($enable_privacy_features && $terms_of_service_url) : ?>
                            <li>
                                <a href="<?php echo esc_url($terms_of_service_url); ?>" class="text-gray-400 hover:text-white transition">
                                    Terms of Service
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <?php if ($newsletter_enable) : ?>
                    <div class="mb-6 max-w-md mx-auto">
                        <?php get_template_part('template-parts/newsletter-form'); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Social Media -->
                <div class="mb-6">
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="text-gray-400 text-sm mb-6">
                    <p><?php echo esc_html($footer_content['column5']['email']); ?> | <?php echo esc_html($footer_content['column5']['phone']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="mt-0 pt-6 text-center text-gray-400 text-sm" style="background-color: <?php echo esc_attr($copyright_background_color); ?>;">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <p><?php echo $copyright_text; ?></p>
                
                <!-- Add privacy links if enabled -->
                <?php if ($enable_privacy_features && ($privacy_policy_url || $terms_of_service_url)) : ?>
                    <p class="mt-2">
                        <?php if ($privacy_policy_url) : ?>
                            <a href="<?php echo esc_url($privacy_policy_url); ?>" class="text-gray-400 hover:text-white transition">
                                Privacy Policy
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($privacy_policy_url && $terms_of_service_url) : ?>
                            <span class="mx-2">|</span>
                        <?php endif; ?>
                        
                        <?php if ($terms_of_service_url) : ?>
                            <a href="<?php echo esc_url($terms_of_service_url); ?>" class="text-gray-400 hover:text-white transition">
                                Terms of Service
                            </a>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    ?>
</footer>
<?php endif; ?>


<!-- Back to top button - only show if enabled in theme settings -->
<?php if ($enable_back_to_top) : ?>
<a href="#" id="back-to-top" class="back-to-top">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
    </svg>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>