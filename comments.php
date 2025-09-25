<?php if (comments_open() || get_comments_number()) : ?>
    <div id="comments" class="comments-area my-8 bg-white rounded-lg shadow-md p-6">
        <?php if (have_comments()) : ?>
            <h3 class="comments-title text-xl font-bold mb-4">
                <?php
                printf(
                    _nx(
                        'One comment',
                        '%1$s comments',
                        get_comments_number(),
                        'comments title',
                        'yiontech-lms'
                    ),
                    number_format_i18n(get_comments_number())
                );
                ?>
            </h3>
            
            <ul class="comment-list space-y-4">
                <?php wp_list_comments(array('style' => 'ul', 'callback' => 'yiontech_lms_comment')); ?>
            </ul>
        <?php endif; ?>
        
        <?php 
        // Get privacy settings
        $enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
        $privacy_policy_url = yiontech_lms_get_privacy_policy_url();
        $terms_of_service_url = yiontech_lms_get_terms_of_service_url();
        
        // Get comment form variables
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
        ?>
        
        <?php 
        comment_form(array(
            'fields' => array(
                'author' => '<div class="comment-form-author mb-4">' . '<label for="author">' . __('Name', 'yiontech-lms') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . ($req ? ' required' : '') . ' class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" /></div>',
                'email'  => '<div class="comment-form-email mb-4">' . '<label for="email">' . __('Email', 'yiontech-lms') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' . '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . ($req ? ' required' : '') . ' class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" /></div>',
                'url'    => '<div class="comment-form-url mb-4">' . '<label for="url">' . __('Website', 'yiontech-lms') . '</label>' . '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" /></div>',
                'cookies' => '<div class="comment-form-cookies-consent mb-4"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> <label for="wp-comment-cookies-consent">' . __('Save my name, email, and website in this browser for the next time I comment.', 'yiontech-lms') . '</label></div>',
            ),
            'comment_field' => '<div class="comment-form-comment mb-4"><label for="comment">' . _x('Comment', 'noun', 'yiontech-lms') . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea></div>',
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">%4$s</button>',
            'submit_field' => '<p class="form-submit mt-4">%1$s %2$s</p>',
            'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'yiontech-lms'), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'yiontech-lms'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
            'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __('Your email address will not be published.', 'yiontech-lms') . '</span>' . ($req ? ' ' . __('Required fields are marked *', 'yiontech-lms') : '') . '</p>',
            'comment_notes_after' => '',
            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'class_submit' => 'submit',
            'name_submit' => 'submit',
            'title_reply' => __('Leave a Reply', 'yiontech-lms'),
            'title_reply_to' => __('Leave a Reply to %s', 'yiontech-lms'),
            'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-xl font-bold mb-4">',
            'title_reply_after' => '</h3>',
            'cancel_reply_before' => ' <small>',
            'cancel_reply_after' => '</small>',
            'cancel_reply_link' => __('Cancel reply', 'yiontech-lms'),
            'label_submit' => __('Post Comment', 'yiontech-lms'),
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">%4$s</button>',
            'submit_field' => '<p class="form-submit mt-4">%1$s %2$s</p>',
            'format' => 'html5',
        ));
        ?>
    </div>
<?php endif; ?>