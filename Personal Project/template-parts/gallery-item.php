<?php
$categories = wp_get_post_terms(get_the_ID(), 'project_category', array('fields' => 'names'));
$languages = wp_get_post_terms(get_the_ID(), 'project_language', array('fields' => 'names'));
$difficulty = get_post_meta(get_the_ID(), '_difficulty', true);
?>

<article class="gallery-item" data-post-id="<?php echo esc_attr(get_the_ID()); ?>">
    <?php if (has_post_thumbnail()) : ?>
        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'gallery-thumbnail')); ?>" 
             alt="<?php echo esc_attr(get_the_title()); ?>" 
             class="gallery-item-image">
    <?php else : ?>
        <div class="gallery-item-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.3));">
            <span style="font-size: 3rem; opacity: 0.5;">{ }</span>
        </div>
    <?php endif; ?>
    
    <div class="gallery-item-content">
        <h3 class="gallery-item-title"><?php the_title(); ?></h3>
        <p class="gallery-item-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
        
        <div class="gallery-item-meta">
            <?php if (!empty($languages)) : ?>
                <?php foreach ($languages as $language) : ?>
                    <span class="meta-tag"><?php echo esc_html($language); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if ($difficulty) : ?>
                <span class="meta-tag" style="background: rgba(236, 72, 153, 0.2); color: #ec4899;">
                    <?php echo esc_html(ucfirst($difficulty)); ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</article>
