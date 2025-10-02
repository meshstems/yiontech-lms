<?php
/**
 * Field Callbacks
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Checkbox field
function yiontech_lms_checkbox_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : false;
    ?>
    <label for="<?php echo esc_attr($args['label_for']); ?>">
        <input type="checkbox" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="1" <?php checked($value, true); ?> aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        <?php echo esc_html($args['description']); ?>
    </label>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Select field
function yiontech_lms_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '';
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <?php foreach ($args['options'] as $option_value => $label): ?>
            <option value="<?php echo esc_attr($option_value); ?>" <?php selected($value, $option_value); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Color field
function yiontech_lms_color_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '#ffffff';
    ?>
    <input type="color" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="yiontech-color-field" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Text field
function yiontech_lms_text_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '';
    ?>
    <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Textarea field
function yiontech_lms_textarea_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '';
    $rows  = isset($args['rows']) ? $args['rows'] : 5;

    // Fix: convert array values into a readable string
    if (is_array($value)) {
        $value = implode(", ", $value); // join array items with comma and space
    }
    ?>
    <textarea 
        id="<?php echo esc_attr($args['label_for']); ?>" 
        name="<?php echo esc_attr($args['name']); ?>" 
        rows="<?php echo esc_attr($rows); ?>" 
        class="large-text" 
        aria-describedby="<?php echo esc_attr($args['id']); ?>-description"
    ><?php echo esc_textarea($value); ?></textarea>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description">
        <?php echo esc_html($args['description']); ?>
    </p>
    <?php
}

// Media field
function yiontech_lms_media_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : '';
    $media_id = attachment_url_to_postid($value);
    ?>
    <div class="media-field" data-field-id="<?php echo esc_attr($args['id']); ?>">
        <input type="hidden" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr($value); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        <div class="media-preview">
            <?php if ($value): ?>
                <img src="<?php echo esc_url($value); ?>" alt="<?php echo esc_attr($args['description']); ?>" style="max-width: 200px; max-height: 100px;" />
            <?php endif; ?>
        </div>
        <button type="button" class="button media-upload-button"><?php _e('Upload', 'yiontech-lms'); ?></button>
        <button type="button" class="button media-remove-button" style="<?php echo $value ? '' : 'display:none;'; ?>"><?php _e('Remove', 'yiontech-lms'); ?></button>
        <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

// Spacing field
function yiontech_lms_spacing_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : ['top' => 48, 'bottom' => 48];
    $top = isset($value['top']) ? $value['top'] : 48;
    $bottom = isset($value['bottom']) ? $value['bottom'] : 48;
    ?>
    <div class="spacing-field">
        <div>
            <label for="<?php echo esc_attr($args['label_for']); ?>"><?php _e('Top (px):', 'yiontech-lms'); ?></label>
            <input type="number" id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>[top]" value="<?php echo esc_attr($top); ?>" min="0" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id']); ?>_bottom"><?php _e('Bottom (px):', 'yiontech-lms'); ?></label>
            <input type="number" id="<?php echo esc_attr($args['id']); ?>_bottom" name="<?php echo esc_attr($args['name']); ?>[bottom]" value="<?php echo esc_attr($bottom); ?>" min="0" aria-describedby="<?php echo esc_attr($args['id']); ?>-description" />
        </div>
    </div>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Header buttons field
function yiontech_lms_header_buttons_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $buttons = isset($options[$args['id']]) ? $options[$args['id']] : [];
    ?>
    <div class="header-buttons-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="header-buttons">
            <?php foreach ($buttons as $index => $button): ?>
                <div class="header-button-item" data-index="<?php echo esc_attr($index); ?>">
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>"><?php _e('Button Text:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($button['text']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>"><?php _e('Button URL:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($button['url']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-style'); ?>"><?php _e('Button Style:', 'yiontech-lms'); ?></label>
                        <select id="<?php echo esc_attr($args['id'] . '-' . $index . '-style'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][style]">
                            <option value="solid" <?php selected($button['style'], 'solid'); ?>><?php _e('Solid', 'yiontech-lms'); ?></option>
                            <option value="outline" <?php selected($button['style'], 'outline'); ?>><?php _e('Outline', 'yiontech-lms'); ?></option>
                        </select>
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-show-desktop'); ?>">
                            <input type="checkbox" id="<?php echo esc_attr($args['id'] . '-' . $index . '-show-desktop'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_desktop]" value="1" <?php checked(isset($button['show_desktop']) ? $button['show_desktop'] : true, true); ?> />
                            <?php _e('Show on Desktop', 'yiontech-lms'); ?>
                        </label>
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-show-mobile'); ?>">
                            <input type="checkbox" id="<?php echo esc_attr($args['id'] . '-' . $index . '-show-mobile'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][show_mobile]" value="1" <?php checked(isset($button['show_mobile']) ? $button['show_mobile'] : true, true); ?> />
                            <?php _e('Show on Mobile', 'yiontech-lms'); ?>
                        </label>
                    </div>
                    <button type="button" class="button remove-button"><?php _e('Remove Button', 'yiontech-lms'); ?></button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button add-button"><?php _e('Add Button', 'yiontech-lms'); ?></button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($buttons)); ?>" />
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

// Menu field
function yiontech_lms_menu_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $menu_items = isset($options[$args['id']]) ? $options[$args['id']] : [];
    ?>
    <div class="menu-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <div class="menu-items">
            <?php foreach ($menu_items as $index => $item): ?>
                <div class="menu-item" data-index="<?php echo esc_attr($index); ?>">
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>"><?php _e('Menu Text:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-text'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][text]" value="<?php echo esc_attr($item['text']); ?>" class="regular-text" />
                    </div>
                    <div>
                        <label for="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>"><?php _e('Menu URL:', 'yiontech-lms'); ?></label>
                        <input type="text" id="<?php echo esc_attr($args['id'] . '-' . $index . '-url'); ?>" name="<?php echo esc_attr($args['name']); ?>[<?php echo $index; ?>][url]" value="<?php echo esc_attr($item['url']); ?>" class="regular-text" />
                    </div>
                    <button type="button" class="button remove-menu-item"><?php _e('Remove', 'yiontech-lms'); ?></button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button add-menu-item"><?php _e('Add Menu Item', 'yiontech-lms'); ?></button>
        <input type="hidden" class="item-counter" value="<?php echo esc_attr(count($menu_items)); ?>" />
        <p class="description"><?php echo esc_html($args['description']); ?></p>
    </div>
    <?php
}

// Elementor header template select field
function yiontech_lms_elementor_header_template_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : 0;

    $all_templates = [];
    if (did_action('elementor/loaded')) {
        $all_templates = get_posts([
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    $theme_builder_templates = [];
    $regular_templates = [];
    foreach ($all_templates as $template) {
        $template_type = get_post_meta($template->ID, '_elementor_template_type', true);
        if ($template_type === 'header') {
            $theme_builder_templates[] = $template;
        } else {
            $regular_templates[] = $template;
        }
    }
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <option value="0"><?php _e('— Default Theme Header —', 'yiontech-lms'); ?></option>
        <?php if (!empty($theme_builder_templates)): ?>
            <optgroup label="<?php esc_attr_e('Theme Builder Header Templates', 'yiontech-lms'); ?>">
                <?php foreach ($theme_builder_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
        <?php if (!empty($regular_templates)): ?>
            <optgroup label="<?php esc_attr_e('Other Elementor Templates', 'yiontech-lms'); ?>">
                <?php foreach ($regular_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php if (empty($all_templates)): ?>
        <p class="description"><?php _e('No templates found. Create templates in Elementor > Templates.', 'yiontech-lms'); ?></p>
    <?php else: ?>
        <p class="description"><?php _e('Create templates in Elementor > Templates or Elementor > Theme Builder.', 'yiontech-lms'); ?></p>
    <?php endif; ?>
    <?php
}

// Elementor template select field
function yiontech_lms_elementor_template_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : 0;

    $all_templates = [];
    if (did_action('elementor/loaded')) {
        $all_templates = get_posts([
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    $theme_builder_templates = [];
    $regular_templates = [];
    foreach ($all_templates as $template) {
        $template_type = get_post_meta($template->ID, '_elementor_template_type', true);
        if ($template_type === 'footer') {
            $theme_builder_templates[] = $template;
        } else {
            $regular_templates[] = $template;
        }
    }
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <option value="0"><?php _e('— Default Theme Footer —', 'yiontech-lms'); ?></option>
        <?php if (!empty($theme_builder_templates)): ?>
            <optgroup label="<?php esc_attr_e('Theme Builder Footer Templates', 'yiontech-lms'); ?>">
                <?php foreach ($theme_builder_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
        <?php if (!empty($regular_templates)): ?>
            <optgroup label="<?php esc_attr_e('Other Elementor Templates', 'yiontech-lms'); ?>">
                <?php foreach ($regular_templates as $template): ?>
                    <option value="<?php echo esc_attr($template->ID); ?>" <?php selected($value, $template->ID); ?>><?php echo esc_html($template->post_title); ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endif; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php if (empty($all_templates)): ?>
        <p class="description"><?php _e('No templates found. Create templates in Elementor > Templates.', 'yiontech-lms'); ?></p>
    <?php else: ?>
        <p class="description"><?php _e('Create templates in Elementor > Templates or Elementor > Theme Builder.', 'yiontech-lms'); ?></p>
    <?php endif; ?>
    <?php
}

// Footer content field
function yiontech_lms_footer_content_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $footer_content = isset($options[$args['id']]) ? $options[$args['id']] : yiontech_lms_get_default_footer_settings()['footer_content'];
    ?>
    <div class="footer-content-field" data-field-name="<?php echo esc_attr($args['name']); ?>">
        <!-- Column 1 -->
        <h4><?php _e('Column 1', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column1-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column1-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column1][title]" value="<?php echo esc_attr($footer_content['column1']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column1-content'); ?>"><?php _e('Content:', 'yiontech-lms'); ?></label>
            <textarea id="<?php echo esc_attr($args['id'] . '-column1-content'); ?>" name="<?php echo esc_attr($args['name']); ?>[column1][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column1']['content'] ?? ''); ?></textarea>
        </div>

        <!-- Column 2 -->
        <h4><?php _e('Column 2', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column2-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column2-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column2][title]" value="<?php echo esc_attr($footer_content['column2']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column2">
                <?php foreach ($footer_content['column2']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column2][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column2"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column2" value="<?php echo esc_attr(count($footer_content['column2']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 3 -->
        <h4><?php _e('Column 3', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column3-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column3-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column3][title]" value="<?php echo esc_attr($footer_content['column3']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column3">
                <?php foreach ($footer_content['column3']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column3][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column3"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column3" value="<?php echo esc_attr(count($footer_content['column3']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 4 -->
        <h4><?php _e('Column 4', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column4-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column4-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column4][title]" value="<?php echo esc_attr($footer_content['column4']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label><?php _e('Links:', 'yiontech-lms'); ?></label>
            <div class="footer-links" data-column="column4">
                <?php foreach ($footer_content['column4']['links'] ?? [] as $index => $link): ?>
                    <div class="footer-link-item" data-index="<?php echo esc_attr($index); ?>">
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][text]" value="<?php echo esc_attr($link['text'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link Text', 'yiontech-lms'); ?>" class="regular-text" />
                        <input type="text" name="<?php echo esc_attr($args['name']); ?>[column4][links][<?php echo $index; ?>][url]" value="<?php echo esc_attr($link['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('Link URL', 'yiontech-lms'); ?>" class="regular-text" />
                        <button type="button" class="button remove-link"><?php _e('Remove', 'yiontech-lms'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button add-link" data-column="column4"><?php _e('Add Link', 'yiontech-lms'); ?></button>
            <input type="hidden" class="item-counter" data-column="column4" value="<?php echo esc_attr(count($footer_content['column4']['links'] ?? [])); ?>" />
        </div>

        <!-- Column 5 -->
        <h4><?php _e('Column 5', 'yiontech-lms'); ?></h4>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-title'); ?>"><?php _e('Title:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column5-title'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][title]" value="<?php echo esc_attr($footer_content['column5']['title'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-content'); ?>"><?php _e('Content:', 'yiontech-lms'); ?></label>
            <textarea id="<?php echo esc_attr($args['id'] . '-column5-content'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][content]" rows="4" class="large-text"><?php echo esc_textarea($footer_content['column5']['content'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-email'); ?>"><?php _e('Email:', 'yiontech-lms'); ?></label>
            <input type="email" id="<?php echo esc_attr($args['id'] . '-column5-email'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][email]" value="<?php echo esc_attr($footer_content['column5']['email'] ?? ''); ?>" class="regular-text" />
        </div>
        <div>
            <label for="<?php echo esc_attr($args['id'] . '-column5-phone'); ?>"><?php _e('Phone:', 'yiontech-lms'); ?></label>
            <input type="text" id="<?php echo esc_attr($args['id'] . '-column5-phone'); ?>" name="<?php echo esc_attr($args['name']); ?>[column5][phone]" value="<?php echo esc_attr($footer_content['column5']['phone'] ?? ''); ?>" class="regular-text" />
        </div>
    </div>
    <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php
}

// Page select field
function yiontech_lms_page_select_field($args) {
    $options = get_option('yiontech_lms_theme_settings', []);
    $value = isset($options[$args['id']]) ? $options[$args['id']] : 0;
    $pages = get_pages();
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="<?php echo esc_attr($args['name']); ?>" aria-describedby="<?php echo esc_attr($args['id']); ?>-description">
        <option value="0"><?php _e('— Select —', 'yiontech-lms'); ?></option>
        <?php foreach ($pages as $page): ?>
            <option value="<?php echo esc_attr($page->ID); ?>" <?php selected($value, $page->ID); ?>><?php echo esc_html($page->post_title); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description" id="<?php echo esc_attr($args['id']); ?>-description"><?php echo esc_html($args['description']); ?></p>
    <?php
}