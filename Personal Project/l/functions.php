<?php
/**
 * Dynamic Creative Code Gallery Theme Functions
 */

// Theme Setup
function dcg_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'dynamic-code-gallery'),
    ));
    
    // Set thumbnail sizes
    add_image_size('gallery-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'dcg_theme_setup');

// Register Custom Post Type: Code Projects
function dcg_register_code_projects() {
    $labels = array(
        'name'               => 'Code Projects',
        'singular_name'      => 'Code Project',
        'menu_name'          => 'Code Gallery',
        'add_new'            => 'Add New Project',
        'add_new_item'       => 'Add New Code Project',
        'edit_item'          => 'Edit Code Project',
        'new_item'           => 'New Code Project',
        'view_item'          => 'View Code Project',
        'search_items'       => 'Search Code Projects',
        'not_found'          => 'No code projects found',
        'not_found_in_trash' => 'No code projects found in trash',
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'code-project'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-editor-code',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
    );
    
    register_post_type('code_project', $args);
}
add_action('init', 'dcg_register_code_projects');

// Register Custom Taxonomy: Project Categories
function dcg_register_taxonomies() {
    $labels = array(
        'name'              => 'Project Categories',
        'singular_name'     => 'Project Category',
        'search_items'      => 'Search Categories',
        'all_items'         => 'All Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Categories',
    );
    
    register_taxonomy('project_category', array('code_project'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'category'),
    ));
    
    // Register Language Taxonomy
    $lang_labels = array(
        'name'              => 'Languages',
        'singular_name'     => 'Language',
        'search_items'      => 'Search Languages',
        'all_items'         => 'All Languages',
        'edit_item'         => 'Edit Language',
        'update_item'       => 'Update Language',
        'add_new_item'      => 'Add New Language',
        'new_item_name'     => 'New Language Name',
        'menu_name'         => 'Languages',
    );
    
    register_taxonomy('project_language', array('code_project'), array(
        'hierarchical'      => false,
        'labels'            => $lang_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'language'),
    ));
}
add_action('init', 'dcg_register_taxonomies');

