<?php get_header(); ?>

<main class="site-main">
    <section class="hero-section">
        <h1 class="hero-title">Dynamic Creative Code Gallery</h1>
        <p class="hero-description">
            Explore a curated collection of creative coding projects, interactive visualizations, and innovative web experiments.
        </p>
    </section>

    <section class="filter-section">
        <div class="filter-controls">
            <button class="filter-btn active" data-category="all">All Projects</button>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'project_category',
                'hide_empty' => true,
            ));
            
            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    echo '<button class="filter-btn" data-category="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</button>';
                }
            }
            ?>
        </div>

        <div class="gallery-grid" id="gallery-grid">
            <?php
            $args = array(
                'post_type' => 'code_project',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );
            
            $query = new WP_Query($args);
            
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    get_template_part('template-parts/gallery-item');
                }
            } else {
                echo '<p class="no-results">No projects found. Add some code projects to get started!</p>';
            }
            
            wp_reset_postdata();
            ?>
        </div>
    </section>
</main>

 Modal for Project Details 
<div class="code-modal" id="codeModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle"></h2>
            <button class="modal-close" id="modalClose">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
             Content loaded via AJAX 
        </div>
    </div>
</div>

<?php get_footer(); ?>
