(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color picker fields
        $('.yiontech-color-field').wpColorPicker();

        // Media upload functionality
        $(document).on('click', '.media-upload-button', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var fieldContainer = button.closest('.media-field');
            var fieldId = fieldContainer.data('field-id');
            var preview = fieldContainer.find('.media-preview');
            var removeButton = fieldContainer.find('.media-remove-button');
            
            // Create media uploader
            var mediaUploader = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            
            // When an image is selected
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // Update hidden field with image URL
                fieldContainer.find('input[type="hidden"]').val(attachment.url);
                
                // Update preview
                preview.html('<img src="' + attachment.url + '" alt="" style="max-width: 200px; max-height: 100px;" />');
                
                // Show remove button
                removeButton.show();
                
                // Close the media uploader
                mediaUploader.close();
            });
            
            // Open the media uploader
            mediaUploader.open();
        });

        // Remove media functionality
        $(document).on('click', '.media-remove-button', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var fieldContainer = button.closest('.media-field');
            var preview = fieldContainer.find('.media-preview');
            
            // Clear hidden field
            fieldContainer.find('input[type="hidden"]').val('');
            
            // Clear preview
            preview.html('');
            
            // Hide remove button
            button.hide();
        });

        // Header buttons functionality
        $(document).on('click', '.header-buttons-field .add-button', function(e) {
            e.preventDefault();
            
            var container = $(this).closest('.header-buttons-field');
            var buttonsContainer = container.find('.header-buttons');
            var fieldName = container.data('field-name');
            var counter = container.find('.item-counter');
            var index = parseInt(counter.val());
            
            // Create new button HTML
            var newButtonHtml = '<div class="header-button-item" data-index="' + index + '">';
            newButtonHtml += '<div><label>Button Text:</label><input type="text" name="' + fieldName + '[' + index + '][text]" class="regular-text" /></div>';
            newButtonHtml += '<div><label>Button URL:</label><input type="text" name="' + fieldName + '[' + index + '][url]" class="regular-text" /></div>';
            newButtonHtml += '<div><label>Button Style:</label><select name="' + fieldName + '[' + index + '][style]"><option value="solid">Solid</option><option value="outline">Outline</option></select></div>';
            newButtonHtml += '<div><label><input type="checkbox" name="' + fieldName + '[' + index + '][show_desktop]" value="1" checked /> Show on Desktop</label></div>';
            newButtonHtml += '<div><label><input type="checkbox" name="' + fieldName + '[' + index + '][show_mobile]" value="1" checked /> Show on Mobile</label></div>';
            newButtonHtml += '<button type="button" class="button remove-button">Remove Button</button>';
            newButtonHtml += '</div>';
            
            // Append new button
            buttonsContainer.append(newButtonHtml);
            
            // Update counter
            counter.val(index + 1);
        });

        // Remove header button
        $(document).on('click', '.header-button-item .remove-button', function(e) {
            e.preventDefault();
            $(this).closest('.header-button-item').remove();
        });

        // Menu items functionality
        $(document).on('click', '.menu-field .add-menu-item', function(e) {
            e.preventDefault();
            
            var container = $(this).closest('.menu-field');
            var menuContainer = container.find('.menu-items');
            var fieldName = container.data('field-name');
            var counter = container.find('.item-counter');
            var index = parseInt(counter.val());
            
            // Create new menu item HTML
            var newMenuItemHtml = '<div class="menu-item" data-index="' + index + '">';
            newMenuItemHtml += '<div><label>Menu Text:</label><input type="text" name="' + fieldName + '[' + index + '][text]" class="regular-text" /></div>';
            newMenuItemHtml += '<div><label>Menu URL:</label><input type="text" name="' + fieldName + '[' + index + '][url]" class="regular-text" /></div>';
            newMenuItemHtml += '<button type="button" class="button remove-menu-item">Remove</button>';
            newMenuItemHtml += '</div>';
            
            // Append new menu item
            menuContainer.append(newMenuItemHtml);
            
            // Update counter
            counter.val(index + 1);
        });

        // Remove menu item
        $(document).on('click', '.menu-item .remove-menu-item', function(e) {
            e.preventDefault();
            $(this).closest('.menu-item').remove();
        });

        // Footer links functionality
        $(document).on('click', '.footer-content-field .add-link', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var column = button.data('column');
            var container = button.closest('.footer-content-field');
            var linksContainer = container.find('.footer-links[data-column="' + column + '"]');
            var fieldName = container.data('field-name');
            var counter = container.find('.item-counter[data-column="' + column + '"]');
            var index = parseInt(counter.val());
            
            // Create new link HTML
            var newLinkHtml = '<div class="footer-link-item" data-index="' + index + '">';
            newLinkHtml += '<input type="text" name="' + fieldName + '[' + column + '][links][' + index + '][text]" placeholder="Link Text" class="regular-text" />';
            newLinkHtml += '<input type="text" name="' + fieldName + '[' + column + '][links][' + index + '][url]" placeholder="Link URL" class="regular-text" />';
            newLinkHtml += '<button type="button" class="button remove-link">Remove</button>';
            newLinkHtml += '</div>';
            
            // Append new link
            linksContainer.append(newLinkHtml);
            
            // Update counter
            counter.val(index + 1);
        });

        // Remove footer link
        $(document).on('click', '.footer-link-item .remove-link', function(e) {
            e.preventDefault();
            $(this).closest('.footer-link-item').remove();
        });
    });

})(jQuery);