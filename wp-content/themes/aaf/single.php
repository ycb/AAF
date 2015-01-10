<?php
/**
 * The Template for displaying all single posts.
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
get_header();
?>

<div id="primary" class="content-area span8">
    <div id="content" class="site-content" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part( 'content', 'single' ); ?>

            <?php AAF_content_nav( 'nav-below' ); ?>

        <?php endwhile; // end of the loop. ?>

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<div class="hidden-desktop sidebarmobile"><?php get_sidebar('mobile'); ?></div>
<div class="visible-desktop sidebardesktop span4"><?php get_sidebar('desktop'); ?></div>
<?php get_footer(); ?>