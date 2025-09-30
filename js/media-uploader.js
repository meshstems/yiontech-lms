jQuery(document).ready(function($) {
    // Profile Image Media Upload
    var profileImageFrame;
    $('#upload-profile-image').on('click', function(e) {
        e.preventDefault();
        
        if (profileImageFrame) {
            profileImageFrame.open();
            return;
        }
        
        profileImageFrame = wp.media({
            title: 'Select Profile Image',
            button: {
                text: 'Use this image'
            },
            multiple: false,
            library: {
                type: 'image',
                author: yiontech_media.user_id
            }
        });
        
        profileImageFrame.on('select', function() {
            var attachment = profileImageFrame.state().get('selection').first().toJSON();
            $('#selected-profile-image').val(attachment.id);
            $('#profile-image-form').submit();
        });
        
        profileImageFrame.open();
    });
    
    // Document Media Upload
    var documentFrame;
    $('#upload-document').on('click', function(e) {
        e.preventDefault();
        
        if (documentFrame) {
            documentFrame.open();
            return;
        }
        
        documentFrame = wp.media({
            title: 'Select Document',
            button: {
                text: 'Use this document'
            },
            multiple: false,
            library: {
                type: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'],
                author: yiontech_media.user_id
            }
        });
        
        documentFrame.on('select', function() {
            var attachment = documentFrame.state().get('selection').first().toJSON();
            $('#selected-document').val(attachment.id);
            $('#document-form').submit();
        });
        
        documentFrame.open();
    });
});