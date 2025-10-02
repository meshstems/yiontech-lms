<?php
/**
 * Display Functions
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register all settings
function yiontech_lms_theme_settings_admin_init() {
    register_setting('yiontech_lms_theme_settings', 'yiontech_lms_theme_settings', 'yiontech_lms_sanitize_settings');
}

// Sanitize theme settings
function yiontech_lms_sanitize_settings($input) {
    $output = get_option('yiontech_lms_theme_settings', []);

    // Merge with defaults to ensure all keys exist
    $defaults = array_merge(
        yiontech_lms_get_default_settings(),
        yiontech_lms_get_default_header_settings(),
        yiontech_lms_get_default_footer_settings(),
        yiontech_lms_get_default_newsletter_settings(),
        yiontech_lms_get_default_privacy_settings(),
        yiontech_lms_get_default_css_settings()
    );
    
    $output = wp_parse_args($output, $defaults);

    $fields = [
        'enable_preloader' => 'yiontech_lms_sanitize_checkbox',
        'site_icon' => 'yiontech_lms_sanitize_url',
        'header_style' => function($v) { return in_array($v, ['default', 'minimal', 'centered']) ? $v : 'default'; },
        'transparent_header' => 'yiontech_lms_sanitize_checkbox',
        'sticky_header' => 'yiontech_lms_sanitize_checkbox',
        'header_background_color' => 'yiontech_lms_sanitize_color',
        'sticky_header_background_color' => 'yiontech_lms_sanitize_color',
        'enable_back_to_top' => 'yiontech_lms_sanitize_checkbox',
        'logo_upload' => 'yiontech_lms_sanitize_url',
        'retina_logo_upload' => 'yiontech_lms_sanitize_url',
        'header_buttons' => 'yiontech_lms_sanitize_header_buttons',
        'header_menu' => 'yiontech_lms_sanitize_header_menu',
        'header_elementor_template' => 'absint',
        'footer_style' => function($v) { return in_array($v, ['default', 'minimal', 'centered']) ? $v : 'default'; },
        'footer_elementor_template' => 'absint',
        'footer_content' => 'yiontech_lms_sanitize_footer_content',
        'copyright_text' => 'wp_kses_post',
        'footer_text_color' => 'yiontech_lms_sanitize_color',
        'footer_background_color' => 'yiontech_lms_sanitize_color',
        'copyright_background_color' => 'yiontech_lms_sanitize_color',
        'footer_padding' => 'yiontech_lms_sanitize_footer_padding',
        'newsletter_enable' => 'yiontech_lms_sanitize_checkbox',
        'newsletter_action_url' => 'yiontech_lms_sanitize_url',
        'newsletter_method' => function($v) { return in_array($v, ['post', 'get']) ? $v : 'post'; },
        'newsletter_email_field' => 'yiontech_lms_sanitize_text',
        'newsletter_hidden_fields' => 'yiontech_lms_sanitize_hidden_fields',
        'newsletter_success_message' => 'yiontech_lms_sanitize_text',
        'custom_css' => function($v) { return wp_strip_all_tags($v); },
        'enable_privacy_features' => 'yiontech_lms_sanitize_checkbox',
        'privacy_policy_page' => 'absint',
        'terms_of_service_page' => 'absint',
        'cookie_consent_text' => 'wp_kses_post',
        'cookie_consent_button_text' => 'yiontech_lms_sanitize_text',
        'cookie_consent_learn_more_text' => 'yiontech_lms_sanitize_text',
        'enable_data_export' => 'yiontech_lms_sanitize_checkbox',
        'enable_account_deletion' => 'yiontech_lms_sanitize_checkbox',
        'disable_gutenberg' => 'yiontech_lms_sanitize_checkbox',
    ];

    foreach ($fields as $key => $sanitize_callback) {
        if (isset($input[$key])) {
            $output[$key] = call_user_func($sanitize_callback, $input[$key]);
        }
    }

    return apply_filters('yiontech_lms_sanitized_settings', $output, $input);
}

// Enqueue admin scripts and styles
function yiontech_lms_admin_enqueue_scripts($hook) {
    if (strpos($hook, 'theme-settings') === false) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_script(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/js/admin.js',
        ['jquery', 'wp-color-picker'],
        '1.0.1',
        true
    );

    wp_enqueue_style(
        'yiontech-lms-admin',
        get_template_directory_uri() . '/css/admin.css',
        ['wp-color-picker'],
        '1.0.1'
    );

    wp_localize_script('yiontech-lms-admin', 'yiontech_lms_admin', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('yiontech_lms_admin_nonce'),
        'i18n' => [
            'upload' => __('Upload', 'yiontech-lms'),
            'remove' => __('Remove', 'yiontech-lms'),
            'add_button' => __('Add Button', 'yiontech-lms'),
            'remove_button' => __('Remove Button', 'yiontech-lms'),
            'add_menu_item' => __('Add Menu Item', 'yiontech-lms'),
            'remove_menu_item' => __('Remove', 'yiontech-lms'),
            'add_link' => __('Add Link', 'yiontech-lms'),
            'remove_link' => __('Remove', 'yiontech-lms'),
        ],
    ]);
}

// Output custom CSS
function yiontech_lms_output_custom_css() {
    $custom_css = yiontech_lms_get_css_setting('custom_css');
    if (!empty($custom_css)) {
        // Minify CSS (basic minification, consider a library like CSSMin for production)
        $custom_css = preg_replace('/\s+/', ' ', $custom_css);
        $custom_css = trim($custom_css);
        ?>
        <style id="yiontech-lms-custom-css">
            .yiontech-lms { <?php echo esc_html($custom_css); ?> }
        </style>
        <?php
    }
}

// Gutenberg support
function yiontech_lms_gutenberg_support() {
    if (!yiontech_lms_get_theme_setting('disable_gutenberg')) {
        add_theme_support('align-wide');
        add_theme_support('block-template-parts');
        add_theme_support('wp-block-styles');
    }
}

// Customizer integration
function yiontech_lms_customize_register($wp_customize) {
    $wp_customize->add_section('yiontech_lms_general', [
        'title' => __('Yiontech LMS General', 'yiontech-lms'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('yiontech_lms_theme_settings[header_background_color]', [
        'default' => '#1e40af',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yiontech_lms_theme_settings[header_background_color]', [
        'label' => __('Header Background Color', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
    ]));

    $wp_customize->add_setting('yiontech_lms_theme_settings[footer_background_color]', [
        'default' => '#111827',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yiontech_lms_theme_settings[footer_background_color]', [
        'label' => __('Footer Background Color', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
    ]));

    $wp_customize->add_setting('yiontech_lms_theme_settings[logo_upload]', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'yiontech_lms_theme_settings[logo_upload]', [
        'label' => __('Logo Upload', 'yiontech-lms'),
        'section' => 'yiontech_lms_general',
        'settings' => 'yiontech_lms_theme_settings[logo_upload]',
        'description' => __('Upload your logo (recommended 200x36px)', 'yiontech-lms'),
    ]));
}

// Default header display function
function yiontech_lms_display_default_header($header_style, $transparent_header, $sticky_header, $header_background_color, $sticky_header_background_color, $logo, $retina_logo, $header_buttons) {
    if ($header_style == 'default') : ?>
    <header class="site-header text-white <?php echo $sticky_header ? 'header-sticky-enabled' : ''; ?> <?php echo $transparent_header && is_front_page() ? 'header-transparent' : ''; ?>" 
          <?php if (!$transparent_header || !is_front_page()) : ?>style="background-color: <?php echo esc_attr($header_background_color); ?>;"<?php endif; ?>>
        <?php 
        if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
            // Elementor header
        } else {
            // Default theme header
            ?>
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-3">
                    <!-- Logo (Left) -->
                    <div class="site-branding flex items-center">
                        <?php if ($logo) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                                <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" <?php echo $retina_logo ? 'srcset="' . esc_url($logo) . ' 1x, ' . esc_url($retina_logo) . ' 2x"' : ''; ?>>
                            </a>
                        <?php elseif ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <h1 class="text-xl font-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Desktop Navigation (Center) -->
                    <nav id="site-navigation" class="main-navigation hidden xl:flex flex-1 justify-center">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'flex space-x-8 items-center',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ) );
                        ?>
                    </nav>
                    
                    <!-- Right Side Buttons -->
                    <div class="flex items-center space-x-3">
                        <?php if (!empty($header_buttons)) : ?>
                            <?php foreach ($header_buttons as $button) : ?>
                                <?php 
                                $show_desktop = isset($button['show_desktop']) ? $button['show_desktop'] : true;
                                $show_mobile = isset($button['show_mobile']) ? $button['show_mobile'] : true;
                                if ($show_desktop) : 
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="hidden xl:block px-4 py-1.5 text-sm rounded-lg transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($show_mobile) : 
                                    // Show only the first button on mobile
                                    if ($button === reset($header_buttons)) :
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="xl:hidden px-4 py-1.5 text-sm rounded-lg transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php 
                                    endif;
                                endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-menu-toggle" class="text-white focus:outline-none p-1" aria-label="<?php esc_attr_e('Toggle mobile menu', 'yiontech-lms'); ?>" aria-expanded="false">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </header>
    <?php elseif ($header_style == 'minimal') : ?>
    <header class="site-header text-white <?php echo $sticky_header ? 'sticky top-0 z-50' : ''; ?> <?php echo $transparent_header && is_front_page() ? 'header-transparent' : ''; ?>" 
          <?php if (!$transparent_header || !is_front_page()) : ?>style="background-color: <?php echo esc_attr($header_background_color); ?>;"<?php endif; ?>>
        <?php 
        if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
            // Elementor header
        } else {
            // Minimal theme header
            ?>
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-2">
                    <!-- Logo (Left) -->
                    <div class="site-branding flex items-center">
                        <?php if ($logo) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                                <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" <?php echo $retina_logo ? 'srcset="' . esc_url($logo) . ' 1x, ' . esc_url($retina_logo) . ' 2x"' : ''; ?>>
                            </a>
                        <?php elseif ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <h1 class="text-xl font-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Desktop Navigation (Center) -->
                    <nav id="site-navigation" class="main-navigation hidden xl:flex flex-1 justify-center">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'flex space-x-6 items-center text-sm',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ) );
                        ?>
                    </nav>
                    
                    <!-- Right Side Buttons -->
                    <div class="flex items-center space-x-3">
                        <?php if (!empty($header_buttons)) : ?>
                            <?php foreach ($header_buttons as $button) : ?>
                                <?php 
                                $show_desktop = isset($button['show_desktop']) ? $button['show_desktop'] : true;
                                $show_mobile = isset($button['show_mobile']) ? $button['show_mobile'] : true;
                                if ($show_desktop) : 
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="hidden xl:block px-3 py-1 text-sm rounded transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($show_mobile) : 
                                    // Show only the first button on mobile
                                    if ($button === reset($header_buttons)) :
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="xl:hidden px-3 py-1 text-sm rounded transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php 
                                    endif;
                                endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-menu-toggle" class="text-white focus:outline-none p-1" aria-label="<?php esc_attr_e('Toggle mobile menu', 'yiontech-lms'); ?>" aria-expanded="false">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </header>
    <?php elseif ($header_style == 'centered') : ?>
    <header class="site-header text-white <?php echo $sticky_header ? 'sticky top-0 z-50' : ''; ?> <?php echo $transparent_header && is_front_page() ? 'header-transparent' : ''; ?>" 
          <?php if (!$transparent_header || !is_front_page()) : ?>style="background-color: <?php echo esc_attr($header_background_color); ?>;"<?php endif; ?>>
        <?php 
        if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
            // Elementor header
        } else {
            // Centered theme header
            ?>
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col items-center py-4">
                    <!-- Logo (Center) -->
                    <div class="site-branding flex items-center mb-3">
                        <?php if ($logo) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                                <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" <?php echo $retina_logo ? 'srcset="' . esc_url($logo) . ' 1x, ' . esc_url($retina_logo) . ' 2x"' : ''; ?>>
                            </a>
                        <?php elseif ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <h1 class="text-xl font-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Desktop Navigation (Center) -->
                    <nav id="site-navigation" class="main-navigation hidden xl:flex justify-center w-full">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'flex space-x-8 items-center',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ) );
                        ?>
                    </nav>
                    
                    <!-- Right Side Buttons -->
                    <div class="flex items-center space-x-3 mt-3">
                        <?php if (!empty($header_buttons)) : ?>
                            <?php foreach ($header_buttons as $button) : ?>
                                <?php 
                                $show_desktop = isset($button['show_desktop']) ? $button['show_desktop'] : true;
                                $show_mobile = isset($button['show_mobile']) ? $button['show_mobile'] : true;
                                if ($show_desktop) : 
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="hidden xl:block px-4 py-1.5 text-sm rounded-lg transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($show_mobile) : 
                                    // Show only the first button on mobile
                                    if ($button === reset($header_buttons)) :
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="xl:hidden px-4 py-1.5 text-sm rounded-lg transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-white text-blue-600 hover:bg-blue-50' : 'border border-white hover:bg-white hover:text-blue-600'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php 
                                    endif;
                                endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-menu-toggle" class="text-white focus:outline-none p-1" aria-label="<?php esc_attr_e('Toggle mobile menu', 'yiontech-lms'); ?>" aria-expanded="false">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </header>
    <?php endif;
    
    // Mobile Menu Overlay and Sidebar
    ?>
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden"></div>

    <!-- Mobile Menu Sidebar -->
    <div id="mobile-menu-sidebar" class="fixed top-0 right-0 h-full w-80 bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex flex-col h-full">
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-4" style="background-color: <?php echo esc_attr($header_background_color); ?>; color: white;">
                <div class="site-branding flex items-center">
                    <?php if ($logo) : ?>
                        <img src="<?php echo esc_url($logo); ?>" class="custom-logo" alt="<?php bloginfo('name'); ?>" style="max-height: 36px; width: auto;">
                    <?php elseif ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h2 class="text-xl font-bold"><?php bloginfo( 'name' ); ?></h2>
                    <?php endif; ?>
                </div>
                <button id="mobile-menu-close" class="text-white focus:outline-none p-1">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Menu Content -->
            <div class="flex-grow overflow-y-auto">
                <!-- Main Navigation -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Navigation', 'yiontech-lms'); ?></h3>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'space-y-2',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>
                
                <!-- Mobile Buttons -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Quick Actions', 'yiontech-lms'); ?></h3>
                    <div class="space-y-3">
                        <?php if (!empty($header_buttons)) : ?>
                            <?php foreach ($header_buttons as $button) : ?>
                                <?php 
                                $show_mobile = isset($button['show_mobile']) ? $button['show_mobile'] : true;
                                if ($show_mobile) : 
                                ?>
                                    <a href="<?php echo esc_url($button['url']); ?>" 
                                       class="block px-4 py-2 rounded-lg transition duration-300 
                                              <?php echo $button['style'] == 'solid' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white'; ?>">
                                        <?php echo esc_html($button['text']); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- User Portal -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('User Portal', 'yiontech-lms'); ?></h3>
                    <div class="space-y-3">
                        <a href="<?php echo esc_url( home_url( '/login' ) ); ?>" class="block px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition duration-300"><?php _e('Login', 'yiontech-lms'); ?></a>
                        <a href="<?php echo esc_url( home_url( '/register' ) ); ?>" class="block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300"><?php _e('Create Account', 'yiontech-lms'); ?></a>
                        <a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-300"><?php _e('My Dashboard', 'yiontech-lms'); ?></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Quick Links', 'yiontech-lms'); ?></h3>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer-quick-links',
                        'menu_class'     => 'space-y-2',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </div>
                
                <!-- Contact Information -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Contact Us', 'yiontech-lms'); ?></h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span><?php echo esc_html(get_bloginfo('admin_email')); ?></span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+1 (555) 123-4567</span>
                        </li>
                    </ul>
                </div>
                                   
                <!-- Social Media -->
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Follow Us', 'yiontech-lms'); ?></h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-blue-400 hover:text-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="text-pink-600 hover:text-pink-800">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Newsletter Signup -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php _e('Newsletter', 'yiontech-lms'); ?></h3>
                    <p class="text-gray-600 text-sm mb-3"><?php _e('Subscribe to get the latest updates and offers.', 'yiontech-lms'); ?></p>
                    <?php get_template_part('template-parts/newsletter-form'); ?>
                </div>
            </div>
            
            <!-- Menu Footer -->
            <div class="p-4 bg-gray-100 border-t">
                <div class="text-center text-gray-600 text-sm">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
                    <p class="mt-1"><?php _e('All rights reserved.', 'yiontech-lms'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}