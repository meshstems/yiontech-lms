<?php
/**
 * Footer menu widget template
 *
 * @package Yiontech_LMS
 */

// Args for the menu
$menu_args = array(
    'theme_location' => isset($args['menu_location']) ? $args['menu_location'] : 'footer',
    'menu_class'     => isset($args['menu_class']) ? $args['menu_class'] : 'space-y-2',
    'container'      => false,
    'fallback_cb'    => false,
    'echo'           => true,
);

// Display the menu
wp_nav_menu($menu_args);