// Add Meta Boxes for Code Projects
function dcg_add_meta_boxes() {
    add_meta_box(
        'code_details',
        'Code Details',
        'dcg_code_details_callback',
        'code_project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dcg_add_meta_boxes');

// Meta Box Callback
function dcg_code_details_callback($post) {
    wp_nonce_field('dcg_save_code_details', 'dcg_code_details_nonce');
    
    $code_snippet = get_post_meta($post->ID, '_code_snippet', true);
    $demo_url = get_post_meta($post->ID, '_demo_url', true);
    $github_url = get_post_meta($post->ID, '_github_url', true);
    $difficulty = get_post_meta($post->ID, '_difficulty', true);
    
    ?>
    <div style="margin-bottom: 15px;">
        <label for="code_snippet" style="display: block; margin-bottom: 5px; font-weight: bold;">Code Snippet:</label>
        <textarea id="code_snippet" name="code_snippet" rows="10" style="width: 100%; font-family: monospace;"><?php echo esc_textarea($code_snippet); ?></textarea>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="demo_url" style="display: block; margin-bottom: 5px; font-weight: bold;">Demo URL:</label>
        <input type="url" id="demo_url" name="demo_url" value="<?php echo esc_attr($demo_url); ?>" style="width: 100%;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="github_url" style="display: block; margin-bottom: 5px; font-weight: bold;">GitHub URL:</label>
        <input type="url" id="github_url" name="github_url" value="<?php echo esc_attr($github_url); ?>" style="width: 100%;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="difficulty" style="display: block; margin-bottom: 5px; font-weight: bold;">Difficulty Level:</label>
        <select id="difficulty" name="difficulty" style="width: 100%;">
            <option value="beginner" <?php selected($difficulty, 'beginner'); ?>>Beginner</option>
            <option value="intermediate" <?php selected($difficulty, 'intermediate'); ?>>Intermediate</option>
            <option value="advanced" <?php selected($difficulty, 'advanced'); ?>>Advanced</option>
        </select>
    </div>
    <?php
}

// Save Meta Box Data
function dcg_save_code_details($post_id) {
    if (!isset($_POST['dcg_code_details_nonce']) || !wp_verify_nonce($_POST['dcg_code_details_nonce'], 'dcg_save_code_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['code_snippet'])) {
        update_post_meta($post_id, '_code_snippet', sanitize_textarea_field($_POST['code_snippet']));
    }
    
    if (isset($_POST['demo_url'])) {
        update_post_meta($post_id, '_demo_url', esc_url_raw($_POST['demo_url']));
    }
    
    if (isset($_POST['github_url'])) {
        update_post_meta($post_id, '_github_url', esc_url_raw($_POST['github_url']));
    }
    
    if (isset($_POST['difficulty'])) {
        update_post_meta($post_id, '_difficulty', sanitize_text_field($_POST['difficulty']));
    }
}
add_action('save_post', 'dcg_save_code_details');

// Enqueue Scripts and Styles
function dcg_enqueue_scripts() {
    wp_enqueue_style('dcg-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null);
    
    wp_enqueue_script('dcg-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('dcg-main', 'dcgAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('dcg_filter_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'dcg_enqueue_scripts');

// AJAX Handler for Filtering
function dcg_filter_projects() {
    check_ajax_referer('dcg_filter_nonce', 'nonce');
    
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    
    $args = array(
        'post_type' => 'code_project',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    
    if ($category && $category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/gallery-item');
        }
    } else {
        echo '<p class="no-results">No projects found.</p>';
    }
    
    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_dcg_filter_projects', 'dcg_filter_projects');
add_action('wp_ajax_nopriv_dcg_filter_projects', 'dcg_filter_projects');

// AJAX Handler for Single Project
function dcg_get_project_details() {
    check_ajax_referer('dcg_filter_nonce', 'nonce');
    
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if (!$post_id) {
        wp_send_json_error('Invalid post ID');
    }
    
    $post = get_post($post_id);
    
    if (!$post) {
        wp_send_json_error('Post not found');
    }
    
    $code_snippet = get_post_meta($post_id, '_code_snippet', true);
    $demo_url = get_post_meta($post_id, '_demo_url', true);
    $github_url = get_post_meta($post_id, '_github_url', true);
    $difficulty = get_post_meta($post_id, '_difficulty', true);
    
    $categories = wp_get_post_terms($post_id, 'project_category', array('fields' => 'names'));
    $languages = wp_get_post_terms($post_id, 'project_language', array('fields' => 'names'));
    
    $response = array(
        'title' => get_the_title($post_id),
        'content' => apply_filters('the_content', $post->post_content),
        'code_snippet' => $code_snippet,
        'demo_url' => $demo_url,
        'github_url' => $github_url,
        'difficulty' => $difficulty,
        'categories' => $categories,
        'languages' => $languages,
        'thumbnail' => get_the_post_thumbnail_url($post_id, 'large'),
    );
    
    wp_send_json_success($response);
}
add_action('wp_ajax_dcg_get_project_details', 'dcg_get_project_details');
add_action('wp_ajax_nopriv_dcg_get_project_details', 'dcg_get_project_details');

// Custom excerpt length
function dcg_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'dcg_excerpt_length');

// Custom excerpt more
function dcg_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'dcg_excerpt_more');

function dcg_handle_registration() {
    // Verify nonce
    if (!isset($_POST['dcg_register_nonce']) || !wp_verify_nonce($_POST['dcg_register_nonce'], 'dcg_register_user_action')) {
        wp_redirect(home_url('/signup?registration=failed&error=Security check failed'));
        exit;
    }

    // Get form data
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate
    if (empty($username) || empty($email) || empty($password)) {
        wp_redirect(home_url('/signup?registration=failed&error=All fields are required'));
        exit;
    }

    if ($password !== $confirm_password) {
        wp_redirect(home_url('/signup?registration=failed&error=Passwords do not match'));
        exit;
    }

    if (strlen($password) < 8) {
        wp_redirect(home_url('/signup?registration=failed&error=Password must be at least 8 characters'));
        exit;
    }

    if (username_exists($username)) {
        wp_redirect(home_url('/signup?registration=failed&error=Username already exists'));
        exit;
    }

    if (email_exists($email)) {
        wp_redirect(home_url('/signup?registration=failed&error=Email already registered'));
        exit;
    }

    // Create user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_redirect(home_url('/signup?registration=failed&error=' . urlencode($user_id->get_error_message())));
        exit;
    }

    // Success - redirect to login
    wp_redirect(home_url('/login?registered=success'));
    exit;
}
add_action('admin_post_nopriv_dcg_register_user', 'dcg_handle_registration');
add_action('admin_post_dcg_register_user', 'dcg_handle_registration');

function dcg_login_redirect($redirect_to, $request, $user) {
    return home_url();
}
add_filter('login_redirect', 'dcg_login_redirect', 10, 3);

function dcg_login_failed() {
    wp_redirect(home_url('/login?login=failed'));
    exit;
}
add_action('wp_login_failed', 'dcg_login_failed');

function dcg_logout_redirect() {
    wp_redirect(home_url('/login?logout=success'));
    exit;
}
add_action('wp_logout', 'dcg_logout_redirect');

// Custom logout URL handler
function dcg_custom_logout() {
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        wp_logout();
        wp_redirect(home_url('/login?logout=success'));
        exit;
    }
}
add_action('init', 'dcg_custom_logout');
?>
