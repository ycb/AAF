<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package AAF
 * @package AAF - 2013 1.0
 */
?>
<div id="secondary" class="span4 sidebar" role="complementary">
    <div class="widget-area">

        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( !dynamic_sidebar( 'mobile' ) ) : ?>

        <?php endif; // end sidebar widget area ?>
        <aside id="nav_menu-3" class="widget widget_nav_menu">
            <div class="menu-mobile-bottom-nav-container">
                <ul id="menu-mobile-bottom-nav" class="menu">
                    <li><a href="#">GET DIRECTIONS</a><br /><small>OMEGA BOYS CLUB IS LOCATED AT <br />1060 TENNESSEE STREET, SAN FRANCISCO, CA 94107</small></li>
                </ul>
            </div>
        </aside>
    </div>
</div><!-- #secondary .widget-area -->
