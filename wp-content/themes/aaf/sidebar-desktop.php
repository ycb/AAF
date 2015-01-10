<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
?>
<div><!-- small trick so bootstrap doesn't think this is the first child. --></div>
<div id="secondary" class="sidebar" role="complementary">
    <div class="widget-area">

        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( !dynamic_sidebar( 'desktop' ) ) : ?>

            <aside id="search" class="widget widget_search">
                <?php get_search_form(); ?>
            </aside>

            <aside id="archives" class="widget">
                <h1 class="widget-title"><?php _e( 'Archives', 'AAF' ); ?></h1>
                <ul>
                    <?php wp_get_archives( array('type' => 'monthly') ); ?>
                </ul>
            </aside>

            <aside id="meta" class="widget">
                <h1 class="widget-title"><?php _e( 'Meta', 'AAF' ); ?></h1>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </aside>

        <?php endif; // end sidebar widget area ?>
    </div>
</div><!-- #secondary .widget-area -->
