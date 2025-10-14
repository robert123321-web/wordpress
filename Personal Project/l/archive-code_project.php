<?php get_header(); ?>

<main class="site-main">
    <section class="hero-section">
        <h1 class="hero-title">
            <?php
            if (is_tax('project_category')) {
                single_term_title();
            } elseif (is_tax('project_language')) {
                single_term_title();
            } else {
                echo 'Code Projects Archive';
            }
            ?>
        </h1>
        <?php if (is_tax()) : ?>
            <p class="hero-description"><?php echo term_description(); ?></p>
        <?php endif; ?>
    </section>

    <section class="filter-section">
        <div class="gallery-grid">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    get_template_part('template-parts/gallery-item');
                }
            } else {
                echo '<p class="no-results">No projects found in this category.</p>';
            }
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
