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
    </div>
</header>
