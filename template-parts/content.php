<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail h-48 overflow-hidden">
            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
        </div>
    <?php endif; ?>
    
    <div class="p-6">
        <header>
            <h2 class="text-xl font-bold mb-2"><a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800"><?php the_title(); ?></a></h2>
            <div class="text-gray-600 text-sm mb-3">
                <?php echo get_the_date(); ?> by <?php the_author(); ?>
            </div>
        </header>
        
        <div class="content mb-4">
            <?php the_excerpt(); ?>
        </div>
        
        <footer>
            <a href="<?php the_permalink(); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">View Course</a>
        </footer>
    </div>
</article>