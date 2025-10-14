<?php get_header(); ?>

<main class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        
        $code_snippet = get_post_meta(get_the_ID(), '_code_snippet', true);
        $demo_url = get_post_meta(get_the_ID(), '_demo_url', true);
        $github_url = get_post_meta(get_the_ID(), '_github_url', true);
        $difficulty = get_post_meta(get_the_ID(), '_difficulty', true);
        $categories = wp_get_post_terms(get_the_ID(), 'project_category');
        $languages = wp_get_post_terms(get_the_ID(), 'project_language');
        ?>
        
        <article class="single-project" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
            <header class="project-header" style="margin-bottom: 3rem;">
                <h1 style="font-size: 3rem; margin-bottom: 1rem;"><?php the_title(); ?></h1>
                
                <div class="project-meta" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem;">
                    <?php if (!empty($languages)) : ?>
                        <?php foreach ($languages as $language) : ?>
                            <span class="meta-tag"><?php echo esc_html($language->name); ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if ($difficulty) : ?>
                        <span class="meta-tag" style="background: rgba(236, 72, 153, 0.2); color: #ec4899;">
                            <?php echo esc_html(ucfirst($difficulty)); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div style="border-radius: 12px; overflow: hidden; margin-bottom: 2rem;">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto;')); ?>
                    </div>
                <?php endif; ?>
            </header>
            
            <div class="project-content" style="background: var(--card-bg); padding: 2rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--border-color);">
                <?php the_content(); ?>
            </div>
            
            <?php if ($code_snippet) : ?>
                <div class="code-section" style="margin-bottom: 2rem;">
                    <h2 style="margin-bottom: 1rem;">Code Snippet</h2>
                    <div class="code-preview">
                        <pre><code><?php echo esc_html($code_snippet); ?></code></pre>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($demo_url || $github_url) : ?>
                <div class="project-links" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <?php if ($demo_url) : ?>
                        <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener" 
                           style="padding: 1rem 2rem; background: var(--primary-color); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: var(--transition);">
                            View Live Demo
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($github_url) : ?>
                        <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener"
                           style="padding: 1rem 2rem; background: var(--card-bg); color: var(--text-primary); text-decoration: none; border-radius: 8px; font-weight: 600; border: 2px solid var(--border-color); transition: var(--transition);">
                            View on GitHub
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </article>
        
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
