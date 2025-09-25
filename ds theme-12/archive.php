<?php
get_header();
?>
<main id="main" class="archive-page" style="max-width:800px; margin:auto; padding:40px 20px;">
    <h1><?php the_archive_title(); ?></h1>
    <p><?php the_archive_description(); ?></p>
    <?php if ( have_posts() ) : ?>
        <ul style="list-style:none; padding:0;">
            <?php while ( have_posts() ) : the_post(); ?>
                <li style="margin-bottom:30px;">
                    <h2><a href="<?php the_permalink(); ?>" style="color:#0073aa; text-decoration:none;"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
</main>
<?php
get_footer();
?>