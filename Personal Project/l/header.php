<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration: none; color: inherit;">
                <?php bloginfo('name'); ?>
            </a>
        </h1>
        
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'fallback_cb' => function() {
                    echo '<ul><li><a href="' . esc_url(home_url('/')) . '">Home</a></li></ul>';
                }
            ));
            ?>
        </nav>

        <!-- Add authentication links -->
        <div class="auth-nav">
            <?php if (is_user_logged_in()) : ?>
                <span class="user-greeting">Hello, <?php echo esc_html(wp_get_current_user()->display_name); ?></span>
                <a href="<?php echo esc_url(add_query_arg('action', 'logout', home_url())); ?>" class="auth-nav-link logout-link">Logout</a>
            <?php else : ?>
                <a href="<?php echo get_template_directory_uri(); ?>/login.php" class="auth-nav-link">Login</a>
                <a href="<?php echo get_template_directory_uri(); ?>/signup.php" class="auth-nav-link signup-link">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</header>
