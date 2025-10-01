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
    'walker'         => new Yiontech_LMS_Footer_Menu_Walker(),
);

// Display the menu
wp_nav_menu($menu_args);

// Custom footer menu walker class
class Yiontech_LMS_Footer_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $output .= '<li class="mb-1">';
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target)     .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn)        .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url)        .'"' : '';
        $attributes .= ' class="text-gray-400 hover:text-white transition"';
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}