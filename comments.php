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
        
        <?php comment_form(); ?>
    </div>
<?php endif; ?>