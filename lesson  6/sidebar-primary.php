<div id="sidebar-primary" class="sidebar">
    <?php if (is_active_sidebar('primary')); ?>
        <?php dynamic_sidebar('primary') ;?>
    <?php else:?>    
        <aside id="search" class="widget widget_search">
            <?php get_search_form( );?>
</div